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
?>
<?php
	$mySettings			= new cwd_system();
	$system				= new cwd_system();
	$mySettings->db_connect($thewu32_host, $thewu32_db, $thewu32_user, $thewu32_pass);
	$currentSettings	= $mySettings->get_site_settings();
?>
<?php
	//Site settings
	$settings 	= $mySettings->get_site_settings();
	
	//Language settings
	$langFile	= isset($_SESSION[LANG]) ? ($_SESSION[LANG]) : ($settings["LANG"]);
	
	//Call the language file pack
	require_once("../scripts/langfiles/".$langFile.".php");
	$system->session_checker($_SESSION["CONNECTED_ADMIN"], $_SESSION["CONNECTED_EDIT"]);
?>
<?php
	//Form validations
	$btn_activateLang	= $_POST[btn_activateLang];
	$btn_deactivateLang	= $_POST[btn_deactivateLang];
	$sel_langAvailable	= $_POST[sel_langAvailable];
	$sel_langActivated	= $_POST[sel_langActivated];
	
	//Activate a language:
	if(isset($btn_activateLang)){
		if($mySettings->activate_lang($sel_langAvailable, '1')){
			$lang_cfrm_msg	= "New language successfully activated";
			$system->set_log('LANGUAGE ACTIVATED - ('.$sel_langAvailable.')');
		}
	}
	elseif(isset($btn_deactivateLang)){
		if($mySettings->activate_lang($sel_langActivated, '0')){
			$lang_cfrm_msg	= "Language successfully deactivated";
			$system->set_log('LANGUAGE REMOVED - ('.$sel_langActivated.')');
		}
	}
	
	/*if(isset($_POST[btn_chooseLang])){
		foreach($chkLang as $name => $value){
			//$checked
			/*$where = "WHERE lang_id = '$name'";
			if($mySettings->update_entry("cwd_lang", "display", $value, $where))
				$cfrm_msg = "Language successfully enabled!";
			else
				$err_msg	= "Error while enabling site language";
			print "$name : $value - $chkLang<br />";
		}
	}
	*/
?>
<?php
	ob_end_flush();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>My Admin 1.1 - Website configuration</title>
<link rel="shortcut icon" href="../img/dzine/icons/favicon.png" type="image/x-png" />
<link href="css/layout.css" rel="stylesheet" type="text/css" />
<link href="css/admin.css" rel="stylesheet" type="text/css" />
</head>

<body>
<h1>Website language</h1>
<p>Select a language to display for your website</p>
<form id="frm_chooseLang" name="frm_chooseLang" method="post" action="">
	<?php
		//print $mySettings->chk_showLang();
	?>
	<table border="1" width="100%">
		<tr>
			<th align="center">Not activated</th>
			<th>&nbsp;</th>
			<th align="center">Activated</th>
		</tr>
		<tr>
			<td align="center">
				<select name="sel_langAvailable" size="5">
					<?php print $mySettings->cmb_load_lang('0'); ?>
			        </select>
			</td>
			<td align="center" valign="middle">
				<input type="submit" name="btn_activateLang" value = ' >> Activate >> ' />
				<br /><br />
				<input type="submit" name="btn_deactivateLang" value = ' << Remove << ' />
			</td>
			<td align="center">
				<select name="sel_langActivated" size="5">
					<?php print $mySettings->cmb_load_lang('1'); ?>
			      </select>
			</td>
		</tr>
	</table>
</form>
<p style="margin-left:10px;"><a href="#" onclick="window.close();">Close</a></p>
</body>
</html>
