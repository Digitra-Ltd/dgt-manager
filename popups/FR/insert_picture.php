<?php
	require_once("../../../scripts/incfiles/config.inc.php");
	require_once("../../../modules/gallery/library/gallery.inc.php");
	$artImg	= new cwd_gallery("../../../img/img_pages/thumbs/", $new_imgDir="../../../img/img_pages/");
	//Definition du repertoire d'envoi des images et des imagettes
	$artImg->set_fileDirectory("../../../img/img_pages/");
	
	$artImg_file_name	= $_FILES[artImg_file][name];
	$artImg_file_temp	= $_FILES[artImg_file][tmp_name];
	$artImg_file_size	= $_FILES[artImg_file][size];
	$btn_insertImg		= $_POST[btn_insertImg];
?>
<?php  
	if(isset($btn_insertImg)){
		//Definir la taille max du fichier et le type de fichier
		$artImg->set_fileMaxSize(15360000);
		$pixExt 	= $artImg->get_file_ext($artImg_file_name);
		$pixType	= $artImg->fileImgType;
		
		//Creation du fichier temporaire
		$artImg->set_fileTempName($artImg_file_temp);
		
		
		if(empty($artImg_file_name))
			$err_msg = "Vous devez choisir une image";
		elseif($artImg_file_size > $artImg->fileMaxSize)
			$err_msg = "Erreur!<br />Fichier trop volumineux. Il ne doit exceder ".$artImg->fileMaxSize/1024 ." Ko";
		elseif(!in_array($pixExt, $pixType))
			$err_msg = "Erreur!<br />Le type de fichier n'est pas correct";
		elseif($artImg->fileSend($artImg_file_name)){
			//Message de confirmation d'envoi des images
			$cfrm_msg = "Image envoy&eacute;e avec succ&egrave;s";
		}	
	}
?>
<link rel="stylesheet" type="text/css" href="../css/admin.css">
<div>
  <form enctype="multipart/form-data" action="" method="post">
    <input type="file" name="artImg_file" />
    <input type="submit" name="btn_insertImg" value="Uploader" />
  </form>
</div>
<div>
  <h1>Images upload&eacute;es</h1>
  <hr />
  <?php print $artImg->browse_dir_4_editor($artImg->fileDirectory); ?>
</div>
