<?php
/**
 * User: zura
 * Date: 1/12/17
 * Time: 12:23 PM
 */

namespace centigen\base\i18n;

use yii\bootstrap\Html;
use yii\helpers\ArrayHelper;


/**
 * Class Formatter
 *
 * @author Zura Sekhniashvili <zurasekhniashvili@gmail.com>
 * @package omcrn\base\component\i18n
 */
class Formatter extends \yii\i18n\Formatter
{
    public $yiiFormatToMomentMapping = [
        //      php intl      -       momentjs
        'php:d F Y' => 'DD MMMM YYYY',
        'php:d M Y' => 'DD MMM YYYY',
    ];

    public $yiiFormatToPhpMapping = [
        //     intl    -        php
        'DD/MM/YYYY HH:mm' => 'd/m/Y H:i',
        'MM/DD/YYYY HH:mm' => 'm/d/Y H:i'
    ];

    /**
     * Return bootstrap <span class="label"></span> with class `label-success` or `label-danger`
     * depending on $value param
     *
     * @author Zura Sekhniashvili <zurasekhniashvili@gmail.com>
     * @param $value
     * @return string
     */
    public function asStatusLabel($value)
    {
        if ($value) {
            return Html::tag('span', \Yii::t('omcrnActive', "Active"), ['class' => 'label label-success']);
        }
        return Html::tag('span', \Yii::t('omcrnActive', "Inactive"), ['class' => 'label label-danger']);
    }

    /**
     * @param $value
     * @param bool $disabled
     * @return string
     */
    public function asToggle($value, $disabled = false)
    {
        if ($value === null) {
            return "";
        }
        $div = '<div class="togglebutton">
                  <label>
                    <input type="checkbox"' . ($value ? ' checked' : '') . ($disabled ? ' disabled' : '') . '>
                    <span class="toggle"></span>
                  </label>
                </div>';
        return $div;
    }

    /**
     * Get corresponding momentjs format fot given yii format
     *
     * @author Zura Sekhniashvili <zurasekhniashvili@gmail.com>
     * @param $format
     * @return mixed
     */
    public function getMomentFormat($format)
    {
        return ArrayHelper::getValue($this->yiiFormatToMomentMapping, $format) ?: $format;
    }

    /**
     * Get corresponding php format for given yii format
     *
     * @author Zura Sekhniashvili <zurasekhniashvili@gmail.com>
     * @param $format
     * @return mixed
     */
    public function getPhpFormat($format)
    {
        $format = ArrayHelper::getValue($this->yiiFormatToPhpMapping, $format);
        if (!$format && strpos($format, 'php:') === 0){
            return str_replace('php:', '', $format);
        }
        return $format;
    }

    /**
     * Get corresponding momentjs format for current `datetimeFormat`
     *
     * @author Zura Sekhniashvili <zurasekhniashvili@gmail.com>
     * @return mixed
     */
    public function getMomentDatetimeFormat()
    {
        return $this->getMomentFormat(\Yii::$app->formatter->datetimeFormat);
    }

    /**
     * Get corresponding php datetime formar for current `datetimeFormat`
     *
     * @author Zura Sekhniashvili <zurasekhniashvili@gmail.com>
     * @return mixed
     */
    public function getPhpDatetimeFormat()
    {
        return $this->getPhpFormat(\Yii::$app->formatter->datetimeFormat);
    }
}