<?php

namespace App\Models;

use App\Support\GalleryVideoEmbedNormalizer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GalleryItem extends Model
{
    use HasFactory;

    public const TYPE_IMAGE = 'image';

    public const TYPE_VIDEO = 'video';

    public const TYPES = [
        self::TYPE_IMAGE => 'Снимка',
        self::TYPE_VIDEO => 'Видео',
    ];

    protected $fillable = [
        'title',
        'type',
        'image_path',
        'video_url',
        'video_platform',
        'video_external_id',
        'video_embed_url',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderByDesc('id');
    }

    public function scopeImages($query)
    {
        return $query->where('type', self::TYPE_IMAGE);
    }

    public function scopeVideos($query)
    {
        return $query->where('type', self::TYPE_VIDEO);
    }

    public function isImage(): bool
    {
        return $this->type === self::TYPE_IMAGE;
    }

    public function isVideo(): bool
    {
        return $this->type === self::TYPE_VIDEO;
    }

    public function resolvedVideoEmbedUrl(): ?string
    {
        if (! $this->isVideo()) {
            return null;
        }

        $parsed = GalleryVideoEmbedNormalizer::parse((string) ($this->video_url ?? ''));

        return $parsed['embed_url'] ?? null;
    }

    public function resolvedVideoPlatform(): ?string
    {
        if (! $this->isVideo()) {
            return null;
        }

        $parsed = GalleryVideoEmbedNormalizer::parse((string) ($this->video_url ?? ''));

        return $parsed['platform'] ?? null;
    }

    /**
     * Tailwind aspect classes for the public YouTube embed container.
     */
    public function videoEmbedAspectClass(): string
    {
        return 'aspect-video w-full';
    }

    /**
     * Thumbnail for home preview when the stored URL is a recognised YouTube link.
     */
    public function videoThumbnailUrl(): ?string
    {
        if (! $this->isVideo() || ! $this->video_url) {
            return null;
        }

        if (preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $this->video_url, $m)) {
            return "https://img.youtube.com/vi/{$m[1]}/hqdefault.jpg";
        }

        if (preg_match('/youtube\.com\/(?:shorts|embed|live)\/([a-zA-Z0-9_-]{11})/', $this->video_url, $m)) {
            return "https://img.youtube.com/vi/{$m[1]}/hqdefault.jpg";
        }

        return null;
    }
}
