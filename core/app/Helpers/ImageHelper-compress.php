<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class ImageHelper
{
    protected static function disk()
    {
        return Storage::disk(config('filesystems.default', 'public'));
    }

    protected static function ensureFolderExists($folder)
    {
        $disk = self::disk();
        if (!$disk->exists($folder . '/.keep')) {
            $disk->put($folder . '/.keep', '');
        }
    }

    /**
     * Simple image upload (no compression)
     */
    public static function handleUploadedImage($file, $path, $delete = null)
    {
        if (!$file) return null;

        $disk = self::disk();
        $baseFolder = 'ferranza-image';
        self::ensureFolderExists($baseFolder);
        $fullPath = $baseFolder . '/' . trim($path, '/');

        if ($delete) {
            $disk->delete($fullPath . '/' . $delete);
        }

        $name = 'OM_' . time() . Str::random(8) . '.' . $file->getClientOriginalExtension();

        // ✅ Compress before saving (max width 1200px, 75% quality)
        $compressed = Image::make($file)
            ->orientate() // fix rotation if needed
            ->resize(1200, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })
            ->encode($file->getClientOriginalExtension(), 75);

        $disk->put($fullPath . '/' . $name, (string) $compressed, 'public');

        return $disk->url($fullPath . '/' . $name);
    }

    /**
     * Upload image for Summernote (with compression)
     */
    public static function uploadSummernoteImage($file, $path)
    {
        if (!$file) return null;

        $disk = self::disk();
        $baseFolder = 'ferranza-image';
        self::ensureFolderExists($baseFolder);
        $fullPath = $baseFolder . '/' . trim($path, '/');

        $name = 'OM_' . time() . Str::random(8) . '.' . $file->getClientOriginalExtension();

        // ✅ Compress before saving (max width 1000px, 80% quality for text content)
        $compressed = Image::make($file)
            ->orientate()
            ->resize(1000, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })
            ->encode($file->getClientOriginalExtension(), 80);

        $disk->put($fullPath . '/' . $name, (string) $compressed, 'public');

        return $disk->url($fullPath . '/' . $name);
    }


    /**
     * Compress and save item image + thumbnail
     */
    public static function ItemhandleUploadedImage($file, $path, $delete = null)
    {
        if (!$file) return null;

        $disk = self::disk();
        $baseFolder = 'ferranza-image';
        self::ensureFolderExists($baseFolder);
        $fullPath = $baseFolder . '/' . trim($path, '/');

        if ($delete) {
            $disk->delete($fullPath . '/' . $delete);
        }

        $photoName = 'OM_' . time() . Str::random(8) . '.' . $file->getClientOriginalExtension();
        $thumbnailName = 'THUMB_' . time() . Str::random(8) . '.' . $file->getClientOriginalExtension();

        // ✅ Compress & save main image (max width 1200px)
        $mainImage = Image::make($file)
            ->orientate()
            ->resize(1200, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })
            ->encode($file->getClientOriginalExtension(), 75);

        $disk->put($fullPath . '/' . $photoName, (string) $mainImage, 'public');

        // ✅ Create small, compressed thumbnail (230x230)
        $thumbnail = Image::make($file)
            ->orientate()
            ->fit(230, 230)
            ->encode($file->getClientOriginalExtension(), 60);

        $disk->put($fullPath . '/' . $thumbnailName, (string) $thumbnail, 'public');

        return [
            'photo' => $disk->url($fullPath . '/' . $photoName),
            'thumbnail' => $disk->url($fullPath . '/' . $thumbnailName),
        ];
    }

    /**
     * Update and compress image (for single file)
     */
    public static function handleUpdatedUploadedImage($file, $path, $data, $delete_path, $field)
    {
        if (!$file) return null;

        $disk = self::disk();
        $baseFolder = 'ferranza-image';
        self::ensureFolderExists($baseFolder);
        $fullPath = $baseFolder . '/' . trim($path, '/');

        $name = 'OM_' . time() . Str::random(8) . '.' . $file->getClientOriginalExtension();

        // ✅ Compress before saving
        $compressed = Image::make($file)
            ->orientate()
            ->resize(1200, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })
            ->encode($file->getClientOriginalExtension(), 75);

        $disk->put($fullPath . '/' . $name, (string) $compressed, 'public');

        // Delete old image if exists
        if (!empty($data[$field])) {
            $oldPath = parse_url($data[$field], PHP_URL_PATH);
            $disk->delete($oldPath);
        }

        return $disk->url($fullPath . '/' . $name);
    }

    /**
     * Update and compress item image + thumbnail
     */
    public static function ItemhandleUpdatedUploadedImage($file, $path, $data, $delete_path, $field)
    {
        if (!$file) return null;

        $disk = self::disk();
        $baseFolder = 'ferranza-image';
        self::ensureFolderExists($baseFolder);
        $fullPath = $baseFolder . '/' . trim($path, '/');

        $photoName = 'OM_' . time() . Str::random(8) . '.' . $file->getClientOriginalExtension();
        $thumbnailName = 'THUMB_' . time() . Str::random(8) . '.' . $file->getClientOriginalExtension();

        // ✅ Compress main photo
        $photo = Image::make($file)
            ->orientate()
            ->resize(1200, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })
            ->encode($file->getClientOriginalExtension(), 75);

        // ✅ Compress thumbnail
        $thumbnail = Image::make($file)
            ->orientate()
            ->fit(230, 230)
            ->encode($file->getClientOriginalExtension(), 60);

        $disk->put($fullPath . '/' . $photoName, (string) $photo, 'public');
        $disk->put($fullPath . '/' . $thumbnailName, (string) $thumbnail, 'public');

        // Delete old images
        if (!empty($data['thumbnail'])) {
            $oldThumbPath = parse_url($data['thumbnail'], PHP_URL_PATH);
            $disk->delete($oldThumbPath);
        }

        if (!empty($data[$field])) {
            $oldPhotoPath = parse_url($data[$field], PHP_URL_PATH);
            $disk->delete($oldPhotoPath);
        }

        return [
            'photo' => $disk->url($fullPath . '/' . $photoName),
            'thumbnail' => $disk->url($fullPath . '/' . $thumbnailName),
        ];
    }

    /**
     * Delete image
     */
    public static function handleDeletedImage($data, $field, $delete_path)
    {
        $disk = self::disk();

        if (!empty($data[$field])) {
            $oldPath = parse_url($data[$field], PHP_URL_PATH);
            $disk->delete($oldPath);
        }
    }
}
