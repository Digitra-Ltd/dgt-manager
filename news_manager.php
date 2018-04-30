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
	require_once ("../scripts/incfiles/page.inc.php");
	require_once("../modules/news/library/news.inc.php");
	require_once("../modules/gallery/library/gallery.inc.php");
	//require_once("fckeditor/fckeditor.php");
	$system		= 	new cwd_system();
	$news		= 	new cwd_news();
	$myPage		= 	new cwd_page();
	$news->db_connect($thewu32_host, $thewu32_db, $thewu32_user, $thewu32_pass);
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
require_once("../modules/news/langfiles/".$langFile.".php"); //Module language pack

//Page name
$admin_pageTitle	=	$mod_lang_output['MODULE_DESCR'];
?>

<?php
	
	//Rss settings NB : Prevoir une page speciale pour la generation du flux RSS qui prendra en compte la specificite linguistique
	//$pageNews	= 	$myPage->get_pages_modules_links("news", $_POST[sel_newsLang]);
	$pageNews	= 	$myPage->get_pages_modules_links("news", 'EN');
	$myRss		= 	new cwd_rss091($pageNews);
	
	$myRss->set_rss_tblInfos($news->tbl_news, $news->fld_newsId, $news->fld_newsDescr, $news->fld_newsTitle, $news->fld_newsAuthId, $news->fld_newsDatePub, $news->tbl_newsAuth, $news->fld_newsAuthFirstName, $news->fld_newsAuthLastName);	
	$myRss->set_rss_link_param("", $pageNews.'-detail-', $pageNews.'-detail-'); //Varie selon chaque module	
	$myRss->set_rss_header("CABB News - Actualit� de la R�gion du Nord-Ouest", $myRss->get_datetime(), "NWR News - Actualit� RNO", $thewu32_site_url.'rss/rss.xml', "theWu32 Feeder", $thewu32_site_url.'modules/new/img/rss_news.gif', "NWR News", $thewu32_site_url.'modules/news/img/rss_news.gif', "Actualit&eacute; RNO");
	//$myRss->rss_customize_layout("Actualit� de l'Emploi au Cameroun", "Toutes l'actualit� de l'Emploi au Cameroun", $thewu32_site_url.'modules/job/img/rss_news.gif', "Actualit� Emploi Cameroun", "Actualit� Emploi Cameroun", "");
	$admin_pageTitle	=	"Gestionnaire des News";
	
	//Preparing the news spry dataset
	//$news->news_dsPath	=	'../modules/news/spry/data/spry-news.xml';
	//$news->create_ds_news($pageNews);
	//print "Page News :".$pageNews;
	$news->spry_ds_create();
?>

<?php 
	require_once('../modules/news/inc/news_validations.php');
?>

<?php 
	ob_end_flush();
?>
<?php include_once ('inc/admin_header.php');?>

     <?php if($_REQUEST[what]=="newsCatInsert"){ ?>
    
     <h3><?php print $mod_lang_output['MODULE_NAME']; ?> :: <?php print $mod_lang_output['PAGE_HEADER_ADD_NEWS_CATEGORY']; ?></h3>
     <?php if(isset($news_cat_insert_err_msg)) {  ?>
     <div class="ADM_err_msg"><?php print $news_cat_insert_err_msg; ?></div>
     <?php } ?>
     <?php if(isset($news_cat_insert_cfrm_msg)) {  ?>
     <div class="ADM_cfrm_msg"><?php print $news_cat_insert_cfrm_msg; ?></div>
     <?php } ?>
     
     <div class="tab-content">
		<div class="tab-pane active" id="horizontal-form">
              <form class="form-horizontal" id="frm_news_cat_insert" name="frm_news_cat_insert" method="post" action="">
                <div class="form-group">
					<label for="selLang" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_LANGUAGE']; ?></label>
					<div class="col-sm-8">
                        <select class="form-control" name="selLang" id="selLang">
						   <?php print $news->cmb_showLang($_POST[selLang]); ?>
                        </select>
					</div>
					<div class="col-sm-2">
						<!-- <p class="help-block">Your help text!</p> -->
					</div>
				</div>
                <div class="form-group">
					<label for="txt_newsCatCode" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_CODE']; ?></label>
					<div class="col-sm-8">
                        <input class="form-control1" name="txt_newsCatCode" type="text" id="txt_newsCatCode" maxlength="3" value="<?php print $news->show_content($news_cat_insert_err_msg, $txt_newsCatCode); ?>" />
					</div>
					<div class="col-sm-2">
						<p class="help-block">03 <?php print $mod_lang_output['FORM_HELP_CRT_MAX']; ?></p>
					</div>
				</div>
                <div class="form-group">
					<label for="txt_newsCatLib" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_LABEL']; ?></label>
					<div class="col-sm-8">
						<input class="form-control1" name="txt_newsCatLib" type="text" id="txt_newsCatLib" value="<?php print $news->show_content($news_cat_insert_err_msg, $txt_newsCatLib); ?>" />
                    </div>
					<div class="col-sm-2">
						<!-- <p class="help-block">Your help text!</p> -->
					</div>
				</div>
                <div class="form-group">
					<label for="ta_newsCatDescr" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_DESCRIPTION']; ?></label>
					<div class="col-sm-8">
                        <textarea class="form-control1" name="ta_newsCatDescr" cols="40" rows="15" id="ta_newsCatDescr"><?php print $news->show_content($news_cat_insert_err_msg, $ta_newsCatDescr); ?></textarea>
					</div>
					<div class="col-sm-2">
						<!-- <p class="help-block">Your help text!</p> -->
					</div>
				</div>
                <div class="panel-footer">
                <div class="row">
                    <div class="col-sm-8 col-sm-offset-2">
                        <button name="btn_newsCatInsert" id="btn_newsCatInsert" class="btn-success btn"><?php print $mod_lang_output['FORM_BUTTON_ADD_CATEGORY']; ?></button>
                    </div>
                </div>
             </div>
              </form>
             </div>
         </div>
     
     <?php } ?>
     
     <!-- ********************************* Afficher les rubriques de news  ******************************************************
      ****************************************************************************************************************-->
     
     <?php if($_REQUEST[what]=="newsCatDisplay") { ?>
     <div class="col-sm-6">
	     <h3><?php print $mod_lang_output['MODULE_NAME']; ?> :: <?php print $mod_lang_output['PAGE_HEADER_LIST_NEWS_CATEGORIES']; ?></h3>
	     <?php if(isset($news_cat_display_err_msg)) {  ?>
	     <div class="ADM_err_msg"><?php print $news_cat_display_err_msg; ?></div>
	     <?php } ?>
	     <?php if(isset($news_cat_display_cfrm_msg)) {  ?>
	     <div class="ADM_cfrm_msg"><?php print $news_cat_display_cfrm_msg; ?></div>
	     <?php } ?>
	     	<div class="panel panel-warning" data-widget="{&quot;draggable&quot;: &quot;false&quot;}" data-widget-static="">
	          	<div class="panel-body no-padding">
	     			<?php print stripslashes($news->admin_load_news_cat()); ?>
	            </div>
	     	</div>
     	</div>
     <?php } ?>
     
     <!-- ********************************* Modifier les rubriques de news  ******************************************************
      ****************************************************************************************************************-->
     <?php if(isset($news_catUpdate) && ($_REQUEST[what]=="newsCatDisplay")){ ?>
     <div class="col-sm-6">
	     <h3><?php print $mod_lang_output['PAGE_HEADER_UPDATE_NEWS_CATEGORY']; ?></h3>
	     <?php if(isset($news_cat_update_err_msg)) {  ?>
	     <div class="ADM_err_msg"><?php print $news_cat_update_err_msg; ?></div>
	     <?php } ?>
	     <?php if(isset($news_cat_update_cfrm_msg)) {  ?>
	     <div class="ADM_cfrm_msg"><?php print $news_cat_update_cfrm_msg; ?></div>
	     <?php } ?>
	     
	     
	     <div class="tab-content">
			<div class="tab-pane active" id="horizontal-form">
	              <form class="form-horizontal" id="frm_news_cat_update" name="frm_news_cat_update" method="post" action="">
	                <div class="form-group">
						<label for="selLangUpd" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_LANGUAGE']; ?></label>
						<div class="col-sm-8">
	                        <select class="form-control" name="selLangUpd" id="selLangUpd">
				               <?php print $news->cmb_showLang($tabCatUpd[LANG]); ?>
				            </select>
						</div>
						<div class="col-sm-2">
							<!-- <p class="help-block">Your help text!</p> -->
						</div>
					</div>
	                <div class="form-group">
						<label for="txt_newsCatCodeUpd" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_CODE']; ?></label>
						<div class="col-sm-8">
							<input type	="hidden" name="hd_newsCatCodeUpd" value="<?php print $tabCatUpd[CATID]; ?>" />
	                        <input disabled class="form-control1" name="txt_newsCatCodeUpd" type="text" id="txt_newsCatCodeUpd" value="<?php print $tabCatUpd[CATID]; ?>" maxlength="3" />
						</div>
						<div class="col-sm-2">
							<p class="help-block">03 <?php print $mod_lang_output['FORM_HELP_CRT_MAX']; ?></p>
						</div>
					</div>
	                <div class="form-group">
						<label for="txt_newsCatLibUpd" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_LABEL']; ?></label>
						<div class="col-sm-8">
							<input class="form-control1" name="txt_newsCatLibUpd" value="<?php print stripslashes($tabCatUpd[TITLE]); ?>" type="text" id="txt_newsCatLibUpd" />
	                    </div>
						<div class="col-sm-2">
							<!-- <p class="help-block">Your help text!</p> -->
						</div>
					</div>
	                <div class="form-group">
						<label for="ta_newsCatDescrUpd" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_DESCRIPTION']; ?></label>
						<div class="col-sm-8">
	                        <textarea class="form-control1" name="ta_newsCatDescrUpd" cols="40" rows="5" id="ta_newsCatDescrUpd"><?php print  stripslashes($tabCatUpd[DESCR]); ?></textarea>
						</div>
						<div class="col-sm-2">
							<!-- <p class="help-block">Your help text!</p> -->
						</div>
					</div>
	                <div class="panel-footer">
	                <div class="row">
	                    <div class="col-sm-8 col-sm-offset-2">
	                    	<input type="hidden" name="hd_newsCatId" value="<?php print $_REQUEST[$news->URI_newsCatId]; ?>" />
	                        <button name="btn_newsCatUpd" id="btn_newsCatUpd" class="btn-success btn"><?php print $mod_lang_output['FORM_BUTTON_UPDATE']; ?></button>
	                    </div>
	                </div>
	             </div>
	              </form>
	             </div>
	         </div>
		</div>		       
     <?php } ?>     
     
     <!-- ********************************* Ajouter une news  ******************************************************
      ****************************************************************************************************************-->
     
     <?php if($_REQUEST[what]=="newsInsert") { ?>
     <?php $currentLang = (($_REQUEST[langId] != '') ? ($_REQUEST[langId]) : ($_SESSION['LANG'])); ?>
     
      <h3><?php print $mod_lang_output['MODULE_NAME']; ?> :: <?php print $mod_lang_output['PAGE_HEADER_ADD_NEWS']; ?></h3>
      
      <?php if(isset($err_newsInsert)) {  ?>
      <div class="ADM_err_msg"><?php print $err_newsInsert; ?></div>
      <?php } ?>
      <?php if(isset($cfrm_newsInsert)) {  ?>
      <div class="ADM_cfrm_msg"><?php print $cfrm_newsInsert; ?></div>
      <?php } ?>
      
      <div class="tab-content">
		<div class="tab-pane active" id="horizontal-form">
              <form class="form-horizontal" action="" method="post" enctype="multipart/form-data" name="frm_news_insert" id="frm_news_insert">
                <div class="form-group">
					<label for="sel_newsLang" class="col-sm-2 control-label"><?php print $lang_output['FORM_LABEL_LANGUAGE']; ?></label>
					<div class="col-sm-8">
						<select class="form-control"  name="sel_newsLang" id="jumpMenu" onChange="MM_jumpMenu('parent',this,0)">
							<?php print stripslashes($news->redir_cmb_load_langs($_REQUEST['langId'], $news->admin_modPage, "newsInsert")); ?>
                          </select>
                          <input name="hdLang" type="hidden" value="<?php print $_REQUEST['langId'];?>" />
					</div>
					<div class="col-sm-2">
						<!-- <p class="help-block">Your help text!</p> -->
					</div>
				</div>
                <div class="form-group">
					<label for="ta_newsTags" class="col-sm-2 control-label"><?php print $lang_output['FORM_LABEL_TAGS']; ?></label>
					<div class="col-sm-8">
                        <textarea class="form-control1" name="ta_newsTags" id="ta_newsTags" cols="50" rows="15"><?php print $news->show_content($err_newsInsert, $ta_newsTags); ?></textarea>
					</div>
					<div class="col-sm-2">
						<!-- <p class="help-block">Your help text!</p> -->
					</div>
				</div>
                <div class="form-group">
					<label for="txt_newsTitle" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_NEWS_TITLE']; ?></label>
					<div class="col-sm-8">
                        <input class="form-control1" name="txt_newsTitle" type="text" id="txt_newsTitle" value="<?php print $news->show_content($err_newsInsert, $txt_newsTitle); ?>" />
					</div>
					<div class="col-sm-2">
						<!-- <p class="help-block">04 Caracters Max</p> -->
					</div>
				</div>
                <div class="form-group">
					<label for="ta_newsHead" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_NEWS_HEADER']; ?></label>
					<div class="col-sm-8">
                        <textarea class="form-control1" name="ta_newsHead" id="ta_newsHead" style="height: 10em;"><?php print $news->show_content($err_newsInsert, $ta_newsHead); ?></textarea>
					</div>
					<div class="col-sm-2">
						<!-- <p class="help-block">04 Caracters Max</p> -->
					</div>
				</div>
                <div class="form-group">
					<label for="sel_newsCat" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_NEWS_CATEGORY']; ?></label>
					<div class="col-sm-8">
                        <select class="form-control" name="sel_newsCat" id="sel_newsCat">
                        	<?php print $news->admin_cmb_show_rub_by_lang($currentLang, $_POST[sel_newsCat]); ?>
                        </select>
					</div>
					<div class="col-sm-2">
						<!-- <p class="help-block">04 Caracters Max</p> -->
					</div>
				</div>
                <div class="form-group">
					<label for="file_newsHead" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_NEWS_IMG_HEADER']; ?></label>
					<div class="col-sm-8">
                        <input class="form-control1" type="file" name="file_newsHead" id="file_newsHead" />
					</div>
					<div class="col-sm-2">
						<p class="help-block">NB : <?php print $news->img_homeWidth; ?>px X <?php print $news->img_homeHeight; ?>px</p>
					</div>
				</div>
                <div class="form-group">
					<label for="txt_memberTel" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_NEWS_DATE-PUB']; ?></label>
					<div class="col-sm-8">
						<?php print $news->combo_datetime($arrDate['DAY'], $arrDate['MONTH'], $arrDate['YEAR'], '', '', '', '', $_SESSION[LANG]); ?>
					</div>
					<div class="col-sm-2">
						<!-- <p class="help-block">04 Caracters Max</p> -->
					</div>
				</div>
                <div class="form-group">
					<label for="ta_newsContent" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_NEWS_CONTENT']; ?></label>
					<div class="col-sm-8">
                        <?php /*
							$oFCKeditor = new FCKeditor('ta_newsContent');
							$oFCKeditor->Height="450";
							$oFCKeditor->Width="750";
							$oFCKeditor->ToolbarSet = "Yafe";
							$oFCKeditor->BasePath = $thewu32_site_url.'admin/fckeditor/';
							$oFCKeditor->Value = $news->show_content($err_newsInsert, $ta_newsContent);
							$oFCKeditor->Create(); */
						?>
						<textarea name="ta_newsContent" cols="100" rows="5" id="ta_newsContent"><?php print $news->show_content($err_newsInsert, $ta_newsContent) ?></textarea>
						<script language="JavaScript1.2" type="text/javascript">
							generate_wysiwyg('ta_newsContent');
						</script>
					</div>
					<div class="col-sm-2">
						<!-- <p class="help-block">04 Caracters Max</p> -->
					</div>
				</div>
                <div class="form-group">
					<label for="sel_newsAuthor" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_NEWS_AUTHOR']; ?></label>
					<div class="col-sm-8">
                        <select class="form-control" name="sel_newsAuthor" id="sel_newsAuthor">
							<?php print $news->cmb_getNewsAuthors(); ?>
                        </select> 
                        
					</div>
					<div class="col-sm-2">
						<p class="help-block">[<a href="#" onClick="<?php print $news->popup("news_author_add.php", 300, 200) ?>"><?php print $mod_lang_output['PAGE_LINK_ADD_NEWS_AUTHOR']; ?></a>]</p>
					</div>
				</div>
                <div class="form-group">
					<label for="file_newsThumb" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_NEWS_THUMBNAIL']; ?> 1</label>
					<div class="col-sm-8">
                        <input class="form-control1" type="file" name="file_newsThumb" id="file_newsThumb" />
					</div>
					<div class="col-sm-2">
						<!-- <p class="help-block">04 Caracters Max</p> -->
					</div>
				</div>
                <div class="form-group">
					<label for="file_newsThumb2" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_NEWS_THUMBNAIL']; ?> 2</label>
					<div class="col-sm-8">
                        <input class="form-control1" type="file" name="file_newsThumb2" id="file_newsThumb2" />
					</div>
					<div class="col-sm-2">
						<!-- <p class="help-block">04 Caracters Max</p> -->
					</div>
				</div>
                <div class="panel-footer">
	                <div class="row">
	                    <div class="col-sm-8 col-sm-offset-2">
	                        <button name="btn_newsInsert" id="btn_newsInsert" class="btn-success btn"><?php print $mod_lang_output['FORM_BUTTON_ADD_NEWS']; ?></button>
	                    </div>
	                </div>
             	</div>
              </form>
             </div>
         </div>
      
      
        <?php } ?>
    <!-- ********************************* Afficher les news  ******************************************************
      ****************************************************************************************************************-->
      
	    <!-- Fixer le tab du formulaire -->
	    <!-- Fix the Tab  -->
      	<?php if(isset($_POST['btnTitle'])) { ?>
      		<p>Tongolo</p>
			<script> $('a[href="#tabForm"]').click(); </script>
		<?php } ?>
      
    
    <?php if(!isset($_REQUEST[what]) || ($_REQUEST[what]=="newsDisplay")) { ?>
          <h3><?php print $mod_lang_output['MODULE_NAME']; ?> :: <?php print $mod_lang_output['PAGE_HEADER_LIST_NEWS']; ?></h3>
          
          <?php if(isset($err_newsDisplay)) {  ?>
          <div class="ADM_err_msg"><?php print $err_newsDisplay; ?></div>
          <?php } ?>
          <?php if(isset($cfrm_newsDisplay)) {  ?>
          <div class="ADM_cfrm_msg"><?php print $cfrm_newsDisplay; ?></div>
          <?php } ?>
          <div class="panel panel-warning" data-widget="{&quot;draggable&quot;: &quot;false&quot;}" data-widget-static="">
          		<div class="panel-body no-padding">
          			<?php print $news->admin_load_news(20); ?>
                </div>
           </div>
          <p>&nbsp;</p>
      <?php } ?>
      
      
   <!-- ********************************* Afficher les auteurs de news  ******************************************************
      ****************************************************************************************************************-->
      <div class="col-sm-6">
	      <?php if($_REQUEST[what]== "news_authorDisplay") { ?>
	          <h3><?php print $mod_lang_output['MODULE_NAME']; ?> :: <?php print $mod_lang_output['PAGE_HEADER_LIST_NEWS_AUTHORS']; ?></h3>
	          <?php if(isset($err_newsAuthorDisplay)) {  ?>
	          <div class="ADM_err_msg"><?php print $err_newsAuthorDisplay; ?></div>
	          <?php } ?>
	          <?php if(isset($cfrm_newsAuthorDisplay)) {  ?>
	          <div class="ADM_cfrm_msg"><?php print $cfrm_newsAuthorDisplay; ?></div>
	          <?php } ?>
	          <?php if(isset($_SESSION['CONNECTED_ADMIN'])) { $actionView = '1'; ?>
	          	<!-- For admins only -->
	          	<p><strong><?php print $lang_output['LABEL_ADD']; ?> :</strong> <a href="?what=news_authorInsert"><?php print $lang_output['LABEL_AUTHOR']; ?></a> | <a href="?what=news_authorGroupInsert"><?php print $lang_output['LABEL_AUTHORS_GROUP']; ?></a></p>
	          <?php } ?>
	          <div class="panel panel-warning" data-widget="{&quot;draggable&quot;: &quot;false&quot;}" data-widget-static="">
	          		<div class="panel-body no-padding">
			  			<?php print $news->admin_load_news_authors(50, $actionView); ?>
	                </div>
	           </div>
	          <p>&nbsp;</p>
	      <?php } ?>
      </div>
      
       <!-- ********************************* Update news authors ******************************************************
      ****************************************************************************************************************--> 
      <div class="col-sm-6">     
        <?php if(isset($news_authorUpdate)){?>
        	<h3><?php print $mod_lang_output['PAGE_HEADER_UPDATE_NEWS_AUTHOR']; ?></h3>
			<?php if(isset($err_newsAuthorUpdate)) { ?>
		  		<div class="ADM_err_msg"><?php print $err_newsAuthorUpdate; ?></div>
		    <?php } ?>
			<?php if(isset($cfrm_newsAuthorUpdate)) { ?>
		  		<div class="ADM_cfrm_msg"><?php print $cfrm_newsAuthorUpdate; ?></div>
		    <?php } ?>
            
            <div class="tab-content">
                <div class="tab-pane active" id="horizontal-form">
                      <form class="form-horizontal" action="" method="post" name="frm_newsAuthorUpdate" id="frm_newsAuthorUpdate">
                        <div class="form-group">
                            <label for="txt_newsAuthorLastUpdate" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_LAST-NAME']; ?></label>
                            <div class="col-sm-8">
                                <input class="form-control1" name="txt_newsAuthorLastUpdate" type="text" id="txt_newsAuthorLastUpdate" size="30" value="<?php print $tab_newsAuthorUpd["AUTH_LAST"]; ?>" />
                            </div>
                            <div class="col-sm-2">
                                <!-- <p class="help-block">Your help text!</p> -->
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="txt_newsAuthorFirstUpdate" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_FIRST-NAME']; ?></label>
                            <div class="col-sm-8">
                                <input class="form-control1" name="txt_newsAuthorFirstUpdate" type="text" id="txt_newsAuthorFirstUpdate" size="30" value="<?php print $tab_newsAuthorUpd["AUTH_FIRST"]; ?>" />
                            </div>
                            <div class="col-sm-2">
                                <!-- <p class="help-block">Your help text!</p> -->
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="sel_newsAuthorSexUpdate" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_SEX']; ?></label>
                            <div class="col-sm-8">
                                <select class="form-control" name="sel_newsAuthorSexUpdate" id="sel_newsAuthorSexUpdate">
                                    <option value="M"<?php print ($tab_newsAuthorUpd["AUTH_SEX"] == "M") ? (" SELECTED") : ("")?>><?php print $mod_lang_output['FORM_VALUE_SEX_1']; ?></option>
                                    <option value="F"<?php print ($tab_newsAuthorUpd["AUTH_SEX"] == "F") ? (" SELECTED") : ("")?>><?php print $mod_lang_output['FORM_VALUE_SEX_2']; ?></option>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <!-- <p class="help-block">Your help text!</p> -->
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="sel_newsAuthorCatUpdate" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_GROUP']; ?></label>
                            <div class="col-sm-8">
                                <select class="form-control" name="sel_newsAuthorCatUpdate" id="sel_newsAuthorCatUpdate">
									<?php print $news->cmb_get_news_author_cat($tab_newsAuthorUpd["AUTH_CAT_ID"]); ?>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <!-- <p class="help-block">Your help text!</p> -->
                            </div>
                        </div>
                        <div class="panel-footer">
                            <div class="row">
                                <div class="col-sm-8 col-sm-offset-2">
                                    <button name="btn_newsAuthorUpdate" id="btn_newsAuthorUpdate" class="btn-success btn"><?php print $mod_lang_output['FORM_BUTTON_UPDATE']; ?></button>
                                    <input type="hidden" name="hd_newsAuthorIdUpdate" value="<?php print $tab_newsAuthorUpd["AUTH_ID"] ?>" />
                                </div>
                            </div>
                        </div>            
        			</form>
        		</div>
              </div>
        <?php }?>
      </div>
      
    <!-- ********************************* Insert news author groups ******************************************************
      ****************************************************************************************************************-->
      <?php if($_REQUEST[what]== "news_authorGroupInsert") { ?>
          <h3><?php print $mod_lang_output['MODULE_NAME']; ?> :: <?php print $mod_lang_output['PAGE_HEADER_ADD_AUTHOR_GROUP']; ?></h3>
          <?php if(isset($err_newsAuthorGroupInsert)) {  ?>
          <div class="ADM_err_msg"><?php print $err_newsAuthorGroupInsert; ?></div>
          <?php } ?>
          <?php if(isset($cfrm_newsAuthorGroupInsert)) {  ?>
          <div class="ADM_cfrm_msg"><?php print $cfrm_newsAuthorGroupInsert; ?></div>
          <?php } ?>
          <div class="tab-content">
			<div class="tab-pane active" id="horizontal-form">
            	<form class="form-horizontal" action="?what=news_authorGroupInsert" method="post" name="frm_news_group_insert" id="frm_news_group_insert">
	            	<div class="form-group">
						<label for="txt_newsAuthorGroupInsert" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_AUTHOR_GROUP']; ?></label>
						<div class="col-sm-8">
	          				<input class="form-control1" type="text" name="txt_newsAuthorGroupInsert" />
	          			</div>
	          		</div>
	          		<div class="panel-footer">
	                    <div class="row">
	                        <div class="col-sm-8 col-sm-offset-2">
	                            <button name="btn_newsAuthorGroupInsert" id="btn_newsAuthorGroupInsert" class="btn-success btn"><?php print $mod_lang_output['FORM_BUTTON_ADD_AUTHOR_GROUP']; ?></button>
	                        </div>
	                    </div>
	                 </div>
          		</form>
          <p>&nbsp;</p>
      <?php } ?>
      
      
     <!-- ********************************* Update the news  ******************************************************
      ****************************************************************************************************************-->
      <?php if($news_update) { // Si on a clique sur modifier l'article... ?>
      <h3><?php print $mod_lang_output['MODULE_NAME']; ?> :: <?php print $mod_lang_output['PAGE_HEADER_UPDATE_NEWS']; ?></h3>
      
      <?php if(isset($err_newsUpdate)) {  ?>
      <div class="ADM_err_msg"><?php print $err_newsUpdate; ?></div>
      <?php } ?>
      <?php if(isset($cfrm_newsUpdate)) {  ?>
      <div class="ADM_cfrm_msg"><?php print $cfrm_newsUpdate; ?></div>
      <?php } ?>
      
      <div class="tab-content">
		<div class="tab-pane active" id="horizontal-form">
              <form class="form-horizontal" action="" method="post" enctype="multipart/form-data" name="frm_news_update" id="frm_news_pdate">
                <div class="form-group">
					<label for="sel_newsLangIdUpdate" class="col-sm-2 control-label"><?php print $lang_output['FORM_LABEL_LANGUAGE']; ?></label>
					<div class="col-sm-8">
                        <select class="form-control" name="sel_newsLangIdUpdate" id="sel_newsLangIdUpdate">
							<?php print $news->cmb_showLang($tabUpd[LANG]); ?>
                        </select>
					</div>
					<div class="col-sm-2">
						<!-- <p class="help-block">Your help text!</p> -->
					</div>
				</div>
                <div class="form-group">
					<label for="ta_newsTagsUpdate" class="col-sm-2 control-label"><?php print $lang_output['FORM_LABEL_TAGS']; ?></label>
					<div class="col-sm-8">
                        <textarea class="form-control1" name="ta_newsTagsUpdate" id="ta_newsTagsUpdate" rows="7"><?php print $tabUpd[TAGS] ?></textarea>
					</div>
					<div class="col-sm-2">
						<!-- <p class="help-block">Your help text!</p> -->
					</div>
				</div>
                <div class="form-group">
					<label for="txt_newsTitleUpdate" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_NEWS_TITLE']; ?></label>
					<div class="col-sm-8">
                        <input class="form-control1" name="txt_newsTitleUpdate" type="text" id="txt_newsTitleUpdate" value="<?php print $tabUpd[TITLE] ?>" />
					</div>
					<div class="col-sm-2">
						<!-- <p class="help-block">04 Caracters Max</p> -->
					</div>
				</div>
                <div class="form-group">
					<label for="ta_newsHeadUpdate" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_NEWS_HEADER']; ?></label>
					<div class="col-sm-8">
                        <textarea class="form-control1" name="ta_newsHeadUpdate" id="ta_newsHeadUpdate" style="height: 10em;"><?php print stripslashes($tabUpd[DESCR]); ?></textarea>
					</div>
					<div class="col-sm-2">
						<!-- <p class="help-block">04 Caracters Max</p> -->
					</div>
				</div>
                <div class="form-group">
					<label for="sel_newsCatIdUpdate" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_NEWS_CATEGORY']; ?></label>
					<div class="col-sm-8">
                        <select class="form-control" name="sel_newsCatIdUpdate" id="sel_newsCatIdUpdate">
							<?php print stripslashes($news->cmb_getNewsCat($tabUpd[CATID], $_SESSION['LANG'])); ?>
                        </select>
					</div>
					<div class="col-sm-2">
						<!-- <p class="help-block">04 Caracters Max</p> -->
					</div>
				</div>
                <div class="form-group">
					<label for="file_newsHeadImgUpdate" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_NEWS_IMG_HEADER']; ?></label>
					<div class="col-sm-8">
                        <input class="form-control1" type="file" name="file_newsHeadImgUpdate" id="file_newsHeadImgUpdate" />
                        <input name="hd_newsHeadImg" type="hidden" id="hd_newsHeadImg" value="<?php print $tabUpd[HEADIMG] ?>" />
					</div>
					<div class="col-sm-2">
						<p class="help-block">NB : Image 490px x 249px<br /><?php print $lang_output['FORM_HELP_LEAVE_EMPTY']; ?></p>
					</div>
				</div>
                <div class="form-group">
					<label for="sel_dateUpd" class="col-sm-2 control-label"><?php print $lang_output['FORM_LABEL_PUB-DATE']; ?></label>
					<div class="col-sm-8">
						<?php print $news->combo_datetime_update($tabUpd["DATE"], 'Upd', $_SESSION['LANG'], 'form-control');//$event->combo_datetimeEnUpd($tabUpd[eventSTART], '2012', 1); ?>
                        <?php //print $news->combo_load_datetime_update($tabUpd["DATE"], 'Upd'); //$news->combo_datetimeEnUpd($tabUpd["DATE"]); ?>
					</div>
					<div class="col-sm-2">
						<!-- <p class="help-block">04 Caracters Max</p> -->
					</div>
				</div>
                <div class="form-group">
					<label for="ta_newsContent" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_NEWS_CONTENT']; ?></label>
					<div class="col-sm-8">
						<textarea name="ta_newsContentUpdate" cols="40" rows="5" id="ta_newsContentUpdate"><?php print stripslashes($tabUpd[CONTENT]); ?></textarea>
						<script language="JavaScript1.2" type="text/javascript">
							generate_wysiwyg('ta_newsContentUpdate');
						</script>
					</div>
					<div class="col-sm-2">
						<!-- <p class="help-block">04 Caracters Max</p> -->
					</div>
				</div>
                <div class="form-group">
					<label for="sel_newsAuthorIdUpdate" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_NEWS_AUTHOR']; ?></label>
					<div class="col-sm-8">
                        <select class="form-control" name="sel_newsAuthorIdUpdate" id="sel_newsAuthorIdUpdate">
							<?php print $news->cmb_getNewsAuthors($tabUpd[AUTHOR]); ?>
                        </select> 
                        
					</div>
					<div class="col-sm-2">
						<p class="help-block">[<a href="#" onClick="<?php print $news->popup("news_author_add.php", 300, 200) ?>"><?php print $mod_lang_output['PAGE_LINK_ADD_NEWS_AUTHOR']; ?></a>]</p>
					</div>
				</div>
                <div class="form-group">
					<label for="file_newsThumbUpdate" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_NEWS_THUMBNAIL']; ?></label>
					<div class="col-sm-8">
                        <input class="form-control1" type="file" name="file_newsThumbUpdate" id="file_newsThumbUpdate" />
                        <input name="hd_newsThumb" type="hidden" id="hd_newsThumb" value="<?php print $tabUpd[THUMB] ?>" />
					</div>
					<div class="col-sm-2">
						<p class="help-block"><?php print $lang_output['FORM_HELP_LEAVE_EMPTY']; ?></p>
					</div>
				</div>
                <div class="panel-footer">
                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-2">
                            <input name="hd_newsId" type="hidden" id="hd_newsId" value="<?php print $tabUpd[ID]; ?>" />
                            <button name="btn_newsUpdate" id="btn_newsUpdate" class="btn-success btn"><?php print $mod_lang_output['FORM_BUTTON_UPDATE']; ?></button>
                        </div>
                    </div>
                 </div>
              </form>
             </div>
         </div>
      
      
        <p>&nbsp;</p>
        <?php } ?>
        
     <!-- ********************************* Create news authors ******************************************************
      ****************************************************************************************************************-->       
        <?php if($_REQUEST['what'] ==  'news_authorInsert'){ ?>
        	<h3><?php print $mod_lang_output['MODULE_NAME']; ?> :: <?php print $mod_lang_output['PAGE_HEADER_ADD_NEWS_AUTHOR']; ?></h3>
			<?php if(isset($err_newsAuthorInsert)) { ?>
		  		<div class="ADM_err_msg"><?php print $err_newsAuthorInsert; ?></div>
		    <?php } ?>
			<?php if(isset($cfrm_newsAuthorUpdate)) { ?>
		  		<div class="ADM_cfrm_msg"><?php print $cfrm_newsAuthorInsert; ?></div>
		    <?php } ?>
            
            <div class="tab-content">
                <div class="tab-pane active" id="horizontal-form">
                      <form class="form-horizontal" action="" method="post" name="frm_newsAuthorInsert" id="frm_newsAuthorInsert">
                        <div class="form-group">
                            <label for="txtNom" class="col-sm-2 control-label"><?php print $lang_output['FORM_LABEL_LAST-NAME']; ?></label>
                            <div class="col-sm-8">
                                <input class="form-control1" name="txtNom" type="text" id="txt_newsAuthorLastUpdate" size="30" value="<?php print $news->show_content($err_newsAuthorInsert, $txtNom); ?>" />
                            </div>
                            <div class="col-sm-2">
                                <!-- <p class="help-block">Your help text!</p> -->
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="txtPrenom" class="col-sm-2 control-label"><?php print $lang_output['FORM_LABEL_FIRST-NAME']; ?></label>
                            <div class="col-sm-8">
                                <input class="form-control1" name="txtPrenom" type="text" id="txt_newsAuthorFirstUpdate" size="30" value="<?php print $news->show_content($err_newsAuthorInsert, $txtPrenom); ?>" />
                            </div>
                            <div class="col-sm-2">
                                <!-- <p class="help-block">Your help text!</p> -->
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="selSex" class="col-sm-2 control-label"><?php print $lang_output['FORM_LABEL_SEX']; ?></label>
                            <div class="col-sm-8">
                                <select class="form-control" name="selSex" id="selSex">
                                    <option value="NULL">[ <?php print $lang_output['FORM_VALUE_CHOOSE']; ?> ]</option>
								        <option value="M"><?php print $lang_output['FORM_VALUE_SEX_1']; ?></option>
								        <option value="F"><?php print $lang_output['FORM_VALUE_SEX_2']; ?></option>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <!-- <p class="help-block">Your help text!</p> -->
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="selGroup" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_AUTHOR_GROUP']; ?></label>
                            <div class="col-sm-8">
                                <select class="form-control" name="selGroup" id="sel_newsAuthorCatUpdate">
									<?php print $news->cmb_get_news_author_cat(); ?>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <!-- <p class="help-block">Your help text!</p> -->
                            </div>
                        </div>
                        <div class="panel-footer">
                            <div class="row">
                                <div class="col-sm-8 col-sm-offset-2">
                                    <button onclick="javascript:parent.opener.location.reload();" name="btn_authorInsert" id="btn_authorInsert" class="btn-success btn"><?php print $mod_lang_output['FORM_BUTTON_ADD_NEWS_AUTHOR']; ?></button>
                                </div>
                            </div>
                        </div>            
        			</form>
        		</div>
              </div>
        <?php }?>
     
    
    <!-- ********************************* Display news author groups ******************************************************
      ****************************************************************************************************************-->
      <div class="col-sm-6">
	    <?php if($_REQUEST[what]=="news_authorCatDisplay") { ?>
	          <h3><?php print $mod_lang_output['MODULE_NAME']; ?> :: <?php print $mod_lang_output['PAGE_HEADER_LIST_AUTHOR_GROUPS']; ?></h3>
	          <p>[<a href="?what=news_authorGroupInsert"><?php print $mod_lang_output['PAGE_LINK_ADD_NEWS_AUTHOR_GROUP']; ?></a>]</p>
	          <?php if(isset($err_newsAuthorCatDisplay)) {  ?>
	          <div class="ADM_err_msg"><?php print $err_newsAuthorCatDisplay; ?></div>
	          <?php } ?>
	          <?php if(isset($cfrm_newsAuthorCatDisplay)) {  ?>
	          <div class="ADM_cfrm_msg"><?php print $cfrm_newsAuthorCatDisplay; ?></div>
	          <?php } ?>
	          <div class="panel panel-warning" data-widget="{&quot;draggable&quot;: &quot;false&quot;}" data-widget-static="">
	          		<div class="panel-body no-padding">
	          			<?php print $news->admin_load_news_authors_cat(); ?>
	                </div>
	          </div>
	          <p>&nbsp;</p>
	      <?php } ?>
      </div>
    
    
    <!-- ********************************* Update news author groups ******************************************************
      ****************************************************************************************************************-->
     <div class="col-sm-6">
	    <?php if(($_REQUEST[what]=="news_authorCatDisplay") && (isset($news_authorCatUpdate))) { ?>
	    	
	    	<h3><?php print $mod_lang_output['PAGE_HEADER_UPDATE_AUTHORS_GROUP']; ?></h3>
	    	
	    	<?php if(isset($err_newsAuthorCatUpdate)) { ?>
			  	<div class="ADM_err_msg"><?php print $err_newsAuthorCatUpdate; ?></div>
			<?php } ?>
			<?php if(isset($cfrm_newsAuthorCatUpdate)) { ?>
			  	<div class="ADM_cfrm_msg"><?php print $cfrm_newsAuthorCatUpdate; ?></div>
			<?php } ?>
	        <div class="tab-content">
	                <div class="tab-pane active" id="horizontal-form">
	                    <form class="form-horizontal" method="post" name="frm_newsAuthorCatUpdate" action="">
	                    	<div class="form-group">
	                            <label for="txt_newsAuthorCatUpdate" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_LABEL']; ?></label>
	                            <div class="col-sm-8">
	                                <input class="form-control1" type="text" name="txt_newsAuthorCatUpdate" value="<?php print $tab_newsAuthorCatUpd["TITLE"]; ?>" />
	                            </div>
	                            <div class="col-sm-2">
	                                <!-- <p class="help-block">Your help text!</p> -->
	                            </div>
	                        </div>
	                        <div class="panel-footer">
	                            <div class="row">
	                                <div class="col-sm-8 col-sm-offset-2">
	                                    <button name="btn_newsAuthorCatUpdate" id="btn_newsAuthorCatUpdate" class="btn-success btn"><?php print $mod_lang_output['FORM_BUTTON_UPDATE']; ?></button>
	                                    <input type="hidden" />
	                                </div>
	                            </div>
	                        </div>  
	                    </form>
	                </div>
	        </div>
	    	<p>&nbsp;</p>
	    <?php } ?>
    </div>

<!-- ********************************* Display news comments ******************************************************
      ****************************************************************************************************************-->
     <?php if($_REQUEST[what]=="news_commentDisplay") { ?>
          <h3><?php print $mod_lang_output['MODULE_NAME']; ?> :: <?php print $mod_lang_output['PAGE_HEADER_LIST_NEWS_COMMENTS']; ?></h3>
          <?php $news->limit = $_REQUEST[limite]; ?>
          
          <?php if(isset($err_newsDisplay)) {  ?>
          <div class="ADM_err_msg"><?php print $err_newsCommentDisplay; ?></div>
          <?php } ?>
          <?php if(isset($cfrm_newsDisplay)) {  ?>
          <div class="ADM_cfrm_msg"><?php print $cfrm_newsCommentDisplay; ?></div>
          <?php } ?>
          
          <div class="panel panel-warning" data-widget="{&quot;draggable&quot;: &quot;false&quot;}" data-widget-static="">
          		<div class="panel-body no-padding">
          			<?php print $news->admin_load_news_comment(); ?>
                </div>
          </div>
          <p>&nbsp;</p>
      <?php } ?>

<?php include_once ('inc/admin_footer.php');?>
