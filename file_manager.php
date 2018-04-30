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
	require_once("../modules/file/library/file.inc.php");
	$system		= new cwd_system();
	$file		= new cwd_file();
	$system->db_connect($thewu32_host, $thewu32_db, $thewu32_user, $thewu32_pass);
	$system->session_checker($_SESSION["CONNECTED_ADMIN"], $_SESSION["CONNECTED_EDIT"]);
?>

<?php
//Site settings
$settings 		= 	$system->get_site_settings();

//Language settings
$langFile	= isset($_SESSION[LANG]) ? ($_SESSION[LANG]) : ($settings["LANG"]);

//Call the language file pack
require_once("../scripts/langfiles/".$langFile.".php");  //Global language pack
require_once("../modules/file/langfiles/".$langFile.".php"); //Module language pack

//Page name
$admin_pageTitle	=	$mod_lang_output['MODULE_DESCR'];
?>

<?php 
	require_once('../modules/file/inc/file_validations.php');	
	$file->spry_ds_create();
?>
<?php 
	ob_end_flush();
?>

<?php include_once('inc/admin_header.php');?>

        	<!-- ********************************* Ajouter les categories de fichiers  ***************************************
      ****************************************************************************************************************-->
      <?php if($_REQUEST[what]=="fileCatInsert"){ ?>
      <h3><?php print $mod_lang_output['MODULE_NAME']; ?> :: <?php print $mod_lang_output['PAGE_HEADER_ADD_FILE_CATEGORY']; ?></h3>
      
      <?php if(isset($rub_insert_err_msg)) {  ?>
      <div class="ADM_err_msg"><?php print $rub_insert_err_msg; ?></div>
      <?php } ?>
      <?php if(isset($rub_insert_cfrm_msg)) {  ?>
      <div class="ADM_cfrm_msg"><?php print $rub_insert_cfrm_msg; ?></div>
      <?php } ?>
      <div class="tab-content">
		<div class="tab-pane active" id="horizontal-form">
              <form class="form-horizontal" id="frm_rub_insert" name="frm_rub_insert" method="post" action="">
              	<div class="form-group">
                	<label for="selLang" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_LANGUAGE']; ?></label>
                    <div class="col-sm-8">
                       	<select class="form-control" name="selLang" id="selLang">
							<?php print $file->cmb_showLang($_POST[selLang]); ?>
                        </select>
                    </div>
                    <div class="col-sm-2">
                       	<!-- <p class="help-block">Your help text!</p> -->
                    </div>
                 </div>
              	<div class="form-group">
					<label for="txt_cat_id" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_CODE']; ?></label>
					<div class="col-sm-8">
						<input name="txt_cat_id"  type="text" class="form-control1" id="focusedinput" placeholder="<?php print $mod_lang_output['FORM_LABEL_CODE']; ?>" value="<?php print $file->show_content($rub_insert_err_msg, $txt_cat_id) ?>" maxlength="4" />
					</div>
					<div class="col-sm-2">
						<p class="help-block">04 <?php print $mod_lang_output['FORM_HELP_CRT_MAX']; ?></p>
					</div>
				</div>
                <div class="form-group">
					<label for="txt_cat_lib" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_LABEL']; ?></label>
					<div class="col-sm-8">
						<input name="txt_cat_lib"  type="text" class="form-control1" id="focusedinput" placeholder="<?php print $mod_lang_output['FORM_LABEL_LABEL']; ?>" value="<?php print $file->show_content($rub_insert_err_msg, $txt_cat_lib) ?>" />
					</div>
					<div class="col-sm-2">
						<!-- <p class="help-block">Your help text!</p> -->
					</div>
				</div>
                <div class="form-group">
					<label for="ta_cat_descr" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_DESCRIPTION']; ?></label>
					<div class="col-sm-8">
						<textarea class="form-control1 ta-wide" name="ta_cat_descr" cols="50" rows="25" id="ta_cat_descr"><?php print $file->show_content($rub_insert_err_msg, $ta_cat_descr) ?></textarea>
					</div>
					<div class="col-sm-2">
						<!-- <p class="help-block">04 Caracters Max</p> -->
					</div>
				</div>
                <div class="panel-footer">
                <div class="row">
                    <div class="col-sm-8 col-sm-offset-2">
                        <button name="btn_cat_insert" class="btn-success btn"><?php print $mod_lang_output['FORM_BUTTON_ADD_CATEGORY']; ?></button>
                    </div>
                </div>
             </div>
             <!--
                <table class="ADM_form">
                  <tr>
                    <th align="right">Code :<br />
                      (04 car. Max) </th>
                    <td><input name="txt_cat_id" type="text" id="txt_cat_id" value="<?php //print $file->show_content($rub_insert_err_msg, $txt_cat_id) ?>" size="10" maxlength="4" /></td>
                  </tr>
                  <tr>
                    <th align="right">Title : </th>
                    <td><input name="txt_cat_lib" type="text" id="txt_cat_lib" value="<?php //print $file->show_content($rub_insert_err_msg, $txt_cat_lib) ?>" size="40" /></td>
                  </tr>
                  <tr>
                    <th align="right">Description : </th>
                    <td><textarea name="ta_cat_descr" cols="40" rows="5" id="ta_cat_descr"><?php //print $file->show_content($rub_insert_err_msg, $ta_cat_descr) ?></textarea></td>
                  </tr>
                  <tr>
                    <td align="right">&nbsp;</td>
                    <td><input type="submit" value=" Add the category " name="btn_cat_insert" id="btn_cat_insert" /></td>
                  </tr>
                </table> -->
              </form>
             </div>
         </div>
      <?php } ?>
      
      <!-- ********************************* Afficher les categories de fichiers  ***************************************
      ****************************************************************************************************************-->
      <div class="col-sm-6">
	      <?php if($_REQUEST[what]=="fileCatDisplay") { ?>
	          <h3><?php print $mod_lang_output['MODULE_NAME']; ?> :: <?php print $lang_output['PAGE_HEADER_LIST_CATEGORIES']; ?></h3>
	          
	          <?php if(isset($rub_display_err_msg)) {  ?>
	          <div class="ADM_err_msg"><?php print $rub_display_err_msg; ?></div>
	          <?php } ?>
	          <?php if(isset($rub_display_cfrm_msg)) {  ?>
	          <div class="ADM_cfrm_msg"><?php print $rub_display_cfrm_msg; ?></div>
	          <?php } ?>
	          <div class="panel panel-warning" data-widget="{&quot;draggable&quot;: &quot;false&quot;}" data-widget-static="">
	          	<div class="panel-body no-padding">
	          		<?php print $file->admin_load_filescat(); ?>
	            </div>
	         </div>
	      <?php } ?>
      </div>
      
      <!-- ********************************* Modifier les categories de fichiers  ***************************************
      ****************************************************************************************************************-->
      <div class="col-sm-6">
	      <?php if(($_REQUEST[what]=="fileCatDisplay") && (isset($rub_displayUpd))){ ?>
	      <h3><?php print $mod_lang_output['PAGE_HEADER_UPDATE_FILE_CATEGORY']; ?></h3>
	      
	      <?php if(isset($rub_update_err_msg)) {  ?>
	      <div class="ADM_err_msg"><?php print $rub_update_err_msg; ?></div>
	      <?php } ?>
	      <?php if(isset($rub_update_cfrm_msg)) {  ?>
	      <div class="ADM_cfrm_msg"><?php print $rub_update_cfrm_msg; ?></div>
	      <?php } ?>
	      <div class="tab-content">
			<div class="tab-pane active" id="horizontal-form">
	              <form class="form-horizontal" id="frm_cat_update" name="frm_cat_update" method="post" action="">
	                <div class="form-group">
						<label for="txt_cat_lib_upd" class="col-sm-2 control-label"><?php print $lang_output['FORM_LABEL_LABEL']; ?></label>
						<div class="col-sm-8">
							<input name="txt_cat_lib_upd"  type="text" class="form-control1" id="focusedinput" placeholder="<?php print $lang_output['FORM_LABEL_LABEL']; ?>" value="<?php print $tabCatUpd[fileCATLIB]; ?>" />
						</div>
						<div class="col-sm-2">
							<!-- <p class="help-block">Your help text!</p> -->
						</div>
					</div>
	                <div class="form-group">
						<label for="ta_cat_descr_upd" class="col-sm-2 control-label"><?php print $lang_output['FORM_LABEL_DESCRIPTION']; ?></label>
						<div class="col-sm-8">
							<textarea class="form-control1 ta-wide" name="ta_cat_descr_upd" cols="50" rows="25" id="ta_cat_descr_upd"><?php print $tabCatUpd[fileCATDESCR]; ?></textarea>
	                        <input type="hidden" name="hd_cat_id" value="<?php print $_REQUEST['catId']; ?>" />
						</div>
						<div class="col-sm-2">
							<!-- <p class="help-block">04 Caracters Max</p> -->
						</div>
					</div>
	                <div class="panel-footer">
	                <div class="row">
	                    <div class="col-sm-8 col-sm-offset-2">
	                        <button name="btn_cat_upd" class="btn-success btn"><?php print $lang_output['FORM_BUTTON_UPDATE_CATEGORY']; ?></button>
	                    </div>
	                </div>
	             </div>
	              </form>
	             </div>
	         </div>
	         <p>&nbsp;</p><p>&nbsp;</p>
	      <?php } ?>
      </div>
      
      <!-- ********************************* Ajouter les fichiers  ***************************************
      ****************************************************************************************************************-->
      <?php if($_REQUEST[what]=="fileInsert") { ?>
      <?php $currentLang = (($_REQUEST[langId] != '') ? ($_REQUEST[langId]) : ($_SESSION['LANG'])); ?>
      
      <h3><?php print $mod_lang_output['MODULE_NAME']; ?> :: <?php print $mod_lang_output['PAGE_HEADER_ADD_FILE']; ?></h3>
      
      <?php if(isset($file_insert_err_msg)) {  ?>
      <div class="ADM_err_msg"><?php print $file_insert_err_msg; ?></div>
      <?php } ?>
      <?php if(isset($file_insert_cfrm_msg)) {  ?>
      <div class="ADM_cfrm_msg"><?php print $file_insert_cfrm_msg; ?></div>
      <?php } ?>
      
      <div class="tab-content">
		<div class="tab-pane active" id="horizontal-form">
              <form class="form-horizontal" action="" method="post" enctype="multipart/form-data" name="frm_file_insert" id="frm_file_insert">
              	<div class="form-group">
					<label for="file_selLang" class="col-sm-2 control-label"><?php print $lang_output['FORM_LABEL_LANGUAGE']; ?></label>
					<div class="col-sm-8">
                        <select class="form-control"  name="file_selLang" id="jumpMenu" onChange="MM_jumpMenu('parent',this,0)">
							<?php print stripslashes($file->redir_cmb_load_langs($_REQUEST[langId], $file->admin_modPage, "fileInsert")); ?>
                          </select>
                          <input name="file_hdLang" type="hidden" value="<?php print $_REQUEST[langId];?>" />
					</div>
					<div class="col-sm-2">
						<!-- <p class="help-block">Your help text!</p> -->
					</div>
				</div>
                <div class="form-group">
					<label for="file_selCat" class="col-sm-2 control-label"><?php print $lang_output['FORM_LABEL_CATEGORY']; ?></label>
					<div class="col-sm-8">
                        <select name="file_selCat" id="file_selCat" class="form-control">
                        	<?php print $file->admin_cmb_show_rub_by_lang($currentLang, $_POST[file_selCat]); ?>
                        </select>
					</div>
					<div class="col-sm-2">
						<!-- <p class="help-block">Your help text!</p> -->
					</div>
				</div>
                <div class="form-group">
					<label for="txt_file_title" class="col-sm-2 control-label"><?php print $lang_output['FORM_LABEL_TITLE']; ?></label>
					<div class="col-sm-8">
                        <input class="form-control1" placeholder="<?php print $lang_output['FORM_LABEL_TITLE']; ?>..."  name="txt_file_title" type="text" value="<?php print $file->show_content($file_insert_err_msg, $txt_file_title) ?>" id="txt_file_title" />
					</div>
					<div class="col-sm-2">
						<!-- <p class="help-block">Your help text!</p> -->
					</div>
				</div>
                <div class="form-group">
					<label for="ta_file_descr" class="col-sm-2 control-label"><?php print $lang_output['FORM_LABEL_DESCRIPTION']; ?></label>
					<div class="col-sm-8">
                        <textarea class="form-control1 ta-wide" name="ta_file_descr" cols="50" rows="25" id="ta_file_descr"><?php print $file->show_content($file_insert_err_msg, $ta_file_descr) ?></textarea>
					</div>
					<div class="col-sm-2">
						<!-- <p class="help-block">04 Caracters Max</p> -->
					</div>
				</div>
                <div class="form-group">
					<label for="fileUrl" class="col-sm-2 control-label"><?php print $lang_output['FORM_LABEL_FILE']; ?></label>
					<div class="col-sm-8">
                        <input class="form-control1" type="file" name="fileUrl" id="fileUrl" />
					</div>
					<div class="col-sm-2">
						<!-- <p class="help-block">04 Caracters Max</p> -->
					</div>
				</div>
                <div class="panel-footer">
                <div class="row">
                    <div class="col-sm-8 col-sm-offset-2">
                        <button name="btn_file_insert" class="btn-success btn"><?php print $mod_lang_output['FORM_BUTTON_ADD_FILE']; ?></button>
                    </div>
                </div>
             </div>
              </form>
             </div>
         </div>
         
      <?php } ?>
      
      <!-- ********************************* Afficher les fichiers  ***************************************
      ****************************************************************************************************************-->
      <?php if(!isset($_REQUEST[what]) || ($_REQUEST[what]=="fileDisplay")) { ?>
          <h3><?php print $mod_lang_output['MODULE_NAME']; ?> :: <?php print $mod_lang_output['PAGE_HEADER_LIST_FILES']; ?></h3>
          
          <?php if(isset($file_display_err_msg)) {  ?>
          <div class="ADM_err_msg"><?php print $file_display_err_msg; ?></div>
          <?php } ?>
          <?php if(isset($file_display_cfrm_msg)) {  ?>
          <div class="ADM_cfrm_msg"><?php print $file_display_cfrm_msg; ?></div>
          <?php } ?>
          <?php $file->limit = $_REQUEST[limite]; ?>
          <div class="panel panel-warning" data-widget="{&quot;draggable&quot;: &quot;false&quot;}" data-widget-static="">
          	<div class="panel-body no-padding">
         	 <?php print $file->admin_load_files(100); ?>
            </div>
          </div>
      <?php } ?>
      
     
     <!-- ********************************* Modifier les fichiers  ***************************************
      ****************************************************************************************************************--> 
      <?php 
      	if($_REQUEST[what] == "fileUpdate") { // Si on a clique sur modifier le fichier... 
	  		/*$tabUpd	= $file->get_file($_REQUEST[$file->mod_queryKey]);*/
	  ?>
      <h3><?php print $mod_lang_output['MODULE_NAME']; ?> :: <?php print $mod_lang_output['PAGE_HEADER_UPDATE_FILE']; ?></h3>
      <?php if(isset($file_update_err_msg)) { ?>
      <div class="ADM_err_msg"><?php print $file_update_err_msg; ?></div>
      <?php } ?>
      <?php if(isset($file_update_cfrm_msg)) { ?>
      <div class="ADM_cfrm_msg"><?php print $file_update_cfrm_msg; ?></div>
      <?php } ?>
      
      <div class="tab-content">
		<div class="tab-pane active" id="horizontal-form">
              <form class="form-horizontal" action="" method="post" enctype="multipart/form-data" name="frm_file_update" id="frm_file_update">
                <div class="form-group">
					<label for="file_selCatUpd" class="col-sm-2 control-label"><?php print $lang_output['FORM_LABEL_TITLE']; ?></label>
					<div class="col-sm-8">
                        <select name="file_selLangUpd" id="file_selLangUpd" class="form-control">
							<?php print $file->cmb_showLangUpd($tabUpd["fileLANGID"]); ?>
                         </select>
					</div>
					<div class="col-sm-2">
						<!-- <p class="help-block">Your help text!</p> -->
					</div>
				</div>
                <div class="form-group">
					<label for="file_selCatUpd" class="col-sm-2 control-label"><?php print $lang_output['FORM_LABEL_CATEGORY']; ?></label>
					<div class="col-sm-8">
                        <select name="file_selCatUpd" id="file_selCatUpd" class="form-control">
							<?php print $file->admin_cmb_show_rub($tabUpd["fileCATID"]); ?>
                         </select>
					</div>
					<div class="col-sm-2">
						<!-- <p class="help-block">Your help text!</p> -->
					</div>
				</div>
                <div class="form-group">
					<label for="txt_file_title_upd" class="col-sm-2 control-label"><?php print $lang_output['FORM_LABEL_TITLE']; ?></label>
					<div class="col-sm-8">
                    	<input class="form-control1" name="txt_file_title_upd" type="text" value="<?php print stripslashes($tabUpd["fileTITLE"]); ?>" id="txt_file_title_upd" />
					</div>
					<div class="col-sm-2">
						<!-- <p class="help-block">Your help text!</p> -->
					</div>
				</div>
                <div class="form-group">
					<label for="ta_file_descr_upd" class="col-sm-2 control-label"><?php print $lang_output['FORM_LABEL_DESCRIPTION']; ?></label>
					<div class="col-sm-8">
                        <input type="hidden" name="hd_file_url" value="<?php print $tabUpd["fileURL"]; ?>" />
            			<textarea class="form-control1 ta-wide" name="ta_file_descr_upd" cols="40" rows="5" id="ta_file_descr_upd"><?php print stripslashes($tabUpd["fileDESCR"]); ?></textarea>
					</div>
					<div class="col-sm-2">
						<!-- <p class="help-block">04 Caracters Max</p> -->
					</div>
				</div>
                <div class="form-group">
					<label for="fileUrlUpd" class="col-sm-2 control-label"><?php print $lang_output['FORM_LABEL_FILE']; ?></label>
					<div class="col-sm-8">
                        <input class="form-control1" type="file" name="fileUrlUpd" id="fileUrlUpd" />
					</div>
					<div class="col-sm-2">
						<!-- <p class="help-block">04 Caracters Max</p> -->
					</div>
				</div>
                <div class="panel-footer">
                <div class="row">
                    <div class="col-sm-8 col-sm-offset-2">
                    	<input type="hidden" name="hd_file_id" value="<?php print $_REQUEST[pmId]; ?>" />
            			<input type="hidden" name="hd_file_display" value="<?php print $tabUpd["fileDISPLAY"]; ?>" />
                        <button name="btn_file_upd" class="btn-success btn"><?php print $mod_lang_output['FORM_BUTTON_UPDATE_FILE']; ?></button>
                    </div>
                </div>
             </div>
              </form>
             </div>
         </div>
      
     
      <?php } ?>

      
<?php include_once('inc/admin_footer.php');?>
