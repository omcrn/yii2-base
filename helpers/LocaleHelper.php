<?php
/**
 * User: zura
 * Date: 1/27/17
 * Time: 10:16 AM
 */

namespace centigen\base\helpers;

use Yii;
use yii\helpers\ArrayHelper;


/**
 * Class LocaleHelper
 *
 * @author Zura Sekhniashvili <zurasekhniashvili@gmail.com>
 * @package centigen\base\helpers
 */
class LocaleHelper
{
    /**
     * Returns availableLocales from `Yii::$app->params` if it is set. If not it will return Yii::$app->language
     *
     * @author Zura Sekhniashvili <zurasekhniashvili@gmail.com>
     * @return array
     */
    public static function getAvailableLocales()
    {
        $locales = [];
        if (isset(Yii::$app->params['availableLocales'])) {
            $locales = Yii::$app->params['availableLocales'];
        }

        if (count($locales) === 0) {
            $locales = [Yii::$app->language => Yii::$app->language];
        }

        return $locales;
    }

    /**
     * Get locale value by key from 'availableLocales' array
     *
     * @author Zura Sekhniashvili <zurasekhniashvili@gmail.com>
     * @param $key
     * @return mixed|null
     */
    public static function getByKey($key)
    {
        $locales = self::getAvailableLocales();
        foreach ($locales as $localeKey => $locale){
            if (explode("-", $localeKey)[0] === explode("-", $key)[0]){
                return $locale;
            }
        }
        return null;
    }

    public static function isEqual($locale1, $locale2)
    {
        return explode("-", $locale1)[0] === explode("-", $locale2)[0];
    }
}