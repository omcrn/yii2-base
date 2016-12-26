<?php
/**
 * User: Zura
 * Date: 12/11/2015
 * Time: 1:35 PM
 */

namespace centigen\base\db;
use yii\helpers\ArrayHelper;


/**
 * Class ActiveQuery
 *
 * @author  Zura Sekhniashvili <zurasekhniashvili@gmail.com>
 * @package vendor\centigen\base\db
 */
class ActiveQuery extends \yii\db\ActiveQuery
{
    public $disableBackTicks = false;

    /**
     * Disable ` back ticks for this query
     *
     * @author Zura Sekhniashvili <zurasekhniashvili@gmail.com>
     */
    public function disableBackTicks()
    {
        $this->disableBackTicks = true;
    }

    /**
     * Enable ` back ticks for this query
     *
     * @author Zura Sekhniashvili <zurasekhniashvili@gmail.com>
     */
    public function enableBackTicks()
    {
        $this->disableBackTicks = false;
    }

    /**
     * @inheritdoc
     */
    public function prepare($builder)
    {
        $saveBackTicks = $builder->db->disableBackTicks;
        $builder->db->disableBackTicks = $this->disableBackTicks;

        $res = parent::prepare($builder);

        $builder->db->disableBackTicks = $saveBackTicks;
        return $res;

    }

}