<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePostRequest;
use App\Http\Requests\Admin\UpdatePostRequest;
use App\Models\Post;
use App\Support\GalleryImageProcessor;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::query()
            ->orderByDesc('published_at')
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        return view('admin.posts.index', compact('posts'));
    }

    public function create()
    {
        return view('admin.posts.create');
    }

    public function store(StorePostRequest $request)
    {
        $validated = $request->validated();
        unset($validated['featured_image']);

        $data = $this->prepareForPersistence($validated, null);

        if ($request->hasFile('featured_image')) {
            try {
                $data['featured_image'] = app(GalleryImageProcessor::class)->process(
                    $request->file('featured_image'),
                    'blog'
                );
            } catch (\Throwable $e) {
                return back()
                    ->withInput()
                    ->withErrors(['featured_image' => 'Грешка при обработка на изображението.']);
            }
        } else {
            $data['featured_image'] = null;
        }

        try {
            Post::create($data);
        } catch (\Throwable $e) {
            if (! empty($data['featured_image']) && Storage::disk('public')->exists($data['featured_image'])) {
                Storage::disk('public')->delete($data['featured_image']);
            }

            return back()
                ->withInput()
                ->withErrors(['title' => 'Грешка при запис на публикацията.']);
        }

        return redirect()->route('admin.posts.index')
            ->with('success', 'Публикацията беше добавена успешно.');
    }

    public function edit(Post $post)
    {
        return view('admin.posts.edit', compact('post'));
    }

    public function update(UpdatePostRequest $request, Post $post)
    {
        $validated = $request->validated();
        $removeImage = (bool) ($validated['featured_image_remove'] ?? false);
        unset($validated['featured_image'], $validated['featured_image_remove']);

        $data = $this->prepareForPersistence($validated, $post);

        if ($request->hasFile('featured_image')) {
            $oldPath = $post->featured_image;
            $newPath = null;

            try {
                $newPath = app(GalleryImageProcessor::class)->process(
                    $request->file('featured_image'),
                    'blog'
                );
            } catch (\Throwable $e) {
                return back()
                    ->withInput()
                    ->withErrors(['featured_image' => 'Грешка при обработка на изображението.']);
            }

            $data['featured_image'] = $newPath;

            try {
                $post->update($data);
            } catch (\Throwable $e) {
                if ($newPath && Storage::disk('public')->exists($newPath)) {
                    Storage::disk('public')->delete($newPath);
                }

                return back()
                    ->withInput()
                    ->withErrors(['title' => 'Грешка при обновяване на публикацията.']);
            }

            if ($oldPath) {
                Storage::disk('public')->delete($oldPath);
            }
        } elseif ($removeImage && $post->featured_image) {
            $path = $post->featured_image;
            $data['featured_image'] = null;
            $post->update($data);
            Storage::disk('public')->delete($path);
        } else {
            $data['featured_image'] = $post->featured_image;
            $post->update($data);
        }

        return redirect()->route('admin.posts.index')
            ->with('success', 'Публикацията беше обновена успешно.');
    }

    public function destroy(Post $post)
    {
        $title = $post->title;

        if ($post->featured_image) {
            Storage::disk('public')->delete($post->featured_image);
        }

        $post->delete();

        return redirect()->route('admin.posts.index')
            ->with('success', 'Публикацията „'.$title.'“ беше изтрита.');
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    private function prepareForPersistence(array $data, ?Post $existing = null): array
    {
        $slugInput = trim((string) ($data['slug'] ?? ''));
        $baseSlug = $slugInput !== '' ? Str::slug($slugInput) : Str::slug($data['title']);

        $slug = $baseSlug;
        $suffix = 1;
        $ignoreId = $existing?->id;

        while (
            Post::where('slug', $slug)
                ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = $baseSlug.'-'.$suffix++;
        }

        $isPublished = (bool) ($data['is_published'] ?? false);

        if ($isPublished) {
            if (empty($data['published_at'])) {
                $publishedAt = now();
            } else {
                $publishedAt = Carbon::parse($data['published_at']);
            }
        } else {
            $publishedAt = $existing?->published_at;
        }

        return [
            'title' => $data['title'],
            'slug' => $slug,
            'excerpt' => $data['excerpt'] ?? null,
            'content' => $data['content'],
            'is_published' => $isPublished,
            'published_at' => $publishedAt,
        ];
    }
}
