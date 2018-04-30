<?php
	ob_start();
	ob_implicit_flush();
?>
<?php
	session_save_path("../_sessions/");
	session_start();
?>
<?php	
	//Libraries Import
	require("../scripts/incfiles/config.inc.php");
	require_once("../modules/user/library/user.inc.php");
	$system		= new cwd_system();
	$system->db_connect($thewu32_host, $thewu32_db, $thewu32_user, $thewu32_pass);
	$system->session_checker($_SESSION["CONNECTED_ADMIN"], $_SESSION["CONNECTED_EDIT"]);
?>
<?php
	//Site settings
	$settings 	= $system->get_site_settings();
	
	//Language settings
	$langFile	= isset($_SESSION[LANG]) ? ($_SESSION[LANG]) : ($settings["LANG"]);
	//Call the language file pack
	require_once("../scripts/langfiles/".$langFile.".php");
?>
<?php
	//Personalized scripts in here
?>
<?php
	ob_end_flush();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/admin_template.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>My Admin 1.1 - Welcome</title>
<link rel="shortcut icon" href="../img/dzine/icons/favicon.png" type="image/x-png" />
<!-- InstanceEndEditable -->
<link href="css/layout.css" rel="stylesheet" type="text/css" />
<link href="css/admin.css" rel="stylesheet" type="text/css" />
<!-- InstanceBeginEditable name="head" --><!-- InstanceEndEditable -->
<script type="text/JavaScript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>
</head>
<body>
<center>
  <div id="wrapper">
  	<div id="logout" style="text-align:left; padding-left:25px;"><a href="../logout.php">Logout</a></div>
    <div id="topHead"><img src="img/dzine/topHead.jpg" /></div>
    <div id="headContent">
      <div class="content">
        <div class="appTitle">Web Management Panel </div>
        <div class="appDescr">Your intuitive area for the management of your website.</div>
      </div>
    </div>
    <div id="headSeparator"><img src="img/dzine/headSeparator.jpg" width="996" height="12" /></div>
    <div id="menuContent">
      <div class="content">
        <ul>
          <li><a href="index.php">Home</a></li>
          <li>|</li>
          <li><a href="modules.php">Modules</a></li>
          <li>|</li>
          <li><a href="config.php">Configuration</a></li>
          <li>|</li>
          <li><a href="#">Help</a></li>
        </ul>
      </div>
      <div class="clear_both"></div>
    </div>
    <div id="headSub"> <img src="img/dzine/headSub.jpg" height="9" width="996" />
      <div class="clear_both"></div>
    </div>
    <div id="mainContent">
      <div class="content"><!-- InstanceBeginEditable name="pageMainContent" -->
        <p>Welcome to your web management panel.</p>
        <p>Been here means that your installation has been successfully made</p>
        <p>Please ,use the menus on top the access the desired location available</p>
        <p><strong>Clic on the modules menu to get started with the now installed modules of  the web site. </strong></p>
      <!-- InstanceEndEditable --></div>
      <div class="clear_both"></div>
    </div>
    <div id="subSeparator"><img src="img/dzine/subSeparator.jpg" /></div>
    <div id="subContent">
      <div class="content">&nbsp;</div>
    </div>
  </div>
</center>
</body>
<!-- InstanceEnd --></html>
