<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_published' => $this->boolean('is_published'),
        ]);
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('posts', 'slug')],
            'excerpt' => ['nullable', 'string'],
            'content' => ['required', 'string'],
            'featured_image' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp', 'max:8192'],
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
