<?php

namespace App\Traits;
use Illuminate\Support\Facades\File;

use Image;

trait ImageTrait
{
    public function uploadImage($image, $filename = 'image', $directory = 'images')
    {
        // image extension
        $extension = $image->getClientOriginalExtension();
        // destination path
        $destinationPath = public_path("images/upload/{$directory}");
        // create image new name        
        $imageName = "{$filename}_" . time() . '.' . $extension;
        // create image instanc and save
        $imageFile = Image::make($image->getRealPath());
        $imageFile->save($destinationPath . '/' . $imageName);
        // get image url
        $imageUrl = "images/upload/{$directory}/" . $imageName;

        return $imageUrl;
    }

    public function deleteImage($imageUrl)
    {
        if (File::exists(public_path($imageUrl))) {
            // delete image from storage
            File::delete($imageUrl);
        }
    }
}
