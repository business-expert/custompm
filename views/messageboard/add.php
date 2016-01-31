<?php
include_once(CONTROLLERS."/messageboard.php");

?>

<div>
  <ul class="breadcrumb">
    <li><a href="#"><?=$lang['Manage']?></a> <span class="divider">/</span></li>
    <li><a href="index.php?model=messageboard"><?=$lang['Message Board']?></a><span class="divider">/</span></li>
    <li><a href="#"><?=$lang['Add Message']?></a></li>
  </ul>
</div>
<div class="row-fluid sortable">
  <div class="box span12">
    <div class="box-header well" data-original-title>
      <h2><i class="icon-list-alt"></i> <?=$lang['Message']?></h2>
    </div>
    <div class="box-content">
     <form class="form-horizontal" method="post" action="index.php">
       <input type="hidden" name="action" id="action" value="ADD" />
	   <input type="hidden" name="type" id="type" value="<?=$_REQUEST['type']?>" />         
       <input type="hidden" name="model" id="model" value="<?=$_REQUEST['model']?>" />
       <input type="hidden" name="pk_id" id="pk_id" value="<?=$_REQUEST['id']?>" />

        <fieldset>
          <div class="control-group">
            <label class="control-label" for="typeahead"><?=$lang['Subject']?> </label>
            <div class="controls">
             <?=$objHTML->messageSubjectBox1('data_SubjectID',$_REQUEST['subject_id'],$WorkGroupID,'style="width:310px;" required onchange="getWorkgroupIdBasedonSubject(this.value);"')?>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="date01"><?=$lang['Message Text']?></label>
            <div class="controls">
				<textarea class="" id="data_MessageText" name="data_MessageText" required rows="3" style="width:300px;"></textarea>
            </div>
          </div>
          
          <?php  if($_REQUEST['type'] == 'int')  { ?>
          <div class="control-group">
            <label class="control-label" for="typeahead"><?=$lang['Work Group']?> </label>
            <div class="controls">
             <?=$objHTML->getWorkGroupCombo('data_WorkgroupID','','style="width:310px;" disabled')?>
            </div>
          </div>
          <?php } ?>
          <div class="controls">
              <button class="btn btn-primary" type="submit" name='btn_submit' value='save'><?=$lang['Save']?></button>
               <a href='index.php?model=<?=$model?>&type=<?=$type?>'><button class="btn" type="button"><?=$lang['Cancel']?></button></a>
            </div>
        </fieldset>
      </form>
    </div>
  </div>
</div>

<script>


$( document ).ready(function() {
	getWorkgroupIdBasedonSubject(<?=$_REQUEST['subject_id']?>);
});


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
