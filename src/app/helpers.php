<?php
namespace App\Helpers;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;


function uploadImage(string $path, $image, int $with, int $height): string
{
    $name = mt_rand(50, 100). "." . $image->getClientOriginalName();

    $image_resize = Image::make($image->getRealPath());
    $image_resize->resize($with, $height);
    $image_resize->save(Storage::path($path) .$name);

    return $name;
}
