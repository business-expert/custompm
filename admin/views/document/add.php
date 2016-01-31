<?php
include_once(CONTROLLERS_ADMIN."/document.php");

$msg = $objComm->getSessionMessage('document');
$extraCond = ($_REQUEST['type'] == 'gen') ? 'style="width:310px;" disabled' : 'style="width:310px;" required';

?>

<link href='<?=CSS?>jquery.treeview.css' rel='stylesheet'>
<script src="<?=JS?>jquery.treeview.js"></script>

<div>
  <ul class="breadcrumb">
    <li><a href="#"><?=$lang['Manage']?></a> <span class="divider">/</span></li>
    <li><a href="index.php?model=document"><?=$lang['Document']?></a><span class="divider">/</span></li>
    <li><a href="#"><?=$lang['Add Document']?></a></li>
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
        <input type="hidden" name="action" id="action" value="ADD" />
        <input type="hidden" name="model" id="model" value="<?=$_REQUEST['model']?>" />
         <input type="hidden" name="type" id="type" value="<?=$_REQUEST['type']?>" />
        <input type="hidden" name="parent_id" id="parent_id" value="<?=$_REQUEST['parent_id']?>" />
        <fieldset>
          <div class="control-group">
            <label class="control-label" for="typeahead"><?=$lang['Directory']?> </label>
            <div class="controls"><?=$objComm->getAllDocument('data_ParentDocumentID', $WorkGroupID)?></div>
          </div>
          <div class="control-group">
            <label class="control-label" for="date01"><?=$lang['Upload Type']?></label>
            <div class="controls">
				<?=$objHTML->radioBox('upload_type[]', 'upload_type_folder', 'folder', 'Folder', '', ' minchecked="1" data-validation-minchecked-message="Please select file type"')?>
				<?=$objHTML->radioBox('upload_type[]', 'upload_type_file', 'file', 'File', '', '')?>                
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
                    <span class="action" style="-moz-user-select: none;"><?=$lang['Choose File']?></span></div>
            </div>
          </div>
          
           <?php if($type == 'int') { ?>
              <div class="control-group">
                <label class="control-label" for="typeahead"><?=$lang['Work Group']?> </label>
                <div class="controls">
                 <?=$objHTML->getWorkGroupCombo('data_WorkgroupID','',$extraCond)?>
                </div>
              </div>
           <?php } ?>
          <div class="controls">
              <button class="btn btn-primary" type="submit" name="btn_submit" value="save" onclick="return extraValidation();"><?=$lang['Save']?></button>
              <a href='index.php?model=<?=$model?>&type=<?=$type?>'><button class="btn" type="button"><?=$lang['Cancel']?></button></a>
            </div>
        </fieldset>
      </form>
    </div>
  </div>
</div>

<script>


$(function(){
	
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
	
	var Current = $(".bfh-selectbox-options UL>LI>a>span.folder").parents("A[data-option='<?=$_REQUEST['parent_id']?>']").html();

	$("SPAN[data-current='folder']").html('<span class="icon icon-color icon-folder-open" ></span>&nbsp;'+Current);
	
	setWorkGroupID(<?=$_REQUEST['parent_id']?>);
	
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



function setFolder(elm)
{
	var DocID   = $(elm).attr("data-option");
	var DocName = $(elm).children().html();
	
	$("#data_ParentDocumentID").val(DocID);
	$("SPAN[data-current='folder']").html('<span class="icon icon-color icon-folder-open" ></span>&nbsp;'+DocName);
	
	setWorkGroupID(DocID);
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
