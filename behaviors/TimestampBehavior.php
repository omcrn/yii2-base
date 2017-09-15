<?php
/**
 * Created by PhpStorm.
 * User: sai
 * Date: 9/15/17
 * Time: 2:32 PM
 * @author Saiat Kalbiev <kalbievich11@gmail.com>
 */

namespace centigen\base\behaviors;


use yii\base\Behavior;
use yii\db\BaseActiveRecord;

class TimestampBehavior extends Behavior
{
    /**
     * @return array
     * @author Saiat Kalbiev <kalbievich11@gmail.com>
     */
    public function events()
    {
        return [
            BaseActiveRecord::EVENT_BEFORE_INSERT => 'beforeInsert',
            BaseActiveRecord::EVENT_BEFORE_UPDATE => 'beforeUpdate',
        ];
    }

    /**
     * @param $event
     * @author Saiat Kalbiev <kalbievich11@gmail.com>
     */
    public function beforeUpdate($event){
        $sender = $event->sender;
        $oldAttributes = $sender->oldAttributes;
        if(isset($sender->created_at) && isset($oldAttributes['created_at'])){
            $sender->created_at = $oldAttributes['created_at'];
        }
        $sender->updated_at = time();
    }

    /**
     * @param $event
     * @author Saiat Kalbiev <kalbievich11@gmail.com>
     */
    public function beforeInsert($event){
        $sender = $event->sender;
        $sender->created_at = time();
        $sender->updated_at = time();
    }
}