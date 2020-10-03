<?php

namespace App\Traits;

Trait PostTrait
{
    function saveImage($image, $folder)
    {
        $ext = $image->getClientOriginalExtension();
        $imageName = 'blog-' . uniqid() . ".$ext";
        $destinationPath = public_path($folder);
        $image->move($destinationPath, $imageName);

        return $imageName;
    }
}



?>
