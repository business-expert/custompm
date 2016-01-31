<?php


class login
{
	function __construct() 
	{
		
	}
	
	function checkLogin()
	{
		global $objComm;
		
		$this->ValidateData();
		
		if($this->row->UserID > 0)
		{
			$this->setLoggedSession();
			$objComm->redirect1('index.php?model=dashboard');
		}
	}
	
	
	function ValidateData()
	{
		global $DB, $objComm;

		$SQL = "SELECT A.UserID, A.UserName, A.Email, A.Status, B.WorkgroupID, B.RoleID, C.RoleName,D.WorkgroupName,A.IsBoardMember 
				  FROM User as A
				  	LEFT JOIN JoinUserWorkgroup as B ON B.UserID = A.UserID
					LEFT JOIN Role as C ON C.RoleID = B.RoleID
					LEFT JOIN Workgroup as D ON D.WorkgroupID = B.WorkgroupID
						WHERE A.UserName='".$_POST['username']."' AND A.Password='".md5($_POST['password'])."'";
						
		$row = $DB->fetchOne($SQL);
		
		if($row->UserID > 0)
		{
			if(strtoupper($row->Status) == '0')
				$this->row = $row;
			else
			{
				$_SESSION['login_error'] = "account_block";
				$objComm->redirect1("index.php");
			}
		}
		else
		{
			$_SESSION['login_error'] = "incorrect_username_password";
			$objComm->redirect1("index.php");
		}
	}
	
	function setLoggedSession()
	{
		$_SESSION['site']['pm_user']  = $this->row->UserName;
		$_SESSION['site']['pm_row']   = $this->row;
	}
	
	function logout()
	{
		global $objComm;

		foreach($_SESSION['site'] as $key => $value)
		{
			$_SESSION['site'][$key] = '';
			unset($_SESSION['site'][$key]);
		}
		
		$_SESSION['login_success']	= 'logout_success';
		$objComm->redirect1('index.php');

		exit();		
	}
}

?>