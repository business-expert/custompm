<?php

if(isset($_REQUEST['lang']))
{
	$langs = $_REQUEST['lang'];
	$_SESSION['pm_lang'] = $langs;
	setcookie('pm_lang', $langs, time() + (3600 * 24 * 30));
}
else if(isset($_SESSION['pm_lang']))
{
	$langs = $_SESSION['pm_lang'];
}
else if(isset($_COOKIE['pm_lang']))
{
	$langs = $_COOKIE['pm_lang'];
}
else
{
	$langs = 'english';
}

$langs = 'english';

include_once($_SERVER['DOCUMENT_ROOT'].'/pm/language/'.$langs.'/index.php');
?>