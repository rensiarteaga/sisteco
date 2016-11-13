<?php
// $Id: all_tests.php,v 1.1 2005/02/25 14:15:59 quipo Exp $

require_once 'simple_include.php';
require_once 'mdb_querytool_include.php';

define('TEST_RUNNING', true);

require_once './mdb_querytool_tests_get.php';
require_once './mdb_querytool_tests_usage.php';

class AllTests extends GroupTest {
    function AllTests() {
        $this->GroupTest('All PEAR::MDB_QueryTool Tests - '.DB_TYPE);
        $this->AddTestCase(new MDB_QueryToolTests_Get());
        $this->AddTestCase(new MDB_QueryToolTests_Usage());
    }
}

$test = &new AllTests();
$test->run(new HtmlReporter());
?>