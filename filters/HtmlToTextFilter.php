<?php
/**
 * User: Zura
 * Date: 12/2/2015
 * Time: 2:40 PM
 */

namespace centigen\base\filters;
use centigen\base\helpers\Html;
use Yii;
use yii\base\ActionFilter;
use yii\helpers\HtmlPurifier;


/**
 * Class HtmlToTextFilter
 *
 * @author  Zura Sekhniashvili <zurasekhniashvili@gmail.com>
 * @package centigen\base\filters
 */
class HtmlToTextFilter extends ActionFilter
{
    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        if ($this->isActive($action)){
            Yii::$app->request->setRawBody(Html::htmlToText(Yii::$app->request->getRawBody()));
        }
        return true;
    }
}