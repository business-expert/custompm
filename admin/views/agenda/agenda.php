<?php 
include_once(CONTROLLERS_ADMIN."/".$_REQUEST['model'].".php"); 

$msg 		= $objComm->getSessionMessage('agenda');
//$arrStatus 	= $objComm->getAllStatus();

?>

<div>
   <ul class="breadcrumb">
        <li><a href="#"><?=$lang['Manage']?></a> <span class="divider">/</span></li>
        <li><a href="index.php?model=agenda"><?=$lang['Agenda']?></a><span class="divider">/</span></li>        
        <li><a href="#"><?=$lang['All Agenda']?></a></li>
   </ul>
</div>
  <?=$msg?>
<div class="row-fluid sortable">
  <div class="box span12">
    <div class="box-header well" data-original-title>
      <h2><i class="icon-user"></i> <?=$lang['Agenda']?></h2>
      <div class="box-icon"></div>
    </div>
    <div class="box-content">
    
    <!--<div style="padding-bottom:5px;margin:8px 0;" class="page-header"><h3><?=$lang['Search']?></h3></div>
    <form action="index.php?model=agenda" method="post" id="frm_search" name="frm_search">
    	<input type="hidden" value="" id="action" name="action">
		<table cellspacing="2" cellpadding="4" style="border:none;" style="width:100%">
            <tbody><tr>
                <td align="right"><?=$lang['Topic']?> : <input type="search" value="<?=$_REQUEST['sr_Topic']?>" id="sr_Topic" name="sr_Topic"></td>
                <!--<td align="right"><?=$lang['Description']?> : <input type="search" value="<?=$_REQUEST['sr_Discription']?>" id="sr_Discription" name="sr_Discription"></td>
                <td align="right"><?=$lang['UserName']?> : <?=$objHTML->getUserCombo('sr_UserID',$_REQUEST['sr_UserID'],'')?></td>
                <td align="right">
                	<button class="btn btn-small btn-success" style="margin:-13px 0px 0 0;"><?=$lang['Search']?></button>
	                <button onclick="ResetSearch();" class="btn btn-small btn-info" style="margin:-13px 0px 0 0;"><?=$lang['Reset']?></button>
                </td>                
            </tr>
        </tbody></table>
        </form>-->
    
      <!--<div class="control-group" style="text-align:right;margin:20px 0 0 0;">
        <div class="controls"> 
           <a class="btn btn-success" href="index.php?model=agenda&action=add"><i class="icon-plus icon-white"></i> <?=$lang['Add Agenda']?> </a> 
        </div>
      </div>-->
      
      <table class="table table-bordered table-striped table-condensed datatable1">
        <thead>
          <tr>
	        <th><?=$lang['AgendaID']?> #</th>
            <th><?=$lang['UserName']?></th>
            <th><?=$lang['Topic']?></th>
            <th><?=$lang['Description']?></th>
            <th><?=$lang['Created Date']?></th>
            <th><?=$lang['Action']?></th>            
          </tr>
        </thead>
        <tbody>
        
        <?php 
			
			foreach($Records as $row)
			{
				$view   = "index.php?model=agenda&action=view&id=".$row->AgendaID;
				$edit   = "index.php?model=agenda&action=edit&id=".$row->AgendaID;
				$delete = "index.php?model=agenda&action=delete&id=".$row->AgendaID;

				echo '<tr>'
					 .'<td>'.$row->AgendaID.'</td>'
					 .'<td id="'.$row->AgendaID.'_username">'.$row->UserName.'</td>'
					 .'<td id="'.$row->AgendaID.'_topic">'.$row->Topic.'</td>'
					 .'<td id="'.$row->AgendaID.'_desc">'.$row->Description.'</td>'
					 .'<td id="'.$row->AgendaID.'_date">'.$row->DateCreated.'</td>'					 
					 .'<td class="center" nowrap>
					 	<a class="btn btn-success" id="view" agendaid="'.$row->AgendaID.'"><i class="icon-zoom-in icon-white"></i></a> 
						<a class="btn btn-info" href="'.$edit.'"> <i class="icon-edit icon-white"></i></a> 
						<a class="btn btn-danger" href="'.$delete.'"> <i class="icon-trash icon-white"></i></a></td>'
					 .'</tr>';
			}
         ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<div id="myModal" class="modal hide fade" style="display: none;">
    <div class="modal-header">
        <button data-dismiss="modal" class="close" type="button">×</button>
        <h3><?=$lang['Agenda Detail']?></h3>
    </div>
    <div class="modal-body">
    <div class="row-fluid">
        <div class="span2"><?=$lang['Topic']?>:</div>
        <div class="span10" id='topic'></div>
    </div>
    
    <div class="row-fluid">
        <div class="span2"><?=$lang['Description']?>:</div>
        <div class="span10" id='desc'></div>
    </div>
    
      <div class="row-fluid">
        <div class="span2"><?=$lang['UserName']?>:</div>
        <div class="span10" id='userid'></div>
    </div>
    
      <div class="row-fluid">
        <div class="span2"><?=$lang['Created Date']?>:</div>
        <div class="span10" id='date'></div>
    </div>
    
    
    </div>
    <div class="modal-footer">
        <a data-dismiss="modal" class="btn" href="#"><?=$lang['Close']?></a>
    </div>
</div>

<script>

$( document ).ready(function() {
	
	/*$('.datatable1').dataTable({
		"sDom": "<'row-fluid'<'span6'><'span6'f>r>t<'row-fluid'<'span12'i><'span12 center'p>>",
		"sPaginationType": "bootstrap",
		"oLanguage": {"sLengthMenu": "_MENU_ records per page"},
	    "bFilter": false,
	});*/
	
	$('.datatable1').dataTable({
			"sDom": '<"toolbar">frti<"span12 center"p>',
			"sPaginationType": "bootstrap",
			"oLanguage": {
							"sSearch": "<?=$lang['Search']?> : ",
							"sLengthMenu": "",
							"sZeroRecords": "<?=$lang['no_record_found']?>",
							"sInfo": "",
							"sInfoEmpty": "",
							"sInfoFiltered": ""
						 },
		});
		
	$("div.toolbar").html('<div class="controls" style="float:right;"> <a class="btn btn-success" href="index.php?model=agenda&action=add"><i class="icon-plus icon-white"></i> <?=$lang['Add Agenda']?> </a></div> ');
	
	$("A[id='view']").click(function(e){		
		e.preventDefault();
		
		var AgendaID =  $(this).attr('agendaid');	
		
		var Topic = $("#"+AgendaID+"_topic").html();
		var Desc = $("#"+AgendaID+"_desc").html();
		var UserName = $("#"+AgendaID+"_username").html();
		var CreatedDate = $("#"+AgendaID+"_date").html();		

		var Topic	= decodeURIComponent((Topic + '').replace(/\+/g, '%20')); 		
		var Desc  	= decodeURIComponent((Desc + '').replace(/\+/g, '%20')); 

		$("#topic").html(Topic);
		$("#desc").html(Desc);
		$("#userid").html(UserName);
		$("#date").html(CreatedDate);

		$('#myModal').modal('show');
	});
	
	
	
});


function ResetSearch()
{
	$("#frm_search input,select").val('');
	$("#frm_search").submit();
}
	
</script>		