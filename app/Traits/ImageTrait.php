<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait ImageTrait
{
    public static function uploadImage($image, $path)
    {
        $path = $image->store($path, 'public');
        return $path;
    }

    public static function uploadImageS3($image, $path)
    {
        $fileName = time() . '_' . $image->getClientOriginalName();
        $filePath = $path . '/' . $fileName;
        Storage::disk('s3')->put($filePath, file_get_contents($image));
        return $filePath;
    }


    public static function updateImage($object, $file, $input)
    {
        if (request()->hasFile($input)) {
            if ($object != null) {
                Storage::disk('public')->delete($object);
            }
            return $data[$input] = ImageTrait::uploadImage(request()->file($input), $file);
        } else {
            return $data[$input] = $object;
        }
    }

    public static function updateImageS3($object, $path, $input)
    {
        if (request()->hasFile($input)) {
            if (!is_null($object)) {
                Storage::disk('s3')->delete($object);
            }
            return self::uploadImageS3(request()->file($input), $path);
        }
        return $object;
    }

    
}
