<?php include_once(CONTROLLERS."/dashboard.php");  

?>

<link href='<?=CSS?>jquery.treeview.css' rel='stylesheet'>
<script src="<?=JS?>jquery.treeview.js"></script>

<div>
  <ul class="breadcrumb">
    <li><a href="#">Home</a> <span class="divider">/</span></li>
    <li><a href="#">Dashboard</a></li>
  </ul>
</div>

<input type="hidden" name="hid_general_msg_board" id="hid_general_msg_board" value="" />
<input type="hidden" name="hid_internal_msg_board" id="hid_internal_msg_board" value="" />
<input type="hidden" name="hid_agenda" id="hid_agenda" value="" />

<div class="row-fluid sortable ui-sortable">
  <div class="box span4" style="width:45%">
    <div data-original-title="" class="box-header well">
      <h2><i class="icon-list-alt"></i> <?=$lang['General Message Board']?></h2>
      <div class="box-icon"> <a class="btn btn-minimize btn-round" href="#"><i class="icon-chevron-up"></i></a></div>
    </div>
    <div class="box-content" id='div_general_msg'>
      <?=$GeneralMessageBox?>
    </div>
  </div>
  
  <!--/span-->
  
  <div class="box span4" style="width:45%">
    <div data-original-title="" class="box-header well">
      <h2><i class="icon-user"></i> <?=$lang['Internal Message Board']?> (<?=$WorkGroupName?>)</h2>
      <div class="box-icon"> <a class="btn btn-minimize btn-round" href="#"><i class="icon-chevron-up"></i></a></div>
    </div>
    <div class="box-content">
       <spna id='div_internal_msg'><?=$InternalMessageBox?> </span>
    </div>
  </div>
</div>
<div class="row-fluid sortable ui-sortable">
  <div class="box span4" style="width:45%">
    <div data-original-title="" class="box-header well">
      <h2><i class="icon-folder-open"></i> <?=$lang['General Documents']?></h2>
      <div class="box-icon"> <a class="btn btn-minimize btn-round" href="#"><i class="icon-chevron-up"></i></a></div>
    </div>
    <div class="box-content">
      <?=$GeneralDocuments?>
    </div>
  </div>
  
  <!--/span-->
  
  <div class="box span4" style="width:45%">
    <div data-original-title="" class="box-header well">
      <h2><i class="icon-folder-open"></i> <?=$lang['Internal Documents']?> (<?=$WorkGroupName?>)</h2>
      <div class="box-icon"> <a class="btn btn-minimize btn-round" href="#"><i class="icon-chevron-up"></i></a> </div>
    </div>
    <div class="box-content">
      <?=$InternalDocuments?>
    </div>
  </div>
  </div>
<div class="row-fluid sortable ui-sortable">  
  <div class="box span4" style="width:45%">
    <div data-original-title="" class="box-header well">
      <h2><i class="icon-calendar"></i> <?=$lang['Agenda']?></h2>
      <div class="box-icon"> <a class="btn btn-minimize btn-round" href="#"><i class="icon-chevron-up"></i></a> </div>
    </div>
    <div class="box-content" id="div_agenda">
      <?=$strAgenda?>
    </div>
  </div>
</div>
</div>
</div>
<hr>
<div class="modal hide fade" id="myModal">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">×</button>
    <h3>Settings</h3>
  </div>
  <div class="modal-body">
    <p>Here settings can be configured...</p>
  </div>
  <div class="modal-footer"> <a href="#" class="btn" data-dismiss="modal"><?=$lang['Close']?></a> <a href="#" class="btn btn-primary"><?=$lang['Save changes']?></a> </div>
</div>


<span class="btn btn-primary noty" data-noty-options='' style="display:none;"></span>


<div id="MessageModel" class="modal hide fade" style="display: none;">
    <div class="modal-header">
        <button data-dismiss="modal" class="close" type="button">×</button>
        <h3><?=$lang['Message Details']?></h3>
    </div>
    <div class="modal-body">
		<p><h4 id='subject'></h4></p>
        <span id='message'>
        </span>
    </div>
    <div class="modal-footer">
        <a data-dismiss="modal" class="btn" href="#"><?=$lang['Close']?></a>
    </div>
</div>


<div id="AgendaModal" class="modal hide fade" style="display: none;">
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
        <div class="span2"><?=$lang['Created Date']?>:</div>
        <div class="span10" id='date'></div>
    </div>
    </div>
    <div class="modal-footer">
        <a data-dismiss="modal" class="btn" href="#"><?=$lang['Close']?></a>
    </div>
</div>

<script>


var msgnotfound = "<?=$lang['message_not_found']?>";

$( document ).ready(function() {
	setInterval('getGeneralMessage()',25000);
	setInterval('getInternalMessage()',24000);
	setInterval('getAgenda()',23000);
	
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

});


function getMessageModel(MessageID,Type)
{
	if(MessageID > 0)
	{
		$.ajax({
				type	: "GET",
				url		: "ajax.php",
				beforeSend: function () {},
				data    : "ajaxcall=true&mod=getMessageModel&message_id="+MessageID+"&type="+Type,
				success	: function(result) 
						  {
							data = JSON.parse(result);
							var content = '';
							
							for(var i = 0; i < data.length; i++)
							{
								$("#subject").html(data[i].SubjectName);								

								if(data[i].MessageText != '')
								{
									content += "<blockquote><p>"+data[i].MessageText+"</p>";
									content += "<small>"+data[i].UserName+'<br>— '+data[i].DateCreated+"</small></blockquote>";
									content += "<hr>";									
								}
								else
								{
									content += "<blockquote><p></p>";
									content += "<small></small></blockquote>";
									content += "<hr>";
								}
							}
							
							$("#message").html(content);
							$('#MessageModel').modal('show');  
						  }
		     });
	}else{
		alert(msgnotfound);	
	}
}


function getAgendaModel(AgendaID)
{
	if(AgendaID > 0)
	{
		$.ajax({
				type	: "GET",
				url		: "ajax.php",
				beforeSend: function () {},
				data    : "ajaxcall=true&mod=getAgendaModel&agenda_id="+AgendaID,
				success	: function(result) 
						  { 
						  	data = JSON.parse(result);
						  	
							$("#topic").html(data.Topic);
							$("#desc").html(data.Description);
							$("#date").html(data.DateCreated);
					
							$('#AgendaModal').modal('show');
						  }
			   });
	}
	else
	{
		alert("Message not found");	
	}
}


function getGeneralMessage()
{
	$.ajax({
			type	: "GET",
			url		: "ajax.php",
			beforeSend: function () {},
			data    : "ajaxcall=true&mod=getDashboardGeneralMessage",
			success	: function(result) { $("#div_general_msg").html(result); }
		   });
}


function getInternalMessage()
{
	var WorkGroupID = "<?=$WorkGroupID?>";
	
	$.ajax({
			type	: "GET",
			url		: "ajax.php",
			beforeSend: function () {},
			data    : "ajaxcall=true&mod=getDashboardInternalMessage&workgroup="+WorkGroupID,
			success	: function(result) { $("#div_internal_msg").html(result);  }
		   });	
}


function getAgenda()
{
	$.ajax({
			type	: "GET",
			url		: "ajax.php",
			beforeSend: function () {},
			data    : "ajaxcall=true&mod=getDashboardAgenda",
			success	: function(result) { $("#div_agenda").html(result);  }
		   });	
}


function getDataBasedWorkGroup(elmVal)
{
	getInternalMessage();
}


function showNotification(text)
{
	var NotificationText = '{"text":"'+text+'","layout":"bottomRight","type":"alert","animateOpen": {"opacity": "show"}}';
	$(".noty").attr("data-noty-options",NotificationText);
	$(".noty").trigger("click");	
}

</script>