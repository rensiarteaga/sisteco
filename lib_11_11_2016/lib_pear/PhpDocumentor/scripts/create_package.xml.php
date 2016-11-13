<?php
require_once('PEAR/PackageFileManager.php');
$test = new PEAR_PackageFileManager;

$packagedir = 'C:/Web Pages/chiara/phpdoc';

$e = $test->setOptions(
array('baseinstalldir' => 'PhpDocumentor',
'version' => '1.2.3',
'packagedirectory' => $packagedir,
'state' => 'stable',
'filelistgenerator' => 'cvs',
'notes' => 'Bugfix release

From both Windows and Unix, both the command-line version
of phpDocumentor and the web interface will work
out of the box by using command phpdoc - guaranteed :)

WARNING: in order to use the web interface through PEAR, you must set your
data_dir to a subdirectory of your document root.

$ pear config-set data_dir /path/to/public_html/pear

on Windows with default apache setup, it might be

C:\> pear config-set data_dir "C:\Program Files\Apache\htdocs\pear"

After this, install/upgrade phpDocumentor

$ pear upgrade phpDocumentor

and you can browse to:

http://localhost/pear/PhpDocumentor/

for the web interface

- WARNING: phpDocumentor installs phpdoc in the
  scripts directory, and this will conflict with PHPDoc,
  you can\'t have both installed at the same time
- fixed these bugs:
 [ 731750 ] Links to unparsed includes shown (2nd time reopened)
 [ 771531 ] body styles not explicitly white
 [ 795095 ] top_frame.tpl doesn\'t output single RIC element
 [ 797066 ] HighlightParser stuffs whitespace in start of string in func
 [ 802891 ] Inline link text does not show up
',
'package' => 'PhpDocumentor',
'dir_roles' => array(
    'Documentation' => 'doc',
    'Documentation/tests' => 'test',
    'docbuilder' => 'data',
    'HTML_TreeMenu-1.1.2' => 'data',
    'tutorials' => 'doc',
    ),
'exceptions' =>
    array(
        'index.html' => 'data',
        'README' => 'doc',
        'ChangeLog' => 'doc',
        'PHPLICENSE.txt' => 'doc',
        'poweredbyphpdoc.gif' => 'data',
        'INSTALL' => 'doc',
        'FAQ' => 'doc',
        'Authors' => 'doc',
        'Release-1.2.0beta1' => 'doc',
        'Release-1.2.0beta2' => 'doc',
        'Release-1.2.0beta3' => 'doc',
        'Release-1.2.0rc1' => 'doc',
        'Release-1.2.0rc2' => 'doc',
        'Release-1.2.0' => 'doc',
        'Release-1.2.1' => 'doc',
        'Release-1.2.2' => 'doc',
        'Release-1.2.3' => 'doc',
        'pear-phpdoc' => 'script',
        'pear-phpdoc.bat' => 'script',
        'HTML_TreeMenu-1.1.2/TreeMenu.php' => 'php',
        'phpDocumentor/Smarty-2.5.0/libs/debug.tpl' => 'php',
        'new_phpdoc.php' => 'data',
        'phpdoc.php' => 'data',
        ),
'ignore' =>
    array('package.xml', 
          "$packagedir/phpdoc",
          'phpdoc.bat', 
          'LICENSE',
          '*docbuilder/actions.php',
          '*docbuilder/builder.php',
          '*docbuilder/config.php',
          '*docbuilder/file_dialog.php',
          '*docbuilder/top.php',
          'utilities.php',
          'Converter.inc',
          'IntermediateParser.inc',
          '*templates/PEAR/*',
          'Setup.inc.php',
          'makedocs.ini',
          'common.inc.php',
          'publicweb-PEAR-1.2.1.patch.txt',
          ),
'installas' =>
    array('pear-phpdoc' => 'phpdoc',
          'pear-phpdoc.bat' => 'phpdoc.bat',
          'docbuilder/pear-actions.php' => 'docbuilder/actions.php',
          'docbuilder/pear-builder.php' => 'docbuilder/builder.php',
          'docbuilder/pear-config.php' => 'docbuilder/config.php',
          'docbuilder/pear-file_dialog.php' => 'docbuilder/file_dialog.php',
          'docbuilder/pear-top.php' => 'docbuilder/top.php',
          'docbuilder/includes/pear-utilities.php' => 'docbuilder/includes/utilities.php',
          'phpDocumentor/pear-IntermediateParser.inc' => 'phpDocumentor/IntermediateParser.inc',
          'phpDocumentor/pear-Converter.inc' => 'phpDocumentor/Converter.inc',
          'phpDocumentor/pear-Setup.inc.php' => 'phpDocumentor/Setup.inc.php',
          'phpDocumentor/pear-common.inc.php' => 'phpDocumentor/common.inc.php',
          'user/pear-makedocs.ini' => 'user/makedocs.ini',
          ),
'installexceptions' => array('pear-phpdoc' => '/', 'pear-phpdoc.bat' => '/', 'scripts/makedoc.sh' => '/'),
));
if (PEAR::isError($e)) {
    echo $e->getMessage();
    exit;
}
$e = $test->addPlatformException('pear-phpdoc.bat', 'windows');
if (PEAR::isError($e)) {
    echo $e->getMessage();
    exit;
}
$e = $test->addDependency('php', '4.1.0', 'ge', 'php');
if (PEAR::isError($e)) {
    echo $e->getMessage();
    exit;
}
// just to make sure people don't try to install this with a broken Archive_Tar
$e = $test->addDependency('Archive_Tar', '1.1', 'ge');
if (PEAR::isError($e)) {
    echo $e->getMessage();
    exit;
}
// replace @PHP-BIN@ in this file with the path to php executable!  pretty neat
$e = $test->addReplacement('pear-phpdoc', 'pear-config', '@PHP-BIN@', 'php_bin');
if (PEAR::isError($e)) {
    echo $e->getMessage();
    exit;
}
$e = $test->addReplacement('pear-phpdoc.bat', 'pear-config', '@PHP-BIN@', 'php_bin');
if (PEAR::isError($e)) {
    echo $e->getMessage();
    exit;
}
$e = $test->addReplacement('pear-phpdoc.bat', 'pear-config', '@BIN-DIR@', 'bin_dir');
if (PEAR::isError($e)) {
    echo $e->getMessage();
    exit;
}
$e = $test->addReplacement('pear-phpdoc.bat', 'pear-config', '@PEAR-DIR@', 'php_dir');
if (PEAR::isError($e)) {
    echo $e->getMessage();
    exit;
}
$e = $test->addReplacement('pear-phpdoc.bat', 'pear-config', '@DATA-DIR@', 'data_dir');
if (PEAR::isError($e)) {
    echo $e->getMessage();
    exit;
}
$e = $test->addReplacement('docbuilder/pear-builder.php', 'pear-config', '@DATA-DIR@', 'data_dir');
if (PEAR::isError($e)) {
    echo $e->getMessage();
    exit;
}
$e = $test->addReplacement('docbuilder/pear-file_dialog.php', 'pear-config', '@DATA-DIR@', 'data_dir');
if (PEAR::isError($e)) {
    echo $e->getMessage();
    exit;
}
$e = $test->addReplacement('docbuilder/pear-file_dialog.php', 'pear-config', '@WEB-DIR@', 'data_dir');
if (PEAR::isError($e)) {
    echo $e->getMessage();
    exit;
}
$e = $test->addReplacement('docbuilder/pear-actions.php', 'pear-config', '@WEB-DIR@', 'data_dir');
if (PEAR::isError($e)) {
    echo $e->getMessage();
    exit;
}
$e = $test->addReplacement('docbuilder/pear-config.php', 'pear-config', '@DATA-DIR@', 'data_dir');
if (PEAR::isError($e)) {
    echo $e->getMessage();
    exit;
}
$e = $test->addReplacement('docbuilder/pear-config.php', 'pear-config', '@WEB-DIR@', 'data_dir');
if (PEAR::isError($e)) {
    echo $e->getMessage();
    exit;
}
$e = $test->addReplacement('phpDocumentor/pear-Setup.inc.php', 'pear-config', '@DATA-DIR@', 'data_dir');
if (PEAR::isError($e)) {
    echo $e->getMessage();
    exit;
}
$e = $test->addReplacement('phpDocumentor/pear-Converter.inc', 'pear-config', '@DATA-DIR@', 'data_dir');
if (PEAR::isError($e)) {
    echo $e->getMessage();
    exit;
}
$e = $test->addReplacement('phpDocumentor/pear-common.inc.php', 'package-info', '@VER@', 'version');
if (PEAR::isError($e)) {
    echo $e->getMessage();
    exit;
}
$e = $test->addReplacement('user/pear-makedocs.ini', 'pear-config', '@PEAR-DIR@', 'php_dir');
if (PEAR::isError($e)) {
    echo $e->getMessage();
    exit;
}
$e = $test->addReplacement('user/pear-makedocs.ini', 'pear-config', '@DOC-DIR@', 'doc_dir');
if (PEAR::isError($e)) {
    echo $e->getMessage();
    exit;
}
$test->addRole('inc', 'php');
$test->addRole('sh', 'script');
if (isset($_GET['make'])) {
    $e = $test->writePackageFile();
} else {
    $e = $test->debugPackageFile();
}
if (PEAR::isError($e)) {
    echo $e->getMessage();
}
if (!isset($_GET['make'])) {
    echo '<a href="' . $_SERVER['PHP_SELF'] . '?make=1">Make this file</a>';
}
?>