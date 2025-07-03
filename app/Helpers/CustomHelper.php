<?php

namespace App\Helpers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class CustomHelper
{
    /**
     * Upload image to public/images folder and return path.
     */


     function createRecord($model, $data)
     {
        $record = new $model($data);
        $record->save();
        return $record;
     }
    public static function uploadImage(Request $request, $fieldName = 'image', $folder = 'images')
    {
        if ($request->hasFile($fieldName)) {
            $file = $request->file($fieldName);
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path($folder), $filename);
            return $folder . '/' . $filename;
        }


        return null;
    }

    /**
     * Generate slug from string.
     */
    public static function generateSlug($string)
    {
        return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $string)));
    }
}
