<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class UploadService
{
    /**
     * Upload file
     *
     * @param UploadedFile $file
     * @param string $path|null
     * @param string $disk
     * @return boolean|string
     */

    public function uploadFile(UploadedFile $file, $path = null, $disk = 'public')
    {
        if ($file->isValid()) {
            $set_name = Carbon::now()->format('ymdhs').'_'.$file->getClientOriginalName();
            return ($file->storeAs($path, $set_name, $disk)) ? $set_name : false;
        }
        return false;
    }

    /**
     * delete file
     *
     * @param string $filename
     * @param string|null $path
     * @param string|null $disk
     * @return boolean
     */
    public function deleteFile($filename, $path = null, $disk = 'public')
    {
        $storage = Storage::disk($disk);
        $filepath = ($path != null ? $path . '/' : null) . $filename;

        if ($storage->exists($filepath)) {
            return $storage->delete($filepath);
        }
        return true;
    }

    /**
     * delete dir
     *
     * @param string $dir
     * @return bool
     */
    public function deleteDir($dir, $disk = 'public')
    {
        $storage = Storage::disk($disk);

        if ($storage->exists($dir)) {
            return $storage->deleteDirectory($dir);
        }

        return true;
    }
}
