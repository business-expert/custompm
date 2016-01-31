<?php

class messageboard
{
	
	function __construct() 
	{
		
	}
	
	
	function getAllMessage($WorkGroupID = 0)
	{
		global $DB;
		
		$start	=	($start == '' || $start < 0) ? '0' : $start - 1 ; 
		$start	=	($start * RECORD_PER_PAGE);
		
		$srSubject	= $_POST['sr_Subject'];
		$srMessageText	= $_POST['sr_MessageText'];
		$srWorkGroupID	= $_POST['sr_WorkGroup'];

		if($srSubject != '')   		$arrWhere[] = "A.`SubjectName` like '%".$srSubject."%'";
		if($srMessageText != '')  	$arrWhere[] = "B.`MessageText` like '%".$srMessageText."%'";
		if($srWorkGroupID != '')  	$arrWhere[] = "A.`WorkgroupID` = '".$srWorkGroupID."'";
		
		if($WorkGroupID == '-1')
			$arrWhere[] = "A.`WorkgroupID` > 0";
		else	
			$arrWhere[] = "A.`WorkgroupID` = 0";
		
		$SQL = "SELECT A.MessageSubjectID,A.SubjectName,B.MessageID,B.MessageText,B.DateCreated,B.CreatedBy,C.UserName,A.WorkgroupID
					FROM MessageSubject AS A
						LEFT JOIN Message AS B ON B.SubjectID = A.MessageSubjectID
						LEFT JOIN User AS C ON C.UserID = B.CreatedBy";	
		
		if(count($arrWhere) > 0)
			$Where = " WHERE ".implode(" AND ", $arrWhere); 
		
		if($Where != '')	
			$SQL .=  $Where;
		
		$SQL .=  " ORDER BY A.MessageSubjectID AND A.DateCreated DESC";
		
		//echo $SQL;
		$Records = $DB->fetchAll($SQL);
		
		return $Records;
	}
	
	
	function displayMessage($Records, $type)
	{
		global $lang;
		
		$SubjectID = '';
		$type = ($type == '') ? 'gen' : $type;
		
		if(count($Records) == 0)
			return '<div class="box-content">
                  	<div class="row-fluid">
                        <div class="span4"><h6></h6></div>
                        <div class="span4"><h6>No Message Found</h6></div>
                        <div class="span4"><h6></h6></div>
                    </div>                   
                  </div>';	
			
		foreach($Records as $key => $row)
		{
			if($SubjectID != $row->MessageSubjectID)	
			{
				$SubjectID = $row->MessageSubjectID;
				
				$arrSubjectDiv[] = '<div class="row-fluid">
									<div class="span8">
								  	<span class="icon32 icon-color icon-triangle-e" style="margin-top:-9px;" id="div_subject_'.$SubjectID.'" subject="'.$SubjectID.'">
								  	</span> '.$row->SubjectName.'</div>
									<a href="index.php?model=messageboard&type='.$type.'&action=add&subject_id='.$row->MessageSubjectID.'">
										<button class="btn btn-mini btn-info">&nbsp;'.$lang['Add Message'].'&nbsp;</button></a>&nbsp;
									<a href="index.php?model=messageboard&type='.$type.'&action=editsub&id='.$row->MessageSubjectID.'">
										<button class="btn btn-mini btn-success">&nbsp;'.$lang['Edit Subject'].'&nbsp;</button></a>&nbsp;
									<a href="index.php?model=messageboard&type='.$type.'&action=delsub&id='.$row->MessageSubjectID.'" onclick="return deleteSubjectConfirm();">
										<button class="btn btn-mini btn-danger">&nbsp;'.$lang['Delete Subject'].'&nbsp;</button></a>	
										</div>';
									
				if($row->MessageText != '')	
				{
					$Date 		= date(DATE_FORMAT,strtotime($row->DateCreated));
					$Time 		= date(TIME_FORMAT,strtotime($row->DateCreated));
					$DateTime 	= date(DATE_FORMAT.TIME_FORMAT,strtotime($row->DateCreated));
					$MsgText 	= $row->MessageText;
					$CreatedBy 	= $row->UserName;				
					$ShortMsgText = (strlen($row->MessageText) > 200) ? substr($row->MessageText,0,200)."..." : $row->MessageText;					
				
					$arrSubjectDiv[] = '<div class="row-fluid" style="margin-bottom:8px;display:none;margin-left:-29px;" id="div_text_'.$SubjectID.'_'.$row->MessageID.'" >
										<div class="span1"></div>
										<div class="span1">'.$Date.'<br />'.$Time.'</div>
										<div class="span7">'.$CreatedBy.'<br />"'.$ShortMsgText.'"</div>
										<div class="span3">
											<button id="view" value="'.$SubjectID.'_'.$row->MessageID.'" class="btn btn-mini" onclick="javascript:getMessageDetails(\''.$row->MessageID.'\',\''.$type.'\');">'.$lang['View'].'</button>
										  	<a href="index.php?model=messageboard&type='.$type.'&action=edit&id='.$row->MessageID.'">
											<button class="btn btn-mini">&nbsp;'.$lang['Edit'].'&nbsp;</button></a>
											<a href="index.php?model=messageboard&type='.$type.'&action=delmsg&id='.$row->MessageID.'" onclick="return deleteMsgConfirm();"><button class="btn btn-mini">'.$lang['Delete'].'</button></a></div>
										</div>';	
				}
				
			}
			else
			{
				$Date 		= date(DATE_FORMAT,strtotime($row->DateCreated));
				$Time 		= date(TIME_FORMAT,strtotime($row->DateCreated));
				$DateTime 	= date(DATE_FORMAT.TIME_FORMAT,strtotime($row->DateCreated));				
				$MsgText 	= $row->MessageText;
				$CreatedBy  = $row->UserName;
				$ShortMsgText = (strlen($row->MessageText) > 200) ? substr($row->MessageText,0,200)."..." : $row->MessageText;								
				
				$arrSubjectDiv[] = '<div class="row-fluid" style="margin-bottom:8px;display:none;margin-left:-29px;" id="div_text_'.$SubjectID.'_'.$row->MessageID.'">
									  <div class="span1"></div>
									  <div class="span1">'.$Date.'<br />'.$Time.'</div>
									  <div class="span7">'.$CreatedBy.'<br />"'.$ShortMsgText.'"</div>
									  <div class="span3">
								  	<button id="view" value="'.$SubjectID.'_'.$row->MessageID.'" class="btn btn-mini" onclick="javascript:getMessageDetails(\''.$row->MessageID.'\',\''.$type.'\');">'.$lang['View'].'</button>
									  	<a href="index.php?model=messageboard&type='.$type.'&action=edit&id='.$row->MessageID.'">
										<button class="btn btn-mini">&nbsp;'.$lang['Edit'].'&nbsp;</button></a>
										<a href="index.php?model=messageboard&type='.$type.'&action=delmsg&id='.$row->MessageID.'" onclick="return deleteMsgConfirm();"><button class="btn btn-mini">'.$lang['Delete'].'</button></a></div>
									</div>';	
			}
		}
		
		if(count($arrSubjectDiv) > 0)
			return  @implode(" ",$arrSubjectDiv);
	}
	
	
	function setMessage()
	{
		global $objComm, $DB;
		
		$PkID = $_REQUEST['pk_id'];
		
		$this->arrField = $objComm->setTableField();
		
		$this->arrField['MessageText'] = htmlentities($_REQUEST['data_MessageText']);
		$this->setExtraApplicationField();

		if($PkID > 0)
		{
			$_SESSION['messageboard_success'] = "message_updated";
			
			$where = "`MessageID` = '".$PkID."'";
			return $DB->updateRecord('Message', $this->arrField, $where , '');
		}
		else
		{
			$_SESSION['messageboard_success'] = "message_added";		
		
			$DB->addNewRecord('Message', $this->arrField, '');
		}		
	}
	
	
	function setExtraApplicationField($action = '')
	{
		$action = ($action == "") ? $_REQUEST['action'] : $action;
		
		if(strtoupper($action) == 'ADDSUB')
			$this->arrField['CreatedBy'] = $_SESSION['admin']['pm_user_row']->UserID;
		
		if(strtoupper($action) == 'ADD')
			$this->arrField['CreatedBy'] = $_SESSION['admin']['pm_user_row']->UserID;
	}


	function setMessageSubject()
	{
		global $objComm, $DB;
		
		$PkID = $_REQUEST['pk_id'];
		
		$this->arrField = $objComm->setTableField();
		
		$this->arrField['SubjectName'] = htmlentities($_REQUEST['data_SubjectName']);
		$this->setExtraApplicationField();

		if($PkID > 0)
		{
			$_SESSION['messageboard_success'] = "subject_updated";
			
			$where = "`MessageSubjectID` = '".$PkID."'";
			return $DB->updateRecord('MessageSubject', $this->arrField, $where , '');
		}
		else
		{
			$_SESSION['messageboard_success'] = "subject_added";		
		
			$DB->addNewRecord('MessageSubject', $this->arrField, '');
		}		
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
	
	
	function getSubject()
	{
		global $DB, $objComm;
		
		$SQL = "SELECT * FROM MessageSubject WHERE MessageSubjectID='".$_REQUEST['id']."'";
						
		$Records = $DB->fetchOne($SQL);
		
		return $Records;
	}
	
	
	function delSubject($id)
	{
		global $DB, $objComm;
		
		$SQL = "DELETE A,B FROM MessageSubject as A
					LEFT JOIN Message as B ON B.SubjectID = A.MessageSubjectID
						WHERE A.MessageSubjectID='".$id."'";
						
		$DB->query($SQL);
		
		$_SESSION['messageboard_success'] = "subject_msg_all_deleted";
	}


	function delMessageSubject($id)
	{
		global $DB, $objComm;
		
		$SQL = "DELETE FROM Message WHERE MessageID = '".$id."'";
						
		$DB->query($SQL);
		
		$_SESSION['messageboard_success'] = "message_deleted";
	}

}

?>