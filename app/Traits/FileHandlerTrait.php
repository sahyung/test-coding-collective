<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait FileHandlerTrait
{
    /**
     * Can upload multi image or single image,
     * return
     * single : string
     * multiple : string json array.
     * pri
     *
     * @param mixed
     *
     * @return String
     */
    protected function uploadFile($files, $folderName, $ownerId, $privilege = 'public')
    {
        if (is_array($files)) {
            $filename = [];
            foreach ($files as $file) {
                if ($privilege === 'private') {
                    $filename = $this->uploadFileHandler($file, $folderName, $ownerId, $privilege);
                } else {
                    $filename[] = url('storage/' . $this->uploadFileHandler($file, $folderName, $ownerId));
                }
            }

            return json_encode($filename);
        } else {
            if ($privilege === 'private') {
                $filename = $this->uploadFileHandler($files, $folderName, $ownerId, $privilege);
            } else {
                $filename = url('storage/' . $this->uploadFileHandler($files, $folderName, $ownerId));
            }

            return $filename;
        }
    }

    /**
     * Handler for upload file
     */
    private function uploadFileHandler($file, $folderName, $ownerId, $privilege = 'public')
    {
        $filename = $ownerId . '_' . uniqid() . '.' . $file->extension();
        $folder = $privilege . '/' . $folderName;

        Storage::putFileAs($folder, $file, $filename);

        return $folderName . '/' . $filename;
    }
}
