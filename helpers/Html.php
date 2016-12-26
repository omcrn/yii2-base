<?php
/**
 * User: Zura
 * Date: 12/2/2015
 * Time: 2:41 PM
 */

namespace centigen\base\helpers;


/**
 * Class Html
 *
 * @author  Zura Sekhniashvili <zurasekhniashvili@gmail.com>
 * @package centigen\base\helpers
 */
class Html extends \yii\bootstrap\Html
{
    /**
     * Convert html to string by removing tags
     *
     * @param array|string $string
     * @param array        $keysToProcess
     * @param array        $keysToExclude
     * @return array|string
     */
    public static function htmlToText($string, $keysToProcess = [], $keysToExclude = [])
    {
        $wasArray = true;
        if (!is_array($string)) {
            $wasArray = false;
            $string = [$string];
        }
        foreach ($string as $key => $val) {
            if (count($keysToProcess) > 0 && in_array($key, $keysToProcess) ||
                count($keysToProcess) === 0 && !in_array($key, $keysToExclude)
            ) {
                if (is_string($val)) {
                    $string[$key] = str_replace('&nbsp;', ' ', strip_tags($val));
                }
            }

        }

        return $wasArray ? $string : $string[0];
    }
}