<?php

$model  = $_REQUEST['model'];
$action = $_REQUEST['action'];
$type   = $_REQUEST['type'];

$type   = ($type == '' ) ? 'gen' : $type;
$WorkGroupID = ($type == 'gen') ? '0' : -1;

include_once(MODELS_ADMIN."messageboard_model.php");

switch(strtoupper($action))
{
	case 'ADD':
				if(isset($_REQUEST['btn_submit']) && $_REQUEST['btn_submit'] == 'save')
				{
					$objMsg = new messageboard();
					$objMsg->setMessage($_REQUEST);
					
					$objComm->redirect('index.php?model='.$model.'&type='.$type);
				}
				
				break;	
				
	case 'ADDSUB':
				$objComm->checkReadWriteAccess();
				
				if(isset($_REQUEST['btn_submit']) && $_REQUEST['btn_submit'] == 'savesub')
				{
					$objMsg = new messageboard();
					$objMsg->setMessageSubject($_REQUEST);
					
					$objComm->redirect('index.php?model='.$model.'&type='.$type);
				}
				break;
										
	case 'EDIT':
					$objMsg = new messageboard();
				
				if(isset($_REQUEST['btn_submit']) && $_REQUEST['btn_submit'] == 'update')
				{
					$objMsg->setMessage($_REQUEST);
					$objComm->redirect('index.php?model='.$model.'&action=edit&type='.$type.'&id='.$_REQUEST['pk_id']);	
				}
				else
				{
					$row = $objMsg->getMessageSubject();
				}
					
				break;
				
	case 'EDITSUB':
	
				$objMsg = new messageboard();
				
				if(isset($_REQUEST['btn_submit']) && $_REQUEST['btn_submit'] == 'updatesub')
				{
					$objMsg->setMessageSubject($_REQUEST);
					$objComm->redirect('index.php?model='.$model.'&action=editsub&type='.$type.'&id='.$_REQUEST['pk_id']);
				}
				else
				{
					$row  = $objMsg->getSubject();
				}
					
				break;				
					
	case 'DELMSG':
				$objMsg = new messageboard();
				$objMsg->delMessageSubject($_REQUEST['id']);
								
				$objComm->redirect('index.php?model='.$model.'&type='.$type);
				break;	
							
	case 'DELSUB':
				$objMsg = new messageboard();
				$objMsg->delSubject($_REQUEST['id']);
								
				$objComm->redirect('index.php?model='.$model.'&type='.$type);
				break;			
				
	default:
				$objMsg = new messageboard();
				$Records = $objMsg->getAllMessage($WorkGroupID);
				$ViewContent = $objMsg->displayMessage($Records, $type);

				break;
}

?>