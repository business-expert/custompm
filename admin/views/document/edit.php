<?php
include_once(CONTROLLERS_ADMIN."/document.php");

$msg = $objComm->getSessionMessage('document');

$CheckFile    = ($row->IsFolder == 'N') ? "checked='checked'": "";
$CheckFolder  = ($row->IsFolder == 'Y') ? "checked='checked'": "";

if($row->IsFolder == 'Y')
	$DocumentName = ($row->ParentDocumentID == 0 ) ? 'Root Folder' : $row->DocumentName;
else	
{
	$NewRow = $objDoc->getDocument($row->ParentDocumentID);
	$DocumentName  = $NewRow->DocumentName; 
	
	$DocumentName = ($DocumentName == '') ? "Root Folder" : $DocumentName;
}
?>

<div>
  <ul class="breadcrumb">
    <li><a href="#"><?=$lang['Manage']?></a> <span class="divider">/</span></li>
    <li><a href="index.php?model=document"><?=$lang['Document']?></a><span class="divider">/</span></li>
    <li><a href="#"><?=$lang['Edit Document']?></a></li>
  </ul>
</div>
<span id="span_error"></span>
<?=$msg?>
<div class="row-fluid sortable">
  <div class="box span12">
    <div class="box-header well" data-original-title>
      <h2><i class="icon-list-alt"></i> <?=$lang['Document']?></h2>
    </div>
    <div class="box-content">
        <form class="form-horizontal" method="post" action="index.php" name="frmDoument" id="frmDoument" enctype="multipart/form-data">
        <input type="hidden" name="action" id="action" value="edit" />
        <input type="hidden" name="model" id="model" value="<?=$_REQUEST['model']?>" />
        <input type="hidden" name="pk_id" id="pk_id" value="<?=$_REQUEST['id']?>" />
		<input type="hidden" name="type" id="type" value="<?=$_REQUEST['type']?>" />        
        <input type="hidden" name="parent_id" id="parent_id" value="<?=$_REQUEST['parent_id']?>" />
        <fieldset>
          <div class="control-group">
            <label class="control-label" for="typeahead"><?=$lang['Parent Directory']?> </label>
            <div class="controls">
            
            <input required type="hidden" id="data_ParentDocumentID" name="data_ParentDocumentID" value="<?=$_REQUEST['parent_id']?>" class="input-xlarge focused">
             <span class="bfh-selectbox-option input-medium">&nbsp;&nbsp;
				<span class="icon icon-color icon-folder-open"></span> <?=$DocumentName?> </span>
            </div>
          </div>
          <div class="control-group" style="display:none;">
            <label class="control-label" for="date01"><?=$lang['Upload Type']?></label>
            <div class="controls">
				<?=$objHTML->radioBox('upload_type[]', 'upload_type_folder', 'folder', 'Folder', '', ' minchecked="1" data-validation-minchecked-message="Please select file type" '.$CheckFolder)?>
				<?=$objHTML->radioBox('upload_type[]', 'upload_type_file', 'file', 'File', '',$CheckFile)?>                
            </div>
          </div>
          <div class="control-group"  style="display:none;" id="div_folder">
            <label class="control-label" for="typeahead"><?=$lang['Folder Name']?> </label>
            <div class="controls">
				<input type="text" id="txt_foldername" name="txt_foldername" class="input-xlarge focused">
            </div>
          </div>
          <div class="control-group"  style="display:none;" id="div_file">
            <label class="control-label" for="typeahead"><?=$lang['Upload File']?> </label>
            <div class="controls">
				<div class="uploader" id="uniform-fileInput">
                	<input type="file" id="txt_filename" name="txt_filename" class="input-file uniform_on" size="19" style="opacity: 0;">
                    <span class="filename" style="-moz-user-select: none;"></span>
                    <span class="action" style="-moz-user-select: none;"><?=$lang['Choose File']?></span>
                    </div>
                   <span id='div_uplodede_file'><br />&nbsp;&nbsp;<?=$row->DocumentName?> </span>
            </div>
          </div>
           <?php if($type == 'int') { ?>
              <div class="control-group">
                <label class="control-label" for="typeahead"><?=$lang['Work Group']?> </label>
                <div class="controls">
                 <?=$objHTML->getWorkGroupCombo('data_WorkgroupID',$row->WorkgroupID,'style="width:280px;" ')?>
                </div>
              </div>
            <?php } ?>  
          <div class="controls">
              <button class="btn btn-primary" type="submit" name="btn_submit" value="update" onclick="return extraValidation();"><?=$lang['Save']?></button>
              <a href='index.php?model=<?=$model?>&type=<?=$type?>'><button class="btn" type="button"><?=$lang['Cancel']?></button></a>
            </div>
        </fieldset>
      </form>
    </div>
  </div>
</div>

<script>


$(function(){
	
	if('<?=$row->IsFolder?>' == 'Y')
	{
		$("#div_folder").show();
		$("#txt_foldername").val('<?=$row->DocumentName?>');
		$("#div_file").hide();
	}
	else
	{
		$("#div_folder").hide();
		$("#div_file").show();			
	}
	
	
    $("input:radio[name='upload_type[]']").click(function() {
   		if($(this).val() == 'folder'){
			$("#div_folder").show();
			$("#div_file").hide();
		}else{
			$("#div_folder").hide();
			$("#div_file").show();			
		}
	});
	
	$("#data_ParentDocumentID").val(<?=$_REQUEST['parent_id']?>);
	
	var Current = $(".bfh-selectbox-options UL>LI.folder").children("A[data-option='<?=$_REQUEST['parent_id']?>']").html();
	$("SPAN[data-current='folder']").html(Current);
	
	
	if(<?=$row->ParentDocumentID?> > 0)
		$("#data_WorkgroupID").attr("disabled",true);
});


function extraValidation()
{
	error = new Array();
	var flag = false;
	$("#span_error").html('');
	
	if($("input[name='upload_type[]']:checked").length == 0)
	{
		flag = true;
		error[error.length] = 'please select upload type';
	}
	
	var UploadType = $("input[name='upload_type[]']:checked").val();
	
	if(UploadType == 'folder')
	{
		if($("#txt_foldername").val() == '')
		{
			flag = true;
			error[error.length] = 'please enter folder name';	
		}
	}
	else if(UploadType == 'file')
	{
		if($("#txt_filename").val() == '')
		{
			flag = true;
			error[error.length] = 'please select file to upload';	
		}	
	}
	
	
	if(flag == false)
	{
		$("#span_error").html('');
		return true;		
	}
	else
	{
		$("#span_error").html('<div class="alert alert-error">'+error.join('<br>')+'</div>');		
		return false;			
	}
}


function setWorkGroupID(DocID)
{
	if(DocID > 0)
	{
		$.ajax({
			type	: "GET",
			url		: "ajax.php",
			data    : "ajaxcall=true&mod=getDocumentWorkGroup&DocID="+DocID,
			success	: function(result)   {
						if(result > 0)
							$("#data_WorkgroupID").attr("disabled",true).val(result);
					  }
		   });	
	}
	else
	{
		var WorkGroupID = $("#data_WorkgroupID").val();
		
		if(WorkGroupID != '')
			$("#data_WorkgroupID").attr("disabled",false).val(WorkGroupID);
		else	
			$("#data_WorkgroupID").attr("disabled",false).val('');
	}
}



</script>
