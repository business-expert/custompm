<?php
$model  = $_REQUEST['model'];
$action = $_REQUEST['action'];
$objComm->checkSiteSession();
$SessUserDetails = $_SESSION['site']['pm_row'];

include_once(MODELS."/".$model."_model.php");

switch(strtoupper($action))
{
	case 'UPDATE':
				
				$objProfile = new profile();
				$objProfile->setUsers();

				$objComm->redirect1('index.php?model=profile');
				
				break;
	
	default:
				$objProfile = new profile();
				$row = $objProfile->getUser($SessUserDetails->UserID);
				break;
}

?>