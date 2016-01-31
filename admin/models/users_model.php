<?php


class users
{
	function __construct() 
	{
		
	}
	
	function getAllUsers()
	{
		global $DB;
		
		$start	=	($start == '' || $start < 0) ? '0' : $start - 1 ; 
		$start	=	($start * RECORD_PER_PAGE);
		
		$srUserID 	= $_POST['sr_UserID'];

		if($srUserID != '')		 $arrWhere[] = "A.`UserID` like '%".$srUserID."%'";
		
		$SQL = "SELECT A.*,B.WorkgroupID,B.RoleID,C.WorkgroupName,D.RoleName FROM User as A
					LEFT JOIN JoinUserWorkgroup as B ON B.UserID = A.UserID
					LEFT JOIN Workgroup as C On C.WorkgroupID = B.WorkgroupID
					LEFT JOIN Role as D ON D.RoleID = B.RoleID";	
		
		if(count($arrWhere) > 0)
			$Where = " WHERE ".implode(" AND ", $arrWhere); 
		
		if($Where != '')	
			$SQL .=  $Where;
		
		$Records = $DB->fetchAll($SQL);

		return $Records;
	}
	
	
	
	function getUsers($id)
	{
		global $DB;
		
		$SQL = "SELECT * FROM User as A
					LEFT JOIN JoinUserWorkgroup as B ON B.UserID = A.UserID
					LEFT JOIN Workgroup as C On C.WorkgroupID = B.WorkgroupID
					LEFT JOIN Role as D ON D.RoleID = B.RoleID
						WHERE A.UserID='".$id."'";	
						
		$row = $DB->fetchOne($SQL);
		
		return $row;
	}
	
	
	function setUsers()
	{
		global $objComm, $DB;
		
		$PkID = $_REQUEST['pk_id'];
		
		$this->arrField = $objComm->setTableField();
		
		if($_REQUEST['data_Password'] == '***********')
			unset($this->arrField['Password']);
		else	
			$this->arrField['Password'] = md5($this->arrField['Password']);
		
		$this->setExtraApplicationField();
		
		if($PkID > 0)
		{
			$_SESSION['User_success'] = "user_updated";
			
			$where = "`UserID` = '".$PkID."'";
			$DB->updateRecord('User', $this->arrField, $where , '');
		}
		else
		{
			$_SESSION['User_success'] = "user_added";		
		
			$UserID = $DB->addNewRecord('User', $this->arrField, '');
		}
		
		$this->setJoinUserWorkGroup($UserID);
	}
	
	public function setJoinUserWorkGroup($UserID = '')
	{
		global $objComm, $DB;
	
		$PkID = $_REQUEST['pk_id'];	
		
		$arrField['WorkgroupID'] = $_REQUEST['txt_workgroup'];
		$arrField['RoleID'] 	 = $_REQUEST['txt_user_role'];

		if($PkID > 0)
		{
			$where = "`UserID` = '".$PkID."'";
			return $DB->updateRecord('JoinUserWorkgroup', $arrField, $where , '');
		}
		else
		{
			$arrField['UserID'] 	 = $UserID;
			$DB->addNewRecord('JoinUserWorkgroup', $arrField, '');
		}	
	}
	
	public function setExtraApplicationField($action = '')
	{
		$action = ($action == "") ? $_REQUEST['action'] : $action;
		
		if(strtoupper($action) == 'SAVE')
		{
			#$this->arrField['created_datetime']	= date("Y-m-d 00:00:00");
		}
	
		if(strtoupper($action) == 'UPDATE')
		{
			#$this->arrField['updated_datetime']	= date("Y-m-d 00:00:00");
		}	

	}
	
	
	function delUsers($id)
	{
		global $DB;
		
		$row = $this->getUsers($id);
		
		if($row->IsAdmin == 1)
		{
			$_SESSION['User_error'] = "cant_delete_admin";	
			return NULL;
		}
			
		$_SESSION['User_success'] = "user_deleted";
		
		$SQL = "DELETE FROM User WHERE id='".$id."' LIMIT 1";
		$DB->query($SQL);	
	}
	
	
	function getAllWorkGroup()
	{
		global $DB;
		
		$SQL = "SELET * FROM Workgroup";
		$Records = $DB->fetchAll($SQL);	
		
	}
}

?>