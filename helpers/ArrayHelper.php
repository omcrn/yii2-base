<?php
/**
 * User: Zura
 * Date: 1/28/2016
 * Time: 6:09 PM
 */

namespace centigen\base\helpers;


/**
 * Class ArrayHelper
 *
 * @author  Zura Sekhniashvili <zurasekhniashvili@gmail.com>
 * @package centigen\base\helpers
 */
class ArrayHelper
{
    /**
     * Merge two arrays. One from the first array, seconds from second, third from first array, fourth from second and so on
     *
     * @author Zura Sekhniashvili <zurasekhniashvili@gmail.com>
     * @param array $array1
     * @param array $array2
     * @return array
     */
    public static function mergeLikeZebra(array $array1, array $array2)
    {
        $array = [];
        $i = 0;
        $j = 0;
        $len1 = count($array1);
        $len2 = count($array2);
        $length = $len1 + $len2;
        $ind = 0;
        $first = true;
        while ($ind < $length) {
            if ($i == $len1) {
                $array[$ind] = $array2[$j++];
            } else if ($j == $len2) {
                $array[$ind] = $array1[$i++];
            } else if ($first) {
                $array[$ind] = $array1[$i++];
            } else {
                $array[$ind] = $array2[$j++];
            }
            $first = !$first;
            $ind++;
        }
        return $array;
    }

    /**
     * Get array of ids from array of objects/arrays
     *
     * @author zura
     * @param array $objects
     * @param string $propertyName
     * @return array
     */
    public static function getIdsFromMultiArray(array $objects, $propertyName = 'id')
    {
        $ids = [];
        foreach ($objects as $o) {
            $ids[] = $o[$propertyName];
        }
        return $ids;
    }

    public static function getValuesForKeys($mapping, $keys)
    {
        $arr = [];
        foreach ($keys as $key) {
            $arr[] = $mapping[$key];
        }
        return $arr;
    }

    public static function stringsToInts($array)
    {
        return array_map(function($value) { return (int)$value; }, $array);
    }
}