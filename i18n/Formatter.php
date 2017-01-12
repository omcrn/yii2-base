<?php
/**
 * User: zura
 * Date: 1/12/17
 * Time: 12:23 PM
 */

namespace centigen\base\i18n;

use yii\bootstrap\Html;


/**
 * Class Formatter
 *
 * @author Zura Sekhniashvili <zurasekhniashvili@gmail.com>
 * @package omcrn\base\component\i18n
 */
class Formatter extends \yii\i18n\Formatter
{
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
        if ($value){
            return Html::tag('span', \Yii::t('omcrnActive', "Active"), ['class' => 'label label-success']);
        }
        return Html::tag('span', \Yii::t('omcrnActive', "Inactive"), ['class' => 'label label-danger']);
    }
}