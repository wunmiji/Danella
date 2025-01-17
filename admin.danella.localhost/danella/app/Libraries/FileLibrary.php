<?php


namespace App\Libraries;


class FileLibrary
{

    public static $dir = 'assets' . DIRECTORY_SEPARATOR . 'file-manager' . DIRECTORY_SEPARATOR;
    public static $publicDir = 'assets' . DIRECTORY_SEPARATOR . 'file-manager' . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR;
    public static $privateDir = 'assets' . DIRECTORY_SEPARATOR . 'file-manager' . DIRECTORY_SEPARATOR . 'private' . DIRECTORY_SEPARATOR;

    public static function createFolder($path)
    {
        if (!is_dir($path)) {
            mkdir($path, 0777, TRUE);
        }

        return $path . DIRECTORY_SEPARATOR;
    }

    public static function moveFiles($files, $path)
    {
        foreach ($files as $file) {
            if ($file->isValid()) {
                $fileImage = $file->getTempName();
                $fileName = $file->getClientName();
                $fileDestination = $path . DIRECTORY_SEPARATOR . $fileName;

                if (!$file->hasMoved())
                    move_uploaded_file($fileImage, $fileDestination);
            }
        }
    }

    public static function deleteDirectory($dirPath)
    {
        if (is_dir($dirPath)) {
            $files = scandir($dirPath);
            foreach ($files as $file) {
                if ($file !== '.' && $file !== '..') {
                    $filePath = $dirPath . '/' . $file;
                    if (is_dir($filePath)) {
                        static::deleteDirectory($filePath);
                    } else {
                        unlink($filePath);
                    }
                }
            }
            rmdir($dirPath);
        }
    }

    public static function deleteFile($filePath)
    {
        if (file_exists($filePath))
            unlink(FCPATH . $filePath);
    }

    public static function rename($oldName, $newName)
    {
        rename($oldName, $newName);
    }

    public static function formatBytes($bytes, $precision = 2)
    {
        $kilobyte = 1024;
        $megabyte = $kilobyte * 1024;
        $gigabyte = $megabyte * 1024;

        if ($bytes < $kilobyte) {
            return $bytes ?? 0 . ' b';
        } elseif ($bytes < $megabyte) {
            return round($bytes / $kilobyte, $precision) . ' kb';
        } elseif ($bytes < $gigabyte) {
            return round($bytes / $megabyte, $precision) . ' mb';
        } else {
            return round($bytes / $gigabyte, $precision) . ' gb';
        }
    }


}









