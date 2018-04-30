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
	require_once("../modules/job/library/job.inc.php");
	require_once("../modules/candidat/library/candidat.inc.php");
	require_once("../modules/recruteur/library/recruteur.inc.php");
	require_once("../modules/user_register/library/user_register.inc.php");
	$system			= new cwd_system();
	$myProfile		= new cwd_profile();
	$myJob			= new cwd_job();
	$myCandidat		= new cwd_candidat();
	$myUserRegister	= new cwd_user_register();
	$myUserRegister->db_connect($thewu32_host, $thewu32_db, $thewu32_user, $thewu32_pass);
	$myUserRegister->session_checker("connected_admin");
	
	//Site settings
	$settings 	= $system->get_site_settings();
?>
<?php
	//Personalized scripts in here
	//Actions sur les utilisateurs et leurs categories
	$what 		= $_REQUEST[what];
	$action		= $_REQUEST[action];
	$uId		= $_REQUEST[uId];
	$ucId		= $_REQUEST[ucId];
	$userId		= $_REQUEST[userId];
	
	
	switch($action){
		case "user_registerDelete" : $toDo 			= $myUserRegister->delete_user_register($_REQUEST[$myUserRegister->URI_user_register]);
							$user_register_display_cfrm_msg	= "Profil supprim&eacute; avec succ&egrave;s";
							//Cr&eacute;er le Data Set Correspondant
							//$news->create_xml_user_register("../xml/ec_user_register.xml");
		break;
		case "user_registerDeactivate": $toDo		= $myUserRegister->activate_user_register($_REQUEST[$myUserRegister->URI_user_register], "0");
							$user_register_display_cfrm_msg	= "Profil d&eacute;sactiv&eacute; avec succ&egrave;s.";
							//Cr&eacute;er le Data Set Correspondant
							//$myUserRegister->create_xml_user_register("../xml/ec_user_register.xml");
		break;
		case "user_registerActivate":	$toDo		= $myUserRegister->activate_user_register($_REQUEST[$myUserRegister->URI_user_register], "1");
							$user_register_display_cfrm_msg	= "Profil activ&eacute; avec succ&egrave;s.";
							//Cr&eacute;er le Data Set Correspondant
							//$myUserRegister->create_xml_user_register("../xml/ec_user_register.xml");
		break;
		case "user_registerUpdate" : $tab_userRegisterUpd 		= $myUserRegister->get_user_register($_REQUEST[$myUserRegister->URI_user_register]); 
							$tab_userRegisterDetailUpd 	= $myUserRegister->get_user_register_detail($_REQUEST[$myUserRegister->URI_user_register]);
							//Ces tableaux seront utilises pour remplir les champs du formulaire de modification
							$user_registerDisplayUpd = true;
							//Cr&eacute;er le Data Set Correspondant
							//$myUserRegister->create_xml_user_register("../xml/ec_user_register.xml");
		break;
		case "user_registerCatDelete" : $toDo			= $myUserRegister->delete_user_cat($_REQUEST[$my_users->URI_userTypeVar]);
							   $rub_display_cfrm_msg	= "Cat&eacute;gorie supprim&eacute;e avec succ&egrave;s";
							  
		break;
		case "user_registerCatUpdate" : $tab_userRegisterCatUpd = $myUserRegister->get_user_register_cat($_REQUEST[$myUserRegister->URI_user_registerType]);
							   $rub_displayUpd			= true;
		break;
		case "postulationPublish" : $toDo	= $myCandidat->switch_postulation_state($_REQUEST[$myCandidat->URI_candidatPostulations], 1);
							$postulation_display_cfrm_msg	= "Cadidature publi&eacute;e avec succ&egrave;s";
							//Create the corresponding Data Set
							//$myCandidat->set_xml_postulation(../xml/ec_postulations.xml)
		break;
		case "postulationHide"	: 	$toDo	=	$myCandidat->switch_postulation_state($_REQUEST[$myCandidat->URI_candidatPostulations], 0);
							$postulation_display_cfrm_msg	= "Candidature masqu&eacute;e avec succ&egrave;s";
							//Create the corresponding Data Set
							//$myCandidat->set_xml_postulation(../xml/ec_postulations.xml)
		break;
		case "postulationDelete" : $toDo 			= $myCandidat->delete_postulation($_REQUEST[$myCandidat->URI_candidatPostulations]);
							$postulation_display_cfrm_msg	= "Candidature supprim&eacute;e avec succ&egrave;s";
							//Cr&eacute;er le Data Set Correspondant
							//$myCandidat->create_xml_postulation("../xml/ec_postulations.xml");
		break;
	}
?>
<?php
	ob_end_flush();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/admin_template.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>cawad My Admin 1.1 - Profile Manager</title>
<link rel="shortcut icon" href="../img/dzine/icons/favicon.png" type="image/x-png" />
<!-- InstanceEndEditable -->
<link href="css/layout.css" rel="stylesheet" type="text/css" />
<link href="css/admin.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" type="text/javascript" src="wysiwyg.js"></script>
<script language="JavaScript" type="text/javascript" src="js/cms_admin.js"></script>
<!-- InstanceBeginEditable name="head" --><!-- InstanceEndEditable -->
</head>
<body>
<center>
  <div id="wrapper">
  	<div id="logout" style="text-align:left; padding-left:25px;"><a href="../logout.php">Logout</a></div>
    <div id="topHead"><img src="img/dzine/topHead.jpg" /></div>
    <div id="headContent">
      <div class="content">
        <div class="appTitle">Web Management Panel </div>
        <div class="appDescr">Your intuitive area for the management of your website.</div>
      </div>
    </div>
    <div id="headSeparator"><img src="img/dzine/headSeparator.jpg" width="996" height="12" /></div>
    <div id="menuContent">
      <div class="content">
        <?php print $myProfile->admin_main_menu_display(); ?>
    	<div style="float:right;"><a href="#">Modifier mon compte</a></div>
      </div>
      <div class="clear_both"></div>
    </div>
    <div id="headSub"> <img src="img/dzine/headSub.jpg" height="9" width="996" />
      <div class="clear_both"></div>
    </div>
    <div id="mainContent">
      <div class="content">
      	<!-- InstanceBeginEditable name="pageMainContent" -->
      	<?php print $myUserRegister->admin_get_menu(); ?>
      	<!-- Lister les utilisateurs -->
	      <?php if($_REQUEST[what]=="user_registerDisplay") { $nbProfile = $myCandidat->count_all_profiles(); $nb_hiddenProfiles = $myCandidat->count_all_profiles_where("0"); $nb_publicProfiles = $myCandidat->count_all_profiles_where("1"); ?>
	          <h1>Display profiles (<?php print $nbProfile; ?> = <?php print $nb_hiddenProfiles; ?> hidden + <?php print $nb_publicProfiles; ?> activated)</h1>
	          
	          <?php if(isset($user_register_display_err_msg)) {  ?>
	          <div class="ADM_err_msg"><?php print $user_register_display_err_msg; ?></div>
	          <?php } ?>
	          <?php if(isset($user_register_display_cfrm_msg)) {  ?>
	          <div class="ADM_cfrm_msg"><?php print $user_register_display_cfrm_msg; ?></div>
	          <?php } ?>
	          
	          <?php print $myUserRegister->admin_load_user_register(50); ?>
	      <?php } ?>
	      
      	<!-- Lister les postulations -->
	      <?php if($_REQUEST[what]=="postulationDisplay") { $nbPostulation = $myCandidat->count_all_postulations(); $nb_hiddenPostulations = $myCandidat->count_all_postulations_where("0"); $nb_publicPostulations = $myCandidat->count_all_postulations_where("1");?>
	          <h1>Display postulations (<?php print $nbPostulation; ?> = <?php print $nb_hiddenPostulations; ?> hidden + <?php print $nb_publicPostulations; ?> visibles)</h1>
	          
	          <?php if(isset($postulation_display_err_msg)) {  ?>
	          <div class="ADM_err_msg"><?php print $user_register_display_err_msg; ?></div>
	          <?php } ?>
	          <?php if(isset($postulation_display_cfrm_msg)) {  ?>
	          <div class="ADM_cfrm_msg"><?php print $postulation_display_cfrm_msg; ?></div>
	          <?php } ?>
	          
	          <?php print $myCandidat->admin_load_postulations(50); ?>
	      <?php } ?>
      	<!-- InstanceEndEditable -->
      </div>
      <div class="clear_both"></div>
    </div>
    <div id="subSeparator"><img src="img/dzine/subSeparator.jpg" /></div>
    <div id="subContent">
      <div class="content">&nbsp;</div>
    </div>
  </div>
</center>
</body>
<!-- InstanceEnd --></html>
