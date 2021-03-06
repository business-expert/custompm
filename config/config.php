<?php

define('SITENAME','pm');
define('DOCUMENT_ROOT', $_SERVER['DOCUMENT_ROOT']."/".SITENAME);
define('SITE_PATH', "http://".$_SERVER['HTTP_HOST']."/".SITENAME);

define('SITE_ADMIN','pm/admin');
define('DOCUMENT_ROOT_ADMIN', $_SERVER['DOCUMENT_ROOT']."/".SITE_ADMIN);
define('SITE_PATH_ADMIN', "http://".$_SERVER['HTTP_HOST']."/".SITE_ADMIN);

define('ROOT', dirname(__FILE__));
define('CONFIG', DOCUMENT_ROOT.'/config');

define('MODELS_ADMIN', DOCUMENT_ROOT_ADMIN.'/models');
define('CONTROLLERS_ADMIN', DOCUMENT_ROOT_ADMIN.'/controllers');
define('VIEWS_ADMIN', DOCUMENT_ROOT_ADMIN.'/views');
define('LIBS_ADMIN', DOCUMENT_ROOT_ADMIN.'/libraries');
define('AJAX_ADMIN', DOCUMENT_ROOT_ADMIN.'/ajax');

define('MODELS', DOCUMENT_ROOT.'/models');
define('CONTROLLERS', DOCUMENT_ROOT.'/controllers');
define('VIEWS', DOCUMENT_ROOT.'/views');
define('LIBS', DOCUMENT_ROOT.'/libraries');
define('AJAX', DOCUMENT_ROOT.'/ajax');

define('MEDIA_ADMIN', SITE_PATH_ADMIN.'/media');
define('IMAGES_ADMIN', MEDIA_ADMIN.'/img/');
define('CSS_ADMIN', MEDIA_ADMIN.'/css/');
define('JS_ADMIN', MEDIA_ADMIN.'/js/');

define('MEDIA', SITE_PATH.'/media');
define('IMAGES', MEDIA.'/img/');
define('CSS', MEDIA.'/css/');
define('JS', MEDIA.'/js/');

define('LOG_PATH',DOCUMENT_ROOT.'/log/');
define('LOG_FILE_NAME',date("Y_m_d_H").".txt");
define('SQL_ERROR_FILE_NAME',"query_error_".date("Y_m_d_H").".txt");

define('ADMIN_USERNAME','admin');
define('ADMIN_PASSWORD','admin');

define('RECORD_PER_PAGE',10);

define("DATE_FORMAT","Y-m-d");
define("TIME_FORMAT","H:i A");

define('RESTRICT_UPLOAD_FILE','');
define('UPLOAD_PATH',DOCUMENT_ROOT."/upload");
#-------------- SMTP ------------- #

define('SMTP_HOST','smtp.gmail.com');      				// sets GMAIL as the SMTP server
define('SMTP_PORT',465);                   				// set the SMTP port for the GMAIL server
define('SMTP_USERNAME',"rakesh.r.singh.2013@gmail.com"); 	// GMAIL username
define('SMTP_PASSWORD',"rakeshrsingh2013");
define('EMAIL_FROM',"rakesh.r.singh.2013@gmail.com");
define('EMAIL_FROM_NAME',"AI Club");

		
?>
