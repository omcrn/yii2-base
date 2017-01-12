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
    public function asStatusLabel($status)
    {
        if ($status){
            return Html::tag('span', \Yii::t('omcrnActive', "Active"), ['label label-success']);
        }
        return Html::tag('span', \Yii::t('omcrnActive', "Inactive"), ['label label-danger']);
    }
}