<?php 

$model  = $_REQUEST['model'];
$action = $_REQUEST['action'];

include_once(MODELS_ADMIN."/".$model."_model.php");

switch(strtoupper($action))
{
	case 'ADD':
				break;
				
	case 'SAVE':
				$objAgenda = new agenda();
				$objAgenda->setAgenda($_REQUEST);
				
				$objComm->redirect('index.php?model='.$model);
				break;
				
	case 'VIEW':
	case 'EDIT':
				$objAgenda = new agenda();
				$row = $objAgenda->getAgenda($_REQUEST['id']);

				break;	
				
	case 'UPDATE':
	
				$objAgenda = new agenda();
				$objAgenda->setAgenda($_REQUEST);
				
				$objComm->redirect('index.php?model='.$model.'&action=edit&id='.$_REQUEST['pk_id']);
				
				break;	
				
	case 'DELETE':
	
				$objAgenda = new agenda();
				$objAgenda->delAgenda($_REQUEST['id']);
				
				$objComm->redirect('index.php?model='.$model);
				
				break;									
	
	default:
				$objAgenda = new agenda();
				$Records = $objAgenda->getAllAgenda();
				break;
}

?>