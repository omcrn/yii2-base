<?php
/**
 * User: Zura
 * Date: 12/18/2015
 * Time: 11:44 AM
 */

namespace centigen\base\helpers;


/**
 * Class Image
 *
 * @author  Zura Sekhniashvili <zurasekhniashvili@gmail.com>
 * @package centigen\base\helpers
 */
class Image
{
    /**
     * Get proportional image height based on original and given width
     *
     * @param $path
     * @param $width
     * @return integer
     */
    public static function getImageHeightFromImage($path, $width)
    {
        $imageInfo = getimagesize($path);
        return (int)($imageInfo[1] * $width / $imageInfo[0]);
    }

}