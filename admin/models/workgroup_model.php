<?php


class workgroup
{
	function __construct() 
	{
		
	}
	
	function getAllWorkGroup()
	{
		global $DB;
		
		$start	=	($start == '' || $start < 0) ? '0' : $start - 1 ; 
		$start	=	($start * RECORD_PER_PAGE);
		
		$srWorkGroupName = $_POST['sr_workgroupname'];
		
		if($srWorkGroupName != '')		 $arrWhere[] = "`WorkgroupName` like '%".$srWorkGroupName."%'";
		
		$SQL = "SELECT * FROM Workgroup ";	
		
		if(count($arrWhere) > 0)
			$Where = " WHERE ".implode(" AND ", $arrWhere); 
		
		if($Where != '')	
			$SQL .=  $Where;
		
		//echo $SQL;
		$Records = $DB->fetchAll($SQL);
		
		return $Records;
	}
	
	
	function getWorkGroup($id)
	{
		global $DB;
		
		$SQL = "SELECT * FROM Workgroup WHERE WorkgroupID='".$id."'";	
		$row = $DB->fetchOne($SQL);
		
		return $row;			
	}
	
	function setWorkGroup()
	{
		global $objComm, $DB;
		
		$PkID = $_REQUEST['pk_id'];
		
		$this->arrField = $objComm->setTableField();
		
		//$this->setExtraApplicationField();

		if($PkID > 0)
		{
			$_SESSION['workgroup_success'] = "workgroup_updated";
			
			$where = "`WorkgroupID` = '".$PkID."'";
			return $DB->updateRecord('Workgroup', $this->arrField, $where , '');
		}
		else
		{
			$_SESSION['workgroup_success'] = "workgroup_added";		
		
			$DB->addNewRecord('Workgroup', $this->arrField, '');
		}		
	}
	
	function delWorkGroup($id)
	{
		global $DB;
		
		$_SESSION['workgroup_success'] = "workgroup_deleted";
		
		$SQL = "DELETE FROM Workgroup WHERE WorkgroupID = '".$id."'";
		$DB->query($SQL);	
	}
}

?>