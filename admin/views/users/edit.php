<?php 
include_once(CONTROLLERS_ADMIN."/".$_REQUEST['model'].".php"); 

$msg = $objComm->getSessionMessage('User');

$checked1 = ($row->IsBoardMember == 'Y') ? 'class="checked"'   : '';
$checked2 = ($row->IsBoardMember == 'N') ? 'class="checked"'   : '';
$chek1    = ($row->IsBoardMember == 'Y') ? 'checked="checked"' : '';
$chek2    = ($row->IsBoardMember == 'N') ? 'checked="checked"' : '';

?>
<script src="<?=JS?>jquery.passstrength.min.js"></script>
<div>
    <ul class="breadcrumb">
        <li><a href="#"><?=$lang['Settings']?></a> <span class="divider">/</span></li>
        <li><a href="index.php?model=users"><?=$lang['Users']?></a><span class="divider">/</span></li>        
        <li><a href="#"><?=$lang['Edit User']?></a></li>
   </ul>
</div>
<div class="row-fluid sortable">
  <div class="box span12">
    <div class="box-header well" data-original-title>
      <h2><i class="icon-user"></i> <?=$lang['Edit User']?></h2>
      <div class="box-icon"></div>
    </div>
    <div class="box-content">
      <div class="box-content">
	      <?=$msg?>
        <form class="form-horizontal" method="post" action="index.php">
        <input type="hidden" name="action" id="action" value="edit" />
        <input type="hidden" name="model" id="model" value="<?=$_REQUEST['model']?>" />
        <input type="hidden" name="pk_id" id="pk_id" value="<?=$_REQUEST['id']?>" />
          <fieldset>
            <div class="control-group">
              <label class="control-label" for="data_userid"><?=$lang['UserName']?></label>
              <div class="controls">
                <input type="text" required value="<?=$row->UserName?>" id="data_UserName" name="data_UserName" class="input-xsmall focused">
              </div>
            </div>
			<div class="control-group">
              <label class="control-label" for="data_password"><?=$lang['Password']?></label>
              <div class="controls">
                <input type="password" required value="***********" id="data_Password" name="data_Password" class="input-xsmall focused" 
                onkeydown='$(".passStrengthify").show();'>&nbsp;&nbsp;&nbsp;&nbsp;
              </div>
            </div>
             <div class="control-group">
              <label class="control-label" for="data_gender"><?=$lang['Email']?></label>
              <div class="controls"><input type="email" required value="<?=$row->Email?>" id="data_Email" name="data_Email" class="input-xsmall focused"  data-validation-email-message="Please enter valid email address"></div>
            </div>
            
            <div class="control-group">
                    <label class="control-label">Board of Organization Member?</label>
                    <div class="controls">
                      <label class="radio">
                        <div class="radio" id="uniform-optionsRadios1">
                        	<span <?=$checked1?>>
                           	 <input type="radio" <?=$chek1?> value="Y" id="board_of_member_y" name="data_IsBoardMember" style="opacity: 0;">
                            </span>
                        </div> Yes
                      </label>&nbsp;&nbsp;&nbsp;
                      <label class="radio">
                        <div class="radio" id="uniform-optionsRadios1">
                        	<span <?=$checked2?>>
                           	 <input type="radio" <?=$chek2?> value="N" id="board_of_member_n" name="data_IsBoardMember" style="opacity: 0;">
                            </span>
                        </div> No
                      </label>
                      </div>
                  </div>
              <?php
			
            if($row->IsAdmin == 0)
            {
            	?>
                
           <div class="control-group">
              <label class="control-label" for="data_gender"><?=$lang['Work Group']?></label>
              <div class="controls"><?=$objHTML->getWorkGroupCombo('txt_workgroup',$row->WorkgroupID ,'required')?></div>
            </div>
            
            <div class="control-group">
              <label class="control-label" for="name"><?=$lang['Role']?></label>
              <div class="controls"><?=$objHTML->getUserRoleCombo('txt_user_role',$row->RoleID ,'required')?></div>
            </div>
             <?php } ?>
             <div class="control-group">
              <label class="control-label" for="name"><?=$lang['Status']?></label>
              <div class="controls"><?=$objHTML->statusBasicCombo('data_Status',$row->Status ,'required')?></div>
            </div>
            
            <div class="form-actions">
              <button type="submit" class="btn btn-primary" id="btn_submit" name="btn_submit" value="update"><?=$lang['Save Changes']?></button>
              <button type="reset" class="btn"><?=$lang['Cancel']?></button>
            </div>
          </fieldset>
        </form>
      </div>
    </div>
  </div>
  <!--/span--> 
  
</div>

<script language="javascript">

$(document).ready(function() {
	$('input[id=data_Password]').passStrengthify();
});


</script>