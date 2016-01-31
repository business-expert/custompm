<?php
include_once(CONTROLLERS."/messageboard.php");
$msg = $objComm->getSessionMessage('messageboard');

?>

<div>
  <ul class="breadcrumb">
    <li><a href="#"><?=$lang['Manage']?></a> <span class="divider">/</span></li>
    <li><a href="index.php?model=messageboard"><?=$lang['Message Board']?></a><span class="divider">/</span></li>
    <li><a href="#"><?=$lang['Edit Message Subject']?></a></li>
  </ul>
</div>
<?=$msg?>
<div class="row-fluid sortable">
  <div class="box span12">
    <div class="box-header well" data-original-title>
      <h2><i class="icon-list-alt"></i> <?=$lang['Message Subject']?></h2>
    </div>
    <div class="box-content">
        <form class="form-horizontal" method="post" action="index.php">
        <input type="hidden" name="action" id="action" value="editsub" />
        <input type="hidden" name="model" id="model" value="<?=$_REQUEST['model']?>" />
        <input type="hidden" name="type" id="type" value="<?=$_REQUEST['type']?>" />        
        <input type="hidden" name="pk_id" id="pk_id" value="<?=$row->MessageSubjectID?>" />        

        <fieldset>
          <div class="control-group">
            <label class="control-label" for="typeahead"><?=$lang['Subject']?> </label>
            <div class="controls">
				<input type="text" class="input-xlarge focused" name="data_SubjectName" id="data_SubjectName" value="<?=$row->SubjectName?>" required>
            </div>
          </div>
        <?php  if($_REQUEST['type'] == 'int')  { ?>
              <div class="control-group">
                <label class="control-label" for="typeahead"><?=$lang['Work Group']?> </label>
                <div class="controls">
                 <?=$objHTML->getWorkGroupCombo('data_WorkgroupID',$row->WorkgroupID,'style="width:310px;"')?>
                </div>
              </div>
        <?php } ?>
          <div class="controls">
              <button class="btn btn-primary" type="submit" name='btn_submit' value='updatesub'><?=$lang['Save']?></button>
              <button class="btn" type="reset"><?=$lang['Cancel']?></button>
            </div>
        </fieldset>
      </form>
    </div>
  </div>
</div>
