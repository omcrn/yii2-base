<?php
/**
 * User: Zura
 * Date: 12/11/2015
 * Time: 1:00 PM
 */

namespace centigen\base\db;


/**
 * Class Connection
 *
 * @author  Zura Sekhniashvili <zurasekhniashvili@gmail.com>
 * @package vendor\centigen\base\db
 */
class Connection extends \yii\db\Connection
{

    /**
     * Whether to disable backtick for mysql or not
     *
     * @author Zura Sekhniashvili <zurasekhniashvili@gmail.com>
     * @var bool
     */
    public $disableBackTicks = false;

    /**
     * @var array mapping between PDO driver names and [[Schema]] classes.
     * The keys of the array are PDO driver names while the values the corresponding
     * schema class name or configuration. Please refer to [[Yii::createObject()]] for
     * details on how to specify a configuration.
     *
     * This property is mainly used by [[getSchema()]] when fetching the database schema information.
     * You normally do not need to set this property unless you want to use your own
     * [[Schema]] class to support DBMS that is not supported by Yii.
     */
    public $schemaMap = [
        'pgsql' => 'yii\db\pgsql\Schema', // PostgreSQL
        'mysqli' => 'yii\db\mysql\Schema', // MySQL
        'mysql' => 'centigen\base\db\mysql\Schema', // MySQL
        'sqlite' => 'yii\db\sqlite\Schema', // sqlite 3
        'sqlite2' => 'yii\db\sqlite\Schema', // sqlite 2
        'sqlsrv' => 'yii\db\mssql\Schema', // newer MSSQL driver on MS Windows hosts
        'oci' => 'yii\db\oci\Schema', // Oracle driver
        'mssql' => 'yii\db\mssql\Schema', // older MSSQL driver on MS Windows hosts
        'dblib' => 'yii\db\mssql\Schema', // dblib drivers on GNU/Linux (and maybe other OSes) hosts
        'cubrid' => 'yii\db\cubrid\Schema', // CUBRID
    ];
}