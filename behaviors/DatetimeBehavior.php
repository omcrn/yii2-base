<?php
/**
 * User: Zura
 * Date: 3/2/2016
 * Time: 1:33 PM
 */

namespace centigen\base\behaviors;
use centigen\base\helpers\DateHelper;
use yii\base\Event;
use yii\base\InvalidConfigException;
use yii\behaviors\AttributeBehavior;
use yii\db\BaseActiveRecord;


/**
 * Class DatetimeBehavior
 *
 * @author Zura Sekhniashvili <zurasekhniashvili@gmail.com>
 * @package centigen\base\behaviors
 */
class DatetimeBehavior extends AttributeBehavior
{
    public $format = null;

    public $timezone = null;

    /**
     * Evaluates the attribute value and assigns it to the current attributes.
     * @param Event $event
     */
    public function evaluateAttributes($event)
    {
        if (!empty($this->attributes[$event->name])) {
            $attributes = (array) $this->attributes[$event->name];
            foreach ($attributes as $attribute) {
                // ignore attribute names which are not string (e.g. when set by TimestampBehavior::updatedAtAttribute)
                if (is_string($attribute)) {
                    $this->owner->$attribute = $this->formatValue($this->owner->$attribute);
                }
            }
        }
    }

    public function formatValue($value)
    {
        if (!$value){
            return $value;
        }
        return DateHelper::fromFormatIntoMysql($this->format, $value, $this->timezone);
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        if ($this->format === null){
            throw new InvalidConfigException(self::className().'::format must be provided');
        }
        $this->attributes = [
            BaseActiveRecord::EVENT_BEFORE_INSERT => $this->attributes,
            BaseActiveRecord::EVENT_BEFORE_UPDATE => $this->attributes,
        ];
        parent::init();
    }
}