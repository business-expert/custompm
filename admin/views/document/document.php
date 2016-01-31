<?php
include_once(CONTROLLERS_ADMIN."/document.php");

$msg = $objComm->getSessionMessage('document');
?>
<link href="<?=CSS?>jquery.treeview.css" rel="stylesheet">
<script src="<?=JS?>jquery.treeview.js"></script>

<div>
   <ul class="breadcrumb">
        <li><a href="#"><?=$lang['Manage']?></a> <span class="divider">/</span></li>
        <li><a href="index.php?model=document"><?=$lang['Document']?></a><span class="divider">/</span></li>        
        <li><a href="#"><?=$lang['All Document']?></a></li>
   </ul>
</div>
<?=$msg?>
<div class="row-fluid sortable">
<div class="box span12">
  <div data-original-title="" class="box-header well">
    <h2><i class="icon-list-alt"></i> <?=$lang['Document']?></h2>
    <div class="box-icon"> </div>
  </div>
  <?php if($type == 'int') { ?>
  <div style="padding-bottom:5px;margin:8px 0;" class="page-header"></div>
  <div style="text-align:-moz-right;">
    <form action="index.php?model=document" method="post" id="frm_search" name="frm_search">
    	<input type="hidden" value="" id="action" name="action">
        <input type="hidden" value="<?=$_REQUEST['type']?>" id="type" name="type">
		<table cellspacing="2" cellpadding="4" style="border:none;">
        	<tr>
               <td align="right"><?=$lang['Work Group']?> : <?=$objHTML->getWorkGroupCombo('sr_WorkGroup',$_REQUEST['sr_WorkGroup'],'onchange="submitform();"')?></td>                               
            </tr>
		</table>
        </form>
  </div>
  <div style="margin:-30px 0 0 0;" class="page-header"></div>     
  <?php } ?>
  <div class="treeview" style="padding:0px 0px 0px 5px;">
  	<?=$strTree?>
  </div>
</div>
</div>

<a href='index.php?model=document&action=add&parent_id=0&type=<?=$type?>'>
	<button class="btn btn-small btn-success">
    	<i class="icon-plus-sign"></i><?=$lang['Add File/Folder']?>
    </button>
</a>

<div id="myModal" class="modal hide fade" style="display: none;">
    <div class="modal-header">
        <button data-dismiss="modal" class="close" type="button">×</button>
        <h3><?=$lang['Message Details']?></h3>
    </div>
    <div class="modal-body">
		<p><h4 id='subject'></h4></p>
        <blockquote>
			<p id='message'></p>
			<small id='userid'></small>
	    </blockquote>
    </div>
    <div class="modal-footer">
        <a data-dismiss="modal" class="btn" href="#"><?=$lang['Close']?></a>
    </div>
</div>
        
<script>

var LangSubjectDelete = "<?=$lang['subject_delete']?>";
var LangMessageDelete = "<?=$lang['message_delete']?>";

$( document ).ready(function() {
	
	$("#browser").treeview({
		animated:"normal",
		persist: "cookie"
	});
	
	$("BUTTON[id='view']").click(function(e){		
		e.preventDefault();
		
		var SubjectID =  $(this).attr('value');	
		
		var Subject = $("#div_text_"+SubjectID).attr('data-subject');
		var Text 	= $("#div_text_"+SubjectID).attr('data-text');
		var UserID 	= $("#div_text_"+SubjectID).attr('data-userid');
		var Time 	= $("#div_text_"+SubjectID).attr('data-time');				

		var Subject	= decodeURIComponent((Subject + '').replace(/\+/g, '%20')); 		
		var Text  	= decodeURIComponent((Text + '').replace(/\+/g, '%20')); 
		
		$("#subject").html(Subject);
		$("#message").html(Text);
		$("#userid").html(UserID + "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" + Time);

		$('#myModal').modal('show');
	});
});


function deleteSubjectConfirm()
{
	if(!confirm(LangSubjectDelete))	
		return false;
	else
		return true;	
}

function deleteMsgConfirm()
{
	if(!confirm(LangMessageDelete))	
		return false;
	else
		return true;	
}

function submitform()
{
	document.getElementById('frm_search').submit();
}

</script>