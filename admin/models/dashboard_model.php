<?php

class dashboard
{
	function __construct() 
	{
		
	}
	
	function getAllMessageBoard($workgroup = 0)
	{
		global $DB;
		
		$arrWhere = array();

		$SQL = "SELECT *, (SELECT count(*) FROM Message as B WHERE B.SubjectID = MessageSubjectID) as totalmessage,
				(SELECT MessageText FROM Message as B WHERE B.SubjectID = MessageSubjectID ORDER BY DateCreated DESC LIMIT 1)  as message,
				(SELECT MessageID FROM Message as B WHERE B.SubjectID = MessageSubjectID ORDER BY DateCreated DESC LIMIT 1)  as MessageID
					FROM MessageSubject as A";
		
		if($workgroup == 0)
			$arrWhere[] = "(A.WorkgroupID = 0 || A.WorkgroupID = '')";
		else if($workgroup == -1)
			$arrWhere[] = "A.WorkgroupID > 0";
		else	
			$arrWhere[] = "A.WorkgroupID = '".$workgroup."'";
			
		if(is_array($arrWhere) && count($arrWhere) > 0)	
			$SQL .= " WHERE ".implode(" AND " , $arrWhere);

		$SQL .= " ORDER BY A.MessageSubjectID DESC LIMIT 5";
			
		$Records = $DB->fetchAll($SQL);
		
		return $Records;
	}
		
	function displayMessageBoard($record)
	{
		global $lang;
		
		if(count($record) == 0)
			$messageBoard = '<div class="span7">'.$lang['no message found'].'</div>';
			
		foreach($record as $key => $row)
		{
			$DateD = date("d",strtotime($row->DateCreated));
			$DateM = date("M",strtotime($row->DateCreated));			
			$Subject = (strlen($row->SubjectName) > 50 ) ? substr($row->SubjectName,0, 50)."..." : $row->SubjectName;
			$Message = (strlen($row->message) > 100 ) ? substr($row->message,0, 100)."..." : $row->message;			
			
			$arrMessageBoard[] = '<li>
									<div class="row-fluid">
									  <div class="span1"><span class="green"><strong>'.$DateD.'<br>'.$DateM.'</strong></span></div>
									  <div class="span9"><strong>'.$Subject.' ('.$row->totalmessage.')</strong><br />"'.$Message.' "</div>
									  <div class="span2"><a href="javascript:getMessageModel(\''.$row->MessageSubjectID.'\');">'.$lang['View'].'</a></div>
									</div>
								  </li>';
		}
		
		if(count($arrMessageBoard) > 0)
			$messageBoard = '<ul class="dashboard-list">'.implode("",$arrMessageBoard).'</ul>';
		
		return $messageBoard;
	}
	
	function getAllAgenda()
	{
		global $DB;
		
		$arrWhere = array();

		$srUserID = $_POST['sr_UserID'];

		if($srUserID != '')		 $arrWhere[] = "`A.UserID` like '%".$srUserID."%'";
		
		$SQL = "SELECT * FROM Agenda  as A
					LEFT JOIN User as B ON B.UserID = A.UserID";
		
		
		if(is_array($arrWhere) && count($arrWhere) > 0)	
			$SQL .= " WHERE ".implode(" AND " , $arrWhere);

		$SQL .= " ORDER BY A.DateCreated DESC LIMIT 5";
			
		$Records = $DB->fetchAll($SQL);
		
		return $Records;	
	}
	
	function displayAgenda($record)
	{
		global $lang;
		
		if(count($record) == 0)
			$messageBoard = '<div class="span7">'.$lang['No Agenda Found'].'</div>';
			
		foreach($record as $key => $row)
		{
			$Date = date("Y-m-d",strtotime($row->DateCreated));
			$Topic = (strlen($row->Topic) > 50 ) ? substr($row->Topic,0, 50)."..." : $row->Topic;
			
			$arrTopic[] = '<li>
							<div class="row-fluid">
							<div class="span3"><span class="green"><strong>'.$Date.'</strong></span></div>
							<div class="span7"><strong>'.$Topic.'</strong></div>
							<div class="span2"><h6><a href="javascript:getAgendaModel(\''.$row->AgendaID.'\');">'.$lang['View'].'</a></h6></div>
					  	  </li>';
		}
		
		if(count($arrTopic) > 0)
			$messageBoard = '<ul class="dashboard-list">'.implode("",$arrTopic).'</ul>';
		
		return $messageBoard;
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
		else if($WorkGroupID == -1)	
			$arrWhere[] = "A.`WorkgroupID` > 0";
		else
			$arrWhere[] = "A.`WorkgroupID` = '".$WorkGroupID."'";
		
		$SQL = "SELECT * FROM Documents AS A
				  LEFT JOIN User AS C ON C.UserID = A.CreatedBy";	
		
		if(count($arrWhere) > 0)
			$Where = " WHERE ".implode(" AND ", $arrWhere); 
		
		if($Where != '')	
			$SQL .=  $Where;
		
		#echo "<br>".$SQL;
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
		$this->displayDocument(0,$arrTree, $DocType, true);
		$rr = $objComm->parseTree($arrTree, 0) ;
		
		if(count($this->arrRecord) == 0)
			$this->strTree = '<div class="span7">'.$lang['No Documents Found'].'</div>';
			
		return $this->strTree;
	}
	
	function displayDocument($root, $tree, $DocType, $IsFirst) 
	{
		global $objComm;
		
    	$return = array();
		
		$DocType = ($DocType == '') ? 'gen' : $DocType;
		
	    if(!is_null($tree) && count($tree) > 0) 
		{
			if($IsFirst == true)
        		$this->strTree .= '<ul id="browser_'.$DocType.'" class="filetree">';
			else	
				$this->strTree .= '<ul>';
			
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
		                $this->strTree .= '<li><span class="folder">'.$DocName.'</span>';
					else	
		                $this->strTree .= '<li>
											<span class="file">'.$DocName.'
												<a href="../download.php?id='.$DocID.'">
													&nbsp;<i class="icon-download-alt"></i>
												</a>
											</span>
										   </li>';
																	
    	            $this->displayDocument($child, $tree, $DocType,false);
        	        $this->strTree .= '</li>';
            	}
	        }
    	    $this->strTree .=  '</ul>';
	    }
	}
	
}
?>