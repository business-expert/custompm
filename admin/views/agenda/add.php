<?php 
include_once(CONTROLLERS_ADMIN."/".$_REQUEST['model'].".php"); 

$msg = $objComm->getSessionMessage('agenda');

?>
<div>
   <ul class="breadcrumb">
        <li><a href="#"><?=$lang['Manage']?></a> <span class="divider">/</span></li>
        <li><a href="index.php?model=agenda"><?=$lang['Agenda']?></a><span class="divider">/</span></li>        
        <li><a href="#"><?=$lang['Add Agenda']?></a></li>
   </ul>
</div>
<div class="row-fluid sortable">
  <div class="box span12">
    <div class="box-header well" data-original-title>
      <h2><i class="icon-user"></i> <?=$lang['Agenda']?></h2>
      <div class="box-icon"></div>
    </div>
    <div class="box-content">
      <div class="box-content">
	    <?=$msg?>
        <form class="form-horizontal" method="post" action="index.php">
        <input type="hidden" name="action" id="action" value="SAVE" />
        <input type="hidden" name="model" id="model" value="<?=$_REQUEST['model']?>" />
          <fieldset>
            <div class="control-group">
              <label class="control-label" for="data_userid"><?=$lang['Topic']?></label>
              <div class="controls">
                <input type="text" required value="<?=$row->Topic?>" id="data_Topic" name="data_Topic" class="input-xsmall focused">
              </div>
            </div>

            <div class="control-group">
              <label class="control-label" for="data_userid"><?=$lang['Description']?></label>
              <div class="controls">
                <textarea required id="data_Description" name="data_Description" rows="3" style="width:350px;"><?=$row->Description?></textarea>
              </div>
            </div>
            
             <div class="control-group">
              <label class="control-label" for="name"><?=$lang['UserName']?></label>
              <div class="controls"><?=$objHTML->getUserCombo('data_UserID',$row->UserID,'')?></div>
            </div>

            <div class="controls">
              <button type="submit" class="btn btn-primary"><?=$lang['Save Changes']?></button>
              <button type="reset" class="btn"><?=$lang['Cancel']?></button>
            </div>
          </fieldset>
        </form>
      </div>
    </div>
  </div>
  <!--/span--> 
  
</div>