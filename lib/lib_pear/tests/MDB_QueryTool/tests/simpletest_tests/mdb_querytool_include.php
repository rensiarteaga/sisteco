<?php
// $Id: mdb_querytool_include.php,v 1.1 2005/02/25 14:15:59 quipo Exp $

require_once 'MDB/QueryTool.php';
require_once dirname(__FILE__).'/db_settings.php';

class MDB_QT extends MDB_QueryTool
{
    var $tableSpec = array(
        array(
            'name'      => TABLE_QUESTION,
            'shortName' => TABLE_QUESTION
        ),
        array(
            'name'      => TABLE_ANSWER,
            'shortName' => TABLE_ANSWER
        ),
    );

    function MDB_QT($table = null)
    {
        if (!is_null($table)) {
            $this->table = $table;
        }
        parent::MDB_QueryTool(DB_DSN, $GLOBALS['DB_OPTIONS']);
        $this->setErrorSetCallback(array(&$this,'errorSet'));
        $this->setErrorLogCallback(array(&$this,'errorLog'));
    }

    //
    //  just for the error handling
    //

    function errorSet($msg)
    {
        $GLOBALS['_Common_Errors'][] = array('set', $msg);
    }

    function errorLog($msg)
    {
        $GLOBALS['_Common_Errors'][] = array('log', $msg);
    }

    function getErrors()
    {
        return $GLOBALS['_Common_Errors'];
    }

}

?>