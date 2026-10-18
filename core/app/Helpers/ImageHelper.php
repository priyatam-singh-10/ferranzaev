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

    public static function handleUploadedImage($file, $path, $delete = null)
    {
        if (!$file) return null;

        $disk = self::disk();

        // Ensure base folder exists (ferranza-image)
        $baseFolder = 'ferranza-image';
        self::ensureFolderExists($baseFolder);

        $fullPath = $baseFolder . '/' . trim($path, '/');

        if ($delete) {
            $disk->delete($fullPath . '/' . $delete);
        }

        $name = 'OM_' . time() . Str::random(8) . '.' . $file->getClientOriginalExtension();
        $disk->putFileAs($fullPath, $file, $name, 'public');

        return $disk->url($fullPath . '/' . $name);
    }

    public static function uploadSummernoteImage($file, $path)
    {
        if (!$file) return null;

        $disk = self::disk();

        $baseFolder = 'ferranza-image';
        self::ensureFolderExists($baseFolder);

        $fullPath = $baseFolder . '/' . trim($path, '/');

        $name = 'OM_' . time() . Str::random(8) . '.' . $file->getClientOriginalExtension();
        $disk->putFileAs($fullPath, $file, $name, 'public');

        return $disk->url($fullPath . '/' . $name);
    }

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
        $thumbnailName = 'OM_' . time() . Str::random(8) . '.' . $file->getClientOriginalExtension();

        $disk->putFileAs($fullPath, $file, $photoName, 'public');

        $thumbnail = Image::make($file)->resize(230, 230)->encode();
        $disk->put($fullPath . '/' . $thumbnailName, $thumbnail, 'public');

        return [
            'photo' => $disk->url($fullPath . '/' . $photoName),
            'thumbnail' => $disk->url($fullPath . '/' . $thumbnailName),
        ];
    }

    public static function handleUpdatedUploadedImage($file, $path, $data, $delete_path, $field)
    {
        if (!$file) return null;

        $disk = self::disk();

        $baseFolder = 'ferranza-image';
        self::ensureFolderExists($baseFolder);

        $fullPath = $baseFolder . '/' . trim($path, '/');

        $name = 'OM_' . time() . Str::random(8) . '.' . $file->getClientOriginalExtension();
        $disk->putFileAs($fullPath, $file, $name, 'public');

        if (!empty($data[$field])) {
            $oldPath = parse_url($data[$field], PHP_URL_PATH);
            $disk->delete($oldPath);
        }

        return $disk->url($fullPath . '/' . $name);
    }

    public static function ItemhandleUpdatedUploadedImage($file, $path, $data, $delete_path, $field)
    {
        if (!$file) return null;

        $disk = self::disk();

        $baseFolder = 'ferranza-image';
        self::ensureFolderExists($baseFolder);

        $fullPath = $baseFolder . '/' . trim($path, '/');

        $photoName = 'OM_' . time() . Str::random(8) . '.' . $file->getClientOriginalExtension();
        $thumbnailName = 'OM_' . time() . Str::random(8) . '.' . $file->getClientOriginalExtension();

        $thumbnail = Image::make($file)->resize(230, 230)->encode();

        $disk->putFileAs($fullPath, $file, $photoName, 'public');
        $disk->put($fullPath . '/' . $thumbnailName, $thumbnail, 'public');

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

    public static function handleDeletedImage($data, $field, $delete_path)
    {
        $disk = self::disk();

        if (!empty($data[$field])) {
            $oldPath = parse_url($data[$field], PHP_URL_PATH);
            $disk->delete($oldPath);
        }
    }
}