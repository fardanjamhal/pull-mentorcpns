<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Traits\Imageable;
use Carbon\Carbon;

trait Uploadable
{
    use Imageable;

    /**
     * Undocumented function
     *
     * @param UploadedFile $file
     * @param string $path|null
     * @param string $disk
     * @return boolean|string
     */

    public function uploadFile(UploadedFile $file, $filename = null, $path = null, $disk = 'public')
    {
        if ($file->isValid()) {
            $set_name = Carbon::now()->format('ymdhs').'_'.$file->getClientOriginalName();
            return ($file->storeAs($path, $set_name, $disk)) ? $set_name : false;
        }
        return false;
    }

    /**
     * Undocumented function
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
     * Undocumented function
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
