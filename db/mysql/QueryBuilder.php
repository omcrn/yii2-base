<?php
/**
 * User: Zura
 * Date: 12/11/2015
 * Time: 1:37 PM
 */

namespace centigen\base\db\mysql;
use centigen\base\db\ActiveQuery;
use centigen\base\db\Connection;


/**
 * Class QueryBuilder
 *
 * @author  Zura Sekhniashvili <zurasekhniashvili@gmail.com>
 * @package centigen\base\db\mysql
 */
class QueryBuilder extends \yii\db\mysql\QueryBuilder
{

    /**
     * @var Connection the database connection.
     */
    public $db;
    /**
     * Generates a SELECT SQL statement from a [[Query]] object.
     * @param ActiveQuery $query the [[Query]] object from which the SQL statement will be generated.
     * @param array $params the parameters to be bound to the generated SQL statement. These parameters will
     * be included in the result with the additional parameters generated during the query building process.
     * @return array the generated SQL statement (the first array element) and the corresponding
     * parameters to be bound to the SQL statement (the second array element). The parameters returned
     * include those provided in `$params`.
     */
    public function build($query, $params = [])
    {
        $saveBackTicks = $this->db->disableBackTicks;
        if ($query->hasProperty('disableBackTicks') && $query->disableBackTicks !== null){
            $this->db->disableBackTicks = $query->disableBackTicks;
        }

        $res = parent::build($query, $params);

        $this->db->disableBackTicks = $saveBackTicks;
        return $res;
    }
}