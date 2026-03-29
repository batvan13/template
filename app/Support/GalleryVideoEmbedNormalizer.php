<?php

namespace App\Support;

/**
 * Parses YouTube watch/share URLs into a deterministic embed URL.
 * Parsing only — no HTTP requests.
 */
class GalleryVideoEmbedNormalizer
{
    public const PLATFORM_YOUTUBE = 'youtube';

    /**
     * @return array{platform: string, external_id: string, embed_url: string, canonical_url: string}|null
     */
    public static function parse(string $rawUrl): ?array
    {
        $trimmed = trim($rawUrl);
        if ($trimmed === '') {
            return null;
        }

        if (! preg_match('#^https?://#i', $trimmed)) {
            $trimmed = 'https://'.$trimmed;
        }

        $parts = parse_url($trimmed);
        if ($parts === false || empty($parts['host'])) {
            return null;
        }

        $host = strtolower($parts['host']);
        $host = preg_replace('/^www\./', '', $host) ?? $host;

        if (! self::isYouTubeHost($host)) {
            return null;
        }

        return self::parseYouTube($parts);
    }

    private static function isYouTubeHost(string $host): bool
    {
        return $host === 'youtu.be'
            || $host === 'youtube.com'
            || str_ends_with($host, '.youtube.com');
    }

    /**
     * Supported shapes: watch?v=, youtu.be/, /embed/, /shorts/, /live/.
     *
     * @param  array<string, mixed>  $parts
     * @return array{platform: string, external_id: string, embed_url: string, canonical_url: string}|null
     */
    private static function parseYouTube(array $parts): ?array
    {
        $path = $parts['path'] ?? '';
        $query = [];
        if (! empty($parts['query'])) {
            parse_str($parts['query'], $query);
        }

        $id = null;
        if (preg_match('#^/embed/([a-zA-Z0-9_-]{11})(?:/|$)#', $path, $m)) {
            $id = $m[1];
        } elseif (preg_match('#^/shorts/([a-zA-Z0-9_-]{11})(?:/|$)#', $path, $m)) {
            $id = $m[1];
        } elseif (preg_match('#^/live/([a-zA-Z0-9_-]{11})(?:/|$)#', $path, $m)) {
            $id = $m[1];
        } elseif (self::hostIsYouTuDotBe((string) ($parts['host'] ?? ''))) {
            if (preg_match('#^/([a-zA-Z0-9_-]{11})(?:/|$)#', $path, $m)) {
                $id = $m[1];
            }
        } elseif (isset($query['v']) && is_string($query['v']) && preg_match('/^[a-zA-Z0-9_-]{11}$/', $query['v'])) {
            $id = $query['v'];
        }

        if ($id === null || $id === '') {
            return null;
        }

        $canonical = 'https://www.youtube.com/watch?v='.$id;
        $embed = 'https://www.youtube.com/embed/'.rawurlencode($id).'?rel=0';

        return [
            'platform' => self::PLATFORM_YOUTUBE,
            'external_id' => $id,
            'embed_url' => $embed,
            'canonical_url' => $canonical,
        ];
    }

    private static function hostIsYouTuDotBe(string $host): bool
    {
        $host = strtolower($host);

        return $host === 'youtu.be' || str_ends_with($host, '.youtu.be');
    }
}
