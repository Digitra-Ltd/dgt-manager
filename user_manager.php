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
	require_once("../plugins/phpmailer/_lib/class.phpmailer.php");
	
	$system		= 	new cwd_system();
	$my_users	= 	new cwd_user();
	$my_users->db_connect($thewu32_host, $thewu32_db, $thewu32_user, $thewu32_pass);
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
	require_once("../scripts/langfiles/".$langFile.".php");  		//Global language pack
	require_once("../modules/user/langfiles/".$langFile.".php");	//Module language pack
	
	//Page name
	$admin_pageTitle	=	$mod_lang_output['MODULE_DESCR'];
?>
<?php 
	require_once ('../modules/user/inc/user_validations.php');
?>
<?php 
	ob_end_flush();
?>

<?php include_once('inc/admin_header.php');?>

        	<?php //print $my_users->admin_get_menu(); ?>
		  <!-- Ajouter les utilisateurs -->
	      <?php if($_REQUEST[what]=="userInsert") { ?>
	      <h3><?php print $mod_lang_output['MODULE_NAME']; ?> :: <?php print $mod_lang_output['PAGE_HEADER_ADD_USER']; ?></h3>
	      
	      <?php if(isset($user_insert_err_msg)) {  ?>
	      <div class="ADM_err_msg"><?php print $user_insert_err_msg; ?></div>
	      <?php } ?>
	      <?php if(isset($user_insert_cfrm_msg)) {  ?>
	      <div class="ADM_cfrm_msg"><?php print $user_insert_cfrm_msg; ?></div>
	      <?php } ?>
          
          <div class="tab-content">
			<div class="tab-pane active" id="horizontal-form">
              <form class="form-horizontal" action="" method="post" name="frm_user_insert" id="frm_user_insert">
                <div class="form-group">
					<label for="user_selCat" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_CATEGORY']; ?></label>
					<div class="col-sm-8">
                        <select class="form-control" name="user_selCat" id="user_selCat">
							<?php //print $my_users->combo_sel_row_2($my_users->tbl_userType, $my_users->fld_userTypeId, $my_users->fld_userTypeLib); ?>
                            <option value='1'><?php print $mod_lang_output['FORM_VALUE_CATEGORY_1']; ?></option>
                            <option value='2'><?php print $mod_lang_output['FORM_VALUE_CATEGORY_2']; ?></option>
                        </select>
					</div>
					<div class="col-sm-2">
						<!-- <p class="help-block">Your help text!</p> -->
					</div>
				</div>
                <div class="form-group">
					<label for="txt_file_title" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_USER-NAME']; ?></label>
					<div class="col-sm-8">
                    	<input class="form-control1" placeholder="login..." name="txt_user_login" id="txt_user_login" value="<?php print $my_users->show_content($user_insert_err_msg, $txt_user_login) ?>" />
					</div>
					<div class="col-sm-2">
						<p class="help-block redStar">*</p>
					</div>
				</div>
                <div class="form-group">
					<label for="txt_user_password1" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_PASSWORD']; ?></label>
					<div class="col-sm-8">
                        <input class="form-control1" type="password" name="txt_user_password1" id="txt_user_password1" />
					</div>
					<div class="col-sm-2">
						<p class="help-block redStar">*</p>
					</div>
				</div>
                <div class="form-group">
					<label for="txt_user_password2" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_PASSWORD2']; ?></label>
					<div class="col-sm-8">
                        <input class="form-control1" type="password" name="txt_user_password2" id="txt_user_password1" />
					</div>
					<div class="col-sm-2">
						<p class="help-block redStar">*</p>
					</div>
				</div>
                <div class="form-group">
					<label for="txt_user_email" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_E-MAIL']; ?></label>
					<div class="col-sm-8">
                        <input class="form-control1" name="txt_user_email" type="text" value="<?php print $my_users->show_content($user_insert_err_msg, $txt_user_email) ?>" id="txt_user_email" />
					</div>
					<div class="col-sm-2">
						<p class="help-block redStar">*</p>
					</div>
				</div>
                
                <p><br /></p>
                
                <div class="form-group">
					<label for="txt_user_last" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_LAST-NAME']; ?></label>
					<div class="col-sm-8">
                        <input class="form-control1" name="txt_user_last" type="text" value="<?php print $my_users->show_content($user_insert_err_msg, $txt_user_last) ?>" id="txt_user_last" />
					</div>
					<div class="col-sm-2">
						<!-- <p class="help-block">04 Caracters Max</p> -->
					</div>
				</div>
                <div class="form-group">
					<label for="txt_user_first" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_FIRST-NAME']; ?></label>
					<div class="col-sm-8">
                        <input class="form-control1" name="txt_user_first" type="text" value="<?php print $my_users->show_content($user_insert_err_msg, $txt_user_first) ?>" id="txt_user_first" />
					</div>
					<div class="col-sm-2">
						<!-- <p class="help-block">04 Caracters Max</p> -->
					</div>
				</div>
                <div class="form-group">
					<label for="txt_user_telephone" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_PHONE-NUMBER']; ?></label>
					<div class="col-sm-8">
                        <input class="form-control1" name="txt_user_telephone" type="text" value="<?php print $my_users->show_content($user_insert_err_msg, $txt_user_telephone) ?>" id="txt_user_telephone" />
					</div>
					<div class="col-sm-2">
						<!-- <p class="help-block">04 Caracters Max</p> -->
					</div>
				</div>
                <div class="form-group">
					<label for="chk_user_display" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_ACCOUNT_ACTIVATE']; ?></label>
					<div class="col-sm-8">
                        <input name="chk_user_display" type="checkbox" id="chk_user_display" value="1" checked="checked" />
					</div>
					<div class="col-sm-2">
						<!-- <p class="help-block">04 Caracters Max</p> -->
					</div>
				</div>
                <div class="panel-footer">
                <div class="row">
                    <div class="col-sm-8 col-sm-offset-2">
                        <button name="btn_user_insert" class="btn-success btn"><?php print $mod_lang_output['FORM_LABEL_ADD_USER']; ?></button>
                    </div>
                </div>
             </div>
              </form>
             </div>
         </div>

	      <?php } ?>
	      
	      <!-- ********************************* Modifier les types de compte ******************************************************
	      ****************************************************************************************************************-->
	      <?php if(isset($rub_displayUpd)){ ?>
	      <h3><?php print $mod_lang_output['MODULE_NAME']; ?> :: <?php print $mod_lang_output['PAGE_HEADER_UPDATE_USER_CATEGORY']; ?></h3>
	      
	      <?php if(isset($rub_update_err_msg)) {  ?>
	      <div class="ADM_err_msg"><?php print $rub_update_err_msg; ?></div>
	      <?php } ?>
	      <?php if(isset($rub_update_cfrm_msg)) {  ?>
	      <div class="ADM_cfrm_msg"><?php print $rub_update_cfrm_msg; ?></div>
	      <?php } ?>
          
          <div class="tab-content">
			<div class="tab-pane active" id="horizontal-form">
              <form class="form-horizontal" action="" method="post" id="frm_rub_insert" name="frm_rub_insert">
                <div class="form-group">
					<label for="txt_cat_lib_upd" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_CATEGORY']; ?></label>
					<div class="col-sm-8">
                    	<input class="form-control1" name="txt_cat_lib_upd" value="<?php print $tab_userCatUpd["ut_LIB"]; ?>" type="text" id="txt_cat_lib_upd" />
					</div>
					<div class="col-sm-2">
						<p class="help-block redStar">*</p>
					</div>
				</div>
                <div class="panel-footer">
                <div class="row">
                    <div class="col-sm-8 col-sm-offset-2">
                        <button name="btn_cat_upd" id="btn_cat_upd" class="btn-success btn"><?php print $mod_lang_output['FORM_BUTTON_UPDATE']; ?></button>                       
                        <input type="hidden" name="hd_cat_id" value="<?php print $tab_userCatUpd["ut_ID"]; ?>" />
                    </div>
                </div>
             </div>
              </form>
             </div>
         </div>
          
         
	      <?php } ?>
	      
	      <!-- Afficher les categories (types de comptes) -->
	      <?php if($_REQUEST[what]=="userCatDisplay") { ?>
	          <h3><?php print $mod_lang_output['MODULE_NAME']; ?> :: <?php print $mod_lang_output['PAGE_HEADER_LIST_USERS_CATEGORIES']; ?></h3>
	          
	          <?php if(isset($rub_display_err_msg)) {  ?>
	          <div class="ADM_err_msg"><?php print $rub_display_err_msg; ?></div>
	          <?php } ?>
	          <?php if(isset($rub_display_cfrm_msg)) {  ?>
	          <div class="ADM_cfrm_msg"><?php print $rub_display_cfrm_msg; ?></div>
	          <?php } ?>
	          <div class="panel panel-warning" data-widget="{&quot;draggable&quot;: &quot;false&quot;}" data-widget-static="">
                  <div class="panel-body no-padding">
                  	<table class="table  table-bordered">
						<tr>
							<th row="scope">&num;</th>
							<th><?php print $mod_lang_output['TABLE_HEADER_CATEGORY']?></th>
							<th><?php print $mod_lang_output['TABLE_HEADER_ACTION']?></th>
						</tr>
	          		<?php print $my_users->admin_load_users_cat(); ?>
                  </div>
              </div>
	      <?php } ?>
		  
		  <!-- Lister les utilisateurs -->
	      <?php if(!isset($_REQUEST[what]) || ($_REQUEST[what]=="userDisplay")) { ?>
	          <h3><?php print $mod_lang_output['MODULE_NAME']; ?> :: <?php print $mod_lang_output['PAGE_HEADER_LIST_USERS']; ?></h3>
	          
	          <?php if(isset($user_display_err_msg)) {  ?>
	          <div class="ADM_err_msg"><?php print $user_display_err_msg; ?></div>
	          <?php } ?>
	          <?php if(isset($user_display_cfrm_msg)) {  ?>
	          <div class="ADM_cfrm_msg"><?php print $user_display_cfrm_msg; ?></div>
	          <?php } ?>
              <div class="panel panel-warning" data-widget="{&quot;draggable&quot;: &quot;false&quot;}" data-widget-static="">
                  <div class="panel-body no-padding">
                  	<table class="table table-bordered">
						<tr>
							<th row="scope">&num;</th>
							<th><?php print $mod_lang_output['TABLE_HEADER_NAME']?></th>
							<th><?php print $mod_lang_output['TABLE_HEADER_LOGIN']?></th>
							<th><?php print $mod_lang_output['TABLE_HEADER_E-MAIL']?></th>
							<th><?php print $mod_lang_output['TABLE_HEADER_STATUS']?></th>
							<th><?php print $mod_lang_output['TABLE_HEADER_REG-DATE']?></th>
							<th><?php print $mod_lang_output['TABLE_HEADER_ACTION']?></th>
						</tr>
                    <?php print $my_users->admin_load_users(20); ?>
                  </div>
              </div>
	      <?php } ?>
	      
	      <!-- ********************************* Modifier un compte utilisateur ******************************************************
	      ****************************************************************************************************************-->
	      <?php 
	      	if($_REQUEST[what] == "userUpdate") { // Si on a clique sur modifier l'annuaire... 
		  		$tabUpd	= $my_users->get_user($_REQUEST[$my_users->mod_queryKey]);
		  ?>
	      <h3><?php print $mod_lang_output['MODULE_NAME']; ?> :: <?php print $mod_lang_output['PAGE_HEADER_UPDATE_USER']; ?></h3>
	      <?php if(isset($user_update_err_msg)) { ?>
	      	<div class="ADM_err_msg"><?php print $user_update_err_msg; ?></div>
	      <?php } ?>
	      <?php if(isset($user_update_cfrm_msg)) { ?>
	      	<div class="ADM_cfrm_msg"><?php print $user_update_cfrm_msg; ?></div>
	      <?php } ?>
	      
          <div class="tab-content">
			<div class="tab-pane active" id="horizontal-form">
              <form class="form-horizontal" action="" method="post" name="frm_user_update" id="frm_user_update">
                <div class="form-group">
					<label for="user_selCat" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_CATEGORY']; ?></label>
					<div class="col-sm-8">
                        <select class="form-control" name="user_selCat_upd" id="user_selCat_upd">
                        	<option value='1' <?php print $tabUpd['u_TYPE'] == '1' ? ('SELECTED ') : (''); ?>>Administrator</option>
                            <option value='2' <?php print $tabUpd['u_TYPE'] == '2' ? ('SELECTED ') : (''); ?>>Editor</option>
							<?php //print $my_users->upd_combo_sel_row_2($my_users->tbl_userType, $my_users->fld_userTypeId, $my_users->fld_userTypeLib, $tabUpd["u_TYPE"]); ?>
                        </select>
					</div>
					<div class="col-sm-2">
						<!-- <p class="help-block">Your help text!</p> -->
					</div>
				</div>
                <div class="form-group">
					<label for="txt_file_title" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_USER-NAME']; ?></label>
					<div class="col-sm-8">
                    	<input class="form-control1" name="txt_user_login_upd" id="txt_user_login_upd" value="<?php print $tabUpd["u_LOGIN"]; ?>" />
					</div>
					<div class="col-sm-2">
						<p class="help-block redStar">*</p>
					</div>
				</div>
                <div class="form-group">
					<label for="txt_user_pass_upd" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_PASSWORD']; ?></label>
					<div class="col-sm-8">
                        <input  class="form-control1" type="password" name="txt_user_pass_upd" id="txt_user_pass_upd" />
					</div>
					<div class="col-sm-2">
						<p class="help-block"><?php print $mod_lang_output['FORM_HELP_LEAVE_EMPTY']; ?></p>
					</div>
				</div>
                <div class="form-group">
					<label for="txt_user_email_upd" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_E-MAIL']; ?></label>
					<div class="col-sm-8">
                        <input class="form-control1" name="txt_user_email_upd" type="text" value="<?php print $tab_userDetailUpd["ud_EMAIL"]; ?>" id="txt_user_email_upd" />
					</div>
					<div class="col-sm-2">
						<p class="help-block redStar">*</p>
					</div>
				</div>
                
                <p><br /></p>
                
                <div class="form-group">
					<label for="txt_user_last_upd" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_LAST-NAME']; ?></label>
					<div class="col-sm-8">
                        <input class="form-control1" name="txt_user_last_upd" type="text" value="<?php print $tab_userDetailUpd["ud_LAST"]; ?>" id="txt_user_last_upd" />
					</div>
					<div class="col-sm-2">
						<!-- <p class="help-block">04 Caracters Max</p> -->
					</div>
				</div>
                <div class="form-group">
					<label for="txt_user_first_upd" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_FIRST-NAME']; ?></label>
					<div class="col-sm-8">
                        <input class="form-control1" name="txt_user_first_upd" type="text" value="<?php print $tab_userDetailUpd["ud_FIRST"]; ?>" id="txt_user_first_upd" />
					</div>
					<div class="col-sm-2">
						<!-- <p class="help-block">04 Caracters Max</p> -->
					</div>
				</div>
                <div class="form-group">
					<label for="txt_user_telephone_upd" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_PHONE-NUMBER']; ?></label>
					<div class="col-sm-8">
                        <input class="form-control1" name="txt_user_telephone_upd" type="text" value="<?php print $tab_userDetailUpd["ud_TELEPHONE"]; ?>" id="txt_user_telephone_upd" />
					</div>
					<div class="col-sm-2">
						<!-- <p class="help-block">04 Caracters Max</p> -->
					</div>
				</div>
                <div class="panel-footer">
                <div class="row">
                    <div class="col-sm-8 col-sm-offset-2">
                        <button name="btn_user_update" id="btn_user_update" class="btn-success btn"><?php print $mod_lang_output['FORM_BUTTON_UPDATE']; ?></button>
                        <input type="hidden" name="hd_user_id" value="<?php print $_REQUEST[$my_users->URI_userVar]; ?>" />
                        <input type="hidden" name="hd_user_img_id" value="<?php print $tab_userDetailUpd["ud_IMGID"]; ?>" />
                        <input type="hidden" name="hd_user_date_enreg" value="<?php print $tab_userUpd["u_DATEENREG"]; ?>" />
                        <input type="hidden" name="hd_user_is_connected" value="<?php print $tab_userUpd["u_ISCONNECTED"]; ?>" />
                        <input type="hidden" name="hd_user_display" value="<?php print $tab_userUpd["u_DISPLAY"]; ?>" />
                    </div>
                </div>
             </div>
              </form>
             </div>
         </div>
         
	      <?php } ?>
		  
	        <?php if($_REQUEST[what]=="userCatInsert"){ ?>
	      
	      <h3><?php print $mod_lang_output['MODULE_NAME']; ?> :: <?php print $mod_lang_output['PAGE_HEADER_ADD_USER_CATEGORY']; ?></h3>
	      
	      <?php if(isset($rub_insert_err_msg)) {  ?>
	      <div class="ADM_err_msg"><?php print $rub_insert_err_msg; ?></div>
	      <?php } ?>
	      <?php if(isset($rub_insert_cfrm_msg)) {  ?>
	      <div class="ADM_cfrm_msg"><?php print $rub_insert_cfrm_msg; ?></div>
	      <?php } ?>
          
          <div class="tab-content">
			<div class="tab-pane active" id="horizontal-form">
              <form class="form-horizontal" action="" method="post" id="frm_rub_insert" name="frm_rub_insert">
                <div class="form-group">
					<label for="txt_cat_lib" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_CATEGORY']; ?></label>
					<div class="col-sm-8">
                        <input class="form-control1" name="txt_cat_lib" type="text" id="txt_cat_lib" value="<?php print $my_users->show_content($rub_insert_err_msg, $txt_cat_lib) ?>" />
					</div>
					<div class="col-sm-2">
						<p class="help-block redStar">*</p>
					</div>
				</div>
                <div class="panel-footer">
                <div class="row">
                    <div class="col-sm-8 col-sm-offset-2">
                        <button name="btn_cat_insert" id="btn_cat_insert" class="btn-success btn"><?php print $mod_lang_output['FORM_BUTTON_ADD_CATEGORY']; ?></button>
                    </div>
                </div>
             </div>
              </form>
             </div>
         </div>
          
	      <?php } ?>
        	
<?php include_once('inc/admin_footer.php');?>
