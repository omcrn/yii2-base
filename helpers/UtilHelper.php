<?php
/**
 * User: Zura
 * Date: 3/2/2016
 * Time: 10:44 AM
 */

namespace centigen\base\helpers;

use yii\helpers\VarDumper;


/**
 * Class UtilHelper
 *
 * @author Zura Sekhniashvili <zurasekhniashvili@gmail.com>
 * @package centigen\base\helpers
 */
class UtilHelper
{
    /**
     * Get array of ids from array of objects
     *
     * @author zura
     * @param array $objects
     * @param bool $isObjects
     * @param string $propertyName
     * @return array
     */
    public static function fromTwoDimensionArrayToArray(array $objects, $isObjects = false, $propertyName = 'id')
    {
        $ids = [];
        foreach ($objects as $o) {
            $ids[] = $isObjects ? $o->{$propertyName} : $o[$propertyName];
        }
        return $ids;
    }

    /**
     * Convert plain array of object/arrays into "hashmap".
     *
     * @author Zura Sekhniashvili <zurasekhniashvili@gmail.com>
     * @param           $array
     * @param string $keyName
     * @param array $valueProperties
     * @param bool|true $isUnique
     * @return array
     */
    public static function fromArrayToMap($array, $keyName = 'id', $isUnique = true, $valueProperties = [])
    {
        $return = [];
        foreach ($array as $item) {
            $key = $item[$keyName];

            if (!empty($valueProperties)) {
                $item = array_intersect_key($item, array_flip($valueProperties));
            }
            if ($isUnique) {
                $return[$key] = $item;
            } else {
                if (!isset($return[$key])) {
                    $return[$key] = [];
                }
                $return[$key][] = $item;
            }
        }
        return $return;
    }

    public static function vardump()
    {
        echo '<pre>';
        $args = func_get_args();
        foreach ($args as $arg) {
            var_dump($arg);
        }
        echo '</pre>';
    }

    public static function dumpAsString()
    {
        $content = '<pre>';
        $args = func_get_args();
        foreach ($args as $arg) {
            $content .= VarDumper::dumpAsString($arg);
        }
        $content .= '</pre>';

        return $content;
    }

    public static function formatError(\Exception $e)
    {
        return sprintf('FILE="%s"; LINE="%s"; ERROR="%s"; ', $e->getFile(), $e->getLine(), $e->getMessage());
    }

    public static function createTreeByParentId($data, $parentIdAttr = 'parent_id')
    {
        $new = [];
        foreach ($data as $a) {
            if (!$a[$parentIdAttr]){
                $new[0][] = $a;
            } else {
                $new[$a[$parentIdAttr]][] = $a;
            }

        }
        $return = [];
        if (!empty($new) && isset($new[0])) {
            foreach ($new[0] as $rec) {
                $return[] = self::_createTreeByParentId($new, [$rec])[0];
            }
        }
        return $return;
    }

    private static function _createTreeByParentId(&$list, $parent)
    {
        $tree = [];
        foreach ($parent as $k => $l) {
            if (isset($list[$l['id']])) {
                $l['children'] = self::_createTreeByParentId($list, $list[$l['id']]);
            }
            $tree[] = $l;
        }
        return $tree;
    }
}