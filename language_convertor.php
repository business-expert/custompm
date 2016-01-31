<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
error_reporting(1);
ini_set('error_reporting', E_ALL^E_NOTICE^E_WARNING);
include_once(dirname(__FILE__).'/bootstrap.php');

include_once("language/english/index.php");
$arrEngLang = $lang;

include_once("language/dutch/index.php");
$arrDutchLang = $lang;

$str = '';

foreach($arrEngLang as $key => $value)
{
	if(trim($arrDutchLang[$key]) == '')
	{
		$value = getResponce($value);
		
		if(strlen($value) < 50)
			$arrTranslated[] =  '$lang["'.$key.'"] = "'.$value.'"';
	}
	else
	{
		$arrTranslated[] =  '$lang["'.$key.'"] = "'.$arrDutchLang[$key].'"';
	}
	
	sleep(1);
}

$filevar = $_SERVER['DOCUMENT_ROOT'].'/aiclub/language/dutch/index1.txt';
chmod($filevar,0755);
$fp = fopen($filevar);

if($fp)
{
	foreach($arrTranslated as $value){
		fwrite($fp,$value."\n")	;
	}
}
	

fclose($fp);

echo "<pre>"; print_r($arrTranslated);




function getResponce($text)
{
	echo "<br>".$url = "http://mymemory.translated.net/api/get?q=".urlencode($text)."&langpair=en|nl-NL";
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HEADER, TRUE);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	$data = curl_exec($ch);
	curl_close($ch); 

  	$arrData = explode('charset=utf-8',$data);
	$arrFinal = json_decode(trim($arrData[1])); 
	
	return 	$arrFinal->responseData->translatedText;
}







?>