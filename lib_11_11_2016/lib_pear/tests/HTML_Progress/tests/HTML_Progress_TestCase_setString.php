<?php
/**
 * API setString Unit tests for HTML_Progress class.
 * 
 * @version    $Id: HTML_Progress_TestCase_setString.php,v 1.3 2004/08/10 22:18:05 farell Exp $
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress
 */

class HTML_Progress_TestCase_setString extends PHPUnit_TestCase
{
    /**
     * HTML_Progress instance
     *
     * @var        object
     */
    var $progress;

    function HTML_Progress_TestCase_setString($name)
    {
        $this->PHPUnit_TestCase($name);
    }

    function setUp()
    {
        error_reporting(E_ALL);

        $logger['push_callback'] = array(&$this, '_pushCallback'); // don't die when an exception is thrown
        $this->progress = new HTML_Progress($logger);
    }

    function tearDown()
    {
        unset($this->progress);
    }

    function _stripWhitespace($str)
    {
        return preg_replace('/\\s+/', '', $str);
    }

    function _methodExists($name) 
    {
        if (substr(PHP_VERSION,0,1) < '5') {
            $n = strtolower($name);
        } else {
            $n = $name;
        }
        if (in_array($n, get_class_methods($this->progress))) {
            return true;
        }
        $this->assertTrue(false, 'method '. $name . ' not implemented in ' . get_class($this->progress));
        return false;
    }

    function _pushCallback($err)
    {
        // don't die if the error is an exception (as default callback)
        return HTML_PROGRESS_ERRORSTACK_PUSH;
    }

    function _getResult()
    {
        if ($this->progress->hasErrors()) {
            $err = $this->progress->getError();
            $this->assertTrue(false, $err['message']);
        } else {
            $this->assertTrue(true);
	}
    }

    /**
     * TestCases for method setString.
     *
     */
    function test_setString_fail()
    {
        if (!$this->_methodExists('setString')) {
            return;
        }
        $this->progress->setStringPainted(false);
        $str = '"Receiving 1 out of 5"';
        $this->progress->setString($str);
        $percent = $this->progress->getString();

        $this->assertEquals($str, '"'.$percent.'"');
    }

    function test_setString()
    {
        if (!$this->_methodExists('setString')) {
            return;
        }
        $this->progress->setStringPainted(true);
        $str = '"Receiving 1 out of 5"';
        $this->progress->setString($str);
        $percent = $this->progress->getString();

        $this->assertEquals($str, $percent);
    }
}

?>
