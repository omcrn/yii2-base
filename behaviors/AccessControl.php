<?php
/**
 * User: Zura
 * Date: 1/12/2016
 * Time: 5:08 PM
 */

namespace centigen\base\behaviors;
use Yii;
use yii\helpers\ArrayHelper;


/**
 * Class AccessControl
 *
 * @author  Zura Sekhniashvili <zurasekhniashvili@gmail.com>
 * @package centigen\base\behaviors
 */
class AccessControl extends \yii\filters\AccessControl
{
    public $roleLayouts = [];

    /**
     *
     *
     * @author Zura Sekhniashvili <zurasekhniashvili@gmail.com>
     * @param \yii\base\Action $action
     * @return bool
     */
    public function beforeAction($action)
    {
        $check = parent::beforeAction($action);
        if (!$check){
            return $check;
        }
        $permissions = Yii::$app->authManager->getRolesByUser(Yii::$app->user->id);
        $permission = null;
        foreach ($permissions as $p){
            $permission = $p;
            break;
        }
        if ($permission !== null){
            if (ArrayHelper::getValue($this->roleLayouts, $permission->name)){
                $action->controller->layout = $this->roleLayouts[$permission->name];
            }
        }

        return $check;
    }
}