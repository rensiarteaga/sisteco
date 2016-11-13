<?php
// $Id: mdb_querytool_tests_usage.php,v 1.1 2005/02/25 14:15:59 quipo Exp $

require_once 'simple_include.php';
require_once 'mdb_querytool_include.php';

class MDB_QueryToolTests_Usage extends GroupTest {
    function MDB_QueryToolTests_Usage() {
        $this->GroupTest('MDB_QueryTool Usage Tests');
        $this->addTestFile('mdb_querytool_testDbInstance.php');
        $this->addTestFile('mdb_querytool_testLimit.php');
        $this->addTestFile('mdb_querytool_testWhere.php');
        $this->addTestFile('mdb_querytool_testHaving.php');

    }
}

if (!defined('TEST_RUNNING')) {
    define('TEST_RUNNING', true);
    $test = &new MDB_QueryToolTests_Usage();
    $test->run(new HtmlReporter());
}
?>