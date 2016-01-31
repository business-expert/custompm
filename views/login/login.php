<?php
	//echo "<pre>"; print_r($_SESSION);
	require_once(CONTROLLERS."/login.php");
	$msg = $objComm->getSessionMessage('login');
?>

<div class="container-fluid">
  <div class="row-fluid">
    <div class="row-fluid">
      <div class="span12 center login-header">
        <h2><?=$lang['site_title']?></h2>
      </div>
      <!--/span--> 
    </div>
    <!--/row-->
    
    <div class="row-fluid">
      <div class="well span5 center login-box">
        <?=$msg?>
        <form class="form-horizontal" method="post" action="index.php">
          <input type="hidden" name="model" id="model" value='login'>
          <input type="hidden" name="action" id="action" value='login'>
          <fieldset>
            <div class="input-prepend" title="Username" data-rel="tooltip"> <span class="add-on"><i class="icon-user"></i></span>
              <input autofocus class="input-large span10" name="username" id="username" type="text" value="" />
            </div>
            <div class="clearfix"></div>
            <div class="input-prepend" title="Password" data-rel="tooltip"> <span class="add-on"><i class="icon-lock"></i></span>
              <input class="input-large span10" name="password" id="password" type="password" value="" />
            </div>
            <div class="clearfix"></div>
            <div class="input-prepend">
              <label class="remember" for="remember">
                <input type="checkbox" id="remember" />
                <?=$lang['Remember me']?></label>
            </div>
            <div class="clearfix"></div>
            <p class="center span5">
              <button type="submit" class="btn btn-primary"><?=$lang['Login']?></button>
            </p>
          </fieldset>
        </form>
      </div>
      <!--/span--> 
    </div>
    <!--/row--> 
  </div>
  <!--/fluid-row--> 
  
</div>
