<?php

class common
{
	function __construct() 
	{
		
	}
	
	function getMarrageStatus()
	{
		$arrMarrage = array(
							'Single' 	=> 'Single', 
							'Married' 	=> 'Married',
							'Widowed' 	=> 'Widowed'
				  		  );
		
		return $arrMarrage;
	}


	function getEducationLevel()
	{
		$arrEducation = array(
								'Graduate' 	=> 'Graduate', 
								'Post Graduate' => 'Post Graduate',
								'Other' => 'Other'
				  		  );
		
		return $arrEducation;
	}
	
	
	function getRoleStatus()
	{
		$arrStatus = array(
							'Active' 	=> 'label-success', 
							'Inactive' 	=> 'label-warning',
							'Block' 	=> 'label-inverse'
				  		  );
		
		return $arrStatus;
	}
	
	function getDefaultAccessModels()
	{
		$arrModel = array("dashboard","login");
		
		return $arrModel;
	}
	
	function getAllUserStatusBlock()
	{
		$arrStatus = array(	'0' => 'label-success', 
							'1' => 'label-warning' );
		
		return $arrStatus;
	}
	
	function getAllUserStatus()
	{
		$arrStatus = array(	'0' 	=> 'actief', 
							'1' 	=> 'inactief' );
		
		return $arrStatus;
	}
	
	function getAllCategory()
	{
		$arrCategory = array(
							'Art' 		=> 'Art', 
							'Music' 	=> 'Music',
							'Language' 	=> 'Language',
							'Sports' 	=> 'Sports',
				  		  );
		
		return $arrCategory;
	}
	
	function GenderList()
	{
		$arrGender = array('M' => 'Male', 'F' => 'Female');
		
		return $arrGender;
	}
	
	function fileUploadError()
	{
		$arrUploadError = array(1 => "The uploaded file exceeds the upload_max_filesize directive in php.ini",
								2 => "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form",
								3 => "The uploaded file was only partially uploaded",
								4 => "No file was uploaded",
								6 => "Missing a temporary folder"); 

		return $arrUploadError;
	}
	
	function setTableField()
	{
		$arrInputData	=	$_REQUEST;	

		foreach($arrInputData as $key => $value)
		{
			if(substr($key,0,5) == 'data_')
			{
				$key =	substr($key,5);
				$arrField[$key] = $value;
			}	
		}
		
		return $arrField;
	}
	
	
	function redirect($URL)
	{
		$SitePath = SITE_PATH_ADMIN; 

		if (!headers_sent()) 
		{
			header("Location: ".$SitePath."/".$URL);
			exit();
		}
		else 
		{
	        echo '<script type="text/javascript">';
	        echo 'window.location.href="'.$SitePath."/".$URL.'";';
	        echo '</script>';
			die();
		 }
	}
	
	function redirect1($URL)
	{
		$SitePath = SITE_PATH ; 

		if (!headers_sent()) 
		{
			header("Location: ".$SitePath."/".$URL);
			exit();
		}
		else 
		{
	        echo '<script type="text/javascript">';
	        echo 'window.location.href="'.$SitePath."/".$URL.'";';
	        echo '</script>';
			die();
		 }
	}
	
	function getSessionMessage($name)
	{
		$arrMsg = array(	'error' 	=> $name."_error",
							'success' 	=> $name."_success",
							'info' 		=> $name."_info",
							'block' 	=> $name."_block ");
							
		foreach($arrMsg as $key => $value)
		{
			if($_SESSION[$value] != '')
			{
				$messageType = $key;
				break;	
			}
		}

		$msg = $this->getSession($value);
		return $this->getMessage($messageType, $name, $msg);
	}
	
	
	function setSession($session_name,$value)
	{
		$_SESSION[$session_name] = $value;
	}
	

	function getSession($session_name)
	{
		$value = $_SESSION[$session_name];
		
		return $value;
	}
	
	function getMessage($errtype='info', $name, $msg)
	{
		global $lang;
		
		$message = '';
		$arrMsg = array(	'error' 	=> 'alert-error',
							'success' 	=> 'alert-success',
							'info' 		=> 'alert-info',
							'block'		=> 'alert-block');
		
		if($msg != '')
		{
			if($lang[$msg] == '')
				$lang[$msg] = $msg;
				
			$message = '<div class="alert '.$arrMsg[$errtype].'">'.$lang[$msg].'</div>';
		}

		$_SESSION[$name."_".$errtype] = '';
		unset($_SESSION[$name."_".$errtype]);
		
		return $message;
	}
	
	function getYearFromCombo($arrData, $Prefix = 'date_', $suffix = '')
	{
		$Year = $arrData[$Prefix.'year'.$suffix];
		$Month = $arrData[$Prefix.'month'.$suffix];
		$Date = $arrData[$Prefix.'date'.$suffix];
		
		return $Year."-".$Month."-".$Date;
	}
	
	
	function getUserRole($id)
	{
		global $DB;
		
		$SQL = "SELECT * FROM Role where RoleID='$id'";	
		$row = $DB->fetchOne($SQL);
		
		return $row;
	}
	
	function getWorkGroup($id)
	{
		global $DB;
		
		$SQL = "SELECT * FROM Workgroup where WorkgroupID='$id'";	
		$row = $DB->fetchOne($SQL);
		
		return $row;
	}
	
	function getModuleProperty($id)
	{
		global $DB;
		
		$SQL = "SELECT * FROM module_access_property WHERE id='".$id."'";	
		$row = $DB->fetchOne($SQL);
		
		$arrRow = array($row->access_1, $row->access_2, $row->access_3, $row->access_4, $row->access_5,$row->access_6);
		
		return $arrRow;
	}
	
	function getModulePropertyDetails($modulename)
	{
		global $DB;
		
		$modulename = ucfirst(strtolower($modulename));
		
		$SQL = "SELECT * FROM module_access_property WHERE module_name='".$modulename."'";
		$row = $DB->fetchOne($SQL);
		
		return $row;
	}
	
	function checkAccessModule($model, $action)
	{
		$arrDefaultModel = $this->getDefaultAccessModels();
		
		$action = ($action == '') ? 'list' : strtolower($action) ;
		
		$_SESSION['ai_access'] = 'N';	

		if($_SESSION['admin']['ai_role']->id > 0)
		{
			$arrModule = $_SESSION['admin']['ai_access'][strtolower($model)];
			
			if(!in_array($model,$arrDefaultModel))
			{
				if(in_array($action, $arrModule))
					$_SESSION['ai_access'] = 'Y';	
				else
					$_SESSION['ai_access'] = 'N';	
			}
			else
				$_SESSION['ai_access'] = 'Y';	
		}
		
		if($model == '')
			$_SESSION['ai_access'] = 'Y';	
		
		# for admin user
		if($_SESSION['admin']['ai_role']->id == 1)
			$_SESSION['ai_access'] = 'Y';	

	}
	
	function redirectFromUnauthorizePage()
	{

		if($_SESSION['ai_access'] == 'N' && $_SESSION['admin']['ai_role']->id > 0)
		{
			 include_once(VIEWS. "/error/denied.php");
		}
	}
	
	function generateRandomString($length = 10) 
	{
    	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $randomString = '';
		
	    for ($i = 0; $i < $length; $i++) 
		{
        	$randomString .= $characters[rand(0, strlen($characters) - 1)];
	    }
    	
		return $randomString;
	}	
	
	function getAllWorkGroup()
	{
		global $DB;
		
		$SQL = "SELECT * FROM Workgroup";
		$row = $DB->fetchAll($SQL);
		
		return $row;
	}
	
	function getAllUserRole()
	{
		global $DB;
		
		$SQL = "SELECT * FROM Role";
		$row = $DB->fetchAll($SQL);
		
		return $row;
	}
	
	function getUser($id)
	{
		global $DB;
		
		$SQL = "SELECT * FROM User WHERE UserID='".$id."";
		$row = $DB->fetchOne($SQL);
		
		return $row;
	}
	
	function getAllUsers()
	{
		global $DB;
		
		$SQL = "SELECT * FROM User WHERE Status='0'";
		$row = $DB->fetchAll($SQL);
		
		return $row;
	}
	
	
	function getAllSubjects($WorkGroupID = '')
	{
		global $DB,$objComm;

		$SQL = "SELECT * FROM MessageSubject";
		
		if($WorkGroupID == 0 )
			$SQL .= " WHERE WorkgroupID = '".$WorkGroupID."'";		
		else if($WorkGroupID == '-1' )
			$SQL .= " WHERE WorkgroupID > '0'";
		else
			$SQL .= " WHERE WorkgroupID = '".$WorkGroupID."'";			
		
		$Records = $DB->fetchAll($SQL);
		
		return $Records;
	}
	
	
	function parseTree($tree, $root = null) 
	{
    	$return = array();
	    # Traverse the tree and search for direct children of the root
    	foreach($tree as $child => $parent) {
        	# A direct child is found
	        if($parent == $root) {
    	        # Remove item from tree (we don't need to traverse this again)
        	    unset($tree[$child]);
            	# Append the child into result array and parse its children
	            $return[] = array('DocumentID' => $child,'children' => $this->parseTree($tree, $child)
            	);
	        }
    	}
	    return empty($return) ? null : $return;    
	}
	
	
	function getAllDocument($ID, $WorkGroupID = '')
	{
		global $DB;
		
		if($WorkGroupID == '-1')
			$arrWhere[] = "`WorkgroupID` > '0'";
		else if($WorkGroupID != '')
			$arrWhere[] = "`WorkgroupID` = '".$WorkGroupID."'";	
		
		$SQL = "SELECT * FROM Documents";	
		
		if(count($arrWhere) > 0)
			$Where = " WHERE ".implode(" AND ", $arrWhere); 
		
		if($Where != '')	
			$SQL .=  $Where;
	
		$Records = $DB->fetchAll($SQL);
		
		foreach($Records as $key => $row)
			$arrRow[$row->DocumentID] = $row;

		return $this->makeHierarchy($ID,$arrRow);
	}
	
	function makeHierarchy_Old($ID,$arrRow)
	{
		global $objComm;
		
		foreach($arrRow as $key => $row)
			$arrTree[$row->DocumentID] = $row->ParentDocumentID;

		//$rr = $this->parseTree($arrTree,0);
		
		$this->strTree = '<div class="bfh-selectbox">
				            <input type="hidden" name="'.$ID.'" id="'.$ID.'" value="0" onchange="javascript:setWorkGroupID(this.value);" required data-validation-required-message="Please select Parent Document">
					          <a class="bfh-selectbox-toggle" role="button" data-toggle="bfh-selectbox" href="#" >
								<span class="bfh-selectbox-option input-medium" data-option="" data-current="folder"></span> 
								<b class="caret"></b> 
							  </a>
				           <div class="bfh-selectbox-options" style="width:450px;">
				            <div role="listbox">';
							  
				              /*  <ul role="option" id="browser_gen" class="filetree treeview">
								<li class="folder">
								  <a tabindex="-1" href="#" data-option="0">
									<span class="icon icon-color icon-folder-open"></span> Root Folder
								  </a>
								</li>';*/
		
		$this->documentComboBox(0,$arrTree,$arrRow, 0);
		
		//$this->strTree .= "</ul> </div> </div> </div>";
		$this->strTree .= "</div> </div> </div>";
		
		return $this->strTree;
	}




	function makeHierarchy($ID,$arrRow)
	{
		global $objComm;
		
		foreach($arrRow as $key => $row)
			$arrTree[$row->DocumentID] = $row->ParentDocumentID;
		
		$this->strTree = '<div class="bfh-selectbox">
				            <input type="hidden" name="'.$ID.'" id="'.$ID.'" value="0" onchange="javascript:setWorkGroupID(this.value);" required data-validation-required-message="Please select Parent Document">
					          <a class="bfh-selectbox-toggle" role="button" data-toggle="bfh-selectbox" href="#" >
								<span class="bfh-selectbox-option input-medium" data-option="" data-current="folder"></span> 
								<b class="caret"></b> 
							  </a>
							  <div class="bfh-selectbox-options" style="width:450px;">
							  <div class="treeview" role="listbox">
							  	<ul id="browser" class="filetree">
									<li><a tabindex="-1" href="#" data-option="0" onclick="setFolder(this);"><span class="folder">Root Folder</span></a>';
							  
		$this->documentComboBox(0,$arrTree,$arrRow, true);
		
		$this->strTree .= "</li></ul></div></div></div>";
		
		return $this->strTree;
	}
	
	function documentComboBox($root, $tree, $arrRow, $IsFirst) 
	{
    	$return = array();
		
	    if(!is_null($tree) && count($tree) > 0) 
		{
       		$this->strTree .= '<ul>';
			
        	foreach($tree as $child => $parent) 
			{
            	if($parent == $root) 
				{
                	unset($tree[$child]);
					
					$DocID = $arrRow[$child]->DocumentID;
					$DocName = $arrRow[$child]->DocumentName;
					$IsFolder = $arrRow[$child]->IsFolder;
					$DocParentID = $arrRow[$child]->ParentDocumentID;

					if($IsFolder == 'Y')
		                $this->strTree .= '<li><a tabindex="-1" href="#" data-option="'.$DocID.'" onclick="setFolder(this);">
											<span class="folder">'.$DocName.'</span></a>';
					else	
		                $this->strTree .= '<li><span class="file">'.$DocName.'</span></li>';
											
    	            $this->documentComboBox($child, $tree, $arrRow, false);
        	        $this->strTree .= '</li>';
            	}
	        }
    	    $this->strTree .=  '</ul>';
	    }
	}


	function documentComboBox_Old($root, $tree, $arrRow, $cnt) 
	{
		$strDash = '';
		$return  = array();

		/*for($i = 0; $i < $cnt; $i++)
			$strDash .= '&nbsp;&nbsp;';
		*/
		
	    if(!is_null($tree) && count($tree) > 0) 
		{
			$cnt++;
			
			$this->strTree .= ($IsFirst == true) ? '<ul id="browser" class="filetree">' : '<ul>';
			
        	foreach($tree as $child => $parent) 
			{
            	if($parent == $root) 
				{
                	unset($tree[$child]);
					
					$DocID 		= $arrRow[$child]->DocumentID;
					$DocName 	= $arrRow[$child]->DocumentName;
					$IsFolder	= $arrRow[$child]->IsFolder;
					$DocParentID= $arrRow[$child]->ParentDocumentID;
					
					if($IsFolder == 'Y')
		                $this->strTree .= '<li class="folder" style="width:300px;">
											  <a tabindex="-1" href="#" data-option="'.$DocID.'">'.$strDash.'
												<span class="icon icon-color icon-folder-open" ></span> '.$DocName.'
											  </a>';
					else	
		                $this->strTree .= '<li class="file" style="width:300px;">'.$strDash.'
											<span class="icon icon-color icon-page"></span> '.$DocName.'</li>';
																
    	            $this->documentComboBox($child, $tree, $arrRow, $cnt);
					$this->strTree .= '</li>';
            	}
	        }
			
			$this->strTree .=  '</ul>';
	    }
	}
	
	
	function uploadfile($destination, $files)
	{
		global $objLog;
		
		$msg = '';
		
		$destination1   = $destination;
		$arrUploadError = $this->fileUploadError();
		
		$arrRestrictType = explode(",",RESTRICT_UPLOAD_FILE);
		
		$filename    = $files['name'];
		$filesize    = $files['size'];
		$destination = UPLOAD_PATH.$destination;
		
		$objLog->writeLog(__LINE__, __FILE__, 'Upload File Details: FileName :'.$filename.' Destination:'.$destination, 'Upload Common');
		
		chmod($destination, 0777);
		exec("chmod 0777 -R ".$destination."/");

		if($filename != '' && $filesize > 0)
		{
			if(!in_array($files['type'],$arrRestrictType))
			{
				if(file_exists(DOCUMENT_ROOT/$filename))
				{
					$filename = substr(time(),0,2).$filename;
					$objLog->writeLog(__LINE__, __FILE__, 'Upload File Details: File Exists New FileName :'.$filename.' Destination:'.$destination, 'Upload Common');
					
				}
				
				chmod($destination, 077);
				exec("chmod 0777 ".$destination."/ -R");
				
				if(is_writable($destination))
				{
					if(move_uploaded_file($files['tmp_name'], $destination."/".$filename))
					{
						$objLog->writeLog(__LINE__, __FILE__, 'Upload File Details: File Uploded at:'.$destination1."/".$filename, 'Upload Common');
						$msg = '';
						exec("chmod 0777 ".$destination."/".$filename);
					}
					else
					{
						$msg = 'File Upload Failed';	
					}
				}
				else
				{
					$msg = 'Upload Folder is not writable';	
				}
			}
			else
			{
				$msg = 'File extention is restrict to upload file';
			}
		}
		else
		{
			$msg = $arrUploadError[$files['error']];
		}
		
		$objLog->writeLog(__LINE__, __FILE__, 'Upload File Details: File Permission Changed ', 'Upload Common');
		
		chmod($destination1."/".$filename, 0777);
		exec("chmod 0777 ".$destination1."/".$filename." -R");
		
		return array("filename" => $filename, "filepath" => $destination1."/".$filename, "error" => $msg);
	}
	
	
	function createDirectory($destination)
	{
		$destination = UPLOAD_PATH."/".$destination;
		
		mkdir($destination, 0777);
		exec("chmod 0777 ".$destination);
	}
	
	
	function recursiveDirectoryDelete($dir) 
	{ 
		exec("chmod 0777 -r ".$dir);
		
		if (is_dir($dir)) 
		{
			$objects = scandir($dir); 
		
			foreach ($objects as $object) 
			{ 
				if ($object != "." && $object != "..") 
				{ 
					if (filetype($dir."/".$object) == "dir") 
						recursiveDirectoryDelete($dir."/".$object); 
					else
					{ 
						chmod($dir."/".$object, 0777);
						exec("chmod 0777 ".$dir."/".$object);
						unlink($dir."/".$object); 
					}
				} 
			} 
		
			reset($objects); 
			rmdir($dir); 
			exec("rm -f ".$dir);
		} 
	 }
	 
	 
	function getRole($type='')
	{
		if($type == 'gen')
		{
			$Role = $_SESSION['site']['pm_row']->IsBoardMember;
			$RoleType = ($Role == 'Y') ? 'Write' : 'Read'; 
		}
		else
		{	
			$Role = $_SESSION['site']['pm_row']->RoleID;
			$RoleType = ($Role == 2) ? 'Write' : 'Read'; 
		}
		
		return $RoleType;
	 }
	 
	 
	function checkSiteSession()
	{
		if($_SESSION['site']['pm_user'] == '')
		{
			$this->redirect1('index.php');
		}
		else
		{
			if($_SESSION['site']['pm_row']->UserID == '' || $_SESSION['site']['pm_row']->WorkgroupID == '')
			{
				$this->redirect1('index.php');
			}
		}
	}
	
	
	function checkReadWriteAccess($type, $CreatedBy = '')
	{
		if($CreatedBy == $_SESSION['site']['pm_row']->UserID){
			return '';
		}
		
		$arrParam = array(	'model' => $_REQUEST['model'],
							'type' => $_REQUEST['type']);
		
		$RoleType = $this->getRole($type);
		
		$arrWriteAction = array('ADD','UPDATE','EDIT','DELETE','DELMSG','DELSUB','ADDSUB','EDITSUB');
		
		if($RoleType == 'Read')
		{
			if(in_array(strtoupper($_REQUEST['action']),$arrWriteAction))
			{
				$_SESSION[$arrParam['model'].'_error'] = "permission_denied";	
				
				foreach($arrParam as $key => $value)
				{
					if($value != '')
						$arrParamQuery[] = $key.'='.$value;
				}
				
				$this->redirect1('index.php?'.implode("&",$arrParamQuery));
			}
		}
	}
	
	
	function downloadFile($DocumentName, $DocumentPath)
	{
		$DocumentPath = UPLOAD_PATH.$DocumentPath;
		$DocumentName = str_replace(" ","_",$DocumentName);
		
		$FileMimeType = array( "pdf" => "application/pdf",
							   "txt" => "text/plain",
							   "html" => "text/html",
							   "htm" => "text/html",
							   "exe" => "application/octet-stream",
							   "zip" => "application/zip",
							   "doc" => "application/msword",
							   "xls" => "application/vnd.ms-excel",
							   "csv" => "text/csv",
							   "ppt" => "application/vnd.ms-powerpoint",
							   "gif" => "image/gif",
							   "png" => "image/png",
							   "jpeg"=> "image/jpg",
							   "jpg" =>  "image/jpg",
							   "php" => "text/plain"
							  );
		
	    $FileExt = strtolower(substr(strrchr($DocumentPath,"."),1));
		
	    $MimeType = (array_key_exists($FileExt, $FileMimeType)) ? $FileMimeType[$FileExt] : "application/force-download";
		
		//turn off output buffering to decrease cpu usage
		@ob_end_clean();
		
		// required for IE Only
		if(ini_get('zlib.output_compression'))
		ini_set('zlib.output_compression', 'Off');
			
		if (file_exists($DocumentPath)) 
		{
			header('Content-Description: File Transfer');
			header('Content-Type: '.$MimeType);
			header('Content-Disposition: attachment; filename='.$DocumentName);
			header('Content-Transfer-Encoding: binary');
			header('Expires: 0');
			header('Cache-Control: must-revalidate');
			header('Pragma: public');
			header('Content-Length: ' . filesize($DocumentPath));
			ob_clean();
			flush();
			readfile($DocumentPath);
			exit;
		}	
	}
}

?>