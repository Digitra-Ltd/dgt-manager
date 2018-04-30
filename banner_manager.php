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
	require_once("../modules/gallery/library/gallery.inc.php");
	require_once("../modules/banner/library/banner.inc.php");
	require_once("../scripts/incfiles/page.inc.php");
?>

<?php
	//Site settings
	$system		= new cwd_system();
	$myPage		= new cwd_page();
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
require_once("../modules/banner/langfiles/".$langFile.".php"); //Module language pack

//Page name
$admin_pageTitle	=	$mod_lang_output['MODULE_DESCR'];
?>

<?php
	//Module lib initializations
	$myBanner		= new cwd_banner();
	$myBannerImg	= new cwd_gallery("../modules/banner/bans/", "../modules/banner/bans/");
	$myBanner->db_connect($thewu32_host, $thewu32_db, $thewu32_user, $thewu32_pass);
	$system->session_checker($_SESSION["CONNECTED_ADMIN"], $_SESSION["CONNECTED_EDIT"]);
?>

<?php 
	require_once('../modules/banner/inc/banner_validations.php');
?>

<?php
	ob_end_flush();
?>

<?php include_once('inc/admin_header.php');?>
	        	
	        	
	 	<!-- *********************************** INSERER UNE NOUVELLE BANNIERE ******************************
		*************************************************************************************************** -->
      <?php if($_REQUEST['what'] == 'bannerInsert') { ?>
        <h3><?php print $mod_lang_output['MODULE_NAME']; ?> :: <?php print $mod_lang_output['PAGE_HEADER_ADD_BANNER']; ?></h3>
        <?php if(isset($ban_insert_err_msg)) {  ?>
	      <div class="ADM_err_msg"><?php print $ban_insert_err_msg; ?></div>
	    <?php } ?>
	    <?php if(isset($ban_insert_cfrm_msg)) {  ?>
	      <div class="ADM_cfrm_msg"><?php print $ban_insert_cfrm_msg; ?></div>
	    <?php } ?>
		<form class="form-horizontal" action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
			<div class="form-group">
				<label for="sel_banPosition" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_BANNER_POSITION']; ?></label>
				<div class="col-sm-8">
              		<select class="form-control" name="sel_banPosition" id="sel_banPosition">
              			<?php print $myBanner->cmb_load_ban_position($sel_banPosition); ?>
              		</select>
              	</div>
              	<div class="col-sm-2">
					<!-- <p class="help-block">Your help text!</p> -->
				</div>
            </div>
            <div class="form-group">
            	<label for="sel_banPage" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_BANNER_PAGE']; ?></label>
              	<div class="col-sm-8">
					<select class="form-control" name="sel_banPage" id="sel_banPage">
						<?php print $myPage->cmb_load_page($sel_banPage); ?>
					</select>
			  	</div>
            	<div class="col-sm-2">
					<!-- <p class="help-block">Your help text!</p> -->
				</div>
			</div>
			<div class="form-group">
				<label for="fileBan" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_FILE']; ?></label>
              	<div class="col-sm-8">
              		<input class="form-control1" name="fileBan" type="file" id="fileBan" />
              	</div>
            	<div class="col-sm-2">
					<p class="help-block">(JPG, PNG or GIF format)</p>
				</div>
			</div>
			<div class="form-group">
				<label for="ta_banDescr" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_DESCRIPTION']; ?></label>
				<div class="col-sm-8">
              		<textarea class="form-control1" name="ta_banDescr" id="ta_banDescr" style="height: 10em;"></textarea>
              	</div>
              	<div class="col-sm-2">
					<p class="help-block">(JPG, PNG or GIF format)</p>
				</div>
			</div>
            <div class="form-group">
				<label for="txt_banLink" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_URL']; ?></label>
              	<div class="col-sm-8">
              		<input class="form-control1" name="txt_banLink" id="txt_banLink" type="text" size="40" />
              	</div>
              	<div class="col-sm-2">
                	<!-- <p class="help-block">Your help text!</p> -->
				</div>
			</div>
			<div class="form-group">
              	<label for="" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_EXP-DATE']; ?></label>
              	<div class="col-sm-8">
              		<?php print $myBanner->combo_dateFr(); ?>
              	</div>
				<div class="col-sm-2">
					<!-- <p class="help-block">Your help text!</p> -->
              	</div>
			</div>
			<div class="panel-footer">
				<div class="row">
					<div class="col-sm-8 col-sm-offset-2">
						<button name="btnBanOk" type="submit" id="btnBanOk" class="btn-success btn"><?php print $mod_lang_output['FORM_BUTTON_ADD_BANNER']; ?></button>
					</div>
				</div>
			</div>
        </form>
        <?php } ?>
        
        <!-- *********************************** MODIFIER UNE BANNIERE ******************************
*************************************************************************************************** -->
      <?php if($_REQUEST['what'] == 'bannerUpdate') { $tabBanner = $myBanner->get_banner($_REQUEST[$myBanner->URI_bannerVar]); ?>
        <h3><?php print $mod_lang_output['MODULE_NAME']; ?> :: <?php print $mod_lang_output['PAGE_HEADER_UPDATE_BANNER']; ?></h3>
        <?php if(isset($ban_update_err_msg)) {  ?>
	      <div class="ADM_err_msg"><?php print $ban_update_err_msg; ?></div>
	    <?php } ?>
	    <?php if(isset($ban_update_cfrm_msg)) {  ?>
	      <div class="ADM_cfrm_msg"><?php print $ban_update_cfrm_msg; ?></div>
	    <?php } ?>
        <form class="form-horizontal" action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
			<div class="form-group">
				<label for="sel_banPositionUpd" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_BANNER_POSITION']; ?></label>
				<div class="col-sm-8">
	              	<select class="form-control" name="sel_banPositionUpd" id="sel_banPositionUpd">
	              		<?php print $myBanner->cmb_load_ban_position($tabBanner["POSITION_ID"]); ?>
	              	</select>
              	</div>
              	<div class="col-sm-2">
					<!-- <p class="help-block">Your help text!</p> -->
              	</div>
            </div>
            
            <div class="form-group">
				<label for="sel_banPositionUpd" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_BANNER_PAGE']; ?></label>
              	<div class="col-sm-8">
					<select class="form-control" name="sel_banPageUpd" id="sel_banPageUpd">
						<?php print $myPage->cmb_load_page($tabBanner["PAGE_ID"]); ?>
					</select>
			  	</div>
			  	<div class="col-sm-2">
					<!-- <p class="help-block">Your help text!</p> -->
              	</div>
            </div>
            
            <div class="form-group">
              	<label for="fileBanUpd" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_FILE']; ?></label>
              	<div class="col-sm-8">
	              	<input class="form-control1" name="fileBanUpd" type="file" id="fileBanUpd" />
	              	<input name="hd_fileBan" type="hidden" id="hd_fileBan" value="<?php print $tabBanner["FILE"]; ?>" />
	              	<input name="hd_banId" type="hidden" id="hd_banId" value="<?php print $tabBanner["ID"]; ?>" />
              	</div>
            	<div class="col-sm-2">
					<p class="help-block">NB : JPG, PNG or GIF format</p>
              	</div>
            </div>
            
           	<div class="form-group">
				<label for="ta_banDescrUpd" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_DESCRIPTION']; ?></label>
				<div class="col-sm-8">
					<textarea class="form-control1 ta-wide" name="ta_banDescrUpd" id="ta_banDescrUpd" style="height:10em;"><?php print $tabBanner["DESCR"]; ?></textarea>
				</div>
				<div class="col-sm-2">
					<!-- <p class="help-block">Your help text!</p> -->
              	</div>
			</div>
			
			<div class="form-group">
            	<label for="txt_banLinkUpd" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_URL']; ?></label>
            	<div class="col-sm-8">
					<input class="form-control1" name="txt_banLinkUpd" id="txt_banLinkUpd" type="text" size="40" value=<?php print stripslashes($tabBanner["LINK"]); ?> />
				</div>
				<div class="col-sm-2">
					<!-- <p class="help-block">Your help text!</p> -->
              	</div>
            </div>
            
            <div class="form-group">
              	<label for="" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_EXP-DATE']; ?></label>
              	<div class="col-sm-8">
					<?php print $myBanner->combo_dateFrUpd($tabBanner["DATE_EXPIRE"]); ?>
              	</div>
              	<div class="col-sm-2">
					<!-- <p class="help-block">Your help text!</p> -->
              	</div>
            </div>
            
            <div class="form-group">
            	<label for="chk_banDisplayUpd" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_DISPLAY']; ?></label>
              	<div class="col-sm-8">
              		<input <?php print $checked =(($tabBanner["DISPLAY"] == "1")?(" CHECKED"):("")); ?> name="chk_banDisplayUpd" type="checkbox" id="chk_banDisplayUpd" value="1" />
              	</div>
              	<div class="col-sm-2">
					<!-- <p class="help-block">Your help text!</p> -->
              	</div>
            </div>
            
			<div class="panel-footer">
				<div class="row">
					<div class="col-sm-8 col-sm-offset-2">
						<button name="btnBanOkUpd" type="submit" id="btnBanOkUpd" class="btn-success btn"><?php print $mod_lang_output['FORM_BUTTON_UPDATE_BANNER']; ?></button>
					</div>
				</div>
			</div>
        </form>
        <?php } ?>
        
<!-- *********************************** AFFICHER LES BANNIERES ***************************************
*************************************************************************************************** -->
        <?php if(!isset($_REQUEST[what]) || ($_REQUEST[what] == "bannerDisplay")) { ?>
		<a name="bannerDisplay"></a>
		<h3><?php print $mod_lang_output['MODULE_NAME']; ?> :: <?php print $mod_lang_output['PAGE_HEADER_LIST_BANNERS']; ?></h3>
		<?php if(isset($banner_display_err_msg)) { ?>
			<div class="ADM_err_msg"><?php print $banner_display_err_msg;  ?></div>
		<?php } ?>
		<?php if(isset($banner_display_cfrm_msg)) { ?>
			<div class="ADM_cfrm_msg"><?php print $banner_display_cfrm_msg; ?></div>
		<?php } ?>
			
			<div class="panel panel-warning" data-widget="{&quot;draggable&quot;: &quot;false&quot;}" data-widget-static="">
				
          		<div class="panel-body no-padding">
          				<span style="float:right;"><a title="<?php print $mod_lang_output['FORM_BUTTON_ADD_BANNER']; ?>" href="?what=bannerInsert"><?php print $system->admin_button('insert'); ?></a></span>
						<?php print $myBanner->tbl_load_banners(); ?>
				</div>
			</div>			
		
		<?php } ?>
		
		<!-- *********************************** AFFICHER LES POSITIONS DES BANNIERES ***************************************
*************************************************************************************************** -->
        <?php if($_REQUEST[what] == "bpDisplay") { ?>
		<a name="bannerDisplay"></a>
		<h3>Display banners positions</h3>
		<?php if(isset($bp_display_err_msg)) { ?>
			<div class="ADM_err_msg"><?php print $bp_display_err_msg;  ?></div>
		<?php } ?>
		<?php if(isset($bp_display_cfrm_msg)) { ?>
			<div class="ADM_cfrm_msg"><?php print $bp_display_cfrm_msg; ?></div>
		<?php } ?>
	
			<table class="table table-borderd">
				<caption>&nbsp;</caption>
				<tr>
					<th>N&ordm;</th>
					<th>Banner position</th>
				</tr>
				<?php print $myBanner->tbl_load_banners_positions(); ?>
			</table>
		
		<?php } ?>
 <?php include_once('inc/admin_footer.php'); ?>