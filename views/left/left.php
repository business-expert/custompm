<!-- left menu starts -->
<?php

$arrLink['Manage'] = array(
							'general_message_board' => array('General Message Board', 'index.php?model=messageboard&type=gen', 'icon-list-alt'),
							'internal_message_board'=> array('Internal Message Board', 'index.php?model=messageboard&type=int', 'icon-list-alt'),
							'general_document' 	 	=> array('General Documents', 'index.php?model=document&type=gen', 'icon-file'),
							'internal_document' 	=> array('Internal Documents', 'index.php?model=document&type=int','icon-file'),
							'agenda' 				=> array('Agenda', 'index.php?model=agenda', 'icon-calendar')
					    );

$arrFinalNav[]  = '<li class="nav-header hidden-tablet"></li>
      				<li><a class="ajax-link" href="index.php?model=dashboard"><i class="icon-home"></i>
						<span class="hidden-tablet"> '.$lang['Dashboard'].'</span></a></li>';
 
foreach($arrLink as $key => $link)
{	
	 $strNav = '<li class="nav-header hidden-tablet">'.$lang[$key].'</li>';
	 $arrNav = array();

	 foreach($link as $title => $arrDetail)
	 {

		 $arrNav[] = '<li>
						<a class="ajax-link" href="'.$arrDetail['1'].'">
							<i class="'.$arrDetail['2'].'"></i><span class="hidden-tablet"> '.$lang[$arrDetail['0']].'</span>
						</a>
					</li>';	 
	 }
	 
	 if(count($arrNav) > 0)
	 {
		$arrFinalNav[] = $strNav.implode(" ",$arrNav);
	 }
}

$strNavigation = '';

if($_SESSION['site']['pm_user'] != '')
	$strNavigation = implode(" " ,$arrFinalNav);
	
?>
<?php if ($strNavigation != "") { ?>
<div class="span2 main-menu-span">
  <div class="well nav-collapse sidebar-nav">
    <ul class="nav nav-tabs nav-stacked main-menu">
    	<?=$strNavigation?>
     </ul>   
  </div>
</div>
<?php } ?>
<noscript>
<div class="alert alert-block span10">
  <h4 class="alert-heading">Warning!</h4>
  <p>You need to have <a href="http://en.wikipedia.org/wiki/JavaScript" target="_blank">JavaScript</a> enabled to use this site.</p>
</div>
</noscript>
