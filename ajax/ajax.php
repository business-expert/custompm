<?php

if($_REQUEST['ajaxcall'] == true)
{

	$mod = $_REQUEST['mod'];
	
	if($mod != ''){
		if(function_exists($mod)){
			echo $mod(); die();
		}
	}
}	


function getSubjectWorkgroupID()
{
	global $DB, $objComm, $lang;

	$SQL = "SELECT * FROM MessageSubject WHERE MessageSubjectID='".$_REQUEST['subject_id']."'";
	$row = $DB->fetchOne($SQL);		

	return $row->WorkgroupID;
}

function getDashboardGeneralMessage()
{
	$objDash = new dashboard();

	$RowGeneralMessage = $objDash->getAllMessageBoard();
	$GeneralMessageBox = $objDash->displayMessageBoard($RowGeneralMessage);	
	
	return $GeneralMessageBox;
}

function getDashboardInternalMessage()
{
	$workgroup = ($_REQUEST['workgroup'] > 0) ? $_REQUEST['workgroup'] : -1;
	
	$objDash   = new dashboard();
	
	$RowInternalMessage = $objDash->getAllMessageBoard($workgroup);
	$InternalMessageBox = $objDash->displayMessageBoard($RowInternalMessage);
	
	return $InternalMessageBox;
}

function getDocumentWorkGroup()
{
	global $DB, $objComm, $lang;

	$SQL = "SELECT * FROM Documents WHERE DocumentID='".$_REQUEST['DocID']."'";
	$row = $DB->fetchOne($SQL);		

	return $row->WorkgroupID;	
	
}

function getDashboardAgenda()
{
	$objDash = new dashboard();

	$RowAgenda = $objDash->getAllAgenda();
	$strAgenda = $objDash->displayAgenda($RowAgenda);	
	
	return $strAgenda;
}

function getMessageModel()
{
	global $DB;

	$SubjectID	 = $_REQUEST['message_id'];
	$WorkGroupID = ($_REQUEST['type'] == 'gen') ? 0 : $_SESSION['site']['pm_row']->WorkgroupID;
	
	if($_REQUEST['type'] != '')
		$arrWhere[] = "A.`WorkgroupID`='".$WorkGroupID."'";
		
	$arrWhere[] = "A.`MessageSubjectID`=".$SubjectID;	
	
	$SQL = "SELECT A.MessageSubjectID,A.SubjectName,B.MessageID,B.MessageText,B.DateCreated,
				B.DateCreated,A.CreatedBy as SubjectCreatedBy, B.CreatedBy as MessageCreatedBy,C.UserName
				FROM MessageSubject AS A
					LEFT JOIN Message AS B ON B.SubjectID = A.MessageSubjectID
					LEFT JOIN User AS C ON C.UserID = B.CreatedBy";	
	
	if(count($arrWhere) > 0)
		$Where = " WHERE ".implode(" AND ", $arrWhere); 
	
	if($Where != '')	
		$SQL .=  $Where;
	
	//echo $SQL;
	$Records = $DB->fetchAll($SQL);
	
	foreach($Records as $key => $row)
		$Records[$key]->MessageText = nl2br($Records[$key]->MessageText);

	return json_encode($Records);
}

function getMessageModel1()
{
	global $DB;

	$SubjectID	 = $_REQUEST['message_id'];
	$WorkGroupID = ($_REQUEST['type'] == 'gen') ? 0 : $_SESSION['site']['pm_row']->WorkgroupID;
	
	if($_REQUEST['type'] != '')
	{
		if($_REQUEST['type'] == 'gen')
			$arrWhere[] = "A.`WorkgroupID`='".$WorkGroupID."'";
		else if($WorkGroupID == '')
			$arrWhere[] = "A.`WorkgroupID` > '0'";		
		else	
			$arrWhere[] = "A.`WorkgroupID`='".$WorkGroupID."'";
	}
		
	$arrWhere[] = "B.`MessageID`=".$SubjectID;	
	
	$SQL = "SELECT A.MessageSubjectID,A.SubjectName,B.MessageID,B.MessageText,B.DateCreated,
				B.DateCreated,A.CreatedBy as SubjectCreatedBy, B.CreatedBy as MessageCreatedBy,C.UserName
				FROM MessageSubject AS A
					LEFT JOIN Message AS B ON B.SubjectID = A.MessageSubjectID
					LEFT JOIN User AS C ON C.UserID = B.CreatedBy";	
	
	if(count($arrWhere) > 0)
		$Where = " WHERE ".implode(" AND ", $arrWhere); 
	
	if($Where != '')	
		$SQL .=  $Where;
	
	$Records = $DB->fetchOne($SQL);
	
	$Records->MessageText = nl2br($Records->MessageText);

	return json_encode($Records);
}


function getAgendaModel()
{
	global $DB;
	
	$AgendaID = $_REQUEST['agenda_id'];
	$UserID = $_SESSION['site']['pm_row']->UserID;
		
	$SQL = "SELECT * FROM Agenda 
				WHERE AgendaID='".$AgendaID."' AND `UserID`='".$UserID."'";	
				
	$row = $DB->fetchOne($SQL);
	
	return json_encode($row);
}

function getAgendaModel1()
{
	global $DB;
	
	$AgendaID = $_REQUEST['agenda_id'];
	
	$SQL = "SELECT * FROM Agenda  WHERE AgendaID='".$AgendaID."'";
				
	$row = $DB->fetchOne($SQL);
	
	return json_encode($row);
}

function getWorkGroupDocument()
{
	$WorkGroupID = $_REQUEST['workgroup_id'];
	$WorkGroupID = ($WorkGroupID == '') ? '-1' : $WorkGroupID;

	$objDash = new dashboard();	
	$objDash->getAllDocument($WorkGroupID);
	$InternalDocuments = $objDash->makeHierarchy('int');
	
	return $InternalDocuments;
}

?>