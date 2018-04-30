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
	require_once("../modules/annonce/library/annonce.inc.php");
	$system		= new cwd_system();
	$annonce	= new cwd_annonce();
	$myRss		= new cwd_rss091();
	$annonce->db_connect($thewu32_host, $thewu32_db, $thewu32_user, $thewu32_pass);
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
require_once("../modules/annonce/langfiles/".$langFile.".php"); //Module language pack

//Page name
$admin_pageTitle	=	$mod_lang_output['MODULE_DESCR'];

//Spry
$annonce->spry_ds_create();
?>

<?php

	$myRss->set_rss_tblInfos($annonce->tbl_annonce, $annonce->fld_annonceId, $annonce->fld_annonceTitle, $annonce->fld_annonceLib, $annonce->fld_annonceAuthor, $annonce->fld_annonceDatePub, $annonce->tbl_annonceAuthor, $annonce->fld_annonceAuthorF, $annonce->fld_annonceAuthorL);
	$myRss->set_rss_link_param($annonce->URI_annonce, $thewu32_modLink['annonce'], $thewu32_modLink['annonce']);
	$myRss->rss_customize_layout("North West region Announcements", "Toutes les annonces de la R&eacute;gion du Nord-Ouest", $thewu32_site_url.'modules/annonce/img/rss_annonces.gif', "Announcements / Annonces", "NWR Announcements / Annonces RNO", "");
	//$myRss->se
	$myRss->makeRSS("../modules/annonce/rss/annonces.xml");
?>
<?php 
	require_once('../modules/annonce/inc/annonce_validations.php');
?>
<?php 
	ob_end_flush();
?>

<?php include_once('inc/admin_header.php');?>
	        	
	        	<?php //print $annonce->admin_get_menu(); ?>
      
			      <!-- ********************************* Ajouter des categories d'annonce  ******************************************************
			      ****************************************************************************************************************-->
			      <?php if($_REQUEST[what]=="annonceCatInsert"){ ?>
			      <h3><?php print $mod_lang_output['MODULE_NAME']; ?> :: <?php print $mod_lang_output['PAGE_HEADER_ADD_ANNONCE_CATEGORY']; ?></h3>
			      
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
						            <label class="col-sm-2 control-label" for="annonce_catSelLang"><?php print $lang_output['FORM_LABEL_LANGUAGE']; ?></label>
						            <div class="col-sm-8">
							            <select class="form-control" name="annonce_catSelLang" id="annonce_catSelLang">
							                <?php print $annonce->cmb_showLang($_POST[annonce_selLang]); ?>
							              </select>
						              </div>
						      	</div>
						     	<div class="form-group">
						            <label class="col-sm-2 control-label" for="txt_cat_lib"><?php print $lang_output['FORM_LABEL_LABEL']; ?></label>
						            <div class="col-sm-8">
						            	<input class="form-control1" name="txt_cat_lib" type="text" id="txt_cat_lib" value="" size="40" />
						            </div>
						            <div class="col-sm-2">
		                                <!-- <p class="help-block">Your help text!</p> -->
		                            </div>
						       	</div>
						          
						        <div class="panel-footer">
		                            <div class="row">
		                                <div class="col-sm-8 col-sm-offset-2">
		                                    <button type="submit" name="btn_cat_insert" id="btn_cat_insert" class="btn-success btn"><?php print $lang_output['FORM_BUTTON_ADD_CATEGORY']; ?></button>
		                                </div>
		                            </div>
		                        </div>
			      			</form>
			      		</div>
			      	</div>
			      <?php } ?>
			      
			      <!-- ********************************* Afficher les categories d'annonce  ******************************************************
			      ****************************************************************************************************************-->
			      <div class="col-sm-6">
				      <?php if($_REQUEST[what]=="annonceCatDisplay") { ?>
				          <h3><?php print $mod_lang_output['MODULE_NAME']; ?> :: <?php print $mod_lang_output['PAGE_HEADER_LIST_ANNONCE_CATEGORIES']; ?></h3>
				          
				          <?php if(isset($rub_display_err_msg)) {  ?>
				          <div class="ADM_err_msg"><?php print $rub_display_err_msg; ?></div>
				          <?php } ?>
				          <?php if(isset($rub_display_cfrm_msg)) {  ?>
				          <div class="ADM_cfrm_msg"><?php print $rub_display_cfrm_msg; ?></div>
				          <?php } ?>
				          	<div class="panel panel-warning" data-widget="{&quot;draggable&quot;: &quot;false&quot;}" data-widget-static="">
								<div class="panel-body no-padding">
				          			<?php print $annonce->admin_load_annonces_cat(); ?>
				          		</div>
				          	</div>
				      <?php } ?>
			      </div>
			      
			      <!-- ********************************* Modifier les categories d'annonce  ******************************************************
			      ****************************************************************************************************************-->
			      <div class="col-sm-6">
				      <?php if(($_REQUEST[what]=="annonceCatDisplay") && (isset($rub_displayUpd))){ ?>
				      <h3><?php print $mod_lang_output['PAGE_HEADER_UPDATE_ANNONCE_CATEGORY']; ?></h3>
				      
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
							        	<label class="col-sm-2 control-label" for="annonce_selLangUpd"><?php print $lang_output['FORM_LABEL_LANGUAGE']; ?></label>
							            <div class="col-sm-8">
							            	<select class="form-control" name="annonce_selLangUpd" id="annonce_selLangUpd">
							                	<?php print $annonce->cmb_showLang($tabCatUpd[annonceCATLANG]); ?>
							              	</select>
							            </div>
							            <div class="col-sm-2">
			                                <!-- <p class="help-block">Your help text!</p> -->
			                            </div>
							        </div>
							        <div class="form-group">
							        	<label class="col-sm-2 control-label" for="txt_cat_lib_upd"><?php print $lang_output['FORM_LABEL_LABEL']; ?></label>
							            <div class="col-sm-8">
							            	<input class="form-control1" name="txt_cat_lib_upd" value="<?php print $tabCatUpd[annonceCATLIB]; ?>" type="text" id="txt_cat_lib_upd" size="30" />
							            </div>
							            <div class="col-sm-2">
			                                <!-- <p class="help-block">Your help text!</p> -->
			                            </div>
							        </div>
							        
							        <div class="panel-footer">
			                            <div class="row">
			                                <div class="col-sm-8 col-sm-offset-2">
			                                    <button type="submit" name="btn_cat_upd" id="btn_cat_upd" class="btn-success btn"><?php print $lang_output['FORM_BUTTON_UPDATE_CATEGORY']; ?></button>
			                                    <input type="hidden" name="hd_cat_id" value="<?php print $_REQUEST[catId]; ?>" />
			                                </div>
			                            </div>
			                        </div>
							        
						      	</form>
						    </div>
						</div>
				      <?php } ?>
			      </div>
			      			      
			      <!-- ********************************* Ajouter les annonces  ******************************************************
			      ****************************************************************************************************************-->
			      <?php if($_REQUEST[what]=="annonceInsert") { ?>
			      <?php $currentLang = (($_REQUEST[langId] != '') ? ($_REQUEST[langId]) : ($_SESSION['LANG'])); ?>
			      
			     <h3><?php print $mod_lang_output['MODULE_NAME']; ?> :: <?php print $mod_lang_output['PAGE_HEADER_ADD_ANNONCE']; ?></h3>
			      
			      <?php if(isset($annonce_insert_err_msg)) {  ?>
			      <div class="ADM_err_msg"><?php print $annonce_insert_err_msg; ?></div>
			      <?php } ?>
			      <?php if(isset($annonce_insert_cfrm_msg)) {  ?>
			      <div class="ADM_cfrm_msg"><?php print $annonce_insert_cfrm_msg; ?></div>
			      <?php } ?>
			      <div class="tab-content">
                		<div class="tab-pane active" id="horizontal-form">
					      	<form class="form-horizontal" action="" method="post" enctype="multipart/form-data" name="frm_annonce_insert" id="frm_annonce_insert">
						        <div class="form-group">
						          	<label class="col-sm-2 control-label" for="annonce_selLang"><?php print $lang_output['FORM_LABEL_LANGUAGE']; ?></label>
						          	<div class="col-sm-8">
						              	<select class="form-control"  name="annonce_selLang" id="jumpMenu" onchange="MM_jumpMenu('parent',this,0)">
						      				<?php print stripslashes($annonce->redir_cmb_load_langs($_REQUEST[langId], $annonce->admin_modPage, "annonceInsert")); ?>
						      		  	</select>
						      		  	<input name="hdLang" type="hidden" value="<?php print $_REQUEST[langId];?>" />
									</div>
									<div class="col-sm-2">
		                                <!-- <p class="help-block">Your help text!</p> -->
		                            </div>
								</div>
								
						        <div class="form-group">    
						          	<label class="col-sm-2 control-label" for="annonce_selCat"><?php print $lang_output['FORM_LABEL_CATEGORY']; ?></label>
						          	<div class="col-sm-8">
						            	<select class="form-control" name="annonce_selCat" id="annonce_selCat">
						                	<?php print $annonce->admin_cmb_show_rub_by_lang($currentLang, $_POST[annonce_selCat]); ?>
						              	</select>
									</div>
									<div class="col-sm-2">
		                                <!-- <p class="help-block">Your help text!</p> -->
		                            </div>
								</div>
								
								<div class="form-group">
									<label class="col-sm-2 control-label" for="txt_annonce_title"><?php print $lang_output['FORM_LABEL_TITLE']; ?></label>
									<div class="col-sm-8">
										<input class="form-control1" name="txt_annonce_title" type="text" value="<?php print $annonce->show_content($annonce_insert_err_msg, $txt_annonce_title) ?>" id="txt_annonce_title" size="40" />
						          	</div>
						          	<div class="col-sm-2">
		                                <!-- <p class="help-block">Your help text!</p> -->
		                            </div>
								</div>
								<div class="form-group">
						          	<label class="col-sm-2 control-label" for="ta_annonce_content"><?php print $lang_output['FORM_LABEL_CONTENT']; ?></label>
						          	<div class="col-sm-8">
							            <textarea name="ta_annonce_content" cols="40" rows="5" id="ta_annonce_content"><?php print $annonce->show_content($annonce_insert_err_msg, $ta_annonce_content) ?></textarea>
							            <script language="JavaScript1.2" type="text/javascript">
											generate_wysiwyg('ta_annonce_content');
								  		</script>
							  		</div>
							  		<div class="col-sm-2">
		                                <!-- <p class="help-block">Your help text!</p> -->
		                            </div>
						        </div>
						        
						        <div class="form-group">
						          	<label class="col-sm-2 control-label" for="txt_annonce_signature"><?php print $lang_output['FORM_LABEL_SIGNATURE']; ?></label>
						          	<div class="col-sm-8">
						            	<input class="form-control1 name="txt_annonce_signature" type="text" value="<?php print $annonce->show_content($annonce_insert_err_msg, $txt_annonce_signature) ?>" id="txt_annonce_signature" size="35" />
						            </div>
						            <div class="col-sm-2">
		                                <!-- <p class="help-block">Your help text!</p> -->
		                            </div>
						        </div>
						        
						        <div class="form-group">
						        	<label class="col-sm-2 control-label"><?php print $lang_output['FORM_LABEL_PUB-DATE']; ?></label>
						          	<div class="col-sm-8">
						          		<?php print $annonce->combo_date($_POST[cmbDay], $_POST[cmbMonth], $_POST[cmbYear], $LANG); ?>
						          	</div>
						          	<div class="col-sm-2">
		                                <!-- <p class="help-block">Your help text!</p> -->
		                            </div>
						        </div>
						        
						        <div class="form-group">
						        	<label class="col-sm-2 control-label" for="annoncePJ"><?php print $lang_output['FORM_LABEL_PJ']; ?></label>
						        	<div class="col-sm-8">
						            	<input class="form-control1" type="file" name="annoncePJ" id="annoncePJ" />
						        	</div>
						        	<div class="col-sm-2">
		                                <!-- <p class="help-block">Your help text!</p> -->
		                            </div>
						       	</div>
						       	
						       	<div class="panel-footer">
		                            <div class="row">
		                                <div class="col-sm-8 col-sm-offset-2">
		                                    <button type="submit" name="btn_annonce_insert" id="btn_annonce_insert" class="btn-success btn"><?php print $mod_lang_output['FORM_BUTTON_ADD_ANNONCE']; ?></button>
		                                    <input type="hidden" />
		                                </div>
		                            </div>
		                        </div>

					      	</form>
			      		</div>
			      </div>
			      <?php } ?>
			      
			      <!-- ********************************* Afficher les annonces  ******************************************************
			      ****************************************************************************************************************-->
			      <?php if(!isset($_REQUEST[what]) || ($_REQUEST[what]=="annonceDisplay")) { ?>
			          <h3><?php print $mod_lang_output['MODULE_NAME']; ?> :: <?php print $mod_lang_output['PAGE_HEADER_LIST_ANNONCE']; ?></h3>
					  <?php $annonce->limit = $_REQUEST[limite]; ?>
			          
			          <?php if(isset($annonce_display_err_msg)) {  ?>
			          <div class="ADM_err_msg"><?php print $annonce_display_err_msg; ?></div>
			          <?php } ?>
			          <?php if(isset($annonce_display_cfrm_msg)) {  ?>
			          <div class="ADM_cfrm_msg"><?php print $annonce_display_cfrm_msg; ?></div>
			          <?php } ?>
			          	<div class="panel panel-warning" data-widget="{&quot;draggable&quot;: &quot;false&quot;}" data-widget-static="">
							<div class="panel-body no-padding">
			          			<?php print $annonce->admin_load_annonces(); ?>
			          		</div>
			          	</div>
			      <?php } ?>
			      
			      <!-- ********************************* Modifier les annonces  ******************************************************
			      ****************************************************************************************************************-->
			      <?php 
			      	if($_REQUEST[what] == "annonceUpdate") { // Si on a clique sur modifier l'annonce... 
				  		$tabUpd	= $annonce->get_annonce($_REQUEST[$annonce->mod_queryKey]);
				  ?>
			      <h3><?php print $mod_lang_output['MODULE_NAME']; ?> :: <?php print $mod_lang_output['PAGE_HEADER_UPDATE_ANNONCE']; ?></h3>
			      <?php if(isset($annonce_update_err_msg)) { ?>
			      <div class="ADM_err_msg"><?php print $annonce_update_err_msg; ?></div>
			      <?php } ?>
			      <?php if(isset($annonce_update_cfrm_msg)) { ?>
			      <div class="ADM_cfrm_msg"><?php print $annonce_update_cfrm_msg; ?></div>
			      <?php } ?>
			      	<form class="form-horizontal" id="frm_annonce_update" name="frm_annonce_update" method="post" action="">
			      
						<div class="form-group">
				            <label for="annonce_selLangUpd" class="col-sm-2 control-label"><?php print $lang_output['FORM_LABEL_LANGUAGE']?></label>
				            <div class="col-sm-8">
				            	<select class="form-control" name="annonce_selLangUpd" id="annonce_selLangUpd">
				                	<?php print $annonce->cmb_showLang($tabUpd["annonceLANG"]); ?>
				              	</select>
							</div>
							<div class="col-sm-2"><!-- <p class="help-block" >Your help text here</p>--></div>
			          	</div>
			          	
			          	<div class="form-group">
				            <label for="annonce_selCatUpd" class="col-sm-2 control-label"><?php print $lang_output['FORM_LABEL_CATEGORY']?></label>
				            <div class="col-sm-8">
				            	<select class="form-control" name="annonce_selCatUpd" id="annonce_selCatUpd">
				                	<?php print $annonce->admin_cmb_show_rub($tabUpd["annonceCATID"]); ?>
				              	</select>
				            </div>
				            <div class="col-sm-2">&nbsp;</div>
			          	</div>
			          	
			          	<div class="form-group">
				            <label for="txt_annonce_title_upd" class="col-sm-2 control-label"><?php print $lang_output['FORM_LABEL_TITLE']?></label>
				            <div class="col-sm-8">
				            	<input class="form-control1" name="txt_annonce_title_upd" type="text" value="<?php print stripslashes($tabUpd["annonceTITLE"]); ?>" id="txt_annonce_title_upd" size="40" />
				            </div>
				            <div class="col-sm-2">&nbsp;</div>
			          	</div>
			          
			          	<div class="form-group">
				            <label for="ta_annonce_content_upd" class="col-sm-2 control-label"><?php print $lang_output['FORM_LABEL_CONTENT']?></label>
				            <div class="col-sm-8">
				            	<textarea name="ta_annonce_content_upd" id="ta_annonce_content_upd"><?php print stripslashes($tabUpd["annonceLIB"]); ?></textarea>
				                <script language="JavaScript1.2" type="text/javascript">
									generate_wysiwyg('ta_annonce_content_upd');
					  			</script>
				            </div>
				            <div class="col-sm-2">&nbsp;</div>
			          	</div>
			          	
			          	<div class="form-group">
				            <label for="txt_annonce_signature_upd" class="col-sm-2 control-label"><?php print $lang_output['FORM_LABEL_SIGNATURE']?></label>
				            <div class="col-sm-8">
				            	<input class="form-control1" name="txt_annonce_signature_upd" type="text" value="<?php print stripslashes($tabUpd["annonceSIGNATURE"]); ?>" id="txt_annonce_signature_upd" />
				            </div>
				            <div class="col-sm-2">&nbsp;</div>
			          	</div>
			          	
			          	<div class="form-group">
				            <label for="" class="col-sm-2 control-label"><?php print $lang_output['FORM_LABEL_PUB-DATE']?></label>
				            <div class="col-sm-8">
				            	<?php print $annonce->combo_dateFrUpd($tabUpd[annonceDATEPUB]); ?>
				            </div>
				            <div class="col-sm-2">&nbsp;</div>
			          	</div>
			          
			          	<div class="form-group">
			            	<label for="" class="col-sm-2 control-label"><?php print $lang_output['FORM_LABEL_PJ']?></label>
			            	<div class="col-sm-8"><?php print $tabUpd["annoncePJ"]; ?> [<a><?php print $lang_output['LABEL_MODIFY']?></a>]</div>
			            	<div class="col-sm-2">&nbsp;</div>
			          	</div>
			          	
			          	<div class="panel-footer">
		                	<div class="row">
		                    	<div class="col-sm-8 col-sm-offset-2">
		                        	<button type="submit" name="btn_annonce_upd" id="btn_annonce_upd" class="btn-success btn"><?php print $mod_lang_output['FORM_BUTTON_UPDATE_ANNONCE']?></button>
		                        	<input type="hidden" name="hd_annonce_id" value="<?php print $_REQUEST[pmId]; ?>" />
		                        </div>
		                    </div>
		               	</div>
			          	
			      </form>
			      <?php } ?>
<?php include_once('inc/admin_footer.php');?>