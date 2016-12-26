<?php

namespace centigen\base\behaviors;

/**
 * User: giokoco
 * Date: 9/10/2015
 * Time: 10:44 AM
 */
class LayoutBehavior extends \yii\base\Behavior
{
    /**
     * Layout file name
     *
     * @var
     */
    public $layout;

    public function events()
    {
        return [
            \yii\web\Controller::EVENT_BEFORE_ACTION => 'beforeAction',
        ];
    }

    public function beforeAction($event)
    {
        if ($this->layout){
            $event->sender->layout = $this->layout;
        }
    }
} 