<?php 
include_once(CONTROLLERS_ADMIN."/".$_REQUEST['model'].".php"); 

$msg = $objComm->getSessionMessage('workgroup');

?>
<div>
   <ul class="breadcrumb">
        <li><a href="#"><?=$lang['Settings']?></a> <span class="divider">/</span></li>
        <li><a href="index.php?model=usersrole"><?=$lang['Work Group']?></a><span class="divider">/</span></li>        
        <li><a href="#"><?=$lang['Add Work Group']?></a></li>
   </ul>
</div>
<div class="row-fluid sortable">
  <div class="box span12">
    <div class="box-header well" data-original-title>
      <h2><i class="icon-user"></i> <?=$lang['Add Work Group']?></h2>
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
              <label class="control-label" for="data_userid"><?=$lang['WorkGroupName']?></label>
              <div class="controls">
                <input type="text" required value="<?=$row->WorkgroupName?>" id="data_WorkgroupName" name="data_WorkgroupName" class="input-xsmall focused">
              </div>
            </div>
            <div class="form-actions">
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