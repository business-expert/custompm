<?php 

include_once(CONTROLLERS_ADMIN."/".$_REQUEST['model'].".php"); 

$msg = $objComm->getSessionMessage('User');
$arrStatusBlock = $objComm->getAllUserStatusBlock();
$arrStatus = $objComm->getAllUserStatus();

?>

<div>
    <ul class="breadcrumb">
        <li><a href="#"><?=$lang['Settings']?></a> <span class="divider">/</span></li>
        <li><a href="index.php?model=users"><?=$lang['Users']?></a><span class="divider">/</span></li>        
        <li><a href="#"><?=$lang['All Users']?></a></li>
   </ul>
</div>
  <?=$msg?>
<div class="row-fluid sortable">
  <div class="box span12">
    <div class="box-header well" data-original-title>
      <h2><i class="icon-user"></i> <?=$lang['Users']?></h2>
      <div class="box-icon"></div>
    </div>
    <div class="box-content">
      <div class="control-group" style="text-align:right;margin:20px 0 0 0;">
        <div class="controls"> 
           <a class="btn btn-success" href="index.php?model=users&action=add"><i class="icon-plus icon-white"></i> <?=$lang['Add New User']?> </a> 
        </div>
      </div>
      
      <table class="table table-bordered table-striped table-condensed datatable1">
        <thead>
          <tr>
            <th><?=$lang['UserID']?></th>
            <th><?=$lang['UserName']?></th>
            <th><?=$lang['Email']?></th>
            <th><?=$lang['WorkGroupName']?></th>
             <th><?=$lang['Roll']?></th>
            <th><?=$lang['Status']?></th>            
            <th nowrap><?=$lang['Action']?></th>            
          </tr>
        </thead>
        <tbody>
        
        <?php 

			foreach($Records as $row)
			{
				$view   = "index.php?model=users&action=view&id=".$row->UserID;
				$edit   = "index.php?model=users&action=edit&id=".$row->UserID;
				$delete = "index.php?model=users&action=delete&id=".$row->UserID;
					
				$WorkGroupName = ($row->IsAdmin == 1) ? "Admin" :$row->WorkgroupName;
				$RollName = ($row->IsAdmin == 1) ? "Admin" :$row->RoleName;
				
				echo '<tr>'
					 .'<td>'.$row->UserID.'</td>'
					 .'<td class="center">'.$row->UserName.'</td>'
					 .'<td class="center">'.$row->Email.'</td>'
					 .'<td class="center">'.$WorkGroupName.'</td>'
					 .'<td class="center">'.$RollName.'</td>'					  
					 .'<td class="center"><span class="label '.$arrStatusBlock[$row->Status].'">'.$arrStatus[$row->Status].'</span></td>'
					 .'<td class="center" nowrap>
					 	<a class="btn btn-success" href="'.$view.'"> <i class="icon-zoom-in icon-white"></i> '.$lang['View'].'</a> 
						<a class="btn btn-info" href="'.$edit.'"> <i class="icon-edit icon-white"></i> '.$lang['Edit'].'</a>';
	
				if($row->IsAdmin == 0)
					echo ' <a class="btn btn-danger" href="'.$delete.'" onclick="return confirmDelete();"> <i class="icon-trash icon-white"></i> '.$lang['Delete'].'</a></td>';
				
				echo '</tr>';
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
		"oLanguage": {
						"sSearch": "<?=$lang['Search']?> : ",
						"sLengthMenu": "",
						"sZeroRecords": "<?=$lang['no_record_found']?>",
						"sInfo": "",
						"sInfoEmpty": "",
						"sInfoFiltered": ""
						 },
	    "bFilter": false,
	} );
});


function ResetSearch()
{
	$("#frm_search input,select").val('');
	$("#frm_search").submit();
}

function confirmDelete()
{
	if(confirm("<?=$lang['delete_user_confirm']?>"))	
		return true;
	else
		return false;	
	
}
	
</script>		