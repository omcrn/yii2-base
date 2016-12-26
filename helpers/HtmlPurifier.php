<?php
/**
 * User: Zura
 * Date: 12/2/2015
 * Time: 3:44 PM
 */

namespace centigen\base\helpers;


/**
 * Class HtmlPurifier
 *
 * @author  Zura Sekhniashvili <zurasekhniashvili@gmail.com>
 * @package centigen\base\helpers
 */
class HtmlPurifier extends \yii\helpers\HtmlPurifier
{
    /**
     * Process each array item (if it's string) with key in $keysToProcess array with HtmlPurifier::process method.
     * If you want to process the whole array leave second and third parameters as it is.
     * You can exclude keys by giving them third parameter.
     *
     * @author Zura Sekhniashvili <zurasekhniashvili@gmail.com>
     * @param       $array
     * @param array $keysToProcess
     * @param array $keysToExclude
     * @return mixed
     */
    public static function processArray($array, $keysToProcess = [], $keysToExclude = [])
    {
        foreach ($array as $key => $value){
            if (count($keysToProcess) > 0 && in_array($key, $keysToProcess) ||
                    count($keysToProcess) === 0 && !in_array($key, $keysToExclude)){
                if (is_string($value)){
                    $array[$key] = self::process($value);
                }
            }
        }
        return $array;
    }
}