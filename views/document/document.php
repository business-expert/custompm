<?php
include_once(CONTROLLERS."/document.php");

$msg = $objComm->getSessionMessage('document');
$RoleType = $objComm->getRole();

?>
<link href='<?=CSS?>jquery.treeview.css' rel='stylesheet'>
<script src="<?=JS?>jquery.treeview.js"></script>
<!--<link href="<?=CSS_ADMIN?>tree.css" rel="stylesheet"> -->
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
    <h2><i class="icon-list-alt"></i> <?=$lang['Document']?></h2><div class="box-icon"> </div>
  </div>
  <div class="treeview"><?=$strTree?></div>
</div>
</div>

<?php if($RoleType == 'Write') { ?>
<a href='index.php?model=document&action=add&type=<?=$_REQUEST['type']?>&parent_id=0'><button class="btn btn-small btn-success"><i class="icon-plus-sign"></i> <?=$lang['Add File/Folder']?></button></a>
<?php } ?>

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
	
	$("SPAN[id^='div_subject_']" ).click(function() {
		var SubjectID = $(this).attr('subject');

		if($("DIV[id^='div_text_"+SubjectID+"']").css('display') == 'none')
		{
			$( "DIV[id^='div_text_"+SubjectID+"']").slideDown('slow');
    		$(this).addClass("icon-triangle-s").removeClass("icon-triangle-e");
    	}	
    	else	
    	{
			$("DIV[id^='div_text_"+SubjectID+"']").slideUp('slow');
        	$(this).addClass("icon-triangle-e").removeClass("icon-triangle-s");
        }	
	});
	
	// first example
	$("#navigation").treeview({
		collapsed: true,
		unique: true,
		persist: "location"
	});

	// second example
	$("#browser_gen").treeview({
		animated:"normal",
		persist: "cookie"
	});
	
	// second example
	$("#browser_int").treeview({
		animated:"normal",
		persist: "cookie"
	});
	
	// third example
	$("#red").treeview({
		animated: "fast",
		collapsed: true,
		control: "#treecontrol"
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

</script>