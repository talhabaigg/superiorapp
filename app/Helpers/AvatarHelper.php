<?php

namespace App\Helpers;

class AvatarHelper
{
    public static function generateAvatar($name)
    {
        $initials = collect(explode(' ', $name))->map(function ($part) {
            return strtoupper($part[0]);
        })->join('');

        $colors = [
            [229, 115, 115], [240, 98, 146], [186, 104, 200], [149, 117, 205],
            [100, 181, 246], [77, 208, 225], [77, 182, 172], [129, 199, 132],
            [220, 231, 117], [255, 213, 79], [255, 183, 77], [161, 136, 127]
        ];
        $backgroundColor = $colors[array_rand($colors)];

        $imgWidth = 100;
        $imgHeight = 100;
        $fontSize = 40;

        // Create a blank image
        $image = imagecreatetruecolor($imgWidth, $imgHeight);

        // Allocate background color
        $bgColor = imagecolorallocate($image, $backgroundColor[0], $backgroundColor[1], $backgroundColor[2]);

        // Fill the image with background color
        imagefilledrectangle($image, 0, 0, $imgWidth, $imgHeight, $bgColor);

        // Allocate text color (white)
        $textColor = imagecolorallocate($image, 255, 255, 255);

        // Define the path to the font
        $fontPath = public_path('arial.ttf'); // Make sure the font file exists in this path

        // Calculate text bounding box to center it
        $textBox = imagettfbbox($fontSize, 0, $fontPath, $initials);
        $textX = ($imgWidth - ($textBox[2] - $textBox[0])) / 2;
        $textY = ($imgHeight - ($textBox[7] - $textBox[1])) / 2;

        // Add the text
        imagettftext($image, $fontSize, 0, $textX, $textY, $textColor, $fontPath, $initials);

        // Save the image
        $path = 'avatars/' . uniqid() . '.png';
        imagepng($image, public_path($path));

        // Free up memory
        imagedestroy($image);

        return $path;
    }
}
