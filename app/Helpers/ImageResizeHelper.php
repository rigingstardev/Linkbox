<?php

namespace App\Helpers;

use Intervention\Image\Facades\Image;

/**
 * EmailHelper - Helper class used for sending emails
 *
 */
class ImageResizeHelper {

    /**
     * sendEmail
     *
     * Method uder for sending emails to users
     * 
     */
    public static function resizeImage($imgObj, $imageName, $size = 'thumb', $imageSavePath = 'uploads/') {
        $imageResize = Image::make($imgObj);
        switch ($size) {
            case 'thumb':
                $imageResize->resize(112, 112, function ($constraint) {
//                    $constraint->aspectRatio();
//                    $constraint->upsize();
                });
                break;
            case 'icon':
                $imageResize->resize(41, 41, function ($constraint) {
//                    $constraint->aspectRatio();
//                    $constraint->upsize();
                });
                break;
            default:
                $imageResize->resize(200, 200, function ($constraint) {
//                    $constraint->aspectRatio();
//                    $constraint->upsize();
                });
                break;
        }
        $imageResize->save($imageSavePath . $size . '_' . $imageName);
        return true;
    }

}
