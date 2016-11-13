<?php

require_once 'PHPUnit.php';
require_once 'Var_Dump.php';

/*=============*/
/* Test Classe */
/*=============*/

class Var_DumpTest extends PHPUnit_TestCase {

	var $vd;

	function Var_DumpTest($name) {
		$this->PHPUnit_TestCase($name);
	}

	function setUp() {
		$this->vd = new Var_Dump(array('display_mode'=>'Text'));
	}

	function tearDown() {
		unset($this->vd);
	}

	/*====================*/
	/* Test simple values */
	/*====================*/

	function test_type_int() {
		$this->assertEquals('int -2147483647',$this->vd->toString(-2147483647));
		$this->assertEquals('int 0',$this->vd->toString(0));
		$this->assertEquals('int 2147483647',$this->vd->toString(2147483647));
	}

	function test_type_bool() {
		$this->assertEquals('bool false',$this->vd->toString(FALSE));
		$this->assertEquals('bool true',$this->vd->toString(TRUE));
	}

	function test_type_float() {
		$this->assertEquals('float 12.345678',$this->vd->toString(12.345678));
		$this->assertEquals('float -12.345678',$this->vd->toString(-12.345678));
		$this->assertEquals('float 2147483648',$this->vd->toString(2147483648));
		$this->assertEquals('float -2147483648',$this->vd->toString(-2147483648));
	}

	function test_type_resource() {
		$dir='/tmp/';
		if (is_dir($dir)) {
			if ($dh=opendir($dir)) {
				$this->assertRegExp('/^resource\(stream\)\s[0-9]+$/',$this->vd->toString($dh));
        closedir($dh);
			} else {
				$this->assertTrue(FALSE,'Unable to open directory /tmp, ');
			}
    } else {
			$this->assertTrue(FALSE,'Unable to open directory /tmp, ');
		}
	}

	function test_type_null() {
		$this->assertEquals('NULL',$this->vd->toString(NULL));
	}

	/*============*/
	/* Test Array */
	/*============*/

	function test_type_array() {
		$this->assertEquals(
			'array(3) {'."\n".
			'  key1 => string(44) The quick brown'."\n".
			'                     fox jumped over'."\n".
			'                     the lazy dog'."\n".
			'  key2 => &array(3) {'."\n".
			'    0 => bool true'."\n".
			'    1 => int 123'."\n".
			'    2 => float 123.45'."\n".
			'  }'."\n".
			'  key3 => NULL'."\n".
			'}',
			$this->vd->toString($GLOBALS['array'])
		);
	}

	/*=============*/
	/* Test Object */
	/*=============*/

	function test_type_object() {
		$this->assertEquals(
			'object(object)(3) {'."\n".
			'  key1 => string(44) The quick brown'."\n".
			'                     fox jumped over'."\n".
			'                     the lazy dog'."\n".
			'  key2 => array(3) {'."\n".
			'    0 => bool true'."\n".
			'    1 => int 123'."\n".
			'    2 => float 123.45'."\n".
			'  }'."\n".
			'  key3 => NULL'."\n".
			'}',
			$this->vd->toString(new object()));
	}

	/*======================*/
	/* Test "Text" Renderer */
	/*======================*/

	function test_renderer_text() {
		Var_Dump::displayInit(
			array('display_mode'=>'Text'),
			array(
				'show_eol'       => ' *',
				'offset'         => 3,
				'opening'        => '(',
				'closing'        => ')',
				'operator'       => ' -> ',
				'before_num_key' => '\'',
				'after_num_key'  => '\'',
				'before_str_key' => '"',
				'after_str_key'  => '"',
				'before_type'    => '[',
				'after_type'     => ']'
			)
		);
		$this->assertEquals(
			'array(3) ('."\n".
			'   "key1" -> [string(44)] The quick brown *'."\n".
			'                          fox jumped over *'."\n".
			'                          the lazy dog'."\n".
			'   "key2" -> &array(3) ('."\n".
			'      \'0\' -> [bool] true'."\n".
			'      \'1\' -> [int] 123'."\n".
			'      \'2\' -> [float] 123.45'."\n".
			'   )'."\n".
			'   "key3" -> [NULL]'."\n".
			')',
			Var_Dump::display($GLOBALS['array'],TRUE)
		);
	}

	/*============================*/
	/* Test "HTML4_Text" Renderer */
	/*============================*/

	function test_renderer_html4_text() {
		Var_Dump::displayInit(array('display_mode'=>'HTML4_Text'));
		$this->assertEquals(
			'<pre>array(3) {'."\n".
			'  key1 =&gt; <font color="#006600">string(44)</font> <font color="#339900">The quick brown'."\n".
			'</font>                     <font color="#339900">fox jumped over'."\n".
			'</font>                     <font color="#339900">the lazy dog</font>'."\n".
			'  key2 =&gt; &array(3) {'."\n".
			'    0 =&gt; <font color="#006600">bool</font> <font color="#339900">true</font>'."\n".
			'    1 =&gt; <font color="#006600">int</font> <font color="#339900">123</font>'."\n".
			'    2 =&gt; <font color="#006600">float</font> <font color="#339900">123.45</font>'."\n".
			'  }'."\n".
			'  key3 =&gt; <font color="#006600">NULL</font>'."\n".
			'}'."\n".
			'</pre>',
			Var_Dump::display($GLOBALS['array'],TRUE)
		);
	}

	/*============================*/
	/* Test "XHTML_Text" Renderer */
	/*============================*/

	function test_renderer_xhtml_text() {
		Var_Dump::displayInit(array('display_mode'=>'XHTML_Text'));
		$this->assertEquals(
			'<pre class="var_dump">array(3) {'."\n".
			'  key1 =&gt; <span class="type">string(44)</span> <span class="value">The quick brown'."\n".
			'</span>                     <span class="value">fox jumped over'."\n".
			'</span>                     <span class="value">the lazy dog</span>'."\n".
			'  key2 =&gt; &array(3) {'."\n".
			'    0 =&gt; <span class="type">bool</span> <span class="value">true</span>'."\n".
			'    1 =&gt; <span class="type">int</span> <span class="value">123</span>'."\n".
			'    2 =&gt; <span class="type">float</span> <span class="value">123.45</span>'."\n".
			'  }'."\n".
			'  key3 =&gt; <span class="type">NULL</span>'."\n".
			'}'."\n".
			'</pre>',
			Var_Dump::display($GLOBALS['array'],TRUE)
		);
	}

	/*=======================*/
	/* Test "Table" Renderer */
	/*=======================*/

	function test_renderer_table() {
		Var_Dump::displayInit(
			array('display_mode'=>'Table'),
			array(
				'before_str_key' => '"',
				'after_str_key'  => '"',
				'before_type'    => '[',
				'after_type'     => ']'
			)
		);
		$this->assertEquals(
			'<table>'.
			'<caption>array(3)</caption>'.
			'<tr>'.
				'<td>"key1"</td>'.
				'<td>[string(44)]</td>'.
				'<td>The quick brown<br />'."\n".'fox jumped over<br />'."\n".'the lazy dog</td>'.
			'</tr><tr>'.
				'<td>"key2"</td>'.
				'<td colspan="2">'.
					'<table>'.
					'<caption>&amp;array(3)</caption>'.
					'<tr><td>0</td><td>[bool]</td><td>true</td></tr>'.
					'<tr><td>1</td><td>[int]</td><td>123</td></tr>'.
					'<tr><td>2</td><td>[float]</td><td>123.45</td></tr>'.
					'</table>'.
				'</td>'.
			'</tr><tr>'.
				'<td>"key3"</td>'.
				'<td colspan="2">[NULL]</td>'.
			'</tr>'.
			'</table>',
			Var_Dump::display($GLOBALS['array'],TRUE)
		);
	}

	/*=============================*/
	/* Test "HTML4_Table" Renderer */
	/*=============================*/

	function test_renderer_html4_table() {
		Var_Dump::displayInit(array('display_mode'=>'HTML4_Table'));
		$this->assertEquals(
			'<table border="0" cellpadding="1" cellspacing="0" bgcolor="black"><tr><td>'.
			'<table border="0" cellpadding="4" cellspacing="0" width="100%">'.
			'<caption style="color:white;background:#339900;">array(3)</caption>'.
			'<tr valign="top" bgcolor="#F8F8F8">'.
				'<td bgcolor="#CCCCCC"><b>key1</b></td>'.
				'<td><font color="#000000">string(44)</font></td>'.
				'<td><font color="#006600">The quick brown<br />'."\n".'fox jumped over<br />'."\n".'the lazy dog</font></td>'.
			'</tr><tr valign="top" bgcolor="#E8E8E8">'.
				'<td bgcolor="#CCCCCC"><b>key2</b></td>'.
				'<td colspan="2">'.
					'<table border="0" cellpadding="1" cellspacing="0" bgcolor="black"><tr><td>'.
					'<table border="0" cellpadding="4" cellspacing="0" width="100%">'.
					'<caption style="color:white;background:#339900;">&amp;array(3)</caption>'.
					'<tr valign="top" bgcolor="#F8F8F8">'.
						'<td bgcolor="#CCCCCC"><b>0</b></td>'.
						'<td><font color="#000000">bool</font></td>'.
						'<td><font color="#006600">true</font></td>'.
					'</tr><tr valign="top" bgcolor="#E8E8E8">'.
						'<td bgcolor="#CCCCCC"><b>1</b></td>'.
						'<td><font color="#000000">int</font></td>'.
						'<td><font color="#006600">123</font></td>'.
					'</tr><tr valign="top" bgcolor="#F8F8F8">'.
						'<td bgcolor="#CCCCCC"><b>2</b></td>'.
						'<td><font color="#000000">float</font></td>'.
						'<td><font color="#006600">123.45</font></td>'.
					'</tr>'.
					'</table></td></tr></table>'.
				'</td>'.
			'</tr><tr valign="top" bgcolor="#F8F8F8">'.
				'<td bgcolor="#CCCCCC"><b>key3</b></td>'.
				'<td colspan="2"><font color="#000000">NULL</font></td>'.
			'</tr>'.
			'</table></td></tr></table>',
			Var_Dump::display($GLOBALS['array'],TRUE)
		);
	}

	/*=============================*/
	/* Test "XHTML_Table" Renderer */
	/*=============================*/

	function test_renderer_xhtml_table() {
		Var_Dump::displayInit(array('display_mode'=>'XHTML_Table'));
		$this->assertEquals(
			'<table class="var_dump">'.
			'<caption>array(3)</caption>'.
			'<tr>'.
				'<th>key1</th>'.
				'<td><i>string(44)</i></td>'.
				'<td>The quick brown<br />'."\n".'fox jumped over<br />'."\n".'the lazy dog</td>'.
			'</tr><tr class="alt">'.
				'<th>key2</th>'.
				'<td colspan="2">'.
					'<table class="var_dump">'.
					'<caption>&amp;array(3)</caption>'.
					'<tr><th>0</th><td><i>bool</i></td><td>true</td></tr>'.
					'<tr class="alt"><th>1</th><td><i>int</i></td><td>123</td></tr>'.
					'<tr><th>2</th><td><i>float</i></td><td>123.45</td></tr>'.
					'</table>'.
				'</td>'.
			'</tr><tr>'.
				'<th>key3</th>'.
				'<td colspan="2"><i>NULL</i></td>'.
			'</tr>'.
			'</table>',
			Var_Dump::display($GLOBALS['array'],TRUE)
		);
	}

	/*=====================*/
	/* Test "XML" Renderer */
	/*=====================*/

	function test_renderer_xml() {
		Var_Dump::displayInit(array('display_mode'=>'XML'));
		$this->assertEquals(
			'<group caption="array(3)">'."\n".
			'  <element>'."\n".
			'    <key>key1</key>'."\n".
			'    <type>string(44)</type>'."\n".
			'    <value>The quick brown'."\n".
			'fox jumped over'."\n".
			'the lazy dog</value>'."\n".
			'  </element>'."\n".
			'  <element>'."\n".
			'    <key>key2</key>'."\n".
			'    <type>group</type>'."\n".
			'    <value>'."\n".
			'      <group caption="&amp;array(3)">'."\n".
			'        <element>'."\n".
			'          <key>0</key>'."\n".
			'          <type>bool</type>'."\n".
			'          <value>true</value>'."\n".
			'        </element>'."\n".
			'        <element>'."\n".
			'          <key>1</key>'."\n".
			'          <type>int</type>'."\n".
			'          <value>123</value>'."\n".
			'        </element>'."\n".
			'        <element>'."\n".
			'          <key>2</key>'."\n".
			'          <type>float</type>'."\n".
			'          <value>123.45</value>'."\n".
			'        </element>'."\n".
			'      </group>'."\n".
			'    </value>'."\n".
			'  </element>'."\n".
			'  <element>'."\n".
			'    <key>key3</key>'."\n".
			'    <type>NULL</type>'."\n".
			'    <value></value>'."\n".
			'  </element>'."\n".
			'</group>'."\n",
			Var_Dump::display($GLOBALS['array'],TRUE)
		);
	}

	/*===================================*/
	/* Test Text Renderer : Compact mode */
	/*===================================*/

	function test_renderer_text_compact() {
		Var_Dump::displayInit(
			array('display_mode'=>'Text'),
			array('mode'=>'compact')
		);
		$this->assertEquals(
			'array(3) {'."\n".
			'  key-1 => string(44) The quick brown fox jumped over the lazy dog'."\n".
			'  key-2 => array(2) {'."\n".
			'    long-key => &array(3) {'."\n".
			'      0 => string(4) John'."\n".
			'      11 => string(4) Jack'."\n".
			'      127 => string(4) Bill'."\n".
			'    }'."\n".
			'    file => NULL'."\n".
			'  }'."\n".
			'  long-key-3 => int 234'."\n".
			'}',
			Var_Dump::display($GLOBALS['array2'],TRUE)
		);
	}

	/*==================================*/
	/* Test Text Renderer : Normal mode */
	/*==================================*/

	function test_renderer_text_normal() {
		Var_Dump::displayInit(
			array('display_mode'=>'Text'),
			array('mode'=>'normal')
		);
		$this->assertEquals(
			'array(3) {'."\n".
			'  key-1      => string(44) The quick brown fox jumped over the lazy dog'."\n".
			'  key-2      => array(2) {'."\n".
			'    long-key => &array(3) {'."\n".
			'      0   => string(4) John'."\n".
			'      11  => string(4) Jack'."\n".
			'      127 => string(4) Bill'."\n".
			'    }'."\n".
			'    file     => NULL'."\n".
			'  }'."\n".
			'  long-key-3 => int 234'."\n".
			'}',
			Var_Dump::display($GLOBALS['array2'],TRUE)
		);
	}

	/*================================*/
	/* Test Text Renderer : Wide mode */
	/*================================*/

	function test_renderer_text_wide() {
		Var_Dump::displayInit(
			array('display_mode'=>'Text'),
			array('mode'=>'wide')
		);
		$this->assertEquals(
			'array(3) {'."\n".
			'  key-1      => string(44) The quick brown fox jumped over the lazy dog'."\n".
			'  key-2      => array(2) {'."\n".
			'                  long-key => &array(3) {'."\n".
			'                                0   => string(4) John'."\n".
			'                                11  => string(4) Jack'."\n".
			'                                127 => string(4) Bill'."\n".
			'                              }'."\n".
			'                  file     => NULL'."\n".
			'                }'."\n".
			'  long-key-3 => int 234'."\n".
			'}',
			Var_Dump::display($GLOBALS['array2'],TRUE)
		);
	}

	/*==================================*/
	/* Bug #490 Recursions not managed. */
	/*==================================*/

	function test_bug_490() {
		$this->assertEquals(
			'object(parent)(2) {'."\n".
			'  myChild => object(child)(1) {'."\n".
			'    myParent => &object(parent)(2) {'."\n".
			'      myChild => object(child)(1) {'."\n".
			'        myParent => &object(parent)(2) {'."\n".
			'          myChild => *RECURSION*'."\n".
			'          myName => string(6) parent'."\n".
			'        }'."\n".
			'      }'."\n".
			'      myName => string(6) parent'."\n".
			'    }'."\n".
			'  }'."\n".
			'  myName => string(6) parent'."\n".
			'}',
			$this->vd->toString(new parent())
		);
	}

	/*============================================================================*/
	/* Bug #1321 Numeric zero values in array or object attributes are not shown. */
	/*============================================================================*/

	function test_bug_1321() {
		$this->assertEquals(
			'object(zero)(2) {'."\n".
			'  i => int 0'."\n".
			'  f => float 0'."\n".
			'}',
			$this->vd->toString(new zero())
		);
		$this->assertEquals(
			'array(2) {'."\n".
			'  0 => int 0'."\n".
			'  1 => float 0'."\n".
			'}',
			$this->vd->toString(array(0,0.0))
		);
	}

}

/*============================*/
/* Classes used by test Cases */
/*============================*/

class zero {
	var $i = 0;
	var $f = 0.0;
}

class object {
	var $key1 = "The quick brown\nfox jumped over\nthe lazy dog";
	var $key2 = array(TRUE, 123, 123.45);
	var $key3 = NULL;
}

class parent {
	function parent() {
		$this->myChild = new child($this);
		$this->myName = 'parent';
	}
}
class child {
	function child(&$parent) {
		$this->myParent =& $parent;
	}
}

class recursion {
	function recursion() {
		$this->recursion = new recursion();
	}
}

$linkedArray=array(TRUE, 123, 123.45);
$array=array(
	'key1' => 'The quick brown'."\n".'fox jumped over'."\n".'the lazy dog',
	'key2' => & $linkedArray,
	'key3' => NULL
);

$linkedArray2=array(0=>'John', 11=>'Jack', 127=>'Bill');
$array2=array(
    'key-1' => 'The quick brown fox jumped over the lazy dog',
    'key-2' => array(
        'long-key' => & $linkedArray2,
        'file' => NULL
    ),
    'long-key-3' => 234,
);

/*========*/
/* Main() */
/*========*/

$suite  = new PHPUnit_TestSuite("Var_DumpTest");
$result = PHPUnit::run($suite);

echo $result->toHTML();

?>