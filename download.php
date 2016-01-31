<?php
include_once(dirname(__FILE__).'/bootstrap.php');

$DocID  	 = $_REQUEST['id'];
$UserID 	 = $_SESSION['site']['pm_row']->UserID;
$WorkGroupID = $_SESSION['site']['pm_row']->WorkgroupID;

$objDoc = new document();
$DocRow = $objDoc->getDocument($DocID);

if($_SESSION['admin']['pm_user_row']->IsAdmin == 1)
{
	$objComm->downloadFile($DocRow->DocumentName, $DocRow->DocumentPath);	
}

if($DocRow->WorkgroupID == 0)
{
	$objComm->downloadFile($DocRow->DocumentName, $DocRow->DocumentPath);
}
else if($DocRow->WorkgroupID == $WorkGroupID)
{
	$objComm->downloadFile($DocRow->DocumentName, $DocRow->DocumentPath);
}


?>