<?php
session_start();
error_reporting(1);
ini_set('error_reporting', E_ALL^E_NOTICE^E_WARNING);

include_once($_SERVER['DOCUMENT_ROOT'].'/pm/config/config.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/pm/config/database.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/pm/admin/language.php');

#------------- LANGUAGE  CODE ------------#

$objLog		=	new logs(LOG_FILE_NAME);
$QErrLog	=	new logs(SQL_ERROR_FILE_NAME);

$DB 		=	new database(HOST, USER, PASS, DATABASE);
$ln 		=	$DB->dbConnect();

$objComm    = 	new common();
$objHTML    = 	new html();

function __autoload($classname)
{
	if(file_exists(MODELS_ADMIN. "/". $classname . '_model.php')){
		include_once MODELS_ADMIN. "/". $classname . '_model.php';
	}
	else
	{
		if(file_exists(LIBS. "/". $classname . '.php')){
			include_once LIBS. "/". $classname . '.php';
		}
		else if(file_exists(LIBS_ADMIN. "/". $classname . '.php')){
			include_once LIBS_ADMIN. "/". $classname . '.php';
		}
		else{
			echo "Class Name '".$classname .".php' not Found";
		}
	}
}

?>