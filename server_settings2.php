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
	require_once("../scripts/incfiles/config.inc.php");
	require_once("../modules/user/library/user.inc.php");
	$oSmarty 	= new Smarty();
	$system		= new cwd_system();
	$system->session_checker($_SESSION["CONNECTED_ADMIN"], $_SESSION["CONNECTED_EDIT"]);
?>
<?php
	//Site settings
	$settings 		= 	$system->get_site_settings();
	//Modules settings
	//$mod_settings	=	$my_users->get_mod_settings();
	
	//Language settings
	$langFile	= isset($_SESSION[LANG]) ? ($_SESSION[LANG]) : ($settings["LANG"]);
	
	//Call the language file pack
	require_once("../scripts/langfiles/".$langFile.".php");  //Global language pack
	
	//Page name
	$admin_pageTitle	=	'Help'; //$mod_lang_output['MODULE_DESCR'];	
?>
<?php
	//Personalized scripts in here
?>
<?php
	ob_end_flush();
?>
<?php include_once('inc/admin_header.php');?>
        	<h3><i class="fa fa-help"></i>Help :: Server settings</h3>
        	<div class="col-sm-4">
        	<h4>Document root</h4>
        	<p><?php print $_SERVER['DOCUMENT_ROOT']?></p>
        	</div>
        	<div class="col-sm-4">
        	<h4>Adresse IP du serveur</h4>
        	<p><?php print $_SERVER['SERVER_ADDR']?></p>
        	</div>
        	<div class="col-sm-4">
        	<h4>Adresse distante</h4>
        	<p><?php print $_SERVER['PATH']?></p>
        	</div>
        	<p>&nbsp;</p>
        	<p>&nbsp;</p>
        	<h4>PHP Info</h4>
        	<p>Below is the configuration of your online server</p>
        	<?php 
        		//@mail('guyzwyk@gmail.com', 'Test', 'Test from MIDENO Servers');
        	?>
            <p>&nbsp;</p>
            <iframe src="php_info.php" height="800" width="100%"></iframe>
<?php include_once('inc/admin_footer.php');?>