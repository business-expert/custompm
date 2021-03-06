<?php

class document
{
	
	function __construct() 
	{
		$this->pk = 'DocumentID';
		$this->table = 'Documents';
	}
	
	
	function getAllDocument($WorkGroupID = 0)
	{
		global $DB;
		
		$start	=	($start == '' || $start < 0) ? '0' : $start - 1 ; 
		$start	=	($start * RECORD_PER_PAGE);
		
		$srUserID 	= $_POST['sr_UserID'];

		if($srUserID != '')		 $arrWhere[] = "`UserID` like '%".$srUserID."%'";
		
		if($WorkGroupID == 0)
			$arrWhere[] = "(A.`WorkgroupID`=".$WorkGroupID." OR A.`WorkgroupID` IS NULL)";
		else	
			$arrWhere[] = "A.`WorkgroupID`=".$WorkGroupID;
		
		$SQL = "SELECT * FROM Documents AS A
				  LEFT JOIN User AS C ON C.UserID = A.CreatedBy";	
		
		if(count($arrWhere) > 0)
			$Where = " WHERE ".implode(" AND ", $arrWhere); 
		
		if($Where != '')	
			$SQL .=  $Where;
		
		$Records = $DB->fetchAll($SQL);
		
		foreach($Records as $key => $row)
			$arrRecord[$row->DocumentID] = $row;

		$this->arrRecord = $arrRecord;
		
		return $arrRecord;
	}
	
	
	function makeHierarchy($DocType)
	{
		global $objComm, $lang;

		foreach($this->arrRecord as $key => $row)
			$arrTree[$row->DocumentID] = $row->ParentDocumentID;
		
		$this->strTree = '';
		//$arrTree = $objComm->parseTree($arrTree, 0) ;
		$this->displayDocument(0,$arrTree,true, $DocType);

		if(count($this->arrRecord) == 0)
			$this->strTree = '<div class="span7">&nbsp;&nbsp;&nbsp;'.$lang['No Documents Found'].'</div>';
			
		return $this->strTree;
	}
	
	
	function displayDocument($root, $tree, $IsFirst, $type) 
	{
    	$return = array();

	    if(!is_null($tree) && count($tree) > 0) 
		{
       		$this->strTree .= ($IsFirst == true) ? '<ul id="browser_'.$type.'" class="filetree">' : '<ul>';
			
        	foreach($tree as $child => $parent) 
			{
            	if($parent == $root) 
				{
                	unset($tree[$child]);
					
					$DocID = $this->arrRecord[$child]->DocumentID;
					$DocName = $this->arrRecord[$child]->DocumentName;
					$IsFolder = $this->arrRecord[$child]->IsFolder;
					$DocParentID = $this->arrRecord[$child]->ParentDocumentID;

					if($IsFolder == 'Y')
		                $this->strTree .= '<li><span class="folder">'.$DocName.'</span>'.$this->actionMenu($DocID,$DocParentID, 'folder', $type);
					else	
		                $this->strTree .= '<li>
											<span class="file">'.$DocName.'
												<a href="download.php?id='.$DocID.'">
													&nbsp;<i class="icon-download-alt"></i>
												</a>
											</span></li>'.$this->actionMenu($DocID,$DocParentID, 'file', $type);					
											
    	            $this->displayDocument($child, $tree, false, $type);
        	        $this->strTree .= '</li>';
            	}
	        }
    	    $this->strTree .=  '</ul>';
	    }
	}
	
	
	function actionMenu($DocumentID, $parentDocumentID, $type='folder',$DocType)
	{
		global $objComm, $lang;
		
		$RoleType  = $objComm->getRole($DocType);
		$CreatedBy = $this->arrRecord[$DocumentID]->CreatedBy;
		
		$style = ($type == 'file') ? 'margin:-19px 15px 0 0' : 'margin:0px 15px 0px 0px;';
			
		$strAction = '<div class="btn-group" style="float:right;'.$style.'">';
						
		if($type == 'folder')	
		{			
			if($RoleType == 'Write')
			{
				$strAction .= '<a href="index.php?model=document&action=add&type='.$DocType.'&parent_id='.$parentDocumentID.'">
								<button class="btn btn-mini">'.$lang['Add'].'</button></a>';
			}
		}
		
		if(($_SESSION['site']['pm_row']->UserID == $CreatedBy && $DocType == 'int') || ($RoleType == 'Write' && $DocType == 'gen'))
		{
			$strAction .= ' <a href="index.php?model=document&action=edit&type='.$DocType.'&id='.$DocumentID.'&parent_id='.$parentDocumentID.'">
							  <button class="btn btn-mini">'.$lang['Edit'].'</button></a>
							<a href="index.php?model=document&action=delete&type='.$DocType.'&id='.$DocumentID.'"">
							  <button class="btn btn-mini">'.$lang['Delete'].'</button></a>';	
		}

		$strAction .= '</div> ';		
		
		return $strAction;
	}
	
	
	function setDocument()
	{
		global $objComm, $DB, $objLog;
		
		$objLog->writeLog(__LINE__, __FILE__, 'Action :'.$_REQUEST['action'], 'Document');
		
		$PkID = $_REQUEST['pk_id'];
		
		$this->arrField = $objComm->setTableField();
		$ParentDocRow 	= $this->getDocumentOnParentID($_REQUEST['data_ParentDocumentID']);

		$objLog->writeLog(__LINE__, __FILE__, 'Upload Type :'.$_REQUEST['upload_type'][0], 'Document');
		
		if($_REQUEST['upload_type'][0] == 'file')
		{
			$this->arrField['IsFolder'] = 'N';
			$this->uploadFile($PkID, $ParentDocRow->DocumentPath);
			
			$objLog->writeLog(__LINE__, __FILE__, 'File Uploded', 'Document');
			
			$this->arrField['WorkgroupID'] = $ParentDocRow->WorkgroupID;
		}
		else	
		{
			$destination = $ParentDocRow->DocumentPath."/".$_REQUEST['txt_foldername'];
			
			$objLog->writeLog(__LINE__, __FILE__, 'New Folder :'.$destination, 'Document');			
			
			if($PkID > 0)
			{
				$objLog->writeLog(__LINE__, __FILE__, 'Rename Directory', 'Document');
				$this->renameDirectory($PkID, $destination);
			}
			else
			{
				$objLog->writeLog(__LINE__, __FILE__, 'Create Directory', 'Document');
				$objComm->createDirectory($destination);
			}
			
			$this->arrField['DocumentName'] = $_REQUEST['txt_foldername'];
			$this->arrField['DocumentPath'] = $destination;
			$this->arrField['IsFolder'] 	= 'Y';
		}
		
		$this->setExtraApplicationField();

		if($PkID > 0)
		{
			$_SESSION['document_success'] = "document_updated";
			
			$where = "`DocumentID` = '".$PkID."'";
			return $DB->updateRecord('Documents', $this->arrField, $where , '');
		}
		else
		{
			$_SESSION['document_success'] = "document_added";		
		
			$DB->addNewRecord('Documents', $this->arrField, '');
		}		
	}
	
	
	function uploadFile($ID, $uploadFile)
	{
		global $objComm, $objLog;
		
		$objLog->writeLog(__LINE__, __FILE__, 'Upload File Call', 'Document');
		
		$arrResponse = $objComm->uploadfile($uploadFile,$_FILES['txt_filename']);

		if($arrResponse['error'] != '')
		{
			$objLog->writeLog(__LINE__, __FILE__, 'Upload File Error: '.$arrResponse['error'], 'Document');
					
			$_SESSION['document_error'] = $arrResponse['error'];
			
			if($ID > 0)
				$objComm->redirect1("index.php?model=document&type=".$_REQUEST['type']."&action=edit&id=".$ID."&parent_id=".$_REQUEST['parent_id']);
			else	
				$objComm->redirect1("index.php?model=document&type=".$_REQUEST['type']."&action=add&parent_id=".$_REQUEST['parent_id']);	
		}
		else
		{
			$this->arrField['DocumentName'] = $arrResponse['filename'];
			$this->arrField['DocumentPath'] = $arrResponse['filepath'];	
			
			$this->deleteFileFolder($ID);
		}
	}
	
	
	function renameDirectory($id, $newName)
	{
		global $DB,	$objComm, $objLog;
		
		$row 	  = $this->getDocument($id);
		$oldName  = $row->DocumentPath;	
		
		$oldName1 = UPLOAD_PATH.$oldName;
		$newName1 = UPLOAD_PATH.$newName;
		
		$objLog->writeLog(__LINE__,__FILE__,'Rename Directory: Old - '.$oldName1.' || New = '.$newName1,'Document');

		rename($oldName1, $newName1);
		
		$this->updateFolderRecord($id, $oldName, $newName);
		//exec("mv ".$oldName." ".$newName);
	}
	
	
	function updateFolderRecord($id, $oldName, $newName)
	{
		global $DB,	$objComm, $objLog;
		
		$row = $this->getDocument($id);	
		
		if($row->DocumentPath != '' && $row->IsFolder == 'Y')
		{
			$sql = "UPDATE Documents SET `DocumentPath` = replace(`DocumentPath`,'".$oldName."','".$newName."') 
					  WHERE DocumentPath LIKE '".$row->DocumentPath."%'";
			
			$objLog->writeLog(__LINE__, __FILE__, 'Rename Directory: SQL - '.$sql , 'Document');	
					
			$DB->query($sql);
		}
	}
	
	
	function deleteFileFolder($id)
	{
		global $DB,	$objComm, $objLog;;
		
		$row = $this->getDocument($id);	

		$objLog->writeLog(__LINE__, __FILE__, 'Delete File :'.UPLOAD_PATH.$row->DocumentPath, 'Document');
		
		chmod(UPLOAD_PATH.$row->DocumentPath,0777);
		exec("chmod 0777 ".UPLOAD_PATH.$row->DocumentPath);
		
		unlink(UPLOAD_PATH.$row->DocumentPath);
		exec("rm -f ".UPLOAD_PATH.$row->DocumentPath);
	}
	
	
	function setExtraApplicationField($action = '')
	{
		$action = ($action == "") ? $_REQUEST['action'] : $action;
		
		if(strtoupper($action) == 'ADD')
			$this->arrField['CreatedBy']   = $_SESSION['site']['pm_row']->UserID;
	}
	

	function getMessageSubject()
	{
		global $DB, $objComm;
		
		$SQL = "SELECT * FROM MessageSubject as A
					LEFT JOIN Message as B ON B.SubjectID = A.MessageSubjectID
						WHERE B.MessageID='".$_REQUEST['id']."'";
						
		$Records = $DB->fetchOne($SQL);
		
		return $Records;
	}
	
	
	function getDocumentOnParentID($id)
	{
		global $DB, $objComm;
		
		$SQL = "SELECT * FROM Documents WHERE DocumentID='".$id."'";
						
		$Records = $DB->fetchOne($SQL);
		
		return $Records;
	}


	function getDocument($id)
	{
		global $DB, $objComm;
		
		$SQL = "SELECT * FROM Documents WHERE DocumentID='".$id."'";
						
		$Records = $DB->fetchOne($SQL);
		
		return $Records;
	}
	
	
	function delDocument($id)
	{
		global $DB, $objComm;
		
		$SQL = "SELECT * FROM Documents WHERE DocumentID = '".$id."'";
						
		$row  = $DB->fetchOne($SQL);
		
		if($row->IsFolder == 'N')
		{
			$this->deleteFileFolder($id);
			
			$delete = "DELETE FROM Documents WHERE DocumentID = '".$id."'";
			$DB->query($delete);
		}	
		else
		{
			exec("rm -rf ".UPLOAD_PATH.$row->DocumentPath);
			$objComm->recursiveDirectoryDelete(UPLOAD_PATH.$row->DocumentPath);
			
			$delete = "DELETE FROM Documents WHERE DocumentPath LIKE '".$row->DocumentPath."%'";
			$DB->query($delete);
		}
			
		$_SESSION['document_success'] = "document_deleted";
	}
	
	
	function getDocumentTree($arrDeleteID, $id)
	{
		global $DB, $objComm;
		
		$SQL = "SELECT * FROM Document WHERE ParentDocumentID = '".$id."'";
		$Records = $DB->fetchAll($SQL);
		
		foreach($Records as $row)
		{
			$arrDeleteID[] = $row->DocumentID;
			$this->getDocumentTree($arrDeleteID, $row->DocumentID);
		}
	}
}

?>