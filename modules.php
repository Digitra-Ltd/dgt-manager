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
	$system->session_checker($_SESSION["CONNECTED_ADMIN"], $_SESSION["CONNECTED_EDIT"]);
?>
<?php
	//Site settings
	$settings 	= $system->get_site_settings();
	
	//Language settings
	$langFile	= isset($_SESSION[LANG]) ? ($_SESSION[LANG]) : ($settings["LANG"]);
	//Call the language file pack
	require_once("../scripts/langfiles/".$langFile.".php");
?>
<?php
	//Personalized scripts in here
?>
<?php
	ob_end_flush();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/admin_template.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>My Admin 1.1 - Modules management</title>
<link rel="shortcut icon" href="../img/dzine/icons/favicon.png" type="image/x-png" />
<!-- InstanceEndEditable -->
<link href="css/layout.css" rel="stylesheet" type="text/css" />
<link href="css/admin.css" rel="stylesheet" type="text/css" />
<!-- InstanceBeginEditable name="head" --><!-- InstanceEndEditable -->
<script type="text/JavaScript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>
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
      	<?php print $system->admin_main_menu_display(); ?>
    	<div style="float:right;"><a href="#">Modifier mon compte</a></div>
      </div>
      <div class="clear_both"></div>
    </div>
    <div id="headSub"> <img src="img/dzine/headSub.jpg" height="9" width="996" />
      <div class="clear_both"></div>
    </div>
    <div id="mainContent">
      <div class="content"><!-- InstanceBeginEditable name="pageMainContent" -->
        <p>Below are our preinstalled modules for the management of your website.</p>
        <p>For any problem using this feature, please, click on &quot;Help&quot; menu or mail us about.</p>
        <!-- <div class="ADM_box">
          	<div class="ADM_box_head">Profile Manager</div> 
          	<div class="ADM_box_content">
          		<p>Manage the profiles (Enterprises and Candidates) registered in the system.</p>
          		<p>You can also have an overview and/or a specific view of each postulation</p>
          		<p><a href="profile_manager.php">&raquo; Click here to start </a></p>
          	</div>
        </div> -->
        <div class="ADM_box">
        	<div class="ADM_box_head">Users Manager</div> 
        	<div class="ADM_box_content">
        		<p>Users management module.</p>
        		<p>With this graphical and intuitive interface, you can easily create, update and/or delete users that shall be in charge of the administration of the website.</p>
       		  <p><a href="user_manager.php">&raquo; Click here to start</a></p>
       	  </div>
        </div>        
      	<div class="ADM_box">
          	<div class="ADM_box_head">Page Manager </div> 
          	<div class="ADM_box_content">
          		<p>Module for the management of the pages and the main menu of your site. </p>
          		<p>This feature allows you to make an efficient and intuitive management of your web site content. With our wysiwyg editor, it's the best way to create attractive pages contents, and, if you are familiar with HTML code, you can also switch to HTML or wysiwyg view before submitting your work. </p>
          		<p>You can add, remove, publish or mask your menu item and defining their target pages.</p>
          		<p><a href="page_manager.php">&raquo; Click here to start </a></p>
          	</div>
        </div>
        <div class="ADM_box">
        	<div class="ADM_box_head">News Manager</div> 
        	<div class="ADM_box_content">
        		<p>News management modules (stories) for your web site.</p>
        		<p>Here is the easiest way to manage stories in your website. You have indeed th e possibility to create and write your stories, in the languages of your choice defined in the configuration section of this ad;inistration panel, personalise the headline and inner stories layouts of your website with the power of cascading styles sheets</p>
       		  <p><a href="news_manager.php">&raquo; Click here to start</a></p>
       	  </div>
        </div>
        <div class="ADM_box">
          <div class="ADM_box_head">Events Manager</div> 
          <div class="ADM_box_content">
          		<p>Events management module.</p>
       		<p>Easily help you managing the displaying of the upcoming events you want to make available from your website...</p>
          		<p><a href="event_manager.php">&raquo; Click here to start</a></p>
          </div>
        </div>
        <!-- <div class="ADM_box">
        	<div class="ADM_box_head">Picture Gallery Manager</div> 
        	<div class="ADM_box_content">
        		<p>This module allows you to easily manage a photo gallery for your website.</p>
        		<p>In this picture gqllery ;odule, photos are classified in categories or albums. For each photo to be displayed, you will have the followings attributes :</p>
   		  <ul>
        	  		<li><strong>Thumbnail</strong></li>
   		       		<li><strong>Photo legend</strong></li>
       	     		<li><strong>The main photo</strong></li>
           		</ul>
        		<p><a href="gallery_manager.php">&raquo; Click here to start</a></p>
        	</div>
        </div> -->
        <!-- <div class="ADM_box">
          <div class="ADM_box_head">Announcement Manager</div> 
          <div class="ADM_box_content">
          		<p>Announcement management module.</p>
       		<p>Easily manage all types of announcement/communiquees to be displayed in your website. Their are of course grouped by category.</p>
       		<p><a href="annonce_manager.php">&raquo; Click here to start</a></p>
          </div>
        </div> -->
        <div class="ADM_box">
          <div class="ADM_box_head">File Manager</div> 
          <div class="ADM_box_content">
          		<p>Library management modules.</p>
          		<p>Here is the place set for the intuitive management of files to be downloaded via your website.</p>
       		<p><a href="file_manager.php">&raquo; Click here to start</a></p>
          </div>
        </div>
        <!-- <div class="ADM_box">
          <div class="ADM_box_head">Daily quotes Manager</div> 
          <div class="ADM_box_content">
          		<p>Daily quotes management module.</p>
          		<p>If you want some customized quotes to be displayed in a daily basis in your website, here is the place to start. </p>
       		<p><a href="dailyquot_manager.php">&raquo; Click here to start</a></p>
          </div>
        </div> -->
        <div class="ADM_box">
        	<div class="ADM_box_head">MIDENO Members Manager</div> 
        	<div class="ADM_box_content">
        		<p>Management of NGO's and Staff.</p>
        		<p>Intuitive management of accredited NGOs and MIDENO general staff members</p>
        		<p><a href="member_manager.php">&raquo; Clic here to continue</a></p>
        	</div>
        </div>  
        <!--
	  	<div class="ADM_box">
          	<div class="ADM_box_head">Banners Manager</div> 
          	<div class="ADM_box_content">
          		<p>You can here modify the banners of your web site.</p>
          		<p>Make sure that your created banner fit with the default one, in terms of width and height. Your banner must also be designed on GIF, PNG or JPG format.</p>
          		<p><a href="banner_manager.php">&raquo; Click here to start </a></p>
          	</div>
        </div>
        <div class="ADM_box">
          	<div class="ADM_box_head">Audiences Manager</div> 
          	<div class="ADM_box_content">
          		<p>Gestionnaire des demandes d'audience.</p>
          		<p>Make sure that your created banner fit with the default one, in terms of width and height. Your banner must also be designed on GIF, PNG or JPG format.</p>
          		<p><a href="interview_manager.php">&raquo; Click here to start </a></p>
          	</div>
        </div>
         
        <div class="ADM_box">
          	<div class="ADM_box_head">Catalog Manager</div> 
          	<div class="ADM_box_content">
          		<p>Your online store made simple!</p>
          		<p><a href="catalog_manager.php">&raquo; Click here to start </a></p>
          	</div>
        </div>
        
        <div class="ADM_box">
          	<div class="ADM_box_head">Job Manager</div> 
          	<div class="ADM_box_content">
          		<p>Allow you to manage job offers from enterprises registered or not in the system.</p>
          		<p><a href="job_manager.php">&raquo; Click here to start </a></p>
          	</div>
        </div>
         -->
      <!-- InstanceEndEditable --></div>
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
