<?php
	require("../incfiles/biblio.inc.php");
	require("../incfiles/mysql_biblio.inc.php");
	require("../incfiles/cls_biblio.inc.php");
?>
<?php
//KTML include files
require_once('../ktmllite/includes/ktedit/activex.php');
?>
<?php
	$myActu =   new emploi_actu;
	$myFile =   new cwd_fileTransact;
?>
<?php
	$btnSend    = $_POST[btnSend];
	$txtTitre   = $_POST[txtTitre];
	$txtDate    = $_POST[cmbYear]."-".$_POST[cmbMonth]."-".$_POST[cmbDay];
	$txtChapeau = $_POST[txtChapeau];
	$txtAuthor  = $_POST[txtAuthor];
	$txtContent = $_POST[txtContent];
	
	/*Préparation à l'Upload des images*/
	/*Image1*/
	$maxSize 	   = $myFile->get_fileMaxSize();
	$tempfile_name = $myFile->set_fileTempName($_FILES[userfile][tmp_name]);
	$userfile      = $myFile->set_fileName($_FILES[userfile][name]);
	$userfile_size = $myFile->set_fileSize($_FILES[userfile][size]);
	$userfile_type = $myFile->set_fileType($_FILES[userfile][type]);
	$uploaddir 	   = $myFile->set_fileDirectory("../img/img_articles/");
	
	/*Image2*/
	/*$tempfile2_name = $myFile->set_fileTempName($_FILES[userfile2][tmp_name]);
	$userfile2      = $myFile->set_fileName($_FILES[userfile2][name]);
	$userfile2_size = $myFile->set_fileSize($_FILES[userfile2][size]);
	$userfile2_type = $myFile->set_fileType($_FILES[userfile2][type]);*/
	
	/*Fin initialisation pour upload*/
	
?>
<?php
	global $new_connect;
	connect_2_db();
?>
<?php
	//Les validations proprement dites
	if(isset($btnSend)){
		if(empty($txtTitre) || (empty($txtAuthor)) || (empty($txtContent)) || (empty($txtChapeau)))
			$err_msg = "Tous les champs sont obligatoires!! Veuillez remplir les champs vides svp.";
		elseif(!checkdate($_POST[cmbMonth], $_POST[cmbDay], $_POST[cmbYear]))
			$err_msg = "La date choisie n'est pas valide! Veuillez s&eacute;lectionner une date valide svp";
		//Verifier que la taille des fichiers n'excède pas la taille max
		elseif($userfile_size > $maxSize)
			$err_msg = "Veuillez diminuer la taille de vos fichiers";
		else{
			//Si on a selectionné des fichiers, les envoyer
			if(!empty($userfile))/*Champ de fichier n°1*/
				if($myFile->fileSend($tempfile_name))
					print msgbox("$userfile uploadé avec succès");
				else
					print msgbox("Impossible d'uploader $userfile");
			/*if(!empty($userfile2))/*Champ de fichier n°2
				if($myFile->fileSend($tempfile2_name))
					print msgbox("Image2 uploadé avec succès");*/
			/*Fin des envois de fichiers, maintenant, écriture ds la bdd*/
			if($myActu->add_article($txtTitre, $txtChapeau, $txtContent, $txtAuthor, $txtDate, $userfile, $userfile2))
				print msgbox("Article ajouté avec succès");
		}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Editeur de news</title>
<link href="/css/emploiscameroun.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="500" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#0c4f70">
  <tr>
    <td bordercolor="#234E6D"><form action="<?php echo $PHP_SELF; ?>" method="post" enctype="multipart/form-data" name="frmSendActu" id="frmSendActu">
      <table align="center" cellpadding="2" cellspacing="0" class="KT_tngtable">
        <tr>
          <td align="center"><a href="" onclick = "<?php print popup("new_addarticle.php", "600", "900"); ?>">Ouvrir l'&eacute;diteur de news dans une nouvelle fen&ecirc;tre</a> </td>
        </tr>
        <tr>
          <td align="center" class="displayError"><?php print $err_msg; ?></td>
        </tr>
        <tr>
          <td align="center" class="headTableAdminSheet">Titre de l'article:</td>
        </tr>
        <tr>
          <td align="center"><input type="text" name="txtTitre" id="titre" value="<?php echo show_content($err_msg, $txtTitre); ?>" size="32" /></td>
        </tr>
        <tr>
          <td align="center" class="headTableAdminSheet">Auteur</td>
        </tr>
        <tr>
          <td align="center"><input type="text" name="txtAuthor" id="txtAuthor" value="<?php echo show_content($err_msg, $txtAuthor); ?>" size="32" /></td>
        </tr>
        <tr>
          <td align="center" class="headTableAdminSheet">Date de diffusion </td>
        </tr>
        <tr>
          <td align="center"><?php print combo_dateFr(); ?></td>
        </tr>
        <tr>
          <td align="center" class="headTableAdminSheet">Chapeau:</td>
        </tr>
        <tr>
          <td><input name="txtChapeau" type="hidden" id="txtChapeau" value="<?php echo show_content($err_msg,  htmlspecialchars($txtChapeau)); ?>" />
              <?php 
   $KT_display = "Insert Image,Insert Table,Toggle WYSIWYG,Bold,Italic,Underline,Align Left,Align Center,Align Right,Align Justify,Background Color,Foreground Color,Bullet List,Numbered List,Indent,Outdent,Font Size,Insert Link";
   showActivex('txtChapeau', 480, 100, false,$KT_display, "../ktmllite/", "", "../../../img/img_articles/", "../../../img/img_articles/",1, "", 480, "english", "yes", "no");
?></td>
        </tr>
        <tr>
          <td align="center" class="headTableAdminSheet"><span class="KT_th">Contenu de la news </span></td>
        </tr>
        <tr>
          <td align="center"><input name="txtContent" type="hidden" id="txtContent" value="<?php echo show_content($err_msg, htmlspecialchars($txtContent)); ?>" />
              <?php 
   $KT_display = "Insert Image,Insert Table,Toggle Vis/Invis,Toggle WYSIWYG,Bold,Italic,Underline,Align Left,Align Center,Align Right,Align Justify,Background Color,Foreground Color,Bullet List,Numbered List,Indent,Outdent,Font Size,Insert Link,Heading List";
   showActivex('txtContent', 480, 150, false,$KT_display, "../ktmllite/", "", "../../../img/img_articles/", "../../../img/img_articles/",1, "", 480, "english", "yes", "no");
?>
              <input type="hidden" name="hdDate" value="<?php print date("Y-m-d"); ?>"/></td>
        </tr>
        <tr>
          <td align="center" class="headTableAdminSheet">Ins&eacute;rer des images:</td>
        </tr>
        <tr>
          <td><input type="file" name="userfile" /></td>
        </tr>
        <tr>
          <td><!-- <input type="file" name="userfile2" />--></td>
        </tr>
        <tr>
          <td align="center"><label>
            <input name="btnSend" type="submit" id="btnSend" value="Ajouter l'article" />
          </label></td>
        </tr>
      </table>
    </form></td>
  </tr>
</table>
<p></p>
</body>
</html>
