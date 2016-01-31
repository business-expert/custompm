<?php

include_once(CONTROLLERS_ADMIN."/messageboard.php");

$msg = $objComm->getSessionMessage('messageboard');
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
 <?php 
 	if($_REQUEST['type'] == 'int') { ?>
  <div style="padding-bottom:5px;margin:8px 0;" class="page-header"></div>
    <form action="index.php?model=messageboard" method="post" id="frm_search" name="frm_search">
    	<input type="hidden" value="" id="action" name="action">
		<table cellspacing="2" cellpadding="4" style="border:none;" style="width:100%">
            <tbody><tr>
                <!--<td align="right"><?=$lang['Subject']?> : <input type="search" value="<?=$_REQUEST['sr_Subject']?>" id="sr_Subject" name="sr_Subject"></td>
                <td align="right"><?=$lang['MessageText']?> : <input type="search" value="<?=$_REQUEST['sr_MessageText']?>" id="sr_MessageText" name="sr_MessageText"></td>-->
                <td align="right"><?=$lang['Work Group']?> : <?=$objHTML->getWorkGroupCombo('sr_WorkGroup',$_REQUEST['sr_WorkGroup'])?></td>
                <td align="right">
                	<button class="btn btn-small btn-success" style="margin:-13px 0px 0 0;"><?=$lang['Search']?></button>
	                <button onclick="ResetSearch();" class="btn btn-small btn-info" style="margin:-13px 0px 0 0;"><?=$lang['Reset']?></button>
                </td>                
            </tr>
        </tbody></table>
        </form>
  <div style="margin:-30px 0 0 0;" class="page-header"></div> 
  <?php } ?>       
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
        
        
<a href='index.php?model=messageboard&action=addsub&type=<?=$type?>'><button class="btn btn-small btn-success"><i class="icon-plus-sign"></i> <?=$lang['Add New Subject']?></button></a>
<br /><br />
<a href='index.php?model=messageboard&action=add&type=<?=$type?>'><button class="btn btn-small btn-info"><i class="icon-plus-sign"></i> <?=$lang['Add New Message']?></button></a>

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
	
	
	//$("DIV[id^='div_text_']").children().find("BUTTON[id='view']").click(function(e){
	
	/*$("BUTTON[id='view']").click(function(e){		
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
	});*/
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