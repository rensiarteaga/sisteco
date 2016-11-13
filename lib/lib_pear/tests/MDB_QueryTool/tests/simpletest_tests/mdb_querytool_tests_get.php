<?php
// $Id: mdb_querytool_tests_get.php,v 1.1 2005/02/25 14:15:59 quipo Exp $

require_once 'simple_include.php';
require_once 'mdb_querytool_include.php';

class MDB_QueryToolTests_Get extends GroupTest {
    function MDB_QueryToolTests_Get() {
        $this->GroupTest('MDB_QueryTool Get Tests');
        $this->addTestFile('mdb_querytool_testGet.php');
        $this->addTestFile('mdb_querytool_testGetAll.php');
        $this->addTestFile('mdb_querytool_testGetCount.php');
        $this->addTestFile('mdb_querytool_testGetQueryString.php');
    }
}

if (!defined('TEST_RUNNING')) {
    define('TEST_RUNNING', true);
    $test = &new MDB_QueryToolTests_Get();
    $test->run(new HtmlReporter());
}
?>