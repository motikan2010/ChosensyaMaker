<?php
declare(strict_types=1);

namespace App\Http\Services;

use Illuminate\Support\Facades\Log;

class ImageService {

    public function convertImage(string $imageFilename) {
        $inputFileFullPath = storage_path() . '/app/' . $imageFilename;
        $now = new \DateTime();
        $outputFileFullPath = public_path() . '/' . $imageFilename . '.' . $now->format('YmdHis') . '.png';
        $convertLibDir = app_path() . '/Lib/image-background-removal/';
        $convertLibName = 'seg.py';
        $convertCommand = "python {$convertLibDir}{$convertLibName} {$inputFileFullPath} {$outputFileFullPath}"; // 背景透過コマンド
        Log::info($convertCommand);
        exec("cd {$convertLibDir} && $convertCommand"); // 背景透過処理の実行

        return $outputFileFullPath;
    }

    public function trimImageWhitespace(string $imageFilename) {
        $img = imagecreatefrompng($imageFilename);
        $b_top = 0;
        $b_bottom = 0;
        $b_left = 0;
        $b_right = 0;

        //top
        for(; $b_top < imagesy($img); ++$b_top) {
            for($x = 0; $x < imagesx($img); ++$x) {
                if(imagecolorat($img, $x, $b_top) != 0x7f000000) {
                    break 2; //out of the 'top' loop
                }
            }
        }

        //bottom
        for(; $b_bottom < imagesy($img); ++$b_bottom) {
            for($x = 0; $x < imagesx($img); ++$x) {
                if(imagecolorat($img, $x, imagesy($img) - $b_bottom - 1 ) != 0x7f000000) {
                    break 2; //out of the 'bottom' loop
                }
            }
        }

        //left
        for(; $b_left < imagesx($img); ++$b_left) {
            for($y = 0; $y < imagesy($img); ++$y) {
                if(imagecolorat($img, $b_left, $y) != 0x7f000000) {
                    break 2; //out of the 'left' loop
                }
            }
        }

        //right
        for(; $b_right < imagesx($img); ++$b_right) {
            for($y = 0; $y < imagesy($img); ++$y) {
                if(imagecolorat($img, imagesx($img) - $b_right - 1, $y) != 0x7f000000) {
                    break 2; //out of the 'right' loop
                }
            }
        }

        $newImage = imagecreatetruecolor(imagesx($img) - ($b_left + $b_right), imagesy($img) - ($b_top + $b_bottom));
        imagealphablending($newImage, false);
        imagesavealpha($newImage, true);

        imagecopyresampled($newImage, $img,
            0, 0,
            $b_left, $b_top,
            imagesx($img) - ($b_left + $b_right), imagesy($img) - ($b_top + $b_bottom),
            imagesx($img) - ($b_left + $b_right), imagesy($img) - ($b_top + $b_bottom));
        imagepng($newImage, $imageFilename);

        imagedestroy($img);
        imagedestroy($newImage);
    }

}
