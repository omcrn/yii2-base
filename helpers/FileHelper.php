<?php
/**
 * Created by PhpStorm.
 * User: Zura
 * Date: 7/20/2015
 * Time: 4:51 PM
 */

namespace centigen\base\helpers;


class FileHelper extends \yii\helpers\FileHelper
{

    /**
     * Create directory hierarchy of $string in $rootDir directory
     *
     * @author zura
     * @param $rootDir
     * @param $string
     */
    public static function createDirectoryTree($rootDir, $string)
    {
        $parts = explode('/', $string);
        $path = $rootDir;
        foreach ($parts as $part) {
            if (!$part) {
                continue;
            }
            $path = $path . '/' . $part;
            if (file_exists($path) && is_dir($path)) {
                continue;
            }
            mkdir($path, 0777, true);
        }
    }

    /**
     * Delete everything in the given directory
     *
     * @author zura
     * @param $dir
     * @param bool $deleteItself
     * @return bool
     */
    public static function emptyDirectory($dir, $deleteItself = true)
    {
        try {
            if (!file_exists($dir) || !is_dir($dir)) {
                return true;
            }
            $dir = trim($dir, '/') . '/';
            $list = scandir($dir);
            foreach ($list as $item) {
                if ($item === '.' || $item === '..') {
                    continue;
                }
                if (is_dir($dir . $item)) {
                    self::emptyDirectory($dir . $item);
                } else {
                    unlink($dir . $item);
                }
//                // \ChromePhp::log($item);
            }
            if ($deleteItself) {
                unlink($dir);
            }
            return true;
        }
        catch(\Exception $e) {
//            \ChromePhp::error($e);
            return false;
        }
    }

    public static function getExtensionFromFilename($filename)
    {
        return pathinfo($filename, PATHINFO_EXTENSION);
    }

    public static function appendTimestamp($url)
    {
        return $url . '?t=' . time();
    }

    public static function findFiles($dir, $options = [])
    {
        $dirName = dirname($dir);
        $filename = basename($dir);
        $list = scandir($dirName);
        $return = [];
        foreach ($list as $file){
            if ($file === '.' || $file === '..'){
                continue;
            }
            if (strpos($file, $filename) === 0){
                $return[] = $dirName.'/'.$file;
            }
        }
        return $return;
    }
} 