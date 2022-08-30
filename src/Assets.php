<?php

namespace HumbleWordPressSetup;

use Illuminate\Support\Arr;

class Assets
{
    public static function allowSvgsInUpload($mimes)
    {
        return Arr::add($mimes, 'svg', 'image/svg+xml');
    }

    public function setImageSizes(): void
    {
        $imageSizes = config('wordpress.imageSizes');

        if (! $imageSizes) {
            return;
        }

        foreach ($imageSizes as $name => $imageSize) {
            $width = isset($imageSize['width']) ? $imageSize['width'] : 0;
            $height = isset($imageSize['height']) ? $imageSize['height'] : 0;
            $crop = isset($imageSize['crop']) ? $imageSize['crop'] : false;

            add_image_size($name, $width, $height, $crop);
        }
    }

    public function removeWpImageSizes(): void
    {
        $sizes = ['thumbnail', 'medium', 'medium_large', 'large', '1536x1536', '2048x2048'];

        foreach ($sizes as $size) {
            remove_image_size($size);
        }
    }
}
