<?php
$model  = $_REQUEST['model'];
$action = $_REQUEST['action'];
$type   = ($_REQUEST['type'] == '') ? 'gen' : $_REQUEST['type'];

$WorkGroupID = ($type == 'gen') ? '0' : $_SESSION['site']['pm_row']->WorkgroupID;

$objComm->checkSiteSession();

include_once(MODELS."/messageboard_model.php");

switch(strtoupper($action))
{
	case 'ADD':
				$objComm->checkReadWriteAccess($type);
				
				if(isset($_REQUEST['btn_submit']) && $_REQUEST['btn_submit'] == 'save')
				{
					$objMsg = new messageboard();
					$objMsg->setMessage($_REQUEST);
					
					$objComm->redirect1('index.php?model='.$model.'&type='.$type);
				}
				
				break;	
	
	case 'EDIT':
				$objComm->checkReadWriteAccess($type);
				$objMsg = new messageboard();
				
				if(isset($_REQUEST['btn_submit']) && $_REQUEST['btn_submit'] == 'update')
				{
					$objMsg->setMessage($_REQUEST);
					$objComm->redirect1('index.php?model='.$model.'&action=edit&type='.$type.'&id='.$_REQUEST['pk_id']);	
				}
				else
				{
					$row = $objMsg->getMessageSubject();
					$objComm->checkReadWriteAccess($row->CreatedBy);
				}
					
				break;
	
	case 'ADDSUB':

				$objComm->checkReadWriteAccess($type);
				
				if(isset($_REQUEST['btn_submit']) && $_REQUEST['btn_submit'] == 'savesub')
				{
					$objMsg = new messageboard();
					$objMsg->setMessageSubject($_REQUEST);
					
					$objComm->redirect1('index.php?model='.$model.'&type='.$type);
				}
				break;
				
	case 'EDITSUB':
				$objComm->checkReadWriteAccess($type);
				$objMsg = new messageboard();
				
				if(isset($_REQUEST['btn_submit']) && $_REQUEST['btn_submit'] == 'updatesub')
				{
					$objMsg->setMessageSubject($_REQUEST);
					$objComm->redirect1('index.php?model='.$model.'&action=editsub&type='.$type.'&id='.$_REQUEST['pk_id']);
				}
				else
				{
					$row  = $objMsg->getSubject();
					$objComm->checkReadWriteAccess($row->CreatedBy);
				}
					
				break;
				
	case 'DELMSG':
				$objComm->checkReadWriteAccess($type);
				$objMsg = new messageboard();
				$row = $objMsg->getMessageSubject();

				$objComm->checkReadWriteAccess($row->CreatedBy);
				
				$objMsg->delMessageSubject($_REQUEST['id']);
								
				$objComm->redirect1('index.php?model='.$model.'&type='.$type);
				break;					

	case 'DELSUB':
				$objComm->checkReadWriteAccess($type);
				$objMsg = new messageboard();
				$row  = $objMsg->getSubject();

				$objMsg->delMessageSubject($_REQUEST['id']);
				$objMsg->delSubject($_REQUEST['id']);
								
				$objComm->redirect1('index.php?model='.$model.'&type='.$type);
				break;	
	default:
				$WorkGroupID = ($type == 'gen') ? '0' : $_SESSION['site']['pm_row']->WorkgroupID;
				
				$objMsg = new messageboard();
				$Records = $objMsg->getAllMessage($WorkGroupID);
				$row = $objMsg->displayMessage($Records,$type);
				break;					
}

?>