<?php

namespace App\Models;

use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Config;

class UploadImageModel
{
    /**
     * uploads base64 image url to s3 as a png.
     * TODO: to update to allow non png files as well.
     *
     * @param [type] $imageB64Url
     * @return void
     */
    public function uploadParticipantImage($imageFile, $participantUserId)
    {
        try {
            if ($imageFile) {
                $imageName       = $participantUserId
                                . '_' . time()
                                . $this->getEndingFromImageType($imageFile->getMimeType());
            }
            $isUploaded      = Storage::disk('s3')->put(
                Config::get('booster.s3_user_profile_images')
                . $imageName,
                file_get_contents($imageFile->getRealPath()),
                'public'
            );
        } catch (Exception $e) {
            //do nothing in case of invalid photo uploaded
            $imageName = null;
        }

        return $imageName;
    }

    public function deleteParticipantImage($imageName)
    {
        Storage::disk('s3')->delete(Config::get('booster.s3_user_profile_images') . $imageName);
    }

    public function getEndingFromImageType($imageType)
    {
        $types = [
            'image/png'  => '.png',
            'image/jpg'  => '.jpg',
            'image/jpeg' => '.jpg',
        ];
        return $types[$imageType];
    }
}
