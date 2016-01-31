<?php
include_once(CONTROLLERS."/messageboard.php");
$msg = $objComm->getSessionMessage('messageboard');


?>

<div>
  <ul class="breadcrumb">
    <li><a href="#"><?=$lang['Manage']?></a> <span class="divider">/</span></li>
    <li><a href="index.php?model=messageboard"><?=$lang['Message Board']?></a><span class="divider">/</span></li>
    <li><a href="#"><?=$lang['Edit Message']?></a></li>
  </ul>
</div>
<?=$msg?>
<div class="row-fluid sortable">
  <div class="box span12">
    <div class="box-header well" data-original-title>
      <h2><i class="icon-list-alt"></i> <?=$lang['Message']?></h2>
    </div>
    <div class="box-content">
        <form class="form-horizontal" method="post" action="index.php">
        <input type="hidden" name="action" id="action" value="edit" />
        <input type="hidden" name="model" id="model" value="<?=$_REQUEST['model']?>" />
        <input type="hidden" name="type" id="type" value="<?=$_REQUEST['type']?>" />        
        <input type="hidden" name="pk_id" id="pk_id" value="<?=$_REQUEST['id']?>" />

        <fieldset>
          <div class="control-group">
            <label class="control-label" for="data_SubjectID"><?=$lang['Subject']?> </label>
            <div class="controls">
             <?=$objHTML->messageSubjectBox1('data_SubjectID',$row->SubjectID,$WorkGroupID,'style="width:310px;" disabled onchange="getWorkgroupIdBasedonSubject(this.value);"')?>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="data_MessageText"><?=$lang['Message Text']?></label>
            <div class="controls">
			  <textarea class="" id="data_MessageText" name="data_MessageText" required rows="3" style="width:300px;"><?=$row->MessageText?></textarea>
            </div>
          </div>
           <?php  if($_REQUEST['type'] == 'int')  { ?>
          <div class="control-group">
            <label class="control-label" for="data_WorkgroupID"><?=$lang['Work Group']?></label>
            <div class="controls">
             <?=$objHTML->getWorkGroupCombo('data_WorkgroupID',$row->WorkgroupID,'style="width:310px;" disabled')?>
            </div>
          </div>
           <?php } ?>
          <div class="controls">
              <button class="btn btn-primary" type="submit" name='btn_submit' value='update'><?=$lang['Update']?></button>
              <a href='index.php?model=<?=$model?>&type=<?=$type?>'><button class="btn" type="button"><?=$lang['Cancel']?></button></a>
            </div>
        </fieldset>
      </form>
    </div>
  </div>
</div>

<script>

function getWorkgroupIdBasedonSubject(elmVal)
{
	var SubjectID = elmVal;
	
	if(SubjectID > 0)
	{
		$.ajax({
				type	: "GET",
				url		: "ajax.php",
				beforeSend: function () {
							 // $("#span_cycle").html("<div class='ajax_loaing'><img src='webroot/img/loading.gif' /></div>");
							},
				data    : "ajaxcall=true&mod=getSubjectWorkgroupID&subject_id="+SubjectID,
				success	: function(result)   {	$("#data_WorkgroupID").val(result);	  }
			   });	
	}	
}

</script>
