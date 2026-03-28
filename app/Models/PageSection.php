<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'page',
        'section',
        'title',
        'subtitle',
        'content',
        'meta',
    ];

    protected $casts = [
        'meta' => 'array',
    ];

    public function getButtonTextAttribute(): ?string
    {
        return $this->meta['button_text'] ?? null;
    }

    public function getButtonUrlAttribute(): ?string
    {
        return $this->meta['button_url'] ?? null;
    }
}
