<?php

namespace App\Http\Requests\Admin;

use App\Models\GalleryItem;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreGalleryItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $type = $this->input('type');

        return [
            'title'      => ['nullable', 'string', 'max:255'],
            'type'       => ['required', Rule::in(array_keys(GalleryItem::TYPES))],
            'image'      => $type === GalleryItem::TYPE_IMAGE
                                ? ['required', 'file', 'mimes:jpg,jpeg,png,webp', 'max:8192']
                                : ['nullable', 'file', 'mimes:jpg,jpeg,png,webp', 'max:8192'],
            'video_url'  => $type === GalleryItem::TYPE_VIDEO
                                ? ['required', 'url', 'max:255']
                                : ['nullable', 'url', 'max:255'],
            'sort_order' => ['integer', 'min:0'],
            'is_active'  => ['boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'image.required'     => 'Моля, качете изображение.',
            'image.mimes'        => 'Файлът трябва да е JPG, PNG или WebP.',
            'image.max'          => 'Изображението не може да надвишава 8 MB.',
            'video_url.required' => 'Моля, въведете URL на видеото.',
            'video_url.url'      => 'URL адресът не е валиден.',
        ];
    }
}
