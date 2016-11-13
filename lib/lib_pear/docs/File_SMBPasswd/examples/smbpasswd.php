<?php

require_once 'File/SMBPasswd.php';

$f = new File_SMBPasswd('./smbpasswd');
$f->load();
$ret = $f->addAccount('sepp3', 12, 'MyPw');
if (PEAR::isError($ret)) {
    echo $ret->getMessage();
    exit;
} 
$ret = $f->modAccount('sepp', '', 'MyPw');
if (PEAR::isError($ret)) {
    echo $ret->getMessage();
    exit;
} 
$ret = $f->delAccount('karli');
if (PEAR::isError($ret)) {
    echo $ret->getMessage();
    exit;
} 
$f->printAccounts();
if (PEAR::isError($ret)) {
    echo $ret->getMessage();
    exit;
}

echo "PASS 1 ------------\n";

$f = new File_SMBPasswd('./smbpasswdnew');
$ret = $f->addAccount('sepp1', 12, 'MyPw');
if (PEAR::isError($ret)) {
    echo $ret->getMessage();
    exit;
} 
$ret = $f->addUser('sepp3', 1000, 'MyPw');
if (PEAR::isError($ret)) {
    echo $ret->getMessage();
    exit;
} 
$ret = $f->addMachine('mypc', 1000);
if (PEAR::isError($ret)) {
    echo $ret->getMessage();
    exit;
} 

$f->printAccounts();
$ret = $f->save();
if (PEAR::isError($ret)) {
    echo $ret->getMessage();
    exit;
} 

echo "PASS 2 ------------\n";

$f = new File_SMBPasswd('./smbpasswd');
$f->load();
if ($f->verifyAccount('sepp', 'MyPw')) {
    echo "Account valid\n";
} else {
    echo "Account invalid or disabled\n";
}

echo "PASS 3 ------------\n";
?>
