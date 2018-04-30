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
	//Traitement...
	$file_orig	=	'../scripts/incfiles/config.inc.php';
	$file		=	file($file_orig);
	
	$btn_settings_update	=	$_POST['btn_settings_update'];
	$ta_settings_update	=	$_POST['ta_settings_update'];
	
	if(isset($btn_settings_update)){
		$open = fopen("../scripts/incfiles/config.inc.php","w+");
		fwrite($open, $ta_settings_update);
		fclose($open);
		$msg_update_ok	=	"<div class=\"form-group\">
								<div class=\"col-sm-1\"></div>
								<div class=\"col-sm-10 ADM_cfrm_msg\">Fichier modifi&eacute; avec succ&egrave;s!</div>
								<div class=\"col-sm-1\"></div>
							</div>";
	}
	else{
		
	}
?>

<?php 
	ob_end_flush();
?>
<?php include_once('inc/admin_header.php');?>

<h3><i class="fa fa-question"></i>&nbsp;Aide :: Mise &agrave; jour du fichier de configuration de l'application</h3>

<?php
if($_POST['btn_settings_update']){
	$open = fopen("../scripts/incfiles/config.inc.php","w+");
	$text = $_POST['ta_settings_update'];
	fwrite($open, $text);
	fclose($open);
	$msg_update_ok	=	 "Configuration file successfuly updated.";
	//echo "File:<br />";
	$file = file("../scripts/incfiles/config.inc.php");
	foreach($file as $text) {
		echo $text."<br />";
	}
}else{
	$file = file("../scripts/incfiles/config.inc.php");
	echo 	"<div class=\"tab-content\">
          		<div class=\"tab-pane active\" id=\"horizontal-form\">
					<form class=\"form-horizontal\" action=\"\" method=\"post\">";
	echo "<div class=\"form-group\">
			<div class=\"col-sm-1\"><input type=\"checkbox\" onClick=\"javascript:document.getElementById('ta_settings_update').disabled = false;\" /></div>
			<div class=\"col-sm-10 ADM_alert_msg\">Attention!<br />A l'usage du super admin uniquement!</div>	
			<div class=\"col-sm-1\"></div>
		</div>
			$msg_update_ok
		<div class=\"form-group\">
			<div class=\"col-sm-12\">
					<textarea onChange=\"javascript:document.getElementById('btn_settings_update').disabled = false;\" disabled=\"disabled\" class=\"form-control1\" style=\"height:550px;\" name=\"ta_settings_update\" id=\"ta_settings_update\">";
	foreach($file as $text) {
		echo $text;
	}
	echo "</textarea></div></div>";
	echo "<div class=\"panel-footer\">
			<div class=\"row\">
				<div class=\"col-sm-8 col-sm-offset-2\">
					<button disabled=\"disabled\" type=\"submit\" name=\"btn_settings_update\" id=\"btn_settings_update\" class=\"btn-success btn\">Update settings</button>
		        </div>
			</div>
		 </div>
			</form></div></div>";
}
?>

<?php include_once('inc/admin_footer.php');?>
