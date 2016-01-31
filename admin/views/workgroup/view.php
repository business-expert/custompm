<?php 
include_once(CONTROLLERS_ADMIN."/".$_REQUEST['model'].".php"); 

$msg = $objComm->getSessionMessage('workgroup');

?>
<div>
   <ul class="breadcrumb">
        <li><a href="#"><?=$lang['Settings']?></a> <span class="divider">/</span></li>
        <li><a href="index.php?model=usersrole"><?=$lang['Work Group']?></a><span class="divider">/</span></li>        
        <li><a href="#"><?=$lang['View Work Group']?></a></li>
   </ul>
</div>
<div class="row-fluid sortable">
  <div class="box span12">
    <div class="box-header well" data-original-title>
      <h2><i class="icon-user"></i> <?=$lang['View Work Group']?></h2>
      <div class="box-icon"></div>
    </div>
    <div class="box-content">
      <div class="box-content">
	      <?=$msg?>
        <form class="form-horizontal" method="post" action="index.php">
        <input type="hidden" name="action" id="action" value="SAVE" />
        <input type="hidden" name="model" id="model" value="<?=$_REQUEST['model']?>" />
        <input type="hidden" name="pk_id" id="pk_id" value="<?=$_REQUEST['id']?>" />
          <fieldset>
            <div class="control-group">
              <label class="control-label" for="data_userid"><?=$lang['WorkGroupName']?></label>
              <div class="controls"><span class="input-xlarge uneditable-input"><?=$row->WorkgroupName?></span></div>
            </div>
            <div class="form-actions"> 
            	<a href="index.php?model=workgroup"><button type="button" class="btn btn-primary"><?=$lang['Back']?></button></a> 
                <a href="index.php?model=workgroup&action=edit&id=<?=$_REQUEST['id']?>"><button type="button" class="btn btn-success"><?=$lang['Edit']?></button></a>
                <a href="index.php?model=workgroup"><button type="button" class="btn"><?=$lang['Cancel']?></button></a> </div>
          </fieldset>
        </form>
      </div>
    </div>
  </div>
  <!--/span--> 
  
</div>