<?php
include_once(CONTROLLERS."/messageboard.php");

$msg	  = $objComm->getSessionMessage('messageboard');
$RoleType = $objComm->getRole($type);

$ViewContent = $row;
?>

<div>
   <ul class="breadcrumb">
        <li><a href="#"><?=$lang['Manage']?></a> <span class="divider">/</span></li>
        <li><a href="index.php?model=messageboard"><?=$lang['Message Board']?></a><span class="divider">/</span></li>        
        <li><a href="#"><?=$lang['All Message Board']?></a></li>
   </ul>
</div>
<?=$msg?>
<div class="row-fluid sortable">
<div class="box span12">
  <div data-original-title="" class="box-header well">
    <h2><i class="icon-list-alt"></i> <?=$lang['Message Board']?></h2>
    <div class="box-icon"> </div>
  </div>
  <br />
  <?=$ViewContent?>
</div>
</div>


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
        
<?php if($RoleType == 'Write') { ?>
<a href='index.php?model=messageboard&action=addsub&type=<?=$_REQUEST['type']?>'><button class="btn btn-small btn-success"><i class="icon-plus-sign"></i> <?=$lang['Add New Subject']?></button></a>
<br /><br />
<a href='index.php?model=messageboard&action=add&type=<?=$_REQUEST['type']?>'><button class="btn btn-small btn-info"><i class="icon-plus-sign"></i> <?=$lang['Add New Message']?></button></a>
<?php } ?>

<script>

var LangSubjectDelete = "<?=$lang['subject_delete']?>";
var LangMessageDelete = "<?=$lang['message_delete']?>";
var msgnotfound = "<?=$lang['message_not_found']?>";

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

});



function getMessageDetails(MessageID,Type)
{
	if(MessageID > 0)
	{
		$.ajax({
				type	: "GET",
				url		: "ajax.php",
				beforeSend: function () {},
				data    : "ajaxcall=true&mod=getMessageModel1&message_id="+MessageID+"&type="+Type,
				success	: function(result) 
						  { 
						  	data = JSON.parse(result);
						  	
							$("#subject").html(data.SubjectName);
							$("#message").html(data.MessageText);
							$("#userid").html(data.UserName + "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" + data.DateCreated);
							$('#myModal').modal('show');
						  }
			   });
	}
	else
	{
		alert(msgnotfound);	
	}
}



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