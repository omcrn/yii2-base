<?php
/**
 * User: Zura
 * Date: 12/11/2015
 * Time: 1:01 PM
 */

namespace centigen\base\db\mysql;
use centigen\base\db\Connection;


/**
 * Class Schema
 *
 * @author  Zura Sekhniashvili <zurasekhniashvili@gmail.com>
 * @package vendor\centigen\base\db\mysql
 */
class Schema extends \yii\db\mysql\Schema
{
    /**
     * @var Connection the database connection
     */
    public $db;
    /**
     * Quotes a table name for use in a query.
     * A simple table name has no schema prefix.
     * @param string $name table name
     * @return string the properly quoted table name
     */
    public function quoteSimpleTableName($name)
    {
        if ($this->db->disableBackTicks){
            return $name;
        }
        return strpos($name, '`') !== false ? $name : "`$name`";
    }

    /**
     * Quotes a column name for use in a query.
     * A simple column name has no prefix.
     * @param string $name column name
     * @return string the properly quoted column name
     */
    public function quoteSimpleColumnName($name)
    {
        if ($this->db->disableBackTicks){
            return $name;
        }
        return strpos($name, '`') !== false || $name === '*' ? $name : "`$name`";
    }

    /**
     * Creates a query builder for the MySQL database.
     * @return QueryBuilder query builder instance
     */
    public function createQueryBuilder()
    {
        return new QueryBuilder($this->db);
    }
}