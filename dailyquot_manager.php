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
	require_once("../modules/dailyquot/library/dailyquot.inc.php");
	$system		= new cwd_system();
	$dailyquot	= new cwd_dailyquot();
	$myRss		= new cwd_rss091();
	$dailyquot->db_connect($thewu32_host, $thewu32_db, $thewu32_user, $thewu32_pass);
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
	require_once("../modules/dailyquot/langfiles/".$langFile.".php"); //Module language pack
	
	//Page name
	$admin_pageTitle	=	$mod_lang_output['MODULE_DESCR'];
	
	//Spry
	$dailyquot->spry_ds_create();
?>

<?php
	$myRss->set_rss_tblInfos($dailyquot->tbl_dailyquot, $dailyquot->fld_dailyquotId, $dailyquot->fld_dailyquotTitle, $dailyquot->fld_dailyquotLib, $dailyquot->fld_dailyquotAuthor, $dailyquot->fld_dailyquotDatePub, $dailyquot->tbl_dailyquotAuthor, $dailyquot->fld_dailyquotAuthorF, $dailyquot->fld_dailyquotAuthorL);
	$myRss->set_rss_link_param($dailyquot->URI_dailyquot, $thewu32_modLink['dailyquot'], $thewu32_modLink['dailyquot']);
	$myRss->rss_customize_layout("CABB :: Verset biblique du jour", "Tous les versets bibliques du jour selon le CABB", $thewu32_site_url.'modules/dailyquot/img/rss_dailyquots.gif', "Versets du jour", "CABB :: Versets du Jour", "");
	//$myRss->se
	$myRss->makeRSS("../modules/dailyquot/rss/dailyquots.xml");
	$admin_pageTitle	=	"Gestionnaire des Citations";
?>

<?php 
	require_once('../modules/dailyquot/inc/dailyquot_validations.php');
?>

<?php 
	ob_end_flush();
?>

<?php include_once('inc/admin_header.php');?>
	        	
      
      
      <!-- ********************************* Inserer les categories de dailyquots  ******************************************************
      ****************************************************************************************************************-->
      <?php if($_REQUEST[what]=="dailyquotCatInsert"){ ?>
      <h3><?php print $mod_lang_output['MODULE_NAME']; ?> :: <?php print $mod_lang_output['PAGE_HEADER_ADD_DAILYQUOT_CATEGORY']; ?></h3>
      
      <?php if(isset($rub_insert_err_msg)) {  ?>
      <div class="ADM_err_msg"><?php print $rub_insert_err_msg; ?></div>
      <?php } ?>
      <?php if(isset($rub_insert_cfrm_msg)) {  ?>
      <div class="ADM_cfrm_msg"><?php print $rub_insert_cfrm_msg; ?></div>
      <?php } ?>
      	<form class="form-horizontal" id="frm_rub_insert" name="frm_rub_insert" method="post" action="">
			<div class="form-group">
              	<label for="dailyquot_selLang" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_LANGUAGE']; ?></label>
              	<div class="col-sm-8">
            		<select class="form-control" name="dailyquot_selLang" id="dailyquot_selLang">
                		<?php print $dailyquot->cmb_showLang($_POST[dailyquot_selLang]); ?>
              		</select>
              	</div>
              	<div class="col-sm-2">
					<!-- <p class="help-block"> Help text here</p> --> 
              	</div>
			</div>
			
			<div class="form-group">
            	<label for="txt_cat_id" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_CODE']; ?></label>
            	<div class="col-sm-8">
					<input class="form-control1" name="txt_cat_id" type="text" id="txt_cat_id" value="" size="3" />
            	</div>
              	<div class="col-sm-2">
					<p class="help-block"> (03 <?php print $mod_lang_output['FORM_HELP_CRT_MAX']; ?>)</p> 
              	</div>
			</div>
			
			<div class="form-group">
          		<label for="txt_cat_lib" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_LABEL']; ?></label>
          		<div class="col-sm-8">
            		<input class="form-control1" name="txt_cat_lib" type="text" id="txt_cat_lib" value="" size="40" />
            	</div>
            	<div class="col-sm-2">
					<!-- <p class="help-block"> Help text here</p> --> 
              	</div>
			</div>
			
			<div class="panel-footer">
				<div class="row">
					<div class="col-sm-8 col-sm-offset-2">
						<input type="hidden" name="hd_cat_id" value="<?php print $tabCatUpd[dailyquotCATID]; ?>" />
						<button name="btn_cat_insert" type="submit" id="btn_cat_insert" class="btn-success btn"><?php print $mod_lang_output['FORM_BUTTON_ADD_CATEGORY']; ?></button>
					</div>
				</div>
			</div>
          
      </form>
      <?php } ?>
      
      <!-- ********************************* Afficher les categories de dailyquots  ******************************************************
      ****************************************************************************************************************-->
      <div class="col-sm-6">
	      <?php if($_REQUEST[what]=="dailyquotCatDisplay") { ?>
	          <h3><?php print $mod_lang_output['MODULE_NAME']; ?> :: <?php print $mod_lang_output['PAGE_HEADER_LIST_DAILYQUOT_CATEGORIES']; ?></h3>
	          
	          <?php if(isset($rub_display_err_msg)) {  ?>
	          <div class="ADM_err_msg"><?php print $rub_display_err_msg; ?></div>
	          <?php } ?>
	          <?php if(isset($rub_display_cfrm_msg)) {  ?>
	          <div class="ADM_cfrm_msg"><?php print $rub_display_cfrm_msg; ?></div>
	          <?php } ?>
	          	<div class="panel panel-warning" data-widget="{&quot;draggable&quot;: &quot;false&quot;}" data-widget-static="">
	          		<div class="panel-body no-padding">
	          			<?php print $dailyquot->admin_load_dailyquots_cat(); ?>
	          		</div>
	          	</div>
	      <?php } ?>
      </div>
      
      <!-- ********************************* Modifier les categories de dailyquots  ******************************************************
      ****************************************************************************************************************-->
      <div class="col-sm-6">
	      <?php if(($_REQUEST[what]=="dailyquotCatDisplay") && (isset($rub_displayUpd))){ ?>
	      <h3><?php print $mod_lang_output['PAGE_HEADER_UPDATE_DAILYQUOT_CATEGORY']; ?></h3>
	      
	      <?php if(isset($rub_update_err_msg)) {  ?>
	      <div class="ADM_err_msg"><?php print $rub_update_err_msg; ?></div>
	      <?php } ?>
	      <?php if(isset($rub_update_cfrm_msg)) {  ?>
	      <div class="ADM_cfrm_msg"><?php print $rub_update_cfrm_msg; ?></div>
	      <?php } ?>
	      
	      	<form class="form-horizontal" id="frm_cat_update" name="frm_cat_update" method="post" action="">
				<div class="form-group">
	              	<label for="dailyquot_selLangUpd" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_LANGUAGE']; ?></label>
	            	<div class="col-sm-8">
	            		<select class="form-control" name="dailyquot_selLangUpd" id="dailyquot_selLangUpd">
	                		<?php print $dailyquot->cmb_showLang($tabCatUpd[dailyquotCATLANG]); ?>
	              		</select>
	              	</div>
	              	<div class="col-sm-2">
						<!-- <p class="help-block"> Help text here</p> --> 
	              	</div>
	             </div>
	             
	             <div class="form-group">
	              	<label for="dailyquot_selLangUpd" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_LABEL']; ?></label>
	              	<div class="col-sm-8">
	            		<input class="form-control1" name="txt_cat_lib_upd" value="<?php print $tabCatUpd[dailyquotCATLIB]; ?>" type="text" id="txt_cat_lib_upd" size="30" />
	            	</div>
	            	<div class="col-sm-2">
						<!-- <p class="help-block"> Help text here</p> --> 
	              	</div>
	             </div>
	             
	          	<div class="panel-footer">
					<div class="row">
						<div class="col-sm-8 col-sm-offset-2">
							<input type="hidden" name="hd_cat_id" value="<?php print $tabCatUpd[dailyquotCATID]; ?>" />
							<button name="btn_cat_upd" type="submit" id="btn_cat_upd" class="btn-success btn"><?php print $mod_lang_output['FORM_BUTTON_UPDATE_CATEGORY']; ?></button>
						</div>
					</div>
				</div>
				
	          
	      </form>
	      <?php } ?>
      </div>
      
      
      
      
      <!-- ********************************* Inserer les dailyquotes  ******************************************************
      ****************************************************************************************************************-->
      <?php if($_REQUEST[what]=="dailyquotInsert") { ?>
      <?php $currentLang = (($_REQUEST[langId] != '') ? ($_REQUEST[langId]) : ($_SESSION['LANG'])); ?>
      <h3><?php print $mod_lang_output['MODULE_NAME']; ?> :: <?php print $mod_lang_output['PAGE_HEADER_ADD_DAILYQUOT']; ?></h3>
      
      <?php if(isset($dailyquot_insert_err_msg)) {  ?>
      <div class="ADM_err_msg"><?php print $dailyquot_insert_err_msg; ?></div>
      <?php } ?>
      <?php if(isset($dailyquot_insert_cfrm_msg)) {  ?>
      <div class="ADM_cfrm_msg"><?php print $dailyquot_insert_cfrm_msg; ?></div>
      <?php } ?>
      
		<form class="form-horizontal" action="" method="post" name="frm_dailyquot_insert" id="frm_dailyquot_insert">
			<div class="form-group">
	            <label for="dailyquot_selLang" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_LANGUAGE']; ?></label>
	            <div class="col-sm-8">
	              	<select class="form-control"  name="dailyquot_selLang" id="jumpMenu" onchange="MM_jumpMenu('parent',this,0)">
	      				<?php print stripslashes($dailyquot->redir_cmb_load_langs($_REQUEST['langId'], $dailyquot->admin_modPage, "dailyquotInsert")); ?>
	      		  	</select>
	      		  	<input name="dailyquot_hdLang" type="hidden" value="<?php print $_REQUEST[langId];?>" />
	            </div>
	            <div class="col-sm-2"><!-- <p class="help-block">Help text here</p> --></div>
			</div>
			
          	<div class="form-group">
	            <label for="dailyquot_selCat" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_CATEGORY']; ?></label>
	            <div class="col-sm-8">
		            <select class="form-control" name="dailyquot_selCat" id="dailyquot_selCat">
		                <?php print $dailyquot->admin_cmb_show_rub_by_lang($currentLang, $_POST[dailyquot_selCat]); ?>
		            </select>
				</div>
				<div class="col-sm-2">&nbsp;</div>
          	</div>
          	
          	<div class="form-group">
	            <label for="txt_dailyquot_title" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_TITLE']; ?></label>
	            <div class="col-sm-8">
	            	<input class="form-control1" name="txt_dailyquot_title" type="text" value="<?php print $dailyquot->show_content($dailyquot_insert_err_msg, $txt_dailyquot_title) ?>" id="txt_dailyquot_title" size="40" />
	            </div>
	            <div class="col-sm-2">&nbsp;</div>
          	</div>
          	
          	<div class="form-group">
	            <label for="ta_dailyquot_content" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_CONTENT']; ?></label>
	            <div class="col-sm-8">
	            	<textarea name="ta_dailyquot_content" cols="40" rows="5" id="ta_dailyquot_content"><?php print $dailyquot->show_content($dailyquot_insert_err_msg, $ta_dailyquot_content) ?></textarea>
	            	<script language="JavaScript1.2" type="text/javascript">
						generate_wysiwyg('ta_dailyquot_content');
		  			</script>
		  		</div>
		  		<div class="col-sm-2">&nbsp;</div>
          	</div>
          	
          	<div class="form-group">
	            <label for="" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_PUB-DATE']; ?></label>
	            <div class="col-sm-8">
	            	<?php print $dailyquot->combo_dateFr($_POST[cmbDay], $_POST[cmbMonth], $_POST[cmbYear]); ?>
	            </div>
	            <div class="col-sm-2">&nbsp;</div>
          	</div>
          	
          	<div class="panel-footer">
				<div class="row">
					<div class="col-sm-8 col-sm-offset-2">
						<button name="btn_dailyquot_insert" type="submit" id="btn_dailyquot_insert" class="btn-success btn"><?php print $mod_lang_output['FORM_BUTTON_ADD_DAILYQUOT']; ?></button>
					</div>
				</div>
			</div>
          	
      	</form>
      <?php } ?>
      
      <!-- ********************************* Afficher les dailyquots  ******************************************************
      ****************************************************************************************************************-->
      <?php if(!isset($_REQUEST[what]) || ($_REQUEST[what]=="dailyquotDisplay")) { ?>
          <h3><?php print $mod_lang_output['MODULE_NAME']; ?> :: <?php print $mod_lang_output['PAGE_HEADER_LIST_DAILYQUOTS']; ?></h3>
		  <?php $dailyquot->limit = $_REQUEST[limite]; ?>
          
          <?php if(isset($dailyquot_display_err_msg)) {  ?>
          <div class="ADM_err_msg"><?php print $dailyquot_display_err_msg; ?></div>
          <?php } ?>
          <?php if(isset($dailyquot_display_cfrm_msg)) {  ?>
          <div class="ADM_cfrm_msg"><?php print $dailyquot_display_cfrm_msg; ?></div>
          <?php } ?>
          
          	<div class="panel panel-warning" data-widget="{&quot;draggable&quot;: &quot;false&quot;}" data-widget-static="">
          		<div class="panel-body no-padding">
          			<?php print $dailyquot->admin_load_dailyquots(); ?>
          		</div>
          	</div>
      <?php } ?>
      
      
      <!-- ********************************* Modifier les daily quotes  ******************************************************
      ****************************************************************************************************************-->
      <?php 
      	if($_REQUEST[what] == "dailyquotUpdate") { // Si on a clique sur modifier le dailyquot... 
	  		$tabUpd	= $dailyquot->get_dailyquot($_REQUEST[$dailyquot->mod_queryKey]);
	  ?>
      <h3><?php print $mod_lang_output['MODULE_NAME']; ?> :: <?php print $mod_lang_output['PAGE_HEADER_UPDATE_DAILYQUOT']; ?></h3>
      <?php if(isset($dailyquot_update_err_msg)) { ?>
      <div class="ADM_err_msg"><?php print $dailyquot_update_err_msg; ?></div>
      <?php } ?>
      <?php if(isset($dailyquot_update_cfrm_msg)) { ?>
      <div class="ADM_cfrm_msg"><?php print $dailyquot_update_cfrm_msg; ?></div>
      <?php } ?>
      
		<form class="form-horizontal" id="frm_dailyquot_update" name="frm_dailyquot_update" method="post" action="">
		
			<div class="form-group">
	            <label for="dailyquot_selLangUpd" class="col-sm-2 control-label">Choisir la langue :</label>
	            <div class="col-sm-8">
	            	<select name="dailyquot_selLangUpd" id="dailyquot_selLangUpd">
	                	<?php print $dailyquot->cmb_showLang($tabUpd["dailyquotLANG"]); ?>
	              	</select>
				</div>
				<div class="col-sm-2"><!-- <p class="help-block">Your help text here</p> --></div>
          	</div>
          	
          	<div class="form-group">
	            <label for="dailyquot_selCatUpd" class="col-sm-2 control-label">Choisir la rubrique :</label>
	            <div class="col-sm-8">
	            	<select class="form-control" name="dailyquot_selCatUpd" id="dailyquot_selCatUpd">
	                	<?php print $dailyquot->admin_cmb_show_rub($tabUpd["dailyquotCATID"]); ?>
	              	</select>
	            </div>
	            <div class="col-sm-2">&nbsp;</div>
          	</div>
          	
          	<div class="form-group">
	            <label for="txt_dailyquot_title_upd" class="col-sm-2 control-label">Titre :</label>
	            <div class="col-sm-8">
	            	<input class="form-control1" name="txt_dailyquot_title_upd" type="text" value="<?php print stripslashes($tabUpd["dailyquotTITLE"]); ?>" id="txt_dailyquot_title_upd" size="40" />
	            </div>
	            <div class="col-sm-2">&nbsp;</div>
          	</div>
          	
          	<div class="form-group">
	            <label for="ta_dailyquot_content_upd" class="col-sm-2 control-label">Texte :</label>
	            <div class="col-sm-8">
	            	<textarea name="ta_dailyquot_content_upd" cols="40" rows="5" id="ta_dailyquot_content_upd"><?php print stripslashes($tabUpd["dailyquotLIB"]); ?></textarea>
	                <script language="JavaScript1.2" type="text/javascript">
						generate_wysiwyg('ta_dailyquot_content_upd');
			  		</script>
	            </div>
	            <div class="col-sm-2">&nbsp;</div>
          	</div>
          
          	<div class="form-group">
	            <label for="" class="col-sm-2 control-label">Date de publication :</label>
	            <div class="col-sm-8">
	            	<?php print $dailyquot->combo_dateFrUpd($tabUpd[dailyquotDATEPUB]); ?>
	            </div>
	            <div class="col-sm-2">&nbsp;</div>
          	</div>
          
          	<div class="panel-footer">
				<div class="row">
					<div class="col-sm-8 col-sm-offset-2">
						<input type="hidden" name="hd_dailyquot_id" value="<?php print $tabUpd["dailyquotID"]; ?>" /><input type="hidden" name="hd_date_pub" value="<?php print $tabUpd[dailyquotDATEPUB]; ?>" />
						<button name="btn_dailyquot_upd" type="submit" id="btn_dailyquot_upd" class="btn-success btn">Modifier la citation</button>
					</div>
				</div>
			</div>
          
      	</form>
      <?php } ?>
	  
<?php include_once('inc/admin_footer.php'); ?>
