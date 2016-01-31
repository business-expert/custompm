<?php

if(isset($_REQUEST['lang']))
{
	$langs = $_REQUEST['lang'];
	$_SESSION['pm_session_lang'] = $langs;
	setcookie('pm_session_lang', $langs, time() + (3600 * 24 * 30));
}
else if(isSet($_SESSION['pm_session_lang']))
{
	$langs = $_SESSION['pm_session_lang'];
}
else if(isSet($_COOKIE['pm_session_lang']))
{
	$langs = $_COOKIE['pm_session_lang'];
}
else
{
	$langs = 'english';
}

//$langs = 'english';

include_once($_SERVER['DOCUMENT_ROOT'].'/pm/language/'.$langs.'/index.php');

?>