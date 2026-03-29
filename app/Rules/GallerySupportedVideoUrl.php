<?php

namespace App\Rules;

use App\Support\GalleryVideoEmbedNormalizer;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class GallerySupportedVideoUrl implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! is_string($value) || trim($value) === '') {
            return;
        }

        if (GalleryVideoEmbedNormalizer::parse($value) === null) {
            $fail('Поддържат се само публични YouTube видеа. Въведете валиден YouTube линк (напр. youtube.com/watch?v=…, youtu.be/…, youtube.com/shorts/…).');
        }
    }
}
