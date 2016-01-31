<?php 

$model  = $_REQUEST['model'];
$action = $_REQUEST['action'];

include_once(MODELS_ADMIN."/".$model."_model.php");

switch(strtoupper($action))
{
	case 'ADD':
				if(isset($_REQUEST['btn_submit']) && $_REQUEST['btn_submit'] == 'save')
				{
					$objUsr = new users();
					$objUsr->setUsers($_REQUEST);
				
					$objComm->redirect('index.php?model='.$model);	
				}
			
				break;
				
	case 'VIEW':
	case 'EDIT':
				if(isset($_REQUEST['btn_submit']) && $_REQUEST['btn_submit'] == 'update')
				{
					$objUsr = new users();
					$objUsr->setUsers($_REQUEST);

					$objComm->redirect('index.php?model='.$model.'&action=edit&id='.$_REQUEST['pk_id']);
				}
				else
				{
					$objUsr = new users();
					$row = $objUsr->getUsers($_REQUEST['id']);
				}
				break;	
				
	case 'DELETE':
	
				$objUsr = new users();
				$objUsr->delUsers($_REQUEST['id']);
				
				$objComm->redirect('index.php?model='.$model);
				
				break;									
	
	default:
				$objUsr = new users();
				$Records = $objUsr->getAllUsers();
				break;
}

?>