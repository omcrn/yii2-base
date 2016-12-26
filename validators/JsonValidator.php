<?php
/**
 * User: zura
 * Date: 10/26/2016
 * Time: 6:15 PM
 */

namespace centigen\base\validators;
use Yii;
use yii\validators\Validator;


/**
 * Class JsonValidator
 *
 * @author Zura Sekhniashvili <zurasekhniashvili@gmail.com>
 * @package centigen\base\validators
 */
class JsonValidator extends Validator
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if ($this->message === null) {
            $this->message = Yii::t('common', '"{attribute}" must be a valid JSON');
        }
    }
    /**
     * @inheritdoc
     */
    public function validateValue($value)
    {
        if (!@json_decode($value)) {
            return [$this->message, []];
        }
    }

    /**
     * @inheritdoc
     */
    public function clientValidateAttribute($model, $attribute, $view)
    {
        $message = Yii::$app->getI18n()->format($this->message, [
            'attribute' => $model->getAttributeLabel($attribute)
        ], Yii::$app->language);
        return <<<"JS"
            try {
                JSON.parse(value);
            } catch (e) {
                messages.push('{$message}')
            }
JS;
    }
}