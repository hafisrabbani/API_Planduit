<?php

namespace App\Services\Common\FileHandler;

use LaravelEasyRepository\BaseService;

interface FileHandlerService extends BaseService{
    public function uploadFile($file, $path, $file_name);
    public function deleteFile($path);
    public function getFile($path);
}
