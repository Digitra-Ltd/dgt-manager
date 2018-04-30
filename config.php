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
	//Site settings
	$system		= new cwd_system();
	$settings 	= $system->get_site_settings();
	
	//Language settings
	$langFile	= isset($_SESSION[LANG]) ? ($_SESSION[LANG]) : ($settings["LANG"]);
	//Call the language file pack
	require_once("../scripts/langfiles/".$langFile.".php");
	require_once("../modules/gallery/library/gallery.inc.php");
?>
<?php
	$mySettings			= new cwd_system();
	$mySettings->db_connect($thewu32_host, $thewu32_db, $thewu32_user, $thewu32_pass);
	$currentSettings	= $mySettings->get_site_settings();
	$system->session_checker($_SESSION["CONNECTED_ADMIN"], $_SESSION["CONNECTED_EDIT"]);
?>
<?php
	$txtSiteName	= addslashes($_POST[txtSiteName]);
	$taSiteDescr	= addslashes($_POST[taSiteDescr]);
	$txtSiteEmail	= addslashes($_POST[txtSiteEmail]);
	$selSiteLang	= addslashes($_POST[selSiteLang]);
	$hdSiteLogo		= $_POST[hdSiteLogo];
	$btnSiteOk		= $_POST[btnSiteOk];
	
	//Gestion des images
	$mySettingsImg		= new cwd_gallery("../img/logos/", "../img/logos/");
	//Definition du repertoire d'envoi des images et des imagettes
	$mySettingsImg->set_fileDirectory("../img/logos/");
	$fileSiteLogo_name	= $_FILES[fileSiteLogo][name];
	$fileSiteLogo_temp	= $_FILES[fileSiteLogo][tmp_name];
	$fileSiteLogo_size	= $_FILES[fileSiteLogo][size];
?>
<?php
	if(isset($btnSiteOk)){
		$mySettingsImg->set_fileTempName($fileSiteLogo_temp);
		if($fileSiteLogo_name == ""){
			if($mySettings->update_site_settings($txtSiteName, $taSiteDescr, $txtSiteEmail, $selSiteLang, $hdSiteLogo))
				$cfrm_msg = "Settings successfully updated!";
			else
				$err_msg	= "Error while updating the website global settings";
		}
		else{
			if($mySettings->update_site_settings($txtSiteName, $taSiteDescr, $txtSiteEmail, $selSiteLang, $fileSiteLogo_name)){
				$mySettingsImg->set_fileDirectory("../img/logos/");
				$mySettingsImg->fileSend($fileSiteLogo_name);
				$cfrm_msg	= "Settings successfully updated!";
			}
			else
				$err_msg	= "Error while updating the website global settings";
		}
	}
?>
<?php include_once('inc/admin_header.php');?>

        <h3>Help :: Your website global configuration below : </h3>
        <?php if(isset($err_msg)) {  ?>
	      <div class="ADM_err_msg"><?php print $err_msg; ?></div>
	    <?php } ?>
	    <?php if(isset($cfrm_msg)) {  ?>
	      <div class="ADM_cfrm_msg"><?php print $cfrm_msg; ?></div>
	    <?php } ?>
        <form class="form-horizontal" action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
        	<div class="form-group">
        		<label class="col-sm-2 control-label" for="txtSiteName">Site name :</label>
        		<div class="col-sm-8">
        			<input class="form-control1" name="txtSiteName" type="text" id="txtSiteName" value="<?php print $currentSettings[NAME] ?>" />
        		</div>
        		<div class="col-sm-2"></div>
        	</div>
        	<div class="form-group">
				<label for="taSiteDescr" class="col-sm-2 control-label">Site description :</label>
				<div class="col-sm-8">
					<textarea class="form-control1 ta-wide" name="taSiteDescr" cols="40" rows="4" id="taSiteDescr"><?php print $currentSettings[DESCR] ?></textarea>
				</div>
				<div class="col-sm-2">
					<p class="help-block redStar"></p>
				</div>
			</div>
			<div class="form-group">
				<label for="txtSiteEmail" class="col-sm-2 control-label">Administrator e-mail :</label>
				<div class="col-sm-8">
					<input class="form-control1" name="txtSiteEmail" type="text" id="txtSiteEmail" size="50" value="<?php print $currentSettings[EMAIL] ?>" />
				</div>
				<div class="col-sm-2">
					<p class="help-block redStar"></p>
				</div>
			</div>
			<div class="form-group">
				<label for="txtSiteEmail" class="col-sm-2 control-label">Default language :</label>
				<div class="col-sm-8">
					<select class="form-control" name="selSiteLang" id="select">
	                	<?php print $mySettings->cmb_showLang($currentSettings[LANG]); ?>
	              	</select>
				</div>
				<div class="col-sm-2">
					<p class="help-block redStar"><a href="#" onclick="<?php print $mySettings->popup("config_lang_param.php", 350, 220); ?>">Language parameters</a></p>
				</div>
			</div>
			
			<div class="form-group">
				<label for="txtSiteEmail" class="col-sm-2 control-label">Logo :(300 X 100)pixels</label>
				<div class="col-sm-8">
					<input class="form-control1" name="fileSiteLogo" type="file" id="fileSiteLogo" />
	              	<input name="hdSiteLogo" type="hidden" id="hdSiteLogo" value="<?php print $currentSettings[LOGO] ?>" />
				</div>
				<div class="col-sm-2">
					<p class="help-block redStar">(JPG, PNG, or GIF format)</p>
				</div>
			</div>
			
			<div class="panel-footer">
				<div class="row">
		        	<div class="col-sm-8 col-sm-offset-2">
		            	<button type="submit" name="btnSiteOk" id="btnSiteOk" class="btn-success btn">Submit configuration</button>
		            </div>
		       	</div>
	        </div>
        </form>
        
<?php include_once('inc/admin_footer.php');?>