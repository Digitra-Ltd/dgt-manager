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
	require_once("../scripts/langfiles/".$_SESSION[LANG].".php");
	require_once("../scripts/incfiles/config.inc.php");
	require_once("../modules/user/library/user.inc.php");
	require_once("../modules/news/library/news.inc.php");
	$system		= new cwd_system();
	$news		= new cwd_news();
	$news->db_connect($thewu32_host, $thewu32_db, $thewu32_user, $thewu32_pass);
	$system->session_checker($_SESSION["CONNECTED_ADMIN"], $_SESSION["CONNECTED_EDIT"]);
?>
<?php
	$txtNom				= $_POST[txtNom];
	$txtPrenom			= $_POST[txtPrenom];
	$selSex				= $_POST[selSex];
	$selGroup			= $_POST[selGroup];
	$btnInsertAuthor	= $_POST[btnInsertAuthor];
	
	if(isset($btnInsertAuthor)){
		if($selSex == "NULL"){
			$insert_errMsg	= "Veuillez choisir le sexe svp!";
		}
		elseif((empty($txtNom)) && (empty($txtPrenom))){
			$inset_errMsg = "Veuillez saisir un nom ou un pr&eacute;nom pour cet auteur";
		}
		elseif($news->set_news_author($txtNom, $txtPrenom, $selSex, $selGroup)){
			$insert_cfrmMsg	= "Auteur ajout&eacute; avec succ&egrave;s";
		}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Ajouter un auteur</title>
<link rel="shortcut icon" href="../img/dzine/icons/favicon.png" type="image/x-png" />
<link href="css/admin.css" rel="stylesheet" type="text/css" />
</head>

<body>
<form id="form1" name="form1" method="post" action="">
	<?php if(isset($insert_errMsg)) { ?>
  		<div class="ADM_err_msg"><?php print $insert_errMsg; ?></div>
    <?php } ?>
	<?php if(isset($insert_cfrmMsg)) { ?>
  		<div class="ADM_cfrm_msg"><?php print $insert_cfrmMsg; ?></div>
    <?php } ?>
  <table class="ADM_table" style="width:100%;">
    <tr>
      <th>Nom : </th>
      <td><input name="txtNom" type="text" id="txtNom" size="30" /></td>
    </tr>
    <tr>
      <th>Prénom : </th>
      <td><input name="txtPrenom" type="text" id="txtPrenom" size="30" /></td>
    </tr>
    <tr>
      <th>Sexe : </th>
      <td><select name="selSex" id="selSex">
        <option value="NULL">[ Choose ]</option>
        <option value="M">Masculin</option>
        <option value="F">Feminin</option>
      </select>
      </td>
    </tr>
    <tr>
      <th>Groupe : </th>
      <td><select name="selGroup" id="selGroup">
        <option>Club des marcheurs</option>
      </select>
      </td>
    </tr>
    <tr>
      <th>&nbsp;</th>
      <td><input type="submit" name="btnInsertAuthor" id="btnInsertAuthor" value="Ajouter un auteur" /></td>
    </tr>
  </table>
</form>
</body>
</html>
