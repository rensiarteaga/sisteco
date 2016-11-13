<?php
//
//  $Id: index.php,v 1.1 2003/06/09 19:48:19 quipo Exp $
//

ini_set('include_path', realpath(dirname(__FILE__).'/../../../').':'.realpath(dirname(__FILE__).'/../../../../includes').':'.ini_get('include_path'));
require_once 'MDB/QueryTool.php';
require_once 'PHPUnit.php';
require_once 'PHPUnit/GUI/HTML.php';

define('DB_DSN', 'mysql://root@localhost/mdb_qt');
define('TABLE_USER',      'QueryTool_user');
define('TABLE_ADDRESS',   'QueryTool_address');
define('TABLE_QUESTION',  'question');
define('TABLE_ANSWER',    'answer');

$allTables = array(TABLE_USER, TABLE_ADDRESS, TABLE_QUESTION, TABLE_ANSWER);
require_once 'sql.php';

require_once 'UnitTest.php';
require_once 'Common.php';

//
//  common setup (this actually also does the tearDown, since we have the DROP TABLE queries in the setup too
//
$querytool = new tests_Common();
foreach ($dbStructure[$querytool->db->phptype]['setup'] as $aQuery) {
    if (MDB::isError($ret = $querytool->db->query($aQuery))) {
        //include_once 'Var_Dump.php';
        //var_dump::display($ret);
        die($ret->getUserInfo());
    }
}

//
//  run the test suite
//

require_once 'PHPUnit/GUI/SetupDecorator.php';
$gui = new PHPUnit_GUI_SetupDecorator(new PHPUnit_GUI_HTML());
$gui->getSuitesFromDir(dirname(__FILE__),    //dir
                       '.*\.php',            //filenamePattern
                       array('UnitTest.php', //exclude (array)
                             'Common.php',
                             'sql.php',
                             'index.php')
                       );
$gui->show();
/*
require_once 'Get.php';
require_once 'GetAll.php';
require_once 'GetCount.php';
require_once 'Where.php';
require_once 'Limit.php';


$suites = array();
$suites[] = new PHPUnit_TestSuite('MDB_QueryTool_UnitTest_Get');
$suites[] = new PHPUnit_TestSuite('MDB_QueryTool_UnitTest_GetAll');
$suites[] = new PHPUnit_TestSuite('MDB_QueryTool_UnitTest_GetCount');
$suites[] = new PHPUnit_TestSuite('MDB_QueryTool_UnitTest_Where');
$suites[] = new PHPUnit_TestSuite('MDB_QueryTool_UnitTest_Limit');
$gui = new PHPUnit_GUI_HTML();
$gui->addSuites($suites);
$gui->show();
*/
/*
require_once 'PHPUnit/GUI/SetupDecorator.php';
$gui = new PHPUnit_GUI_SetupDecorator(new PHPUnit_GUI_HTML());
$gui->getSuitesFromDir(dirname(__FILE__),'.*\.php',array('UnitTest.php'));
*/
//print_r($errors);
?>