<?php
include_once(CONTROLLERS_ADMIN."/messageboard.php");

$extraCond = ($_REQUEST['type'] == 'gen') ? 'style="width:310px;" disabled' : 'style="width:310px;" required';
	
?>

<div>
  <ul class="breadcrumb">
    <li><a href="#"><?=$lang['Manage']?></a> <span class="divider">/</span></li>
    <li><a href="index.php?model=messageboard"><?=$lang['Message Board']?></a><span class="divider">/</span></li>
    <li><a href="#"><?=$lang['Add Message Subject']?></a></li>
  </ul>
</div>
<div class="row-fluid sortable">
  <div class="box span12">
    <div class="box-header well" data-original-title>
      <h2><i class="icon-list-alt"></i> <?=$lang['Message Subject']?></h2>
    </div>
    <div class="box-content">
        <form class="form-horizontal" method="post" action="index.php">
        <input type="hidden" name="action" id="action" value="addsub" />
         <input type="hidden" name="type" id="type" value="<?=$_REQUEST['type']?>" />     
        <input type="hidden" name="model" id="model" value="<?=$_REQUEST['model']?>" />

        <fieldset>
          <div class="control-group">
            <label class="control-label" for="typeahead"><?=$lang['Subject']?> </label>
            <div class="controls">
				<input type="text" class="input-xlarge focused" name="data_SubjectName" id="data_SubjectName" value="" required>
            </div>
          </div>
          
          <?php if($type == 'int') { ?>
          <div class="control-group">
            <label class="control-label" for="typeahead"><?=$lang['Work Group']?> </label>
            <div class="controls">
             <?=$objHTML->getWorkGroupCombo('data_WorkgroupID','',$extraCond);?>	
            </div>
          </div>
         <?php } ?>
          <div class="controls">
              <button class="btn btn-primary" type="submit" name='btn_submit' value='savesub'><?=$lang['Save']?></button>
              <a href='index.php?model=<?=$model?>&type=<?=$type?>'><button class="btn" type="button"><?=$lang['Cancel']?></button></a>
            </div>
        </fieldset>
      </form>
    </div>
  </div>
</div>
