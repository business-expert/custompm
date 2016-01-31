<?php


class html extends common
{
	function __construct() 
	{
		
	}
	
	function statusBasicCombo($id,$selVal, $extra ='')
	{
		global $lang; 
		
		$arrStatus = $this->getAllUserStatus();

		$select = "<select id='".$id."' name='".$id."' required $extra>";	
		$arrOption[] = "<option value=''> -- ".$lang['SELECT']." -- </option>";

		foreach($arrStatus as $key => $value)
		{
			$selected = (strtoupper($selVal) == strtoupper($key)) ? "selected='selected'" : "" ;		
			$arrOption[] = "<option value='".$key."' ".$selected.">".$value."</option>";	
		}
		
		return $select.implode(" ", $arrOption)."</select>";
		
	}
	
	
	function genderBasicCombo($id,$selVal)
	{
		global $lang; 
		
		$arrGender = array("Male" => "M", "Female" => "F");

		$select = "<select required style='width:100px;' id='".$id."' name='".$id."' data-validation-required-message='Please select gender'>";	
		$arrOption[] = "<option value=''> ".$lang['SELECT']." </option>";

		foreach($arrGender as $key => $value)
		{
			$selected = (strtoupper($selVal) == strtoupper($value)) ? "selected='selected'" : "" ;		
			$arrOption[] = "<option value='".$value."' ".$selected.">".$lang[$key]."</option>";	
		}
		
		return $select.implode(" ", $arrOption)."</select>";
		
	}
	
	function categoryBasicCombo($id,$selVal)
	{
		global $lang; 
		
		$arrStatus = $this->getAllCategory();

		$select = "<select id='".$id."' name='".$id."'>";	
		$arrOption[] = "<option value=''> -- ".$lang['SELECT']." -- </option>";

		foreach($arrStatus as $key => $value)
		{
			$selected = (strtoupper($selVal) == strtoupper($key)) ? "selected='selected'" : "" ;		
			$arrOption[] = "<option value='".$key."' ".$selected.">".$lang[$key]."</option>";	
		}
		
		return $select.implode(" ", $arrOption)."</select>";
		
	}
	
	function searchAgeCombo($id,$selVal)
	{
		$arrComparison = array("<=", ">=");

		$select = "<select  style='width:50px;' id='".$id."' name='".$id."'>";	

		foreach($arrComparison as $key => $value)
		{
			$selected = (strtoupper($selVal) == strtoupper($value)) ? "selected='selected'" : "" ;		
			$arrOption[] = "<option value='".$value."' ".$selected.">".$value."</option>";	
		}
		
		return $select.implode(" ", $arrOption)."</select>";
	}
	
	
	function basicDateCombo($arrName, $arrID, $arrVal)
	{
		global $lang;
		
		if($arrID == '')
			$arrID = $arrName;
			
		if(!is_array($arrVal))
			$arrVal = explode("-",$arrVal);
			
		$selYear = "<select  style='width:70px;' id='".$arrID[0]."' name='".$arrName[0]."'>";
		
		for($i = date('Y'); $i > 1940; $i--)
		{
			$selected = ($arrVal[0] == $i) ? "selected='selected'" : "" ;		
			$arrYearOption[] = "<option value='".$i."' ".$selected.">".$i."</option>";	
		}	
		
		$Year = $selYear.implode(" ", $arrYearOption)."</select>";
		
		#-------------------------------------------------------------------------------------------#
		
		$arrMonth = array( 1 => "January", 2 => "February", 3 => "March", 4 => "April",  5 => "May", 
						   6 => "June", 7 => "July", 8 => "August", 9 => "September", 10 => "October", 11 => "November",12 =>  "December");

		$selMonth = "<select  style='width:100px;' id='".$arrID[1]."' name='".$arrName[1]."'>";
		
		foreach($arrMonth as $key => $value)
		{
			$selected = ((int)$arrVal[1] == $key) ? "selected='selected'" : "" ;		
			$arrMonthOption[] = "<option value='".$key."' ".$selected.">".$lang[$value]."</option>";	
		}	
		
		
		$Month = $selMonth.implode(" ", $arrMonthOption)."</select>";
		
		#-------------------------------------------------------------------------------------------#
		
		$selDate = "<select  style='width:50px;' id='".$arrID[2]."' name='".$arrName[2]."'>";
		
		for($i = 1; $i <= 31; $i++)
		{
			$selected = ($arrVal[2] == $i) ? "selected='selected'" : "" ;		
			$arrDateOption[] = "<option value='".$i."' ".$selected.">".$i."</option>";	
		}	
		
		$Date = $selDate.implode(" ", $arrDateOption)."</select>";
		
		return $Year."&nbsp;&nbsp;".$Month."&nbsp;&nbsp;".$Date;
	}
	
	function roleStatusBasicCombo($id,$selVal)
	{
		global $lang;
		
		$arrStatus = $this->getRoleStatus();

		$select = "<select id='".$id."' name='".$id."'>";	
		$arrOption[] = "<option value=''> --  ".$lang['SELECT']." -- </option>";

		foreach($arrStatus as $key => $value)
		{
			$selected = (strtoupper($selVal) == strtoupper($key)) ? "selected='selected'" : "" ;		
			$arrOption[] = "<option value='".strtolower($key)."' ".$selected.">".$lang[$key]."</option>";	
		}
		
		return $select.implode(" ", $arrOption)."</select>";
		
	}
	
	
	function marrigeCombo($id,$selVal)
	{
		global $lang;
		
		$arrStatus = $this->getMarrageStatus();

		$select = "<select id='".$id."' name='".$id."'>";	
		$arrOption[] = "<option value=''> -- ".$lang['SELECT']." -- </option>";

		foreach($arrStatus as $key => $value)
		{
			$selected = (strtoupper($selVal) == strtoupper($key)) ? "selected='selected'" : "" ;		
			$arrOption[] = "<option value='".$key."' ".$selected.">".$lang[$key]."</option>";	
		}
		
		return $select.implode(" ", $arrOption)."</select>";
	}
	
	function educationCombo($id,$selVal)
	{
		global $lang;
		
		$arrStatus = $this->getEducationLevel();

		$select = "<select id='".$id."' name='".$id."'>";	
		$arrOption[] = "<option value=''> -- ".$lang['SELECT']." -- </option>";

		foreach($arrStatus as $key => $value)
		{
			$selected = (strtoupper($selVal) == strtoupper($key)) ? "selected='selected'" : "" ;		
			$arrOption[] = "<option value='".$key."' ".$selected.">".$lang[$key]."</option>";	
		}
		
		return $select.implode(" ", $arrOption)."</select>";
	}
	
	function getWorkGroupCombo($id, $selVal, $extra)
	{
		global $objComm, $lang;
		
		$arrWorkGroup = $objComm->getAllWorkGroup();
		
		$select = "<select id='".$id."' name='".$id."' $extra>";	
		$arrOption[] = "<option value=''> -- ".$lang['SELECT']." -- </option>";

		foreach($arrWorkGroup as $key => $row)
		{
			$selected = ($selVal == $row->WorkgroupID) ? "selected='selected'" : "" ;		
			$arrOption[] = "<option value='".$row->WorkgroupID."' ".$selected.">".$row->WorkgroupName."</option>";	
		}
		
		return $select.implode(" ", $arrOption)."</select>";
		
	}
	
	function getUserRoleCombo($id, $selVal, $extra='')
	{
		global $objComm, $lang;
		
		$arrRole = $objComm->getAllUserRole();
		
		$select = "<select id='".$id."' name='".$id."' $extra>";	
		$arrOption[] = "<option value=''> -- ".$lang['SELECT']." -- </option>";

		foreach($arrRole as $key => $row)
		{
			$selected 	 = ($selVal == $row->RoleID) ? "selected='selected'" : "" ;		
			$arrOption[] = "<option value='".$row->RoleID."' ".$selected.">".$row->RoleName."</option>";	
		}
		
		return $select.implode(" ", $arrOption)."</select>";
		
	}
	
	function messageSubjectBox($id, $selVal, $extra)
	{
		global $objComm, $lang;
		
		$arrValue = $objComm->getAllSubjects();
		
		$select = "<select id='".$id."' name='".$id."' $extra>";	
		$arrOption[] = "<option value=''> -- ".$lang['SELECT']." -- </option>";

		foreach($arrValue as $key => $row)
		{
			$selected = ($selVal == $row->MessageSubjectID) ? "selected='selected'" : "" ;		
			$arrOption[] = "<option value='".$row->MessageSubjectID."' ".$selected.">".$row->SubjectName."</option>";	
		}
		
		return $select.implode(" ", $arrOption)."</select>";
	}
	
	
	function messageSubjectBox1($id, $selVal, $WorkgroupID = '', $extra)
	{
		global $objComm, $lang;
		
		$arrValue = $objComm->getAllSubjects($WorkgroupID);
		
		$select = "<select id='".$id."' name='".$id."' $extra>";	
		$arrOption[] = "<option value=''> -- ".$lang['SELECT']." -- </option>";

		foreach($arrValue as $key => $row)
		{
			$selected = ($selVal == $row->MessageSubjectID) ? "selected='selected'" : "" ;		
			$arrOption[] = "<option value='".$row->MessageSubjectID."' ".$selected.">".$row->SubjectName."</option>";	
		}
		
		return $select.implode(" ", $arrOption)."</select>";
	}
	
	
	function getUserCombo($id, $selVal, $extra)
	{
		global $objComm, $lang;
		
		$arrValue = $objComm->getAllUsers();
		
		$select = "<select id='".$id."' name='".$id."' $extra>";	
		$arrOption[] = "<option value=''> -- ".$lang['SELECT']." -- </option>";

		foreach($arrValue as $key => $row)
		{
			$selected = ($selVal == $row->UserID) ? "selected='selected'" : "" ;		
			$arrOption[] = "<option value='".$row->UserID."' ".$selected.">".$row->UserName."</option>";	
		}
		
		return $select.implode(" ", $arrOption)."</select>";
	}
	
	function radioBox($name, $id, $value, $text, $selValue, $extra)
	{
		$checked = (strtoupper($value) == strtoupper($selValue)) ? "checked='checked'" : "";
		
		$radio = '<label class="radio">
					<div class="radio" id="uniform-'.$name.'">
					  <span class="">
						<input type="radio" '.$checked.' value="'.$value.'" id="'.$id.'" name="'.$name.'" style="opacity: 0;" '.$extra.'>
					  </span>
				  </div>'.$text.'</label>';
	  
	   return $radio;
	}
	
	
	function DocumentComboBox()
	{
		
		
		
	}
	
	
}	
?>