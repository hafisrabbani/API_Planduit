<?php

namespace App\Services\Common\FileHandler;

use Illuminate\Support\Facades\Storage;
use LaravelEasyRepository\Service;

class FileHandlerServiceImplement extends Service implements FileHandlerService
{
    public function uploadFile($file,$path, $file_name){
        try {
            Storage::disk('public')->putFileAs($path, $file, $file_name);
            return $path . '/' . $file_name;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function deleteFile($path)
    {
        try {
            Storage::disk('public')->delete($path);
            return true;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function getFile($path)
    {
        try {
            return Storage::disk('public')->url($path);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
