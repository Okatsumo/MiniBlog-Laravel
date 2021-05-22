<?php
namespace App\Helpers;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;


/**
 * @param string $path
 * @param $image
 * @param int|null $with
 * @param int|null $height
 * @return string
 */
function uploadImage(string $path, $image, int $with = null, int $height = null): string
{
    $name = rand(50, 999999). "." . str_replace(" ", "-",  $image->getClientOriginalName());
    $image_resize = Image::make($image->getRealPath());

//
//    if($with and $height){
//        $image_resize->resize();
//    }
    $image_resize->save(Storage::path($path) .$name);

    return $name;
}
