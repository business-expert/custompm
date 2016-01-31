<div class="navbar">
		<div class="navbar-inner">
			<div class="container-fluid">
				<a class="btn btn-navbar" data-toggle="collapse" data-target=".top-nav.nav-collapse,.sidebar-nav.nav-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</a>
				<a class="brand" href="index.php"> Project Management</a>
				
				<!-- user dropdown starts -->
				<div class="btn-group pull-right" >
					<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
						<i class="icon-user"></i><span class="hidden-phone"> <?=$_SESSION['admin']['pm_user_row']->UserName;?></span>
						<span class="caret"></span>
					</a>
					<ul class="dropdown-menu">
					<!--	<li><a href="#">Profile</a></li><li class="divider"></li>-->
						
						<li><a href="index.php?model=login&action=logout"><?=$lang['Logout']?></a></li>
					</ul>
				</div>

                 <?php
							
					$model  = $_REQUEST['model'];
					$action = $_REQUEST['action'];
					$pkid   = $_REQUEST['id'];
					$URL    = "index.php?model=".$model."&action=".$action."&id=".$pkid."&lang=";

					$eng = ($langs == 'english') ?  'icon-ok' : '';
					$chn = ($langs == 'chines') ?  'icon-ok' : '';					
				?>
                            
                <div class="top-nav nav-collapse">
					
				</div>
			</div>
		</div>
	</div>
  
  <div class="container-fluid">
	<div class="row-fluid">
    <!-- left menu starts -->
   	 <?php include_once(VIEWS_ADMIN."/left/left.php"); ?>
    <!-- left menu ends -->
    <div id="content" class="span10">
    <!-- content starts -->
			  
            