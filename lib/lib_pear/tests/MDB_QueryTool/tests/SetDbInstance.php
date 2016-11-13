<?php
//
// $Id: SetDbInstance.php,v 1.1 2004/03/17 15:12:05 quipo Exp $
//

/**
* This class just checks if the query is returned, not if
* the query was properly rendered. This should be subject to
* some other tests!
*
* @package tests
*/
class tests_SetDbInstance extends tests_UnitTest
{
    /**
     * Check if the two instances are the same by comparing
     * the fetchMode, since this is the easiest to compare if
     * two objects are the same in PHP4.
     * We can do that since the querytool sets the fetch mode to
     * MDB_FETCHMODE_ASSOC.
     * Not very nice but it works.
     *
     */
    function test_default()
    {
        $db =& MDB::connect(DB_DSN);

        $qt =& new MDB_QueryTool();
        $qt->setDbInstance($db);
        $dbActual =& $qt->getDbInstance();
        $this->assertEquals($db->fetchmode, $dbActual->fetchmode);
    }

    /**
     * Make sure the way we did it before works too.
     * Passing the DB_DSN to the constructor should also work.
     * And retreiving the db instance should result in a sub class
     * of MDB_common.
     */
    function test_oldWay()
    {
        $qt =& new MDB_QueryTool(DB_DSN);
        $db =& $qt->getDbInstance();
        $this->assertTrue(is_a($db, 'mdb_common'));
    }

}

?>
