<?php 

include_once(CONTROLLERS."/".$_REQUEST['model'].".php"); 
$msg = $objComm->getSessionMessage('verification');

$arrDateName = array('date_year','date_month','date_date');
$arrDateID = array('date_year','date_month','date_date');
$arrDateVal = '';

?>

<div class="row-fluid sortable">
  <div class="box span12">
    <div class="box-header well" data-original-title>
      <h2><i class="icon-user"></i> <?=$lang['Verify Details']?></h2>
      <div class="box-icon"></div>
    </div>
    <div class="box-content">
      <div class="box-content">
	      <?=$msg?>
        <form class="form-horizontal" method="post" action="verify.php">
        <input type="hidden" name="action" id="action" value="VERIFIED" />
         <input type="hidden" name="code" id="code" value="<?=$_REQUEST['code']?>" />
        <input type="hidden" name="model" id="model" value="<?=$_REQUEST['model']?>" />
          <fieldset>
            <div class="control-group">
              <label class="control-label" for="data_fname"><?=$lang['First Name']?></label>
              <div class="controls">
                <input type="text" required value="<?=$row->fname?>" id="data_fname" name="data_fname" class="input-xsmall focused">
              </div>
            </div>
			<div class="control-group">
              <label class="control-label" for="data_fname"><?=$lang['Last Name']?></label>
              <div class="controls">
                <input type="text" required value="<?=$row->lname?>" id="data_lname" name="data_lname" class="input-xsmall focused">
              </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="name"><?=$lang['Birth Date']?></label>
              <div class="controls">
	              <?=$objHTML->basicDateCombo($arrDateName, $arrDateID, $arrDateVal);?>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="data_contact_no"><?=$lang['Contact No']?></label>
              <div class="controls">
                <input type="number" required value="<?=$row->contact_no?>" id="data_contact_no" name="data_contact_no" class="input-xsmall focused" data-validation-number-message="Contact number should be in numeric">
              </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="data_email_address"><?=$lang['Email']?></label>
              <div class="controls">
              <div class="input-prepend">
				 <span class="add-on"><i class="icon-envelope"></i></span>
                  <input type="email" required  value="<?=$row->email_address?>" id="data_email_address" name="data_email_address" class="input-xsmall focused" data-validation-email-message="Please enter valid Emal Address"></div></div>
            </div>
            <div class="form-actions">
              <button type="submit" class="btn btn-primary"><?=$lang['Verify Details']?></button>
              <button type="reset" class="btn"><?=$lang['Cancel']?></button>
            </div>
          </fieldset>
        </form>
      </div>
    </div>
  </div>
</div>