<?php 
include_once(CONTROLLERS."/".$_REQUEST['model'].".php"); 

$msg = $objComm->getSessionMessage('agenda');

?>
<div>
   <ul class="breadcrumb">
        <li><a href="#"><?=$lang['Manage']?></a> <span class="divider">/</span></li>
        <li><a href="index.php?model=agenda"><?=$lang['Agenda']?></a><span class="divider">/</span></li>        
        <li><a href="#"><?=$lang['Edit Agenda']?></a></li>
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
        <input type="hidden" name="action" id="action" value="EDIT" />
        <input type="hidden" name="model" id="model" value="<?=$_REQUEST['model']?>" />
        <input type="hidden" name="pk_id" id="pk_id" value="<?=$_REQUEST['id']?>" />        
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
            
            <div class="controls">
              <button type="submit" class="btn btn-primary" id="btn_submit" name="btn_submit" value="update"><?=$lang['Save Changes']?></button>
             <a href='index.php?model=<?=$model?>'><button class="btn" type="button"><?=$lang['Cancel']?></button></a>
            </div>
          </fieldset>
        </form>
      </div>
    </div>
  </div>
  <!--/span--> 
  
</div>