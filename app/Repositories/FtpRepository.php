<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Storage;

class FtpRepository
{
    public function fetchFilesName($directory)
    {
        return Storage::disk('ftp')->files($directory);
    }
    public function downloadFile($filePath)
    {
        $file = Storage::disk('ftp')->get($filePath);
        Storage::disk('local')->put(basename($filePath),$file);
    }
}