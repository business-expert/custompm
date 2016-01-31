<?php 
include_once(CONTROLLERS."/".$_REQUEST['model'].".php"); 
$msg = $objComm->getSessionMessage('User');

$checked1 = ($row->IsBoardMember == 'Y') ? 'class="checked"'   : '';
$checked2 = ($row->IsBoardMember == 'N') ? 'class="checked"'   : '';
$chek1    = ($row->IsBoardMember == 'Y') ? 'checked="checked"' : '';
$chek2    = ($row->IsBoardMember == 'N') ? 'checked="checked"' : '';

?>
<script src="<?=JS?>jquery.passstrength.min.js"></script>
<div>
  <ul class="breadcrumb">
    <li><a href="#"><?=$lang['Profile']?></a></li>
  </ul>
</div>
<div class="row-fluid sortable">
  <div class="box span12">
    <div class="box-content">
      <div class="box-content">
        <?=$msg?>
        <span id="span_error"></span>
        <form class="form-horizontal" method="post" action="index.php">
        <input type="hidden" name="action" id="action" value="update" />
        <input type="hidden" name="model" id="model" value="<?=$_REQUEST['model']?>" />
          <fieldset>
          <div class="control-group">
            <label class="control-label"><?=$lang['UserName']?></label>
            <div class="controls">
              <span class="input-xlarge uneditable-input"  style="width:23%"><?=$row->UserName?></span>
            </div>
          </div>
          
            <div class="control-group">
              <label class="control-label" for="data_password"><?=$lang['Password']?></label>
              <div class="controls">
                <input type="password" value="" id="data_Password" name="data_Password" class="input-xsmall focused" 
                onkeydown='$(".passStrengthify").show();'>&nbsp;&nbsp;&nbsp;&nbsp;
              </div>
            </div>
            
             <div class="control-group">
              <label class="control-label" for="data_password"><?=$lang['retype_Password']?></label>
              <div class="controls">
                <input type="password" value="" id="retype_Password" name="retype_Password" class="input-xsmall focused" >
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
                     <input type="radio" <?=$chek1?> value="Y" disabled="disabled" id="board_of_member_y" name="IsBoardMember" style="opacity: 0;">
                    </span>
                </div> Yes
              </label>&nbsp;&nbsp;&nbsp;
              <label class="radio">
                <div class="radio" id="uniform-optionsRadios1">
                    <span <?=$checked2?>>
                     <input type="radio" <?=$chek2?> value="N" disabled="disabled" id="board_of_member_n" name="IsBoardMember" style="opacity: 0;">
                    </span>
                </div> No
              </label>
            </div>
         </div>
          
         <div class="control-group">
            <label class="control-label"><?=$lang['Work Group']?></label>
            <div class="controls">
              <span class="input-xlarge uneditable-input" style="width:23%"><?=$row->WorkgroupName?></span>
            </div>
          </div>
            
        <div class="control-group">
            <label class="control-label"><?=$lang['Role']?></label>
            <div class="controls">
              <span class="input-xlarge uneditable-input"  style="width:23%"><?=$row->RoleName?></span>
            </div>
          </div>
                              
            <div class="controls">
              <button type="submit" class="btn btn-primary" onclick="return submitForm();"><?=$lang['Save Changes']?></button>
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


function submitForm()
{
	var error = new Array();
	var flagErr = false;
	var pass = $("#data_Password").val();
	var passconfirm = $("#retype_Password").val();
	
	if(pass != '')
	{
		if(passconfirm == "")
		{
			flagErr = true;
			error[0] = "Please retype Password password";
		}
		else if(pass != passconfirm)
		{
			flagErr = true;			
			error[1] = "Please retype Password must be same";
		}
	}
	
	if(flagErr == false)
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


</script>
