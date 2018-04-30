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
	$system				= 	new cwd_system();
	$myPage				= 	new cwd_page();
	$system->session_checker($_SESSION["CONNECTED_ADMIN"], $_SESSION["CONNECTED_EDIT"]);
	$gallery			= 	new cwd_gallery("../modules/gallery/img/thumbs/", "../modules/gallery/img/main/", "../modules/gallery/spry/data/");
	$pageGallery		= 	$myPage->get_pages_modules_links("gallery");
	$admin_pageTitle	=	"Gestionnaire de Gal&eacute;rie Photo";
	//$gallery->URI_galleryCatVar	= $_REQUEST[$URI_galleryCatVar];
	
	$gallery->build_step_carousel("../modules/gallery/stepcarousel.htm", $pageGallery, 10);
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
	require_once("../modules/gallery/langfiles/".$langFile.".php"); //Module language pack
	
	//Page name
	$admin_pageTitle	=	$mod_lang_output['MODULE_DESCR'];
?>

<?php 
	require_once('../modules/gallery/inc/gallery_validations.php');
	//print $gallery->spry_ds_create();
?>

<?php
	ob_end_flush();
?>

<?php include_once('inc/admin_header.php');?>

	  <?php //print $gallery->admin_get_menu(); ?>
	  
      <!-- Modifier les images -->
      <a name="UPDATE"></a>
      <?php if(($_REQUEST[what] == "galleryUpdate") && ($_REQUEST[action]=="galleryUpdate")){ $tab_gallery = $gallery->get_gallery($_REQUEST[$gallery->URI_galleryVar]);?>
      <h3><?php print $mod_lang_output['MODULE_NAME']; ?> :: <?php print $mod_lang_output['PAGE_HEADER_UPDATE_GALLERY_CATEGORY']; ?></h3>
      
      <?php if(isset($gallery_update_err_msg)) {  ?>
      <div class="ADM_err_msg"><?php print $gallery_update_err_msg; ?></div>
      <?php } ?>
      <?php if(isset($gallery_update_cfrm_msg)) {  ?>
      <div class="ADM_cfrm_msg"><?php print $gallery_update_cfrm_msg; ?></div>
      <?php } ?>
      
		<form class="form-horizontal" enctype="multipart/form-data" action="" method="post">
			<div class="form-group">
	            <label for="selCat_upd" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_CATEGORY']; ?></label>
	            <div class="col-sm-8">
	            	<select class="form-control" name="selCat_upd">
	              		<?php print $gallery->load_cmb_gallery_cat($tab_gallery[CATID]); ?>
	            	</select>
	            </div>
	            <div class="col-sm-2"><!-- <p class="help-block">Type your help text here</p> --></div>
          	</div>
          
          	<div class="form-group">
            	<label for="gallery_file_upd" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_NEW_IMAGE']; ?></label>
            	<div class="col-sm-8">
            		<input class="form-control1" type="file" name="gallery_file_upd" />
            	</div>
            	<div class="col-sm-2">
            		<p class="help-block"><?php print $mod_lang_output['FORM_HELP_LEAVE_EMPTY']; ?></p>
            	</div>
          	</div>
          	
          	<div class="form-group">
            	<label for="txt_thumbs_descr_upd" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_TITLE']; ?></label>
            	<div class="col-sm-8">
            		<input class="form-control1" type="text" name="txt_thumbs_descr_upd" value="<?php print stripslashes($tab_gallery[TITLE]); ?>" />
            	</div>
            	<div class="col-sm-2"><!-- <p class="help-block">Type your help text here</p> --></div>
          	</div>
          	
          	<div class="form-group">
	            <label for="ta_img_descr_upd" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_DESCRIPTION']; ?></label>
	            <div class="col-sm-8">
	            	<textarea class="form-control1 ta-wide" name = "ta_img_descr_upd"><?php print stripslashes($tab_gallery[DESCR]); ?></textarea>
	            	<!-- &nbsp;&nbsp;<a style="border:0;" href="#" onclick="<?php $gallery->popup("pop_img.php", "720", "600");?>">
	            	<img class="pxGalImg" src="<?php print $gallery->imgs_dir.$tab_gallery[LIB]; ?>" /></a> -->
	            </div>
	            <div class="col-sm-2"><!-- <p class="help-block">Type your help text here</p> --></div>
          	</div>
          	
          	<div class="form-group">
	            <label for="" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_DATE']; ?></label>
	            <div class="col-sm-8">
	            	<?php print $gallery->combo_dateFrUpd($tab_gallery[DATE]); ?>
	            </div>
	            <div class="col-sm-2"><!-- <p class="help-block">Type your help text here</p> --></div>
          	</div>
          	
          	<div class="panel-footer">
            	<div class="row">
                   	<div class="col-sm-8 col-sm-offset-2">
                   		<input type="hidden" name="hd_publishId" value="<?php print $tab_gallery[DISPLAY]; ?>" />
                   		<input type="hidden" name="hd_galleryId" value="<?php print $tab_gallery[ID]; ?>" />
                    	<button name="btn_img_update" id="btn_img_update" class="btn-success btn"><?php print $mod_lang_output['FORM_BUTTON_UPDATE']; ?></button>
					</div>
				</div>
			</div>
          	
      </form>
      <?php } ?>
	
      
      <!-- Ajouter les images -->
      <?php if($_REQUEST[what]=="galleryInsert"){ ?>
     <?php $currentLang = (($_REQUEST[langId] != '') ? ($_REQUEST[langId]) : ($_SESSION['LANG'])); ?>
      <h3><?php print $mod_lang_output['MODULE_NAME']; ?> :: <?php print $mod_lang_output['PAGE_HEADER_ADD_GALLERY']; ?></h3>
      
      <?php if(isset($gallery_insert_err_msg)) {  ?>
      <div class="ADM_err_msg"><?php print $gallery_insert_err_msg; ?></div>
      <?php } ?>
      <?php if(isset($gallery_insert_cfrm_msg)) {  ?>
      <div class="ADM_cfrm_msg"><?php print $gallery_insert_cfrm_msg; ?></div>
      <?php } ?>
      
		<form class="form-horizontal" enctype="multipart/form-data" action="" method="post">
			<div class="form-group">
	            <label for="gallery_selLang" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_LANGUAGE']; ?></label>
	            <div class="col-sm-8">
	              	<select class="form-control"  name="gallery_selLang" id="jumpMenu" onchange="MM_jumpMenu('parent',this,0)">
	      				<?php print stripslashes($gallery->redir_cmb_load_langs($_REQUEST['langId'], $gallery->admin_modPage, "galleryInsert")); ?>
	      		  	</select>
	      		  	<input name="gallery_hdLang" type="hidden" value="<?php print $_REQUEST[langId];?>" />
	            </div>
	            <div class="col-sm-2"><!-- <p class="help-block">Help text here</p> --></div>
			</div>
        	<div class="form-group">
            	<label for="gallery_selCat" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_CATEGORY']; ?></label>
            	<div class="col-sm-8">
            		<select class="form-control" name="gallery_selCat">
              			<?php print $gallery->admin_cmb_show_rub_by_lang($currentLang, $_POST[selCat]); ?>
            		</select>
            	</div>
            	<div class="col-sm-2"><!-- <p class="help-block">Your help text here...</p> --></div>
          	</div>
          	
          	<div class="form-group">
            	<label for="gallery_file" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_CHOOSE_IMAGE']; ?></label>
            	<div class="col-sm-8">
            		<input class="form-control1" type="file" name="gallery_file" />
            	</div>
            	<div class="col-sm-2"><!-- <p class="help-block">Your help text here...</p> --></div>
          	</div>
          	
          	<div class="form-group">
          		<label for="txt_thumbs_descr" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_TITLE']; ?></label>
            	<div class="col-sm-8">
            		<input class="form-control1" size="45" type="text" name="txt_thumbs_descr" value="<?php print $gallery->show_content($gallery_insert_err_msg, $txt_thumbs_descr); ?>" />
            	</div>
            	<div class="col-sm-2"><!-- <p class="help-block">Your help text here...</p> --></div>
          	</div>
          	
          	<div class="form-group">
            	<label for="ta_img_descr" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_DESCRIPTION']; ?></label>
            	<div class="col-sm-8">
            		<textarea class="form-control1 ta-wide" name = "ta_img_descr"><?php print $gallery->show_content($gallery_insert_err_msg, $ta_img_descr); ?></textarea>
            	</div>
            	<div class="col-sm-2"><!-- <p class="help-block">Your help text here...</p> --></div>
          	</div>
          	
          	<div class="form-group">
            	<label for="" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_DATE']; ?></label>
            	<div class="col-sm-8">
            		<?php print $gallery->combo_date($pixDate); ?>
            	</div>
            	<div class="col-sm-2"><!-- <p class="help-block">Your help text here...</p> --></div>
          	</div>
          
          	<div class="panel-footer">
            	<div class="row">
                   	<div class="col-sm-8 col-sm-offset-2">
                    	<button name="btn_img_insert" id="btn_img_insert" class="btn-success btn"><?php print $mod_lang_output['FORM_BUTTON_ADD_GALLERY']; ?></button>
					</div>
				</div>
			</div>

      	</form>
      <?php } ?>
      
	  <!-- Afficher les images -->
	  <?php if(($_REQUEST[what]=="galleryDisplay") || ($_REQUEST[limite] != '')){ ?>
		  <h3><?php print $mod_lang_output['MODULE_NAME']; ?> :: <?php print $mod_lang_output['PAGE_HEADER_LIST_GALLERY']; ?></h3>
		  <?php $gallery->limit = $_REQUEST[limite]; ?>
		  <?php if(isset($gallery_display_err_msg)) {  ?>
		  <div class="ADM_err_msg"><?php print $gallery_display_err_msg; ?></div>
		  <?php } ?>
		  <?php if(isset($gallery_display_cfrm_msg)) {  ?>
		  <div class="ADM_cfrm_msg"><?php print $gallery_display_cfrm_msg; ?></div>
		  <?php } ?>
		  <form enctype="multipart/form-data" action="" method="post">
		  	<div class="panel panel-warning" data-widget="{&quot;draggable&quot;: &quot;false&quot;}" data-widget-static="">
          		<div class="panel-body no-padding">
          			
	          			<table class="table table-bordered">
							<tr>
								<th scope="row">&num;</th>
								<th><?php print $mod_lang_output['TABLE_HEADER_CATEGORY']; ?></th>
								<th><?php print $mod_lang_output['TABLE_HEADER_TITLE']; ?></th>
								<th><?php print $mod_lang_output['TABLE_HEADER_DESCRIPTION']; ?></th>
								<th><?php print $mod_lang_output['TABLE_HEADER_DATE-PUB']; ?></th>
								<th><?php print $mod_lang_output['TABLE_HEADER_IMAGE']; ?></th>
								<th><?php print $mod_lang_output['TABLE_HEADER_ACTION']; ?></th>
							</tr>
	        				<?php print stripslashes($gallery->admin_load_gallery()); ?>
        			</div>
        		</div>
        		<div class="panel-footer">
            		<div class="row" style="text-align:center;">
	        			<button class="btn-success btn" onclick="return confirm('&Ecirc;tes-vous s&ucirc;r de vouloir supprimer les images s&eacute;lectionn&eacute;es?')" type="submit" name="btn_deleteSelectedGallery">Supprimer les images s&eacute;lectionn&eacute;es</button>
	        		</div>
	        	</div>
	        </form>
        	       
      <?php } ?>
	  
	  <!-- Afficher les images par album-->
	  <?php if(($_REQUEST[what]=="galleryDisplayByCat")){ ?>
		  <h3><?php print $mod_lang_output['MODULE_NAME']; ?> :: <?php print $gallery->get_gallery_cat_by_id("gallery_cat_lib", $_REQUEST[$gallery->URI_galleryCatVar]); ?></h3>
		  <?php $gallery->limit = $_REQUEST[limite]; ?>
		  <?php if(isset($gallery_display_by_cat_err_msg)) {  ?>
		  <div class="ADM_err_msg"><?php print $gallery_display_by_cat_err_msg; ?></div>
		  <?php } ?>
		  <?php if(isset($gallery_display_by_cat_cfrm_msg)) {  ?>
		  <div class="ADM_cfrm_msg"><?php print $gallery_display_by_cat_cfrm_msg; ?></div>
		  <?php } ?>
		  	<div class="panel panel-warning" data-widget="{&quot;draggable&quot;: &quot;false&quot;}" data-widget-static="">
          		<div class="panel-body no-padding">
          			<table class="table table-bordered">
						<tr>
							<th scope="row">&num;</th>
							<th><?php print $mod_lang_output['TABLE_HEADER_TITLE']; ?></th>
							<th><?php print $mod_lang_output['TABLE_HEADER_DESCRIPTION']; ?></th>
							<th><?php print $mod_lang_output['TABLE_HEADER_DATE-PUB']; ?></th>
							<th><?php print $mod_lang_output['TABLE_HEADER_IMAGE']; ?></th>
							<th><?php print $mod_lang_output['TABLE_HEADER_ACTION']; ?></th>
						</tr>
        				<?php print stripslashes($gallery->admin_load_gallery_by_cat($_REQUEST[$gallery->URI_galleryCatVar])); ?>
        			</div>
        		</div>     
      <?php } ?>
	  
      <!-- Creer les albums -->
      <?php if($_REQUEST[what]=="galleryCatInsert"){ ?>
      <h3><?php print $mod_lang_output['MODULE_NAME']; ?> :: <?php print $mod_lang_output['PAGE_HEADER_ADD_GALLERY_CATEGORY']; ?></h3>
      <?php if(isset($gallery_cat_insert_err_msg)) {  ?>
      <div class="ADM_err_msg"><?php print $gallery_cat_insert_err_msg; ?></div>
      <?php } ?>
      <?php if(isset($gallery_cat_insert_cfrm_msg)) {  ?>
      <div class="ADM_cfrm_msg"><?php print $gallery_cat_insert_cfrm_msg; ?></div>
      <?php } ?>
      
		<form class="form-horizontal" name=gallery_cat_insert action="" method="post">
			<div class="form-group">
                	<label for="selLang" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_LANGUAGE']; ?></label>
                    <div class="col-sm-8">
                       	<select class="form-control" name="selLang" id="selLang">
							<?php print $gallery->cmb_showLang($_POST[selLang]); ?>
                        </select>
                    </div>
                    <div class="col-sm-2">
                       	<!-- <p class="help-block">Your help text!</p> -->
                    </div>
                 </div>
        	<div class="form-group">
            	<label for="txt_gallery_cat" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_CATEGORY_TITLE']; ?></label>
            	<div class="col-sm-8">
            		<input class="form-control1" type="text" name="txt_gallery_cat" value="<?php print $gallery->show_content($gallery_cat_insert_err_msg, $txt_gallery_cat); ?>" />
            	</div>
            	<div class="col-sm-2"><!-- <p class="help-block">Your help text here...</p> --></div>
          	</div>
          	
          	<div class="form-group">
            	<label for="ta_gallery_cat_descr" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_DESCRIPTION']; ?></label>
            	<div class="col-sm-8">
            		<textarea class="form-control1 ta-wide" name="ta_gallery_cat_descr"><?php print $gallery->show_content($gallery_cat_insert_err_msg, $ta_gallery_cat_descr); ?></textarea>
            	</div>
            	<div class="col-sm-2"><!-- <p class="help-block">Your help text here...</p> --></div>
          	</div>
          	
          	<div class="form-group">
            	<label for="" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_DATE']; ?></label>
            	<div class="col-sm-8">
            		<?php print $gallery->combo_date(); ?>
            	</div>
            	<div class="col-sm-2"><!-- <p class="help-block">Your help text here...</p> --></div>
          	</div>
          	
          	<div class="panel-footer">
            	<div class="row">
                   	<div class="col-sm-8 col-sm-offset-2">
                    	<button type="submit" name="btn_cat_insert" id="btn_cat_insert" class="btn-success btn"><?php print $mod_lang_output['FORM_BUTTON_ADD_CATEGORY']; ?></button>
					</div>
				</div>
			</div>

      </form>
      <?php } ?>
      
      <!-- Afficher les albums -->
      <?php if($_REQUEST[what]=="galleryCatDisplay"){ ?>
      <div class="col-sm-6">
	      <h3><?php print $mod_lang_output['MODULE_NAME']; ?> :: <?php print $mod_lang_output['PAGE_HEADER_LIST_GALLERY_CATEGORIES']; ?></h3>
	      <?php if(isset($gallery_cat_display_err_msg)) {  ?>
	      <div class="ADM_err_msg"><?php print $gallery_cat_display_err_msg; ?></div>
	      <?php } ?>
	      <?php if(isset($gallery_cat_insert_cfrm_msg)) {  ?>
	      <div class="ADM_cfrm_msg"><?php print $gallery_cat_display_cfrm_msg; ?></div>
	      <?php } ?>
	      	<div class="panel panel-warning" data-widget="{&quot;draggable&quot;: &quot;false&quot;}" data-widget-static="">
	        	<div class="panel-body no-padding">
	        		<table class="table table-bordered">
						<tr>
							<th>&num;</th>
							<th><?php print $mod_lang_output['TABLE_HEADER_CATEGORY']; ?></th>
							<th><?php print $mod_lang_output['TABLE_HEADER_ACTION']; ?></th>
						</tr>
	        			<?php print $gallery->admin_load_gallery_cat(); ?>
	        		</div>
	        	</div>
	  </div>
      <?php } ?>
      
      <!-- Modifier les albums -->
      <?php if($_REQUEST[action]=="galleryCatUpdate"){ ?>
      	<div class="col-sm-6">
	      <h3><?php print $mod_lang_output['MODULE_NAME']; ?> :: <?php print $mod_lang_output['PAGE_HEADER_UPDATE_GALLERY_CATEGORY']; ?></h3>
	      <?php if(isset($gallery_cat_update_err_msg)) {  ?>
	      <div class="ADM_err_msg"><?php print $gallery_cat_update_err_msg; ?></div>
	      <?php } ?>
	      <?php if(isset($gallery_cat_update_cfrm_msg)) {  ?>
	      <div class="ADM_cfrm_msg"><?php print $gallery_cat_update_cfrm_msg; ?></div>
	      <?php } ?>
			<form class="form-horizontal" name="gallery_cat_update" action="" method="post">
				<div class="form-group">
	            	<label for="txt_gallery_cat_upd" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_CATEGORY_TITLE']; ?></label>
	            	<div class="col-sm-8">
	            		<input class="form-control1" type="text" name="txt_gallery_cat_upd" value="<?php print stripslashes($tab_galleryCat[CATLIB]); ?>" />
	            	</div>
	            	<div class="col-sm-2"><!-- <p class="help-block">Your help text here</p> --></div>
	          	</div>
	          	
	          	<div class="form-group">
	           		<label for="ta_gallery_cat_descr_upd" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_DESCRIPTION']; ?></label>
	            	<div class="col-sm-8">
	            		<textarea class="form-control1 ta-wide" name="ta_gallery_cat_descr_upd" rows="7" cols="40"><?php print stripslashes($tab_galleryCat[CATDESCR]); ?></textarea>
	            	</div>
	            	<div class="col-sm-2"><!-- <p class="help-block">Your help text here</p> --></div>
	          	</div>
	
	          	<div class="form-group">
	            	<label for="" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_DATE']; ?></label>
	            	<div class="col-sm-8">
	            		<?php print $gallery->combo_dateFrUpd($tab_galleryCat[CATDATE]); ?>
	            	</div>
	            	<div class="col-sm-2"><!-- <p class="help-block">Your help text here</p> --></div>
	          	</div>
	        
	        	<div class="panel-footer">
	            	<div class="row">
	                   	<div class="col-sm-8 col-sm-offset-2">
	                   		<input type="hidden" name="hd_gallery_cat_id" value="<?php print $tab_galleryCat[CATID]; ?>">
	                    	<button type="submit" name="btn_cat_upd" id="btn_cat_upd" class="btn-success btn"><?php print $mod_lang_output['FORM_BUTTON_UPDATE']; ?></button>
						</div>
					</div>
				</div>
	      	</form>
	  	</div>
      <?php } ?>
      	  
     
    <?php if($_REQUEST[what]=="gallery_commentDisplay") { ?>
          <h1>Afficher les r&eacute;actions</h1>
          <?php $gallery->limit = $_REQUEST[limite]; ?>
          
          <?php if(isset($err_pixgacommentlDisplay)) {  ?>
          <div class="ADM_err_msg"><?php print $err_galleryCommentDisplay; ?></div>
          <?php } ?>
          <?php if(isset($cfrm_galleryCommentDisplay)) {  ?>
          <div class="ADM_cfrm_msg"><?php print $cfrm_galleryCommentDisplay; ?></div>
          <?php } ?>
          	<div class="panel panel-warning" data-widget="{&quot;draggable&quot;: &quot;false&quot;}" data-widget-static="">
          		<div class="panel-body no-padding">
          			<table class="table table-ordered">
						<tr>
							<th>N&ordm;</th>
							<th>Titre</th>
							<th>Date</th>
							<th>Auteur</th>
							<th>Email</th>
							<th>Commentaire</th>
						</tr>
          <?php print $gallery->admin_load_gallery_comment(); ?>
      <?php } ?>
    
<?php include_once('inc/admin_footer.php');?>