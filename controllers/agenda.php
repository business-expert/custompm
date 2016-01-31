<?php 

$model  = $_REQUEST['model'];
$action = $_REQUEST['action'];
$type   = 'gen';

include_once(MODELS."/".$model."_model.php");

switch(strtoupper($action))
{
	case 'ADD':
				$objComm->checkReadWriteAccess($type);
				
				if(isset($_REQUEST['btn_submit']) && $_REQUEST['btn_submit'] == 'save')
				{
					$objAgenda = new agenda();
					$objAgenda->setAgenda($_REQUEST);
				
					$objComm->redirect1('index.php?model='.$model);
				}
				break;
				
	case 'VIEW':
	case 'EDIT':
				$objComm->checkReadWriteAccess($type);
				
				if(isset($_REQUEST['btn_submit']) && $_REQUEST['btn_submit'] == 'update')
				{
					$objAgenda = new agenda();
					$objAgenda->setAgenda($_REQUEST);

					$objComm->redirect1('index.php?model='.$model.'&action=edit&id='.$_REQUEST['pk_id']);
				}
				else
				{
					$objAgenda = new agenda();
					$row = $objAgenda->getAgenda($_REQUEST['id']);
				}

				

				break;	
				
	case 'DELETE':
				
				$objComm->checkReadWriteAccess($type);
				
				$objAgenda = new agenda();
				$objAgenda->delAgenda($_REQUEST['id']);
				
				$objComm->redirect1('index.php?model='.$model);
				
				break;									
	
	default:
				$objAgenda = new agenda();
				$Records = $objAgenda->getAllAgenda();
				break;
}

?>