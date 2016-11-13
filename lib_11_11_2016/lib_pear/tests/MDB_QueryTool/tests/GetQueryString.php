<?php
//
// $Id: GetQueryString.php,v 1.1 2004/03/17 15:12:05 quipo Exp $
//

/**
* This class just checks if the query is returned, not if
* the query was properly rendered. This should be subject to
* some other tests!
*
* @package tests
*/
class tests_GetQueryString extends tests_UnitTest
{
    function _setup()
    {
        $this->question =& new tests_Common(TABLE_QUESTION);
    }

    function test_selectAll()
    {
        $this->_setup();
        $this->assertStringEquals(
                            'SELECT question.id AS "id",question.question AS "question" FROM question',
                            $this->question->getQueryString());
    }

    function test_selectWithWhere()
    {
        $this->_setup();
        $this->question->setWhere('id=1');
        $this->assertStringEquals(
                            'SELECT question.id AS "id",question.question AS "question" FROM question'.
                            ' WHERE id=1',
                            $this->question->getQueryString());
    }
}

?>
