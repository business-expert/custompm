<?php 

$model  = $_REQUEST['model'];
$action = $_REQUEST['action'];

include_once(MODELS_ADMIN."/".$model."_model.php");

switch(strtoupper($action))
{
	case 'ADD':
				break;
				
	case 'SAVE':
				$objWorkGroup = new workgroup();
				$objWorkGroup->setWorkGroup($_REQUEST);
				
				$objComm->redirect('index.php?model='.$model);
				break;
				
	case 'VIEW':
	case 'EDIT':
				$objWorkGroup = new workgroup();
				$row = $objWorkGroup->getWorkGroup($_REQUEST['id']);

				break;	
				
	case 'UPDATE':
	
				$objWorkGroup = new workgroup();
				$objWorkGroup->setWorkGroup($_REQUEST);
				
				$objComm->redirect('index.php?model='.$model.'&action=edit&id='.$_REQUEST['pk_id']);
				
				break;	
				
	case 'DELETE':
	
				$objWorkGroup = new workgroup();
				$objWorkGroup->delWorkGroup($_REQUEST['id']);
				
				$objComm->redirect('index.php?model='.$model);
				
				break;									
	
	default:
				$objWorkGroup = new workgroup();
				$Records = $objWorkGroup->getAllWorkGroup();
				break;
}

?>