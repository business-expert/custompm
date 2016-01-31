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
			
			$objComm->redirect('index.php?model=dashboard');
		}
	}
	
	
	function ValidateData()
	{
		global $DB;
		
		$SQL = "SELECT * FROM User WHERE UserName='".$_POST['username']."' AND Password = '".md5($_POST['password'])."' AND IsAdmin='1'";	
		$row = $DB->fetchOne($SQL);

		if($row->UserID > 0)
		{
			if($row->Status == 0)
				$this->row = $row;
			else
				$_SESSION['login_error'] = "inactive_login";
		}
		else
		{
			$_SESSION['login_error'] = "incorrect_info";
		}
	}
	
	function setLoggedSession()
	{
		//$UserRole   = $this->getAccessRole();
		//$AccessType = $this->getAccessType();		

		$_SESSION['admin']['pm_user'] = $this->row->UserID;
		$_SESSION['admin']['pm_user_row'] = $this->row;
		//$_SESSION['admin']['pm_role'] = $UserRole;
		//$_SESSION['admin']['pm_access'] = $AccessType;
	}
	
	function logout()
	{
		global $objComm;
		
		foreach($_SESSION['admin'] as $key => $value)
		{
			$_SESSION['admin'][$key] = '';
			unset($_SESSION['admin'][$key]);
		}
		
		$_SESSION['login_success']	= 'logged_out';

		$objComm->redirect('index.php?model=login');
		exit();		
	}

}

?>