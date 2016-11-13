<?php
// $Id: mdb_querytool_testDbInstance.php,v 1.1 2005/02/25 14:15:59 quipo Exp $

require_once dirname(__FILE__).'/mdb_querytool_test_base.php';

class TestOfMDB_QueryToolDbInstance extends TestOfMDB_QueryTool
{
    function TestOfMDB_QueryToolDbInstance($name = __CLASS__) {
        $this->UnitTestCase($name);
    }
    function testSetDbInstanceDefault () {
        $db =& MDB::connect(DB_DSN, $GLOBALS['DB_OPTIONS']);

        $qt =& new MDB_QueryTool();
        $qt->setDbInstance($db);
        $dbActual =& $qt->getDbInstance();
        $this->assertEqual($db->fetchmode, $dbActual->fetchmode);
    }
    function SetDbInstanceOldWay () {
        $qt =& new MDB_QueryTool(DB_DSN, $GLOBALS['DB_OPTIONS']);
        $db =& $qt->getDbInstance();
        $this->assertTrue(is_a($db, 'mdb_common'));
    }
}

if (!defined('TEST_RUNNING')) {
    define('TEST_RUNNING', true);
    $test = &new TestOfMDB_QueryToolDbInstance();
    $test->run(new HtmlReporter());
}
?>