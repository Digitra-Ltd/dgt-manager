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
	$system		= new cwd_system();
	$my_users	= new cwd_user();
?>
<?php
	//Site settings
	$settings 	= $system->get_site_settings();
	
	//Language settings
	$langFile	= isset($_SESSION[LANG]) ? ($_SESSION[LANG]) : ($settings['LANG']);
	
	//Call the language file pack
	require_once("../scripts/langfiles/".$langFile.".php");
?>
<?php
	$txtLogin 	= $_POST[txtLogin];
	$txtPass  	= $_POST[txtPass];
	$hdAdmin    = 1; //$_POST[hdAdmin];
	$btnConnect = $_POST[btnConnect];
?>
<?php
	if(isset($btnConnect)){
		if((!empty($txtLogin)) && (!empty($txtPass))){
			
			$usrLevel	=	$my_users->get_user_by_login($txtLogin);
			$arr_userLevels	=	array('0', '1', '2'); //NB: 0 = Super User, 1= Admin 2=Editor
			
			if(in_array($usrLevel['u_TYPE'], $arr_userLevels)){
				if($system->chk_usr_pass_status_enc($my_users->tbl_user, "usr_login", "usr_pass", "usr_level_id", $txtLogin, $txtPass, $hdAdmin)){
								
					$tabUser 			= 	$my_users->get_user_by_login($txtLogin);
					$tab_userDetail		=	$my_users->get_user_detail($tabUser['u_ID']);
				
					//Get the detail info
					$usr_firstName		=	$tab_userDetail['ud_FIRST'];
					$usr_lastName		=	$tab_userDetail['ud_LAST'];
				
					$_SESSION['uId']				= 	$tabUser[u_ID];
				
					$_SESSION['uLogin']				= 	$txtLogin;
					$_SESSION['uLevel']				=	$tabUser['u_TYPE'];
					$_SESSION['ud_Name']			= 	ucfirst($usr_firstName).' '.strtoupper($usr_lastName);
					
					$_SESSION['LANG']				=	$langFile;
					
					
					if($usrLevel['u_TYPE']	< 2 ){
						$_SESSION['CONNECTED_ADMIN']	= 	true;
						$my_users->set_log('LOGIN ADMIN GRANTED');
					}
					else{
						$_SESSION['CONNECTED_EDIT']	= 	true;
						$my_users->set_log('LOGIN EDITOR GRANTED');
					}
				
				
					$location = isset($_REQUEST[page]) ? ($_REQUEST[page]) : ("dashboard.php");
					//Set connected
					$my_users->set_connected_user($_SESSION['uId'], 1);
					
					header("location:$location");
					exit();
				}
				else{
					$err_msg = $lang_output["LOGIN_PASS_FALSE"];
					$my_users->set_log('LOGIN ADMIN FAILED - '.$txtLogin);
				}
			}	
		}
			
		else{
			$err_msg = $lang_output["LOGIN_PASS_FALSE"];
			$my_users->set_log('LOGIN ADMIN FAILED - '.$txtLogin);
		}
	}
?>

<?php
	//ob_end_flush();
?>

<!DOCTYPE HTML>
<html>
<head>
<title>CAWAD CMS 3.0 | Login :: For administrators only</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Modern Responsive web template, Bootstrap Web Templates, Flat Web Templates, Andriod Compatible web template, 
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyErricsson, Motorola web design" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
 <!-- Bootstrap Core CSS -->
<link href="css/bootstrap.min.css" rel='stylesheet' type='text/css' />
<!-- Custom CSS -->
<link href="css/style.css" rel='stylesheet' type='text/css' />
<link href="css/font-awesome.css" rel="stylesheet"> 
<!-- jQuery -->
<script src="js/jquery.min.js"></script>
<!----webfonts--->
<link href='http://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900' rel='stylesheet' type='text/css'>
<!---//webfonts--->  
<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.min.js"></script>
<link rel="shortcut icon" href="../img/icon/favicon.png" type="image/x-png" />
</head>
<body id="login">
  <div class="login-logo">
    <a href="../index.php"><img src="../img/logo/header-logo.png" data-hires="../img/logo/header-logo.2x.png" alt="North-West Region" alt="Retour au site web"/></a>
  </div>
  <h2 class="form-heading"><?php print $lang_output["LBL_ADMIN_FRAME"]; ?></h2>
  <div class="innerTitle">
      <?php 
      	if($_REQUEST[what] == "session_expired")
      		print "<p class=\"err_msg\">".$lang_output["SESSION_EXPIRED"]."</p>";     	
      ?>      
  </div>
  
    
          
  <div class="app-cam">
  	  <?php if(isset($err_msg)){ ?>
            <div class="ADM_err_msg"><?php print $err_msg; ?></div>
      <?php } ?>
	  <form name="adminConnect" method="post" action="">
		<input name="txtLogin" type="text" class="text" value="<?php print $lang_output["LBL_ADMIN_LOGIN"]; ?>" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Your user name here';}" />
		<input name="txtPass" type="password" value="<?php print $lang_output["LBL_ADMIN_PASSWORD"]; ?>" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'You password here';}" />
		<div class="submit">
			<input name="btnConnect" type="submit" value="<?php print $lang_output["BTN_ADMIN_CONNECT"]; ?>" />
			<input type="hidden" name="hdAdmin" value="1" />
		</div>
		<!-- 
		<div class="login-social-link">
          <a href="index.php" class="facebook">
              Facebook
          </a>
          <a href="index.php" class="twitter">
              Twitter
          </a>
        </div>
         -->
		<ul class="new">
			<li class="new_left"><p><a href="#"><?php print $lang_output['LABEL_CONNECT_FORGOTTEN_PASSWORD']?></a></p></li>
			<li class="new_right"><p class="sign"><?php print $lang_output['LABEL_CONNECT_NEW']?> <a href="#"><?php print $lang_output['LABEL_CONNECT_CONTACT_WEBMASTER']?></a></p></li>
			<div class="clearfix"></div>
		</ul>
	</form>
  </div>
   <div class="copy_layout login">
      <p>Copyright &copy; 2015 Modern. All Rights Reserved | Design by <a href="http://www.digitra.com/" target="_blank">DIGITRA - Bamenda</a> </p>
   </div>
</body>
</html>

