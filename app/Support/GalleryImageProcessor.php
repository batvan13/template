<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use RuntimeException;

class GalleryImageProcessor
{
    private const MAX_WIDTH = 1600;

    private const QUALITY = 80;

    private const DIRECTORY = 'gallery';

    /**
     * @param  string  $directory  Relative folder on the public disk (e.g. "gallery", "blog").
     */
    public function process(UploadedFile $file, string $directory = self::DIRECTORY): string
    {
        $manager = $this->createImageManager();

        $path = $file->getRealPath() ?: $file->getPathname();

        $image = $manager->read($path);

        if ($image->width() > self::MAX_WIDTH) {
            $image->scaleDown(self::MAX_WIDTH);
        }

        $encoded = $image->toWebp(self::QUALITY);

        $relativePath = trim($directory, '/').'/'.Str::uuid()->toString().'.webp';

        Storage::disk('public')->put($relativePath, $encoded->toString());

        return $relativePath;
    }

    private function createImageManager(): ImageManager
    {
        if (extension_loaded('gd') && function_exists('imagewebp')) {
            return ImageManager::gd();
        }

        if (extension_loaded('imagick')) {
            return ImageManager::imagick();
        }

        throw new RuntimeException(
            'Gallery image processing requires PHP GD with WebP support (imagewebp) or the Imagick extension. Neither is available.'
        );
    }
}
