<?php
/**
 * User: Zura
 * Date: 12/2/2015
 * Time: 1:00 PM
 */

namespace centigen\base\filters;
use Yii;
use yii\base\ActionFilter;
use yii\helpers\HtmlPurifier;


/**
 * Class PurifierFilter
 *
 * @author  Zura Sekhniashvili <zurasekhniashvili@gmail.com>
 * @package centigen\base\filters
 */
class PurifierFilter extends ActionFilter
{
    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        if ($this->isActive($action)){
            Yii::$app->request->setRawBody(HtmlPurifier::process(Yii::$app->request->getRawBody()));
        }
        return true;
    }
}