<?php 
include_once(CONTROLLERS_ADMIN."/".$_REQUEST['model'].".php"); 

$msg 		= $objComm->getSessionMessage('workgroup');
//$arrStatus 	= $objComm->getAllStatus();

?>

<div>
   <ul class="breadcrumb">
        <li><a href="#"><?=$lang['Settings']?></a> <span class="divider">/</span></li>
        <li><a href="index.php?model=usersrole"><?=$lang['Work Group']?></a><span class="divider">/</span></li>        
        <li><a href="#"><?=$lang['All Work Group']?></a></li>
   </ul>
</div>
  <?=$msg?>
<div class="row-fluid sortable">
  <div class="box span12">
    <div class="box-header well" data-original-title>
      <h2><i class="icon-user"></i> <?=$lang['Work Group']?></h2>
      <div class="box-icon"></div>
    </div>
    <div class="box-content">
      <div class="control-group" style="text-align:right;margin:20px 0 0 0;">
        <div class="controls"> 
           <a class="btn btn-success" href="index.php?model=workgroup&action=add"><i class="icon-plus icon-white"></i> <?=$lang['Add Work Group']?> </a> 
        </div>
      </div>
      
      <table class="table table-bordered table-striped table-condensed datatable1">
        <thead>
          <tr>
            <th><?=$lang['WorkGroupID']?> #</th>
            <th><?=$lang['WorkGroupName']?></th>
            <th nowrap><?=$lang['CreatedDatetime']?></th>            
          </tr>
        </thead>
        <tbody>
        
        <?php 
			
			foreach($Records as $row)
			{
				$view   = "index.php?model=workgroup&action=view&id=".$row->WorkgroupID;
				$edit   = "index.php?model=workgroup&action=edit&id=".$row->WorkgroupID;
				$delete = "index.php?model=workgroup&action=delete&id=".$row->WorkgroupID;

				echo '<tr>'
					 .'<td>'.$row->WorkgroupID.'</td>'				
					 .'<td>'.$row->WorkgroupName.'</td>'
					 .'<td class="center" nowrap>
					 	<a class="btn btn-success" href="'.$view.'"> <i class="icon-zoom-in icon-white"></i> '.$lang['View'].'</a> 
						<a class="btn btn-info" href="'.$edit.'"> <i class="icon-edit icon-white"></i> '.$lang['Edit'].'</a> 
						<a class="btn btn-danger" href="'.$delete.'"> <i class="icon-trash icon-white"></i> '.$lang['Delete'].'</a></td>'
					 .'</tr>';
			}
         ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<script>

$( document ).ready(function() {
	$('.datatable1').dataTable({
		"sDom": "<'row-fluid'<'span6'><'span6'f>r>t<'row-fluid'<'span12'i><'span12 center'p>>",
		"sPaginationType": "bootstrap",
		"oLanguage": {"sLengthMenu": "_MENU_ records per page"},
	    "bFilter": false,
	} );
});


function ResetSearch()
{
	$("#frm_search input,select").val('');
	$("#frm_search").submit();
}
	
</script>		