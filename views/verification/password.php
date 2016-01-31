<?php 
include_once(CONTROLLERS."/".$_REQUEST['model'].".php"); 

$msg = $objComm->getSessionMessage('verification');
?>
<script src="<?=JS?>jquery.passstrength.min.js"></script>
<div class="row-fluid sortable">
  <div class="box span12">
    <div class="box-header well" data-original-title>
      <h2><i class="icon-user"></i> <?=$lang['Create Member Password']?></h2>
      <div class="box-icon"></div>
    </div>
    <div class="box-content">
      <div class="box-content">
	    <?=$msg?>
        <form class="form-horizontal" method="post" action="verify.php">
        <input type="hidden" name="action" id="action" value="CREATE" />
        <input type="hidden" name="model" id="model" value="<?=$_REQUEST['model']?>" />
        <input type="hidden" name="code" id="code" value="<?=$_REQUEST['code']?>" />
          <fieldset>
            <div class="control-group">
              <label class="control-label" for="typeahead"><?=$lang['Name']?></label>
              <div class="controls"> <span class="input-xlarge uneditable-input">
                <?=$objVery->row->fname." ".$objVery->row->lname?>
                </span> </div>
            </div>
			 <div class="control-group">
              <label class="control-label" for="data_contact_no"><?=$lang['Username']?></label>
              <div class="controls">
                <input type="text" required value="" id="data_username" name="data_username" class="input-xsmall focused">
              </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="data_contact_no"><?=$lang['Password']?></label>
              <div class="controls">
                <input type="password" required value="" id="data_password" name="data_password" class="input-xsmall focused">
              </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="data_contact_no"><?=$lang['Confirm Password']?></label>
              <div class="controls">
                <input type="password" required value="" id="data_confirm_password" name="data_confirm_password" class="input-xsmall focused" data-validation-match-match="data_password" data-validation-match-message="confirm password shoulb be match">
              </div>
            </div>
            <div class="form-actions">
              <button type="submit" class="btn btn-primary"><?=$lang['Create Password']?></button>
            </div>
          </fieldset>
        </form>
      </div>
    </div>
  </div>
</div>

<script language="javascript">

$(document).ready(function() {
	$('input[id=data_password]').passStrengthify();
});

</script>