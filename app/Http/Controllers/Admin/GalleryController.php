<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreGalleryItemRequest;
use App\Http\Requests\Admin\UpdateGalleryItemRequest;
use App\Models\GalleryItem;
use App\Support\GalleryImageProcessor;
use App\Support\GalleryVideoEmbedNormalizer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index(Request $request)
    {
        $type = in_array($request->input('type'), array_keys(GalleryItem::TYPES))
            ? $request->input('type')
            : 'all';

        $items = GalleryItem::ordered()
            ->when($type !== 'all', fn ($q) => $q->where('type', $type))
            ->paginate(20)
            ->withQueryString();

        return view('admin.gallery.index', compact('items', 'type'));
    }

    public function create()
    {
        return view('admin.gallery.create');
    }

    public function store(StoreGalleryItemRequest $request)
    {
        $validated = $request->validated();

        $data = [
            'title' => $validated['title'] ?? null,
            'type' => $validated['type'],
            'image_path' => null,
            'video_url' => null,
            'video_platform' => null,
            'video_external_id' => null,
            'video_embed_url' => null,
            'sort_order' => (int) ($validated['sort_order'] ?? 0),
            'is_active' => (bool) ($validated['is_active'] ?? false),
        ];

        if ($validated['type'] === GalleryItem::TYPE_IMAGE) {
            try {
                $data['image_path'] = app(GalleryImageProcessor::class)->process($request->file('image'));
            } catch (\Throwable $e) {
                return back()
                    ->withInput()
                    ->withErrors(['image' => 'Грешка при обработка на изображението.']);
            }

            try {
                GalleryItem::create($data);
            } catch (\Throwable $e) {
                $path = $data['image_path'] ?? null;
                if ($path && Storage::disk('public')->exists($path)) {
                    Storage::disk('public')->delete($path);
                }

                return back()
                    ->withInput()
                    ->withErrors(['image' => 'Грешка при запис на изображението.']);
            }
        } else {
            $parsed = GalleryVideoEmbedNormalizer::parse($validated['video_url']);
            if ($parsed === null) {
                return back()
                    ->withInput()
                    ->withErrors(['video_url' => 'Невалиден YouTube линк. Поддържат се само публични YouTube видеа.']);
            }
            $data['video_url'] = $parsed['canonical_url'];
            $data['video_platform'] = $parsed['platform'];
            $data['video_external_id'] = $parsed['external_id'];
            $data['video_embed_url'] = $parsed['embed_url'];
            GalleryItem::create($data);
        }

        return redirect()
            ->route('admin.gallery.index')
            ->with('success', 'Записът беше добавен успешно.');
    }

    public function edit(GalleryItem $gallery)
    {
        return view('admin.gallery.edit', ['galleryItem' => $gallery]);
    }

    public function update(UpdateGalleryItemRequest $request, GalleryItem $gallery)
    {
        $validated = $request->validated();

        $data = [
            'title' => $validated['title'] ?? null,
            'type' => $validated['type'],
            'image_path' => null,
            'video_url' => null,
            'video_platform' => null,
            'video_external_id' => null,
            'video_embed_url' => null,
            'sort_order' => (int) ($validated['sort_order'] ?? 0),
            'is_active' => (bool) ($validated['is_active'] ?? false),
        ];

        if ($validated['type'] === GalleryItem::TYPE_IMAGE) {
            if ($request->hasFile('image')) {
                $oldPath = $gallery->image_path;
                $newPath = null;

                try {
                    $newPath = app(GalleryImageProcessor::class)->process($request->file('image'));
                } catch (\Throwable $e) {
                    return back()
                        ->withInput()
                        ->withErrors(['image' => 'Грешка при обработка на изображението.']);
                }

                $data['image_path'] = $newPath;

                try {
                    $gallery->update($data);
                } catch (\Throwable $e) {
                    if ($newPath && Storage::disk('public')->exists($newPath)) {
                        Storage::disk('public')->delete($newPath);
                    }

                    return back()
                        ->withInput()
                        ->withErrors(['image' => 'Грешка при обновяване на изображението.']);
                }

                if ($oldPath) {
                    Storage::disk('public')->delete($oldPath);
                }
            } else {
                $data['image_path'] = $gallery->image_path;
                $gallery->update($data);
            }
        } else {
            if ($gallery->image_path) {
                Storage::disk('public')->delete($gallery->image_path);
            }
            $parsed = GalleryVideoEmbedNormalizer::parse($validated['video_url']);
            if ($parsed === null) {
                return back()
                    ->withInput()
                    ->withErrors(['video_url' => 'Невалиден YouTube линк. Поддържат се само публични YouTube видеа.']);
            }
            $data['video_url'] = $parsed['canonical_url'];
            $data['video_platform'] = $parsed['platform'];
            $data['video_external_id'] = $parsed['external_id'];
            $data['video_embed_url'] = $parsed['embed_url'];
            $gallery->update($data);
        }

        return redirect()
            ->route('admin.gallery.index')
            ->with('success', 'Записът беше обновен успешно.');
    }

    public function destroy(GalleryItem $gallery)
    {
        if (! $gallery->exists) {
            return redirect()
                ->back()
                ->with('error', 'Записът не беше намерен или вече е изтрит.');
        }

        if ($gallery->image_path) {
            Storage::disk('public')->delete($gallery->image_path);
        }

        $title = $gallery->title ?: ('Запис #'.$gallery->id);
        $gallery->delete();

        return redirect()
            ->route('admin.gallery.index')
            ->with('success', '"'.$title.'" беше изтрит.');
    }

    public function toggle(GalleryItem $galleryItem)
    {
        $newStatus = ! $galleryItem->is_active;
        $galleryItem->update(['is_active' => $newStatus]);

        $title = $galleryItem->title ?: ('Запис #'.$galleryItem->id);
        $message = $newStatus
            ? '"'.$title.'" е активиран.'
            : '"'.$title.'" е деактивиран.';

        return redirect()
            ->route('admin.gallery.index')
            ->with('success', $message);
    }
}
