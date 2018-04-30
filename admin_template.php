<?php
	ob_start();
	ob_implicit_flush();
?>
<?php	
	//Libraries Import
	require_once("../scripts/incfiles/cms_cls.inc.php");
	$oSmarty 	= new Smarty();
	$system		= new cwd_system();
?>
<?php
	//Personalized scripts in here
?>
<?php
	ob_end_flush();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>cawad My Admin 1.1 - Gestion de la galerie de photos</title>
<link href="css/layout.css" rel="stylesheet" type="text/css" />
<link href="css/admin.css" rel="stylesheet" type="text/css" />
</head>

<body>
<center>
<div id="wrapper">
  <div id="topHead"><img src="img/dzine/topHead.jpg" /></div>
  <div id="headContent">
    <div class="content">
      <div class="appTitle">Espace d'administration cwd MyAdmin 2.0</div>
      <div class="appDescr">Interface de gestion intuitive du contenu de votre site web.</div>
      
    </div>
  </div>
  <div id="headSeparator"><img src="img/dzine/headSeparator.jpg" width="996" height="12" /></div>
  <div id="menuContent">
    <div class="content">
    	<ul>
        	<li><a href="index.php">Accueil</a></li>
            <li>|</li>
            <li><a href="modules.php">Modules</a></li>
            <li>|</li>
            <li><a href="config.php">Configuration</a></li>
            <li>|</li>
            <li><a href="help.php">Aide</a></li>
        </ul>
    </div>
    <div class="clear_both"></div>
  </div>  
  <div id="headSub">
  	<img src="img/dzine/headSub.jpg" height="9" width="996" />
    <div class="clear_both"></div>
  </div>
  <div id="mainContent">
    <div class="content">Contenu de la page &agrave; ins&eacute;rer ici</div>
  <div class="clear_both"></div>
  </div>
  
  <div id="subSeparator"><img src="img/dzine/subSeparator.jpg" /></div>
  <div id="subContent">
    <div class="content">&nbsp;Copyright &copy; cawad Labs 2008<br />
     - All rights reserved - </div>
  </div>
</div>
</center>
</body>
</html>
