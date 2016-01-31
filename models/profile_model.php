<?php


class profile
{
	function __profile() 
	{
		
	}
	
	function getUser($id)
	{
		global $DB;
		
		$SQL = "SELECT * FROM User as  WHERE UserID='".$id."'";	
		
		$srUserID 	= $id;

		if($srUserID != '')		 $arrWhere[] = "A.`UserID` like '%".$srUserID."%'";
		
		$SQL = "SELECT * FROM User as A
					LEFT JOIN JoinUserWorkgroup as B ON B.UserID = A.UserID
					LEFT JOIN Workgroup as C On C.WorkgroupID = B.WorkgroupID
					LEFT JOIN Role as D ON D.RoleID = B.RoleID";	
		
		if(count($arrWhere) > 0)
			$Where = " WHERE ".implode(" AND ", $arrWhere); 
		
		if($Where != '')	
			$SQL .=  $Where;
		
		$row = $DB->fetchOne($SQL);
		
		return $row;
	}
	
	function setUsers()
	{
		global $objComm, $DB;
		
		$PkID = $_SESSION['site']['pm_row']->UserID;
		
		$this->arrField = $objComm->setTableField();
		
		if($_REQUEST['data_Password'] == '')
			unset($this->arrField['Password']);
		else if($this->arrField['Password'] != '')
			$this->arrField['Password'] = md5($this->arrField['Password']);
			
		if($PkID > 0)
		{
			$_SESSION['User_success'] = "profile_updated";
			
			$where = "`UserID` = '".$PkID."'";
			return $DB->updateRecord('User', $this->arrField, $where , '');
		}
	}
}

?>
	