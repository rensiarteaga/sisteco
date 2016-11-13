<?php
// $Id: db_settings.php,v 1.1 2005/02/25 14:15:59 quipo Exp $

$dbtype = isset($_GET['type']) ? $_GET['type'] : 'mysql';
$valid_dbms = array(
    'mysql', 'pgsql', 'ibase',
);
if (!in_array($dbtype, $valid_dbms)) {
    $dbtype = 'mysql';
}
define('DB_TYPE',        $dbtype);
define('TABLE_USER',     'querytool_user');
define('TABLE_ADDRESS',  'querytool_address');
define('TABLE_QUESTION', 'question');
define('TABLE_ANSWER',   'answer');

switch ($dbtype) {
    case 'pgsql':
        define('DB_DSN', 'pgsql://user:pwd@host/dbname');
        $GLOBALS['DB_OPTIONS'] = array();
        break;
    case 'ibase':
        define('DB_DSN', 'ibase://user:pwd@host/dbname');
        $GLOBALS['DB_OPTIONS'] = array(
            'DatabasePath'      => 'path/to/db/dir/',
            'DatabaseExtension' => '.FDB',
            'optimize'          => 'portability',
        );
        break;
    case 'mysql':
    default:
        define('DB_DSN', 'mysql://user:pwd@host/dbname');
        $GLOBALS['DB_OPTIONS'] = array();
}
$allTables = array(TABLE_USER, TABLE_ADDRESS, TABLE_QUESTION, TABLE_ANSWER);
?>