<?php
ini_set('post_max_size', '64M');
ini_set('upload_max_filesize', '64M');

$model  = $_REQUEST['model'];
$action = $_REQUEST['action'];
$type 	= $_REQUEST['type'];

$WorkGroupID = ($type == 'gen') ? '0' : -1;
include_once(MODELS_ADMIN."/document_model.php");

switch(strtoupper($action))
{
	case 'ADD':
				if(isset($_REQUEST['btn_submit']) && $_REQUEST['btn_submit'] == 'save')
				{
					$objDoc = new document();
					$objDoc->setDocument();
					$objComm->redirect('index.php?model='.$model.'&type='.$type);
				}
				
				break;
				
	case 'EDIT':
				
				$objDoc = new document();
				
				if(isset($_REQUEST['btn_submit']) && $_REQUEST['btn_submit'] == 'update')
				{
					$objDoc->setDocument($_REQUEST);
					$objComm->redirect('index.php?model='.$model.'&action=edit&type='.$type.'&id='.$_REQUEST['pk_id'].'&parent_id='.$_REQUEST['parent_id']);	
				}
				else
				{
					$row = $objDoc->getDocument($_REQUEST['id']);
				}
					
				break;
								
	case 'DELETE':
	
				$objDoc = new document();
				$objDoc->delDocument($_REQUEST['id']);
				
				$objComm->redirect('index.php?model='.$model);
				
				break;									
	
	default:

				$objDoc = new document();
				$Records = $objDoc->getAllDocument($WorkGroupID);
				$strTree = $objDoc->makeHierarchy($type);
				break;
}

?>