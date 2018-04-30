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
	require("../scripts/incfiles/config.inc.php");
	require_once("../modules/user/library/user.inc.php");
?>
<?php
	//Site settings
	$system		= new cwd_system();
	$system->db_connect($thewu32_host, $thewu32_db, $thewu32_user, $thewu32_pass);
	$settings 	= $system->get_site_settings();
	
	
	//Language settings
	$langFile	= isset($_SESSION[LANG]) ? ($_SESSION[LANG]) : ($settings["LANG"]);
	
	//Call the language file pack
	require_once("../scripts/langfiles/".$langFile.".php");  		//Global language pack
	require_once("../modules/event/langfiles/".$langFile.".php");	//Module language pack
	$system->session_checker($_SESSION["CONNECTED_ADMIN"], $_SESSION["CONNECTED_EDIT"]);
	//$admin_pageTitle	=	"Gestionnaire des Pages";
?>
<?php
	$menus			= new cwd_page();
	$pageId			= $_GET[$menus->URI_pageVar]; // Pour derouter les hackers!!
	$what			= $_REQUEST[what];
	$pagePublic		= $_REQUEST[pagePublic];
	$modules		= new cwd_module();
	$moduleId		= $_REQUEST[$modules->URI_moduleVar];
	$pageModuleId 	= $_REQUEST[$modules->URI_pageModuleVar];
?>
<?php
	//Nouveau lien = nouvelle page
	$btn_menu_insert 	= 	$_POST[btn_menu_insert];
	$txt_menu_info 		= 	addslashes($_POST[txt_menu_info]);
	$txt_menu_order		= 	$_POST[txt_menu_order];
	$txt_menu_lib 		= 	addslashes($_POST[txt_menu_lib]);
	$sel_menu_type		= 	$_POST[sel_menu_type];
	$sel_menu_parent	= 	$_POST[sel_menu_parent];
	$rdDisplay 			= 	$_POST[rdDisplay];
	$chkLevel			= 	(!isset($_POST[chkLevel]) ? ("1") : ("0"));
	$sel_menu_lang		= 	$_POST[sel_menu_lang];
	$defaultHeader 		=	$lang_output["SITE_LANG"].' - ';
	$defaultContent		= 	$lang_output['LABEL_PAGE_DEFAULT_CONTENT'];

	if(isset($btn_menu_insert)){
		/*if(($menus->chk_entry($menus->tbl_page, "pages_name", $txt_menu_lib)) && ($menus->chk_entry($menus->tbl_page, "lang", $sel_menu_lang)))
			$menu_err_msg	= "Sorry!<br />That menu link still exists;.";*/
		if(empty($txt_menu_lib))
			$menu_err_msg	= $lang_output['PAGE_MSG_MENU_TITLE_REQUIRED'];
		elseif($menus->set_new_page($txt_menu_lib, $sel_menu_lang, $txt_menu_order, $sel_menu_parent, $sel_menu_type, $chkLevel, $defaultHeader, $defaultContent, $rdDisplay)){
			$menu_cfrm_msg	= $lang_output['PAGE_MSG_MENU_SUCCESS'];
			$system->set_log('MENU/LINK CREATED - ('.$txt_menu_lib.')');
		}
	}
?>
<?php
	//MAJ des pages = menus
	$btn_menu_update 		= $_POST[btn_menu_update];
	$txt_menu_info_upd 		= addslashes($_POST[txt_menu_info_upd]);
	$txt_menu_lib_upd 		= addslashes($_POST[txt_menu_lib_upd]);
	$txt_menu_order_upd 	= $_POST[txt_menu_order_upd];
	$sel_menu_type_upd 		= $_POST[sel_menu_type_upd];
	$sel_menu_parent_upd 	= $_POST[sel_menu_parent_upd];
	$rdDisplay_upd 			= $_POST[rdDisplay_upd];
	$chkLevel_upd			= (!isset($_POST[chkLevel_upd]) ? ("1") : ("0"));
	$sel_menu_lang_upd		= $_POST[sel_menu_lang_upd];
	

	if(isset($btn_menu_update)){
		if(empty($txt_menu_lib_upd))
			$menu_update_err_msg	= $lang_output['PAGE_MSG_MENU_TITLE_REQUIRED'];
		elseif($menus->update_page($pageId, $txt_menu_lib_upd, $txt_menu_order_upd, $sel_menu_parent_upd, $sel_menu_type_upd, $chkLevel_upd, $sel_menu_lang_upd, $rdDisplay_upd)){
			$menu_update_cfrm_msg	= $lang_output['PAGE_MSG_MENU_UPDATE_SUCCESS'];
			$system->set_log('MENU/LINK UPDATED - ('.$txt_menu_lib_upd.')');
		}
	}
?>
<?php
	//MAJ des contenus des pages
	$btn_page_update	=	$_POST[btn_page_update];
	$ta_page_content	=	addslashes($_POST[ta_page_content]);
	$ta_page_tags		=	addslashes($_POST[ta_page_tags]);
	$txt_page_title		= 	addslashes($_POST[txt_page_title]);
	$txt_page_head		=	addslashes($_POST[txt_page_head]);
	$hdPage				=	$_POST[hdPage];
	
	
	if(isset($btn_page_update)){
		if($menus->update_page_content($hdPage,
									   $txt_page_head, 
									   $txt_page_title,
									   $ta_page_tags,
									   $ta_page_content)){
			$pedit_cfrm_msg	= $lang_output['PAGE_MSG_UPDATE_SUCCESS'];
			$system->set_log('PAGE UPDATED - ('.$txt_page_title.')');
		}
	}
?>
<?php
	//Suppression des pages
	if($what == "pageDelete"){
		$system->set_log('PAGE DELETED - ('.$menus->get_page_by_id($menus->fld_pageLib, $pageId).')');
		if($menus->delete_page($pageId))
			$pdisplay_cfrm_msg	= $lang_output['PAGE_MSG_DELETE_SUCCESS'];
		else
			$pdisplay_err_msg	= $lang_output['MSG_PAGE_DELETE_IMPOSSIBLE'];
	}
?>
<?php
	//Publier / Rendre priv
	if($pagePublic == "OK"){
		if($menus->set_page_state($pageId)){
			$pdisplay_cfrm_msg = $lang_output['PAGE_MSG_SHOW'];
			$system->set_log('PAGE SET VISIBLE - ('.$menus->get_page_by_id($menus->fld_pageLib, $pageId).')');
		}
	}
	elseif ($pagePublic == "NO"){
		if($menus->set_page_state($pageId, 0)){
			$pdisplay_cfrm_msg = $lang_output['PAGE_MSG_HIDE'];
			$system->set_log('PAGE SET INVISIBLE - ('.$menus->get_page_by_id($menus->fld_pageLib, $pageId).')');
		}
	}
?>
<?php
	//Annuler l'assignation:
	if($_REQUEST[action] == "unassign"){
		if($modules->module_page_unassign($pageModuleId)){
			$pm_unassign_cfrm_msg	= $lang_output['PAGE_MSG_ASSIGNATION_DELETE_SUCCESS'];
			//$system->set_log('MODULE UNASSIGNED FROM PAGE - ('.$menus->get_page_by_id($menus->fld_pageLib, $pageId).')');
		}
		else
			$pm_unassign_err_msg	= $lang_output['PAGE_MSG_ASSIGNATION_DELETE_ERROR'];
	}
?>
<?php
	//Assigner les modules aux pages:
	$sel_assignPage			= $_POST[sel_assignPage];
	$sel_assignModule		= $_POST[sel_assignModule];
	$btn_assignModulePage	= $_POST[btn_assignModulePage];
	
	if(isset($btn_assignModulePage)){
		if(empty($sel_assignModule) || empty($sel_assignPage))
			$pm_assign_err_msg	= $lang_output['PAGE_MSG_MODULE_SELECT_ERROR'];
		elseif($modules->chk_entry_twice($modules->tbl_pageModule, $modules->fld_pId, $modules->fld_modId, $sel_assignPage, $sel_assignModule))
			$pm_assign_err_msg	= $lang_output['PAGE_MSG_ASSIGNATION_EXISTS'];
		elseif($modules->module_page_assign($sel_assignModule, $sel_assignPage)){
			$pm_assign_cfrm_msg	= $lang_output['PAGE_MSG_ASSIGNATION_SUCCESS'];
			//$system->set_log('MODULE ASSIGNATED TO PAGE - ('.$menus->get_page_by_id($menus->fld_pageLib, $sel_assignPage).' --> '.$menus->get_modules_by_id($menus->fld_modulesLib, $sel_assignModule).')');
			$system->set_log('MODULE ASSIGNATED TO PAGE - ('.$menus->get_page_by_id($menus->fld_pageLib, $sel_assignPage).')');
		}
	}
?>
<?php 
	ob_end_flush();
?>

<?php include_once('inc/admin_header.php');?>

        	<!-- *********************************** ASSIGNER LES MODULES AUX PAGES ******************************
            *************************************************************************************************** -->
            
	            <?php if($_REQUEST[what] == "pageModuleAssign") { ?>
	            <div class="col-sm-6">
		    		<h3><?php print $lang_output['MODULE_NAME']; ?> :: <?php print $lang_output['PAGE_HEADER_ASSIGN_PAGES_MODULES']; ?></h3>
		            
			            <?php if($pm_assign_err_msg != "") { ?>
			            <div class="ADM_err_msg"><?php print $pm_assign_err_msg;  ?></div>
			            <?php } ?>
			            <?php if(isset($pm_assign_cfrm_msg)) { ?>
			            <div class="ADM_cfrm_msg"><?php print $pm_assign_cfrm_msg; ?></div>
			            <?php } ?>         
		    		
		    		<div class="panel panel-warning" data-widget="{&quot;draggable&quot;: &quot;false&quot;}" data-widget-static="">
          				<div class="panel-body no-padding">
				            <form action="<?php print $PHP_SELF; ?>?action=assign&what=pageModuleAssign" method="post">
				                <table class="table">
				                	<tr>
				                		<th><?php print $lang_output['FORM_LABEL_PAGES']; ?></th>
				                		<th></th>
				                		<th><?php print $lang_output['FORM_LABEL_MODULES']; ?></th>
				                	</tr>
				                    <tr>
				                        <td>
				                            <select name="sel_assignPage" size="15"><?php print $menus->cmb_load_page(); ?></select>
				                        </td>
				                        <td>
				                            <div style="padding:0 auto;"><button class="btn-success btn type="submit" name="btn_assignModulePage"> <?php print $lang_output['FORM_BUTTON_ASSIGN']; ?> >> </button></div>
				                        </td>
				                        <td>
				                            <select name="sel_assignModule" size="15"><?php print $modules->cmb_load_module(); ?></select>
				                        </td>
				                    </tr>
				                </table>
				            </form>
				    	</div>
					</div>
					<p>&nbsp;</p>
					<i class='fa fa-cogs icon_info icon_color'></i>&nbsp;<a data-toggle='modal' href='#' data-target='#modulesModal'>Modules settings</a>
					<div tabindex='-1' class='modal fade' id='modulesModal' role='dialog' aria-hidden='true' aria-labelledby='modulesModalLabel' style='display: none;'>
						<div class='modal-dialog'>
							<div class='modal-content'>
								<div class='modal-header'>
									<button class="close" aria-hidden="true" type="button" data-dismiss="modal">x</button>
									<h2 class="modal-title"><i class='fa fa-cogs icon_info icon_color'></i>&nbsp;Modules settings</h2>
								</div>
								<div class='modal-body'>
									<p>All modules below</p>
									<div style='height:30em; overflow: auto;'>
										<?php print $modules->tbl_load_modules(); ?>
									</div>
								</div>
								<div class='modal-footer'>
									<button class="btn btn-default" type="button" data-dismiss="modal">Close</button>
									<button class="btn btn-primary" type="button">Save changes</button>
								</div>
							</div>
						</div>
					</div>
	            </div>
	            
	            <div class="col-sm-6">
	            	<?php if($pm_unassign_err_msg != "") { ?>
	                            <div class="ADM_err_msg"><?php print $pm_unassign_err_msg;  ?></div>
	                            <?php } ?>
	                            <?php if(isset($pm_unassign_cfrm_msg)) { ?>
	                            <div class="ADM_cfrm_msg"><?php print $pm_unassign_cfrm_msg; ?></div>
	                            <?php } ?>
	                            <div class="panel panel-warning" data-widget="{&quot;draggable&quot;: &quot;false&quot;}" data-widget-static="">
	                                <div class="panel-body no-padding">
	                                    <?php print $modules->load_modules_pages(); ?>
	                                </div>
	                            </div>
	            </div>
	            <?php } ?>
            
            
            <!-- *********************************** AFFICHER LES MODULES ******************************
            *************************************************************************************************** -->
            
	            <?php if($_REQUEST[what] == "moduleDisplay") { ?>
	            <h3><?php print $lang_output['MODULE_NAME']; ?> :: <?php print $lang_output['PAGE_HEADER_LIST_MODULES']; ?></h3>
	                <div class="panel panel-warning" data-widget="{&quot;draggable&quot;: &quot;false&quot;}" data-widget-static="">
	                    <div class="panel-body no-padding">
	                        <?php print $modules->load_modules(); ?>
	                   </div>
	                </div>
	            <?php } ?>
            
            
            
            <!-- *********************************** NOUVEAU MENU OU LIEN ******************************
            *************************************************************************************************** -->
            
            <?php if($_REQUEST[what] == "pageInsert") { ?>
            <h3><?php print $lang_output['MODULE_NAME']; ?> :: <?php print $lang_output['PAGE_HEADER_ADD_PAGE']; ?></h3>
            <?php if(isset($menu_err_msg)) { ?>
            <div class="ADM_err_msg"><?php print $menu_err_msg; ?></div>
            <?php } ?>
            <?php if(isset($menu_cfrm_msg)) { ?>
            <div class="ADM_cfrm_msg"><?php print $menu_cfrm_msg; ?></div>
            <?php } ?>
            
            <div class="tab-content">
                <div class="tab-pane active" id="horizontal-form">
                      <form class="form-horizontal" id="frm_menu_insert" name="frm_menu_insert" method="post" action="">
                        <div class="form-group">
                            <label for="sel_menu_lang" class="col-sm-2 control-label"><?php print $lang_output['FORM_LABEL_PAGE_LANGUAGE']; ?></label>
                            <div class="col-sm-8">
                                <select class="form-control" name="sel_menu_lang" id="select">
									<?php print $menus->cmb_showLang($sel_menu_lang); ?>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <!-- <p class="help-block">Your help text!</p> -->
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="txt_menu_order" class="col-sm-2 control-label"><?php print $lang_output['FORM_LABEL_PAGE_ORDER']; ?></label>
                            <div class="col-sm-8">
                                <input class="form-control1" name="txt_menu_order" type="text" id="txt_menu_order" maxlength="3" />
                            </div>
                            <div class="col-sm-2">
                                <p class="help-block">03 <?php print $lang_output['FORM_HELP_CRT_MAX']; ?></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="txt_menu_lib" class="col-sm-2 control-label"><?php print $lang_output['FORM_LABEL_MENU_LABEL']; ?></label>
                            <div class="col-sm-8">
                                <input class="form-control1" name="txt_menu_lib" type="text" id="txt_menu_lib" />
                            </div>
                            <div class="col-sm-2">
                                <!-- <p class="help-block">04 caracters max.</p> -->
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="sel_menu_type" class="col-sm-2 control-label"><?php print $lang_output['FORM_LABEL_MENU_CATEGORY']; ?></label>
                            <div class="col-sm-8">
                                <select class="form-control" name="sel_menu_type">
									<?php print $menus->cmb_load_page_type($_POST[sel_menu_type]); ?>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <!-- <p class="help-block">04 caracters max.</p> -->
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="sel_menu_parent" class="col-sm-2 control-label"><?php print $lang_output['FORM_LABEL_PAGE_PARENT']; ?></label>
                            <div class="col-sm-8">
                                <select class="form-control" name="sel_menu_parent">
									<?php print $menus->cmb_load_page($_POST[sel_menu_parent]); ?>
                                    <option value='0'<?php print $selected = (($_POST[sel_menu_parent] == 0) ? (" SELECTED") : ("")); ?>>...<?php print $lang_output['FORM_VALUE_NONE_HOMEPAGE']; ?>...</option>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <!-- <p class="help-block">04 caracters max.</p> -->
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="chkLevel" class="col-sm-2 control-label"><?php print $lang_output['FORM_LABEL_SET_HOMEPAGE']; ?></label>
                            <div class="col-sm-8">
                                <input name="chkLevel" type="checkbox" id="chkLevel" value="0" />
                            </div>
                            <div class="col-sm-2">
                                <!-- <p class="help-block">04 caracters max.</p> -->
                            </div>
                        </div>
                        <div class="panel-footer">
                            <div class="row">
                                <div class="col-sm-8 col-sm-offset-2">
                                    <button name="btn_menu_insert" id="btn_menu_insert" class="btn-success btn"><?php print $lang_output['FORM_BUTTON_ADD_PAGE']; ?></button>
                                </div>
                            </div>
                         </div>
                          </form>
                         </div>
                     </div>
            
            
            <?php } ?>
            
            <!-- *********************************** MISE A JOUR DES PAGES ******************************
            *************************************************************************************************** -->
            <?php 
                if($_REQUEST[what] == "pageUpdate") {  
                    $menu_update = $menus->get_page($pageId); 
                    $menu_update_err_msg=""; 
            ?>
            <h3><?php print $lang_output['MODULE_NAME']; ?> :: <?php print $lang_output['PAGE_HEADER_UPDATE_MENU']; ?></h3>
            
            <?php if($menu_update_err_msg != "") { ?>
            <div class="ADM_err_msg"><?php print $menu_update_err_msg;  ?></div>
            <?php } ?>
            <?php if(isset($menu_update_cfrm_msg)) { ?>
            <div class="ADM_cfrm_msg"><?php print $menu_update_cfrm_msg; ?></div>
            <?php } ?>
            
            <div class="tab-content">
                <div class="tab-pane active" id="horizontal-form">
                      <form class="form-horizontal" id="frm_menu_update" name="frm_menu_insert" method="post" action="">
                        <div class="form-group">
                            <label for="sel_menu_lang" class="col-sm-2 control-label"><?php print $lang_output['FORM_LABEL_PAGE_LANGUAGE']; ?></label>
                            <div class="col-sm-8">
                                <select class="form-control" name="sel_menu_lang_upd" id="select">
									<?php print $menus->cmb_showLang($menu_update["LANG"]); ?>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <!-- <p class="help-block">Your help text!</p> -->
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="txt_menu_order_upd" class="col-sm-2 control-label"><?php print $lang_output['FORM_LABEL_PAGE_ORDER']; ?></label>
                            <div class="col-sm-8">
                                <input class="form-control1" name="txt_menu_order_upd" type="text" id="txt_menu_order_upd" value="<?php print $menu_update["ORDER"] ?>" maxlength="3" />
                            </div>
                            <div class="col-sm-2">
                                <p class="help-block">03 <?php print $lang_output['FORM_HELP_CRT_MAX']; ?></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="txt_menu_lib_upd" class="col-sm-2 control-label"><?php print $lang_output['FORM_LABEL_MENU_LABEL']; ?></label>
                            <div class="col-sm-8">
                                <input class="form-control1" value="<?php print $menu_update["TXT"] ?>" name="txt_menu_lib_upd" type="text" id="txt_menu_lib_upd" />
                            </div>
                            <div class="col-sm-2">
                                <!-- <p class="help-block">04 caracters max.</p> -->
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="sel_menu_type_upd" class="col-sm-2 control-label"><?php print $lang_output['FORM_LABEL_MENU_CATEGORY']; ?></label>
                            <div class="col-sm-8">
                                <select class="form-control" name="sel_menu_type_upd">
									<?php print $menus->cmb_load_page_type($menu_update["TYPEID"]); ?>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <!-- <p class="help-block">04 caracters max.</p> -->
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="sel_menu_parent_upd" class="col-sm-2 control-label"><?php print $lang_output['FORM_LABEL_PAGE_PARENT']; ?></label>
                            <div class="col-sm-8">
                                <select class="form-control" name="sel_menu_parent_upd">
									<?php print $menus->cmb_load_page($menu_update["PARENT"]); ?>
                                    <option value='0'<?php print $selected = (($menu_update["PARENT"] == 0) ? (" SELECTED") : ("")); ?>>...<?php print $lang_output['FORM_VALUE_NONE_HOMEPAGE']; ?>...</option>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <!-- <p class="help-block">04 caracters max.</p> -->
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="chkLevel_upd" class="col-sm-2 control-label"><?php print $lang_output['FORM_LABEL_SET_HOMEPAGE']; ?></label>
                            <div class="col-sm-8">
                                <input <?php print $checked =(($menu_update["LEVEL"] == "0")?(" CHECKED"):("")); ?> name="chkLevel_upd" type="checkbox" id="chkLevel_upd" value="0" />
                            </div>
                            <div class="col-sm-2">
                                <!-- <p class="help-block">04 caracters max.</p> -->
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="chkLevel_upd" class="col-sm-2 control-label"><?php print $lang_output['FORM_LABEL_DISPLAY']; ?></label>
                            <div class="col-sm-8">
                                <label>
                                  <input type="radio" <?php print $menus->radio_show_content($menu_update_err_msg, 1, $menu_update["DISPLAY"]) ?> name="rdDisplay_upd" value="1" id="rdDisplay_upd_0" />
                                  <?php print $lang_output['LABEL_YES']; ?></label>
                              </p>
                                <p>
                                  <label>
                                  <input type="radio" <?php print $menus->radio_show_content($menu_update_err_msg, 0, $menu_update["DISPLAY"]) ?> name="rdDisplay_upd" value="0" id="rdDisplay_upd_1" />
                                    <?php print $lang_output['LABEL_NO']; ?></label>
                                </p>
                            </div>
                            <div class="col-sm-2">
                                <!-- <p class="help-block">04 caracters max.</p> -->
                            </div>
                        </div>
                        <div class="panel-footer">
                            <div class="row">
                                <div class="col-sm-8 col-sm-offset-2">
                                    <button name="btn_menu_update" id="btn_menu_update" class="btn-success btn"><?php print $lang_output['FORM_BUTTON_UPDATE_PAGE']; ?></button>
                                </div>
                            </div>
                         </div>
                          </form>
                         </div>
                     </div>
            
           
            <?php } ?>
            
            <!-- *********************************** EDITER LE CONTENU DES PAGES ******************************
            *************************************************************************************************** -->
            <?php if($_REQUEST[what]=="contentEdit") { ?>
            <a name="contentEdit"></a>
            <h3><?php print $lang_output['MODULE_NAME']; ?> :: <?php print $lang_output['PAGE_HEADER_EDIT_CONTENTS']; ?></h3>
            <?php if(isset($pedit_err_msg)) { ?>
            <div class="ADM_err_msg"><?php print $pedit_err_msg;  ?></div>
            <?php } ?>
            <?php if(isset($pedit_cfrm_msg)) { ?>
            <div class="ADM_cfrm_msg"><?php print $pedit_cfrm_msg; ?></div>
            <?php } ?>
            
            <div class="tab-content">
                <div class="tab-pane active" id="horizontal-form">
                      <form class="form-horizontal" id="frm_content_edit" name="frm_content_edit" method="post" action="">
                      	<div class="form-group">
                            <label for="sel_menu_lang" class="col-sm-2 control-label"><?php print $lang_output['FORM_VALUE_SELECT_PAGE']; ?></label>
                            <div class="col-sm-8">
                                <select class="form-control" name="jumpMenu" id="jumpMenu" onChange="MM_jumpMenu('parent',this,0)">
                                    <?php print stripslashes($menus->redir_cmb_load_pages($_REQUEST[$menus->URI_pageVar])); ?>
                              </select>
                            </div>
                            <div class="col-sm-2">
                                <!-- <p class="help-block">Your help text!</p> -->
                            </div>
                        </div>
                        
                        <?php if(isset($pageId)) { $pContent = $menus->get_page_details($pageId); ?>
                        
                        <div class="form-group">
                            <label for="txt_page_head" class="col-sm-2 control-label"><?php print $lang_output['FORM_LABEL_PAGE_HEADER']; ?></label>
                            <div class="col-sm-8">
                                <input class="form-control1" name="txt_page_head" value="<?php print $pContent["HEADER"]; ?>" type="text" id="txt_page_head"/>
                            </div>
                            <div class="col-sm-2">
                                <!-- <p class="help-block">Your help text!</p> -->
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="txt_page_title" class="col-sm-2 control-label"><?php print $lang_output['FORM_LABEL_PAGE_TITLE']; ?></label>
                            <div class="col-sm-8">
                                <input class="form-control1" name="txt_page_title" value="<?php print $pContent["TITLE"]; ?>" type="text" id="txt_page_title" />
                            </div>
                            <div class="col-sm-2">
                                <!-- <p class="help-block">Your help text!</p> -->
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="ta_page_tags" class="col-sm-2 control-label"><?php print $lang_output['FORM_LABEL_PAGE_TAGS']; ?></label>
                            <div class="col-sm-8">
                                <textarea class="form-control1" name="ta_page_tags" cols="30" rows="4" id="ta_page_tags"><?php print $pContent["TAGS"]; ?></textarea>
                            </div>
                            <div class="col-sm-2">
                                <!-- <p class="help-block">Your help text!</p> -->
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="ta_page_content" class="col-sm-2 control-label"><?php print $lang_output['FORM_LABEL_PAGE_CONTENT']; ?></label>
                            <div class="col-sm-8">
                                <input name="ta_page_content" type="hidden" id="ta_page_content" value="<?php echo stripslashes(htmlspecialchars($pContent["CONTENT"])); ?>" />
                                <script language="javascript1.2">
									generate_wysiwyg('ta_page_content');
								</script>
								<input type="hidden" name="hdDate" value="<?php print date("Y-m-d"); ?>"/>
                            </div>
                            <div class="col-sm-2">
                                <!-- <p class="help-block">Your help text!</p> -->
                            </div>
                        </div>
                        <div class="panel-footer">
                            <div class="row">
                                <div class="col-sm-8 col-sm-offset-2">
                                    <input type="hidden" name="hdPage" value="<?php print $pageId; ?>" />
                                    <button name="btn_page_update" id="btn_page_update" class="btn-success btn"><?php print $lang_output['FORM_BUTTON_UPDATE_PAGE_CONTENT']; ?></button>
                                </div>
                            </div>
                         </div>
                         <?php } ?>
                          </form>
                         </div>
                     </div>
                        
                        
            <?php } ?>
            
            <!-- *********************************** AFFICHER LES PAGES ***************************************
            *************************************************************************************************** -->
            <?php if(!isset($_REQUEST[what]) || ($_REQUEST[what] == "pageDisplay")) { ?>
            
            <a name="pageDisplay"></a>
            <h3><?php print $lang_output['MODULE_NAME']; ?> :: <?php print $lang_output['PAGE_HEADER_LIST_PAGES']; ?></h3>
            <?php if(isset($pdisplay_err_msg)) { ?>
            <div class="ADM_err_msg"><?php print $pdisplay_err_msg;  ?></div>
            <?php } ?>
            <?php if(isset($pdisplay_cfrm_msg)) { ?>
            <div class="ADM_cfrm_msg"><?php print $pdisplay_cfrm_msg; ?></div>
            <?php } ?>
                <div class="panel panel-warning" data-widget="{&quot;draggable&quot;: &quot;false&quot;}" data-widget-static="">
                    <div class="panel-body no-padding">
                        <?php print $menus->admin_load_pages(); ?>
                    </div>
                </div>
            <?php } ?>
        	
<?php include_once('inc/admin_footer.php');?>
