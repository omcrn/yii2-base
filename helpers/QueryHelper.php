<?php
/**
 * User: Zura
 * Date: 3/2/2016
 * Time: 6:24 PM
 */

namespace centigen\base\helpers;
use Yii;
use yii\db\Query;


/**
 * Class QueryHelper
 *
 * @author Zura Sekhniashvili <zurasekhniashvili@gmail.com>
 * @package centigen\base\helpers
 */
class QueryHelper
{
    /**
     * Get generated sql of query
     *
     * @author zura
     * @param Query $query
     * @return string
     */
    public static function getSql(Query $query)
    {
        $sql = $query->prepare(Yii::$app->db->queryBuilder)->createCommand()->sql;
        return $sql;
    }

    /**
     * Get generate raw sql of query
     *
     * @author zura
     * @param Query $query
     * @return string
     */
    public static function getRawSql(Query $query)
    {
        $sql = $query->prepare(Yii::$app->db->queryBuilder)->createCommand()->rawSql;
        return $sql;
    }

    /**
     * Get params of query
     *
     * @author zura
     * @param Query $query
     * @return array
     */
    public static function getParams(Query $query)
    {
        return $query->prepare(Yii::$app->db->queryBuilder)->createCommand()->params;
    }
}