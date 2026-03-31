<?php

namespace App\Http\Requests\Admin;

use App\Models\Post;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_published' => $this->boolean('is_published'),
            'featured_image_remove' => $this->boolean('featured_image_remove'),
        ]);
    }

    public function rules(): array
    {
        /** @var Post $post */
        $post = $this->route('post');

        return [
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('posts', 'slug')->ignore($post->id)],
            'excerpt' => ['nullable', 'string'],
            'content' => ['required', 'string'],
            'featured_image' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp', 'max:8192'],
            'featured_image_remove' => ['boolean'],
            'is_published' => ['boolean'],
            'published_at' => ['nullable', 'date'],
        ];
    }

    public function messages(): array
    {
        return [
            'featured_image.mimes' => 'Файлът трябва да е JPG, PNG или WebP.',
            'featured_image.max' => 'Изображението не може да надвишава 8 MB.',
        ];
    }
}
