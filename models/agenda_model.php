<?php


class agenda
{
	function __construct() 
	{
		
	}
	
	function getAllAgenda()
	{
		global $DB;
		
		$start	=	($start == '' || $start < 0) ? '0' : $start - 1 ; 
		$start	=	($start * RECORD_PER_PAGE);
		
		$srTopic = $_POST['sr_Topic'];
		$srDescription = $_POST['sr_Description'];
		
		if($srTopic != '')		 $arrWhere[] = "A.`Topic` like '%".$srTopic."%'";
		if($srDescription != '') $arrWhere[] = "A.`Description` like '%".$srDescription."%'";
		
		$arrWhere[] = "A.`UserID` = '".$_SESSION['site']['pm_row']->UserID."'";
		
		$SQL = "SELECT * FROM Agenda as A
					LEFT JOIN User as B ON A.UserID = B.UserID ";	
		
		if(count($arrWhere) > 0)
			$Where = " WHERE ".implode(" AND ", $arrWhere); 
		
		if($Where != '')	
			$SQL .=  $Where;
		
		//echo $SQL;
		$Records = $DB->fetchAll($SQL);
		
		return $Records;
	}
	
	
	function getAgenda($id)
	{
		global $DB;
		
		$SQL = "SELECT * FROM Agenda WHERE AgendaID='".$id."'";	
		$row = $DB->fetchOne($SQL);
		
		return $row;			
	}
	
	function setAgenda()
	{
		global $objComm, $DB;
		
		$PkID = $_REQUEST['pk_id'];

		$this->arrField = $objComm->setTableField();
		$this->arrField['UserID'] = $_SESSION['site']['pm_row']->UserID;
		
		//$this->setExtraApplicationField();

		if($PkID > 0)
		{
			$_SESSION['agenda_success'] = "agenda_updated";
			
			$where = "`AgendaID` = '".$PkID."'";
			return $DB->updateRecord('Agenda', $this->arrField, $where , '');
		}
		else
		{
			$_SESSION['agenda_success'] = "agenda_added";
		
			$DB->addNewRecord('Agenda', $this->arrField, '');
		}		
	}
	
	function delAgenda($id)
	{
		global $DB;
		
		$_SESSION['agenda_success'] = "agenda_deleted";
		
		$SQL = "DELETE FROM Agenda WHERE AgendaID = '".$id."'";
		$DB->query($SQL);	
	}
}

?>