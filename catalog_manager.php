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
	require_once("../modules/catalog/library/catalog.inc.php");
	require_once("../scripts/incfiles/page.inc.php");
?>

<?php
	//Site settings
	$system		= new cwd_system();
	$myPage		= new cwd_page();
	$settings 	= $system->get_site_settings();
	$catalog	= new cwd_catalog();
	
	$system->db_connect($thewu32_host, $thewu32_db, $thewu32_user, $thewu32_pass);
	$system->session_checker($_SESSION["CONNECTED_ADMIN"], $_SESSION["CONNECTED_EDIT"]);
	
	//Language settings
	$langFile	= isset($_SESSION[LANG]) ? ($_SESSION[LANG]) : ($settings["LANG"]);
	//Call the language file pack
	require_once("../scripts/langfiles/".$langFile.".php");
	
	$catalog->set_catalog_dir("../modules/catalog/", "img/main/", "img/thumbs/");
?>
<?php	
	//Libraries Import
	/*require_once("../scripts/incfiles/config.inc.php");
	$oSmarty 		= new Smarty();
	$system			= new cwd_system();
	$catalog		= new cwd_catalog();*/
	//$gallery		= new cwd_gallery("../catalog/thumbs/", "../catalog/pix/");
	
	$what			= $_REQUEST[what];
	$emailActiv		= $_REQUEST[emailActiv];
	$emailCat		= $_REQUEST[$mailinglist->mod_catQueryKey];
	$emailId		= $_REQUEST[$mailinglist->mod_queryKey];
?>

<?php
	//Ajout d'un produit
	$selProductCat 			= $_POST[selProductCat];
	$selProductLang			= $_POST[selProductLang];
	$cmbDay					= $_POST[cmbDay];
	$cmbMonth				= $_POST[cmbMonth];
	$cmbYear				= $_POST[cmbYear];
	$txt_product_file_name	= $_FILES[txt_product_file][name];
	$txt_product_file_size	= $_FILES[txt_product_file][size];
	$txt_product_file_temp	= $_FILES[txt_product_file][tmp_name];
	$txt_product_name		= addslashes($_POST[txt_product_name]);
	$ta_product_tags		= addslashes(htmlentities($_POST[ta_product_tags]));
	$txt_product_vente		= $_POST[txt_product_vente];
	$txt_product_achat		= $_POST[txt_product_achat];
	$ta_product_descr		= addslashes($_POST[ta_product_descr]);
	$btn_product_insert		= $_POST[btn_product_insert];
	$product_date			= $cmbYear."-".$cmbMonth."-".$cmbDay;
	
	//Creer les repertoires du catalogue, s'il n'existe pas encore.
	//$catalog->create_dir("../catalog/");
	
	
	
	if(isset($btn_product_insert)){
		if(empty($ta_product_descr))
			$product_err_msg	= "Erreur<br />Description obligatoire avant de continuer";
		elseif($catalog->chk_entry_twice($catalog->tbl_catalog, "catalogue_descr", "catalogue_lib", $ta_product_descr, $txt_product_name))
			$product_err_msg	= "D&eacute;sol&eacute;, ce produit est d&eacute;j&agrave; enregistr&eacute;";
		elseif(!checkdate($cmbMonth, $cmbDay, $cmbYear))
			$product_err_msg	= "Erreur!<br />La date choisie est invalide!!!<br />Veuillez changer de date.";
		elseif(!is_numeric($txt_product_achat) || !is_numeric($txt_product_vente))
			$product_err_msg	= "Erreur!<br />Vous devez saisir des valeurs num&eacute;riques pour les prix de vente et d'acquisition";
		elseif($txt_product_vente < $txt_product_achat)
			$product_err_msg	= "Erreur!<br />Le prix de vente ne peut &ecirc;tre inf&eacute;rieur au prix d'acquisition du produit.";
		elseif(!empty($txt_product_file_name)){
				$currentId = ($catalog->get_lastTblId($catalog->tbl_catalog, $catalog->fld_catalogId) + 1);
				//Definir la taille max du fichier
				$catalog->set_fileMaxSize(15360000);
				
				//Renommage du fichier :
				$pixExt 				= $catalog->get_file_ext($txt_product_file_name);
				$txt_product_file_name 	= $currentId.".".$pixExt;
				$pixType				= $catalog->fileImgType;
				
				//Creation du fichier temporaire
				$catalog->set_fileTempName($txt_product_file_temp);
				//Definition du repertoire d'envoi des images et des imagettes
				
				$catalog->set_fileDirectory("../modules/catalog/img/main/");
				
				if(($catalog->fileSend($txt_product_file_name))&&($catalog->insert_product($selProductCat, $ta_product_descr, $txt_product_name, $ta_product_tags, $txt_product_file_name, $txt_product_vente, $txt_product_achat, $product_date, $selProductLang, '0'))){
					//Create the main img 
					//$catalog->set_fileDirectory("../modules/catalog/img/main/");
					$catalog->set_catalog_dir("../modules/catalog/", "img/main/", "img/main/");
					//$catalog->set_thumbs_dir("../modules/catalog/img/main/");
					$catalog->create_thumbs($txt_product_file_name, "500");
					
					//Create thumbnail
					//$catalog->set_fileDirectory("../modules/catalog/img/thumbs/");
					$catalog->set_catalog_dir("../modules/catalog/", "img/main/", "img/thumbs/");
					//$catalog->set_thumbs_dir("../modules/catalog/img/thumbs/");
					$catalog->create_thumbs($txt_product_file_name, "100");
					
					$product_cfrm_msg = "Produit ajout&eacute; avec succ&egrave;s dans le catalogue!";
				}
			}
		else{
			//S'il n'ya pas d'image, alors, image par defaut
			//$txt_product_file_name 	= 'noimg.jpg';
			$currentId	= ''; // signifie que l'on prendra le nom de l'image par d�faut
			$catalog->insert_product($selProductCat, $ta_product_descr, $txt_product_name, $ta_product_tags, $currentId, $txt_product_vente, $txt_product_achat, $product_date, $selProductLang, '0');
			$product_cfrm_msg 	= "Produit ajout&eacute; avec succ&egrave;s dans le catalogue!";
		}
	}
?>

<?php
	//Modification d'un produit
	$selProductCat_upd 			= $_POST[selProductCat_upd];
	$selProductLang_upd			= $_POST[selProductLang_upd];
	$cmbDayUpd					= $_POST[cmbDayUpd];
	$cmbMonthUpd				= $_POST[cmbMonthUpd];
	$cmbYearUpd					= $_POST[cmbYearUpd];
	$txt_product_file_name_upd	= $_FILES[txt_product_file_upd][name];
	$txt_product_file_size_upd	= $_FILES[txt_product_file_upd][size];
	$txt_product_file_temp_upd	= $_FILES[txt_product_file_upd][tmp_name];
	$txt_product_name_upd		= addslashes($_POST[txt_product_name_upd]);
	$ta_product_tags_upd		= addslashes(htmlentities($_POST[ta_product_tags_upd]));
	$txt_product_vente_upd		= $_POST[txt_product_vente_upd];
	$txt_product_achat_upd		= $_POST[txt_product_achat_upd];
	$ta_product_descr_upd		= addslashes($_POST[ta_product_descr_upd]);
	$btn_product_update			= $_POST[btn_product_update];
	$product_date_upd			= $cmbYearUpd."-".$cmbMonthUpd."-".$cmbDayUpd;
	$hd_productId				= $_POST[hd_productId];
	$hd_productDisplay			= $_POST[hd_productDisplay];
	$hd_productImg				= $_POST[hd_productImg];
	
	//Creer les repertoires du catalogue, s'il n'existe pas encore.
	//$catalog->create_dir("../catalog/");
	
	
	
	if(isset($btn_product_update)){
		//Obtenir le nom du fichier a mettre a jour
		if($_POST[hd_productImg]	!= 	""){
			$old_pixName	= 	$_POST[hd_productImg];
			$old_pixExt		= 	$catalog->get_file_ext($old_pixName);
			$currentId 		= 	(basename($old_pixName, $old_pixExt));
		}
		else {
			$currentId		=	$hd_productId;
		}
		//Definir la taille max du fichier
		$catalog->set_fileMaxSize(15360000);

		//Definition du repertoire de base d'envoi des images et des imagettes
		$catalog->set_fileDirectory("../modules/catalog/img/main/");
		
		if(empty($ta_product_descr_upd))
			$product_update_err_msg	= "Erreur<br />Description obligatoire avant de continuer";
		elseif(!checkdate($cmbMonthUpd, $cmbDayUpd, $cmbYearUpd))
			$product_update_err_msg	= "Erreur!<br />La date choisie est invalide!!!<br />Veuillez changer de date.";
		elseif(!is_numeric($txt_product_achat_upd) || !is_numeric($txt_product_vente_upd))
			$product_update_err_msg	= "Erreur!<br />Vous devez saisir des valeurs num&eacute;riques pour les prix de vente et d'acquisition";
		elseif($txt_product_vente_upd < $txt_product_achat_upd)
			$product_update_err_msg	= "Erreur!<br />Le prix de vente ne peut &ecirc;tre inf&eacute;rieur au prix d'acquisition du produit.";
		elseif((!empty($txt_product_file_name_upd)) && ($hd_productImg !=	"")){
			//L'extension du nouveau fichier
			$pixExt 		= 	$catalog->get_file_ext($txt_product_file_name_upd);
			//Juste pr savoir le type de fichier
			$pixType		= 	$catalog->fileImgType;
				
			//Fichier � envoyer
			$txt_product_file_name_upd 	= $currentId.".".$pixExt;
			
			//Creation du fichier temporaire
			$catalog->set_fileTempName($txt_product_file_temp_upd);				

			//Op�rations d'envoi du fichier et insertion ds la bdd
			if(($catalog->fileSend($txt_product_file_name_upd))&&($catalog->update_product($hd_productId, 
																						   $selProductCat_upd, 
																						   $ta_product_descr_upd, 
																						   $txt_product_name_upd,
																						   $ta_product_tags_upd, 
																						   $txt_product_file_name_upd, 
																						   $txt_product_vente_upd, 
																						   $txt_product_achat_upd, 
																						   $product_date_upd,
																						   $selProductLang_upd,
																						   $hd_productDisplay))){
				//Image principale
				$catalog->set_catalog_dir("../modules/catalog/", "img/main/", "img/main/");
				$catalog->create_thumbs($txt_product_file_name_upd, "500");
					
				//Imagette
				$catalog->set_catalog_dir("../modules/catalog/", "img/main/", "img/thumbs/");
				$catalog->create_thumbs($txt_product_file_name_upd, "100");

				//Cfrm msg
				$product_update_cfrm_msg 	= "Produit mis &agrave; jour avec succ&egrave;s dans le catalogue!";
			}
		}
		
		//Si l'image pr�c�dente est l'image par d�faut
		elseif((!empty($txt_product_file_name_upd)) && ($_POST[hd_productImg] == "")){
				
			//Renommage du fichier :
			$pixExt 					= $catalog->get_file_ext($txt_product_file_name_upd);
			$txt_product_file_name_upd 	= $currentId.".".$pixExt;
			$pixType					= $catalog->fileImgType;
				
			//Creation du fichier temporaire
			$catalog->set_fileTempName($txt_product_file_temp_upd);
			
			if(($catalog->fileSend($txt_product_file_name_upd))&&($catalog->update_product($hd_productId, $selProductCat_upd, $ta_product_descr_upd, $txt_product_name_upd, $ta_product_tags_upd, $txt_product_file_name_upd, $txt_product_vente_upd, $txt_product_achat_upd, $product_date_upd, $selProductLang_upd, $hd_productDisplay))){
				//Create the main img
				$catalog->set_catalog_dir("../modules/catalog/", "img/main/", "img/main/");
				$catalog->create_thumbs($txt_product_file_name_upd, "500");
				
				//Create the thumbnail
				$catalog->set_catalog_dir("../modules/catalog/", "img/main/", "img/thumbs/");
				$catalog->create_thumbs($txt_product_file_name_upd, "100");
				
				//Cfrm msg
				$product_update_cfrm_msg = "Produit mis &agrave; jour avec succ&egrave;s dans le catalogue!";
			}
		}
		elseif(empty($txt_product_file_name_upd)){
			//S'il n'ya pas d'image, alors, l'image d'avant
			$txt_product_file_name_upd 	= $hd_productImg;
			$catalog->update_product($hd_productId, 
									 $selProductCat_upd, 
									 $ta_product_descr_upd, 
									 $txt_product_name_upd,
									 $ta_product_tags_upd, 
									 $txt_product_file_name_upd, 
									 $txt_product_vente_upd, 
									 $txt_product_achat_upd, 
									 $product_date_upd,
									 $selProductLang_upd,
									 $hd_productDisplay);
			$product_update_cfrm_msg 	= "Produit mis &agrave; jour avec succ&egrave;s dans le catalogue!";
		}
	}
?>

<?php
	//Ajout de categories de produits
	$btn_product_cat_insert = $_POST[btn_product_cat_insert];
	$selProductCatLang		= $_POST[selProductCatLang];
	$txt_product_cat_lib	= $_POST[txt_product_cat_lib];
	
	if(isset($btn_product_cat_insert)){
		if(empty($txt_product_cat_lib))
			$product_cat_err_msg = "Erreur!<br />Le libell&eacute; du produit est obligatoire pour continuer.";
		elseif($catalog->chk_entry($catalog->tbl_catalogType, "catalogue_type_lib", $text_product_cat_lib))
			$product_cat_err_msg	= "Erreur!<br />Ce libell&eacute; est d&eacute;j&agrave; utilis&eacute;.<br />Veuillez essayer avec un autre svp.";
		elseif ($catalog->insert_product_type($txt_product_cat_lib, $selProductCatLang, '1'))
			$product_cat_cfrm_msg	= "Bravo!<br />Type de produit ajout&eacute; avec succ&egrave;s dans le catalogue";
	}
?>

<?php
	//Suppressions et modifications
	switch($_REQUEST[action]){
		case "productDelete" 	: 	$imgName	= $catalog->get_img_by_product($_REQUEST[productId]);
									$imgURL 	= $catalog->img_dir.$imgName;
									$thumbURL 	= $catalog->img_thumbs_dir.$imgName;
									if($catalog->delete_product($_REQUEST[productId], $thumbURL, $imgURL))
										$product_display_cfrm_msg = "Bravo!<br />Produit supprim&eacute; avec succ&egrave;s";
		break;
		case "productPrivate"	: 	$toDo		= $catalog->set_product_state($catalog->fld_catalogDisplay, $_REQUEST[$catalog->URI_product], "0");
									$product_display_cfrm_msg	= "The product has been set hidden";
									//Cr&eacute;er le Data Set Correspondant
									//$news->create_xml_news("../xml/province_news.xml");
		break;
		case "productPublish"	:	$toDo		= $catalog->set_product_state($catalog->fld_catalogDisplay, $_REQUEST[$catalog->URI_product], "1");
									$product_display_cfrm_msg	= "The product is now viewable in the website.";
									//Cr&eacute;er le Data Set Correspondant
									//$file->create_xml_annonces("../xml/province_annonce.xml");
		break;
		case "productCatDelete" 	: 	if($catalog->delete_product_cat($_REQUEST[$catalog->mod_catQueryKey]))
										$product_display_cfrm_msg = "Bravo!<br />Type de produit supprim&eacute; avec succ&egrave;s!";
									else
										$product_display_cfrm_msg = "Erreur!<br />Impossible de supprimer; le typed de produit.<br />Veuillez consulter le webmaster svp!";
		break;
		case "productCatPrivate"	: 	$toDo		= $catalog->set_product_cat_state($catalog->fld_catalogTypeDisplay, $_REQUEST[$catalog->URI_productCat], "0");
										$product_display_cfrm_msg	= "The product category has been set hidden";
										//Cr&eacute;er le Data Set Correspondant
										//$news->create_xml_news("../xml/province_news.xml");
		break;
		case "productCatPublish"	:	$toDo		= $catalog->set_product_cat_state($catalog->fld_catalogTypeDisplay, $_REQUEST[$catalog->URI_productCat], "1");
										$product_display_cfrm_msg	= "The product category is now viewable in the website.";
										//Cr&eacute;er le Data Set Correspondant
										//$file->create_xml_annonces("../xml/province_annonce.xml");
		break;
	}
	
	//Suppression massive
	if(isset($_POST[btn_deleteSelectedProduct])){
		
		$nb_productDeleted = $catalog->delete_products($_POST[productId]);
		$msg_single 	= "Bravo!<br />$nb_productDeleted produit a effectivement &eacute;t&eacute; supprim&eacute;e du catalogue";
		$msg_multiple	= "Bravo!<br />$nb_productDeleted produits ont effectivement &eacute;t&eacute; supprim&eacute;es du catalogue";
		$product_display_cfrm_msg = (($nb_productDeleted==1) ? $msg_single : $msg_multiple);
	}

	//Modification des categories de produits
	if(isset($_POST[btn_product_cat_update])){
		if(empty($_POST[txt_product_cat_lib_upd]))
			$product_cat_update_err_msg = "Veuillez saisir un nom de cat&eacute;gorie avant de continuer svp!";
		elseif($catalog->update_product_cat($_POST[hd_product_cat_id], $_POST[txt_product_cat_lib_upd], $_POST[selProductCatLang_upd]))
			$product_cat_update_cfrm_msg = "Cat&eacute;gorie mise &agrave; jour avec succ&egrave;s";
	}
	
?>
<?php
	ob_end_flush();
?>
<?php include_once('inc/admin_header.php');?>
      	<?php print $catalog->admin_get_menu(); ?>

		<?php if($_REQUEST[what] == "productInsert") { ?>
        <h1>Nouveau produit</h1>
        <?php if(isset($product_err_msg)) { ?>
        <div class="ADM_err_msg"><?php print $product_err_msg; ?></div>
        <?php } ?>
        
        <?php if(isset($product_cfrm_msg)) { ?>
        <div class="ADM_cfrm_msg"><?php print $product_cfrm_msg; ?></div>
        <?php } ?>
        <form id="form1" name="form1" method="post" action="" enctype="multipart/form-data"> 
          <table class="ADM_form">
          	<tr>
              <th>Langue : </th>
              <td>
              	<select name="selProductLang" id="selProductLang">
              	<?php print $catalog->cmb_showLang($_SESSION[LANG]); ?>
              	</select>
              </td>
            </tr>
            <tr>
            <tr>
              <th>Intitul&eacute; : </th>
              <td><input size="42" type="text" name="txt_product_name" value="<?php print $catalog->show_content($product_err_msg, $txt_product_name); ?>" /></td>
            </tr>
            <tr>
              <th>Rubrique : </th>
              <td><select name="selProductCat"><?php print $catalog->cmb_load_product_type($selProductCat) ?></select></td>
            </tr>
            <tr>
            	<th>Mots-cl&eacute;s : </th>
            	<td>
              		<textarea name="ta_product_tags" cols="40" rows="5" id="ta_product_tags"><?php $catalog->show_content($product_err_msg, $txt_product_tags); ?></textarea>
              	</td>
            </tr>
            <tr>
              <th>Description : </th>
              <td>
              	<textarea name="ta_product_descr" cols="40" rows="5" id="ta_product_descr"><?php print $catalog->show_content($product_err_msg, $ta_product_descr); ?></textarea>
              	<script language="JavaScript1.2" type="text/javascript">
					generate_wysiwyg('ta_product_descr');
	  			</script>
              </td>
            </tr>
            <tr>
              <th>Photo : </th>
              <td><input type="file" name="txt_product_file" /></td>
            </tr>
            <tr>
              <th>Prix de vente  : </th>
              <td><input size="5" value="<?php print $catalog->show_content($product_err_msg, $txt_product_vente); ?>" name="txt_product_vente" type="text" id="txt_product_vente" /> <select><option>fcfa</option></select></td>
            </tr>
            <tr>
              <th>Prix d'acquisition : </th>
              <td><input size="5" value="<?php print $catalog->show_content($product_err_msg, $txt_product_achat); ?>" name="txt_product_achat" type="text" id="txt_product_achat" /> <select><option>fcfa</option></select></td>
            </tr>
            <tr>
              <th>Date de mise &agrave; prix : </th>
              <td><?php print $catalog->combo_dateFr($selDays, $selMonths, $selYears) ?></td>
            </tr>
            <tr>
              <th>&nbsp;</th>
              <td><input type="submit" value="Ajouter au catalogue" name="btn_product_insert" id="btn_product_insert" /></td>
            </tr>
          </table>
        </form>
        <?php } ?>
        
        <!-- Ajouter les types de produits -->
	  	<?php if($_REQUEST[what] == "productCatInsert") { ?>
        <h1>Nouvelle rubrique / cat&eacute;gorie</h1>
        <?php if(isset($product_cat_err_msg)) { ?>
        <div class="ADM_err_msg"><?php print $product_cat_err_msg; ?></div>
        <?php } ?>
        
        <?php if(isset($product_cat_cfrm_msg)) { ?>
        <div class="ADM_cfrm_msg"><?php print $product_cat_cfrm_msg; ?></div>
        <?php } ?>
        <form id="frm_productCatInsert" name="frm_productCatInsert" method="post" action=""> 
          <table class="ADM_form">        
            <tr>
              <th>langue  : </th>
              <td><select name="selProductCatLang"><?php print $system->cmb_showLang($selProductCatLang); ?></select></td>
            </tr>
            <tr>
              <th>Libell&eacute; : </th>
              <td><input value="<?php print $catalog->show_content($product_cat_err_msg, $txt_product_cat_lib); ?>" name="txt_product_cat_lib" type="text" size="30" id="txt_product_cat_lib" /></td>
            </tr>
            <tr>
              <th>&nbsp;</th>
              <td><input type="submit" value="Cr&eacute;er la rubrique" name="btn_product_cat_insert" id="btn_product_cat_insert" /></td>
            </tr>
          </table>
        </form>
        <?php } ?>
        
        <!-- Mettre les categories de produits a jour-->
        <?php if($_REQUEST[what] == "productCatUpdate") { $tab_productCat = $catalog->get_product_cat($_REQUEST[$catalog->mod_catQueryKey]); ?>
        <h1>Modifier un type de produit</h1>
        <?php if(isset($product_cat_update_err_msg)) { ?>
        	<div class="ADM_err_msg"><?php print $product_cat_update_err_msg; ?></div>
        <?php } ?>
        <?php if(isset($product_cat_update_cfrm_msg)) { ?>
        	<div class="ADM_cfrm_msg"><?php print $product_cat_update_cfrm_msg; ?></div>
        <?php } ?>
        <form id="frm_productCatUpdate" name="frm_productCatUpdate" method="post" action=""> 
          <table class="ADM_form">        
            <tr>
              <th>Langue : </th>
              <td>
              	<select name="selProductCatLang_upd">
              		<?php 
              			print $catalog->cmb_showLangUpd($tab_productCat[product_cat_LANGID]); 
              		?>
              	</select>
              </td>
           </tr>
           <tr>
              <th>Libell&eacute; : </th>
              <td><input value="<?php print $tab_productCat[product_cat_LIB]; ?>" name="txt_product_cat_lib_upd" type="text" size="30" id="txt_product_cat_lib_upd" /></td>
            </tr>
            <tr>
              <th><input type="hidden" name="hd_product_cat_id" value="<?php print $_REQUEST[$catalog->mod_catQueryKey]; ?>" /></th>
              <td><input type="submit" value="Modifier le type de produit" name="btn_product_cat_update" id="btn_product_cat_update" /></td>
            </tr>
          </table>
        </form>
        <?php } ?>
        
        <!-- Mettre les enregistrements d'un produit a jour -->
        <?php 
        	if($_REQUEST[action] 	== "productUpdate") { 
        		$tabProduct 		= 	$catalog->get_product($_REQUEST[$catalog->mod_queryKey]);
        ?>
	        <h1>Modifier un produit</h1>
	        
	        <?php if(isset($product_update_err_msg)) { ?>
	        	<div class="ADM_err_msg"><?php print $product_update_err_msg; ?></div>
	        <?php } ?>
	        
	        <?php if(isset($product_update_cfrm_msg)) { ?>
	        	<div class="ADM_cfrm_msg"><?php print $product_update_cfrm_msg; ?></div>
	        <?php } ?>
	        <form id="formUpd" name="formUpd" method="post" action="" enctype="multipart/form-data"> 
	          <table class="ADM_form">
	          	<tr>
	              <th>Langue : </th>
	              <td>
	              	<select name="selProductLang_upd">
	              		<?php 
	              			print $catalog->cmb_showLangUpd($tab_productCat[product_LANG]); 
	              		?>
	              	</select>
	              </td>
	           </tr>
	            <tr>
	              <th>Intitul&eacute; : </th>
	              <td><input size="42" type="text" name="txt_product_name_upd" value="<?php print $tabProduct[product_LIB]; ?>" /></td>
	            </tr>
	            <tr>
	              <th>Rubrique : </th>
	              <td><select name="selProductCat_upd"><?php print $catalog->cmb_product_cat($tabProduct[product_CATID]); ?></select></td>
	            </tr>
	            <tr>
	            	<th>Mots-cl&eacute;s : </th>
	            	<td>
	              		<textarea name="ta_product_tags_upd" cols="40" rows="5" id="ta_product_tags_upd"><?php print stripslashes($tabProduct[product_TAGS]); ?></textarea>
	              	</td>
	            </tr>
	            <tr>
	              <th>Description : </th>
	              <td>
	              	<textarea name="ta_product_descr_upd" cols="40" rows="5" id="ta_product_descr_upd"><?php print stripslashes($tabProduct[product_DESCR]); ?></textarea>
	              	<script language="JavaScript1.2" type="text/javascript">
						generate_wysiwyg('ta_product_descr_upd');
		  			</script>
	              </td>
	            </tr>
	            <tr>
	              <th>Photo : <br /><em>(Facultatif)</em></th>
	              <td><input type="file" name="txt_product_file_upd" /></td>
	            </tr>
	            <tr>
	              <th>Prix de vente  : </th>
	              <td><input size="5" value="<?php print $tabProduct[product_PVENTE]; ?>" name="txt_product_vente_upd" type="text" id="txt_product_vente_upd" /> <select><option>fcfa</option></select></td>
	            </tr>
	            <tr>
	              <th>Prix d'acquisition : </th>
	              <td><input size="5" value="<?php print $tabProduct[product_PACHAT]; ?>" name="txt_product_achat_upd" type="text" id="txt_product_achat_upd" /> <select><option>fcfa</option></select></td>
	            </tr>
	            <tr>
	              <th>Date de mise &agrave; prix : </th>
	              <td><?php print $catalog->combo_dateFrUpd($tabProduct[product_DATE], ""); ?></td>
	            </tr>
	            <tr>
	              <th><input type="hidden" name="hd_productId" value="<?php print $tabProduct[product_ID]; ?>" /><input type="hidden" name="hd_productImg" value="<?php print $tabProduct[product_IMG]; ?>" /><input type="hidden" name="hd_productDisplay" value="<?php print $tabProduct[product_DISPLAY]; ?>" /></th>
	              <td><input type="submit" value="Modifier le produit" name="btn_product_update" id="btn_product_update" /></td>
	            </tr>
	          </table>
	        </form>
        <?php } ?>
        
        <!-- Aficher les types de produits -->
        <?php if($what=="productCatDisplay") { ?>
        <a name="productCatDisplay"></a>
        <h1>Afficher les types de produits</h1>
        
        <?php if(isset($product_display_err_msg)) { ?>
        <div class="ADM_err_msg"><?php print $product_display_err_msg;  ?></div>
        <?php } ?>
        <?php if(isset($product_display_cfrm_msg)) { ?>
        <div class="ADM_cfrm_msg"><?php print $product_display_cfrm_msg; ?></div>
        <?php } ?>
        
        <form>
            <table class="ADM_table">
                <caption>&nbsp;</caption>
                <tr>
                    <th>N&ordm;</th>
                    <th>Intitul&eacute;s</th>
                    <th colspan="3">Actions</th>
                </tr>
                <?php print $catalog->admin_load_products_cat(); ?>
            </table>
        </form>
        <?php } ?>
        
        <!-- Afficher les produits -->
	  <?php if(!isset($_REQUEST[what]) || ($_REQUEST[what]=="productDisplay")){ ?>
      <h1>Afficher les produits</h1>
      
      <?php if(isset($product_display_err_msg)) {  ?>
      <div class="ADM_err_msg"><?php print $product_display_err_msg; ?></div>
      <?php } ?>
      <?php if(isset($product_display_cfrm_msg)) {  ?>
      <div class="ADM_cfrm_msg"><?php print $product_display_cfrm_msg; ?></div>
      <?php } ?>
      
      <form enctype="multipart/form-data" action="" method="post">
      	<?php $catalog->limit = $_REQUEST[limite]; ?>
        <?php print $catalog->admin_load_catalog("50"); ?>
        <?php 
        	if(!$catalog->admin_load_catalog())
        		//Si table des produits est vide...
        		print "<p>Aucun produit enregistr&eacute; pour l'instant...</p><p>Cliquez sur <a href=\"?what=productInsert\">Nouveau produit</a> pour commencer &agrave; ajouter des produits dans le catalogue</p>"; 
        ?>
        <div style="margin:20px 7px;">
        	<input <?php print $disabled = ((!$catalog->admin_load_catalog()) ? ("disabled") : ("")); ?> onclick="return confirm('&Ecirc;tes-vous s&ucirc;r de vouloir supprimer les produits s&eacute;lectionn&eacute;s?')" type="submit" name="btn_deleteSelectedProduct" value="Supprimer les produits s&eacute;lectionn&eacute;s" />
        </div>
      </form>
      <?php } ?>
	  
<?php include_once('inc/admin_footer.php');?>