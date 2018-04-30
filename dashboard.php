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
	require_once("../member/library/member.inc.php");
?>
<?php 
	$system			= 	new cwd_system();
	$member			= 	new cwd_member();
	$myFiletransact	=	new cwd_system();
	$modules		=	new cwd_module();
	$system->session_checker($_SESSION["CONNECTED_ADMIN"], $_SESSION["CONNECTED_EDIT"]);
?>
<?php
	//Site settings
	$settings 	= $system->get_site_settings();
	
	//Language settings
	$langFile	= isset($_SESSION[LANG]) ? ($_SESSION[LANG]) : ($settings["LANG"]);
	
	//Call the language file pack
	require_once("../scripts/langfiles/".$langFile.".php");  //Global language pack	
?>
<?php
	//:::::::::::::::::::::::::::::::Dynamic modules language packs files loading:::::::::::::::::::::::::::::::
	$site_modules = $myFiletransact->list_dir($thewu32_site_dir.'modules/'); //Lister tous les  sous-répertoires directs du répertoire /modules/
	foreach($site_modules as $module){
		//Load language pack for each module
		require_once('../modules/'.$module.'/langfiles/'.$langFile.'.php');
		//print '<p>../modules/'.$module.'/langfiles/'.$_SESSION['LANG'].'</p>';
	}
?>
<?php
	//Clear log file
	//Log file...
	$logFile	=	'../log/log.gzk';
	if(isset($_SESSION['CONNECTED_ADMIN'])){
		if($_REQUEST['what'] == 'clearLog'){
			$system->clear_file($logFile);
			$system->set_log('LOG CLEARED');
		}
	}
	
	//Disconnect member
	if($_REQUEST[action] == 'memberDisconnect'){
		$member->set_connected_member($_REQUEST[mcId], 0);
		$memberName	=	$member->get_member_name_by_id($_REQUEST[mId]);
		$system->set_log("MEMBER DISCONNECTED - ".$memberName);
	}
?>
<?php
	ob_end_flush();
?>
<?php 
	//print_r($system->digitra_get_mod_dir('news', '1'));
?>
<!--
Author: W3layouts
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<!DOCTYPE HTML>
<html>
<head>
<?php include_once 'admin_header.php'; ?>
<title>CAWAD CMS 3.0 | Home :: Welcome to your CPanel</title>
</head>
<body>
<div id="wrapper">
     <!-- Navigation -->
        <?php 
			include_once('responsive_menu.php')
		?>
        
        <div id="page-wrapper">
        <div class="graphs">
     	<div class="col_3">
        	<div class="col-md-3 widget widget1">
        		<div class="r3_counter_box">
                    <i class="pull-left fa fa-user icon-rounded"></i>
                    <div class="stats">
                      <h5><strong><?php //print $member->count_member_connected(); ?></strong></h5>
                      <span><a href="#openModalConnected">Utilisateur(s) connect&eacute;s</a></span>
                    </div>
                </div>
        	</div>
        	<div class="col-md-3 widget widget1">
        		<div class="r3_counter_box">
                    <i class="pull-left fa fa-globe user1 icon-rounded"></i>
                    <div class="stats">
                      
                      <!-- hitwebcounter Code START -->
						<a href="#" target="_blank">
							<img src="http://hitwebcounter.com/counter/counter.php?page=6521975&style=0003&nbdigits=5&type=ip&initCount=0" title="Hit Web Stats" Alt="Hit Web Stats"   border="0" >
						</a>
                        <br/>
                        <!-- hitwebcounter.com -->
                        <a href="#" title="Total Count" target="_blank" style="font-family: sans-serif, Arial, Helvetica; font-size: 6px; color: #6D6C72; text-decoration: none ;"></a> 
                       <span>Nouveaux Visiteurs</span>
                    </div>
                </div>
        	</div>
        	<div class="col-md-3 widget widget1">
        		<div class="r3_counter_box">
                    <i class="pull-left fa fa-users user2 icon-rounded"></i>
                    <div class="stats">
                      <h5><strong><?php //print $member->count_members()?></strong></h5>
                      <span><a href="#openModalMembers">Utilisateurs OTOURIX</a></span>
                    </div>
                </div>
        	</div>
        	<div class="col-md-3 widget">
        		<div class="r3_counter_box">
                    <i class="pull-left fa fa-terminal dollar1 icon-rounded"></i>
                    <div class="stats">
                      <h5><strong><?php print ($system->count_lines_in_file('../log/log.gzk') - 1) ;?></strong></h5>
                      <span><a title="<?php print $lang_output['LABEL_ADMIN_LOG_ACTIVITY_ALT']; ?>" href="#openModalLog"><?php print $lang_output['LABEL_ADMIN_LOG_ACTIVITY']; ?></a></span>
                    </div>
                </div>
        	 </div>
        	<div class="clearfix"> </div>
      </div>
      <div class="col_1">
		    
		    <div class="col-md-4 span_8">
		       <div class="activity_box">
               	<h4 class="admin_module_title"><?php print $lang_output["USER_ADMIN_MODULE_TITLE"];?></h4>
		        <div class="scrollbar" id="style-2">
                	<img class="img-responsive" src="images/db_user_manager.jpg" />
                   <hr />
                   <div class="activity-row">
                   
                   	 <div class="col-xs-1"><i class="fa fa-user text-info icon_11"></i></div>
	                 <div class="col-xs-11 activity-desc">
	                 	<?php print $lang_output["USER_ADMIN_MODULE_DESCR"];?>
	                 </div>
	                 <div class="clearfix"> </div>
                    </div>
                     <div class="buttons"><a class="<?php print $link = (isset($_SESSION['CONNECTED_EDIT']) ? 'disabled ' : '') ?>btn btn-primary btn-lg" href="<?php print $system->digitra_get_mod_admin('user');?>"><?php print $lang_output["LABEL_MODULE_BUTTON_ACCESS"]?></a></div>
	  		        </div>
		          </div>
		    </div>
			<div class="col-md-4 span_8">
		       <div class="activity_box">
               <h4 class="admin_module_title"><?php print $lang_output["PAGE_ADMIN_MODULE_TITLE"];?></h4>
		        <div class="scrollbar" id="style-2">
                	<img class="img-responsive" src="images/db_page_manager.jpg" />
                   <hr />
                   <div class="activity-row">
                   	 <div class="col-xs-1"><i class="fa fa-sitemap text-info icon_11"></i></div>
	                 <div class="col-xs-11 activity-desc">
	                 	<?php print $lang_output["PAGE_ADMIN_MODULE_DESCR"];?>
	                 </div>
	                 <div class="clearfix"> </div>
                    </div>
                      <div class="buttons"><a class="btn btn-primary btn-lg" href="<?php print $system->digitra_get_mod_admin('page');?>"><?php print $lang_output["LABEL_MODULE_BUTTON_ACCESS"]?></a></div>
	  		        </div>
		          </div>
		    </div>
            <div class="col-md-4 span_8">
		       <div class="activity_box">
               <h4 class="admin_module_title"><?php print $lang_output["NEWS_ADMIN_MODULE_TITLE"];?></h4>
		        <div class="scrollbar" id="style-2">
                	<img class="img-responsive" src="images/db_news_manager.jpg" />
                   <hr />
	  			    <div class="activity-row">
                     <div class="col-xs-1"><i class="fa fa-indent text-info icon_11"></i></div>
	                 <div class="col-xs-11 activity-desc">
	                 	<?php print $lang_output["NEWS_ADMIN_MODULE_DESCR"];?>
	                 </div>
	                 <div class="clearfix"> </div>
                    </div>
                    
                    <div class="buttons"><a class="btn btn-primary btn-lg" href="<?php print $system->digitra_get_mod_admin('news');?>"><?php print $lang_output["LABEL_MODULE_BUTTON_ACCESS"]?></a></div>
	  		        </div>
		          </div>
		    </div>
            <p>&nbsp;</p>
            <div class="col-md-4 span_8">
		       <div class="activity_box">
               <h4 class="admin_module_title"><?php print $lang_output["EVENT_ADMIN_MODULE_TITLE"];?></h4>
		        <div class="scrollbar" id="style-2">
                	<img class="img-responsive" src="images/db_event_manager.jpg" />
                   <hr />
	  			    <div class="activity-row">
                     <div class="col-xs-1"><i class="fa fa-calendar text-info icon_13"></i></div>
	                 <div class="col-xs-11 activity-desc">
	                 	<?php print $lang_output["EVENT_ADMIN_MODULE_DESCR"];?>
	                 </div>
	                 <div class="clearfix"> </div>
                    </div>
                    
                    <div class="buttons"><a class="btn btn-primary btn-lg" href="<?php print $system->digitra_get_mod_admin('event');?>"><?php print $lang_output["LABEL_MODULE_BUTTON_ACCESS"]?></a></div>
	  		        </div>
		          </div>
		    </div>
            <div class="col-md-4 span_8">
		       <div class="activity_box">
               <h4 class="admin_module_title"><?php print $lang_output["FILE_ADMIN_MODULE_TITLE"];?></h4>
		        <div class="scrollbar" id="style-2">
                <img class="img-responsive" src="images/db_file_manager.jpg" />
                   <hr />
                   <div class="activity-row">
	                 <div class="col-xs-1"><i class="fa fa-file text-info icon_13"> </i>  </div>
	                 <!-- <div class="col-xs-3 activity-img"><img src='images/5.png' class="img-responsive" alt=""/></div> -->
	                 <div class="col-xs-11 activity-desc">
	                    <?php print $lang_output["FILE_ADMIN_MODULE_DESCR"];?>
	                 </div>
	                 <div class="clearfix"> </div>
                    </div>
	  			    <div class="buttons"><a class="btn btn-primary btn-lg" href="<?php print $system->digitra_get_mod_admin('file');?>"><?php print $lang_output["LABEL_MODULE_BUTTON_ACCESS"]?></a></div> 
	  		        </div>
		          </div>
		    </div>
            
		    <div class="col-md-4 span_8">
		       <div class="activity_box">
               <h4 class="admin_module_title"><?php print $db_gallery_output['GALLERY_ADMIN_MODULE_TITLE'];?></h4>
		        <div class="scrollbar" id="style-2">
                <img class="img-responsive" src="images/<?php print $db_gallery_output['GALLERY_ADMIN_DB_IMG'];?>" />
                   <hr />
                   <div class="activity-row">
	                 <div class="col-xs-1"><?php print $db_gallery_output['GALLERY_ADMIN_DB_ICON']?></div>
	                 <div class="col-xs-11 activity-desc">
	                 	<?php print $db_gallery_output['GALLERY_ADMIN_MODULE_DESCR'];?>
	                 </div>
	                 <div class="clearfix"> </div>
                    </div>
	  			    <div class="buttons"><a class="btn btn-primary btn-lg" href="<?php print $system->digitra_get_mod_admin('gallery');?>"><?php print $lang_output['LABEL_MODULE_BUTTON_ACCESS']?></a></div> 
	  		        </div>
		          </div>
		    </div>
		    
		    <p>&nbsp;</p>
		    
		    <div class="col-md-4 span_8">
		       <div class="activity_box">
               <h4 class="admin_module_title"><?php print $db_banner_output['BANNER_ADMIN_MODULE_TITLE'];?></h4>
		        <div class="scrollbar" id="style-2">
                <img class="img-responsive" src="images/<?php print $db_banner_output['BANNER_ADMIN_DB_IMG'];?>" />
                   <hr />
                   <div class="activity-row">
	                 <div class="col-xs-1"><?php print $db_banner_output['BANNER_ADMIN_DB_ICON'];?></div>
	                 <div class="col-xs-11 activity-desc">
	                 	<?php print $db_banner_output['BANNER_ADMIN_MODULE_DESCR'];?>
	                 </div>
	                 <div class="clearfix"> </div>
                    </div>
	  			    <div class="buttons"><a class="btn btn-primary btn-lg" href="<?php print $system->digitra_get_mod_admin('banner');?>"><?php print $lang_output['LABEL_MODULE_BUTTON_ACCESS']?></a></div> 
	  		        </div>
		          </div>
		    </div>
		    
		    <div class="col-md-4 span_8">
		       <div class="activity_box">
               <h4 class="admin_module_title"><?php print $db_dailyquot_output['DAILYQUOT_ADMIN_MODULE_TITLE'];?></h4>
		        <div class="scrollbar" id="style-2">
                <img class="img-responsive" src="images/<?php print $db_dailyquot_output['DAILYQUOT_ADMIN_DB_IMG'];?>" />
                   <hr />
                   <div class="activity-row">
	                 <div class="col-xs-1"><?php print $db_dailyquot_output['DAILYQUOT_ADMIN_DB_ICON'];?></div>
	                 <div class="col-xs-11 activity-desc">
	                 	<?php print $db_dailyquot_output['DAILYQUOT_ADMIN_MODULE_DESCR'];?>
	                 </div>
	                 <div class="clearfix"> </div>
                    </div>
	  			    <div class="buttons"><a class="btn btn-primary btn-lg" href="<?php print $system->digitra_get_mod_admin('dailyquot');?>"><?php print $lang_output['LABEL_MODULE_BUTTON_ACCESS']?></a></div> 
	  		        </div>
		          </div>
		    </div>
		    
		    <div class="col-md-4 span_8">
		       <div class="activity_box">
               <h4 class="admin_module_title"><?php print $db_annonce_output['ANNONCE_ADMIN_MODULE_TITLE'];?></h4>
		        <div class="scrollbar" id="style-2">
                <img class="img-responsive" src="images/<?php print $db_annonce_output['ANNONCE_ADMIN_DB_IMG'];?>" />
                   <hr />
                   <div class="activity-row">
	                 <div class="col-xs-1"><?php print $db_annonce_output['ANNONCE_ADMIN_DB_ICON']?></div>
	                 <div class="col-xs-11 activity-desc">
	                 	<?php print $db_annonce_output['ANNONCE_ADMIN_MODULE_DESCR'];?>
	                 </div>
	                 <div class="clearfix"> </div>
                    </div>
	  			    <div class="buttons"><a class="btn btn-primary btn-lg" href="<?php print $system->digitra_get_mod_admin('annonce');?>"><?php print $lang_output['LABEL_MODULE_BUTTON_ACCESS']?></a></div> 
	  		        </div>
		          </div>
		    </div>
		    
		    <p>&nbsp;</p>    
		    
		    <div class="col-md-4 span_8">
		       <div class="activity_box">
               <h4 class="admin_module_title">OTOURIX Module</h4>
		        <div class="scrollbar" id="style-2">
                <img class="img-responsive" src="images/db_otourix_manager.jpg" />
                   <hr />
                   <div class="activity-row">
	                 <div class="col-xs-1"><i class="fa fa-users text-info icon_13"> </i>  </div>
	                 <div class="col-xs-11 activity-desc">
	                 	<h5>Gestion des donn&eacute;es OTOURIX.</h5>
        				<p>G&eacute;rer les donn&eacute;s en provenance de la plate-forme de gestion scolaire OTOURIX pour une interaction en ligne avec les &eacute;l&egrave;ves, les parents et l'administration du CABB.</p>
	                 </div>
	                 <div class="clearfix"> </div>
                    </div>
	  			    <div class="buttons"><a class="btn btn-primary btn-lg" href="<?php print $system->digitra_get_mod_admin('member');?>">Acc&eacute;der au module</a></div> 
	  		        </div>
		          </div>
		    </div>
		    
		    <div class="clearfix"> </div>
		    
		    <?php if($_SESSION['uId']	==	'1') { ?>
		    <hr />
		    <div class="col-md-4 stats-info stats-info1">
                <div class="panel-heading">
                    <h4 class="panel-title">Modules configuration</h4>
                </div>
                <div class="panel-body panel-body2">
                    <?php print $system->load_modal_button('Module configuration', 'moduleConf', '', $modules->tbl_load_modules());?>
                </div>
            </div>
            
            <div class="clearfix"> </div>
            <?php } ?>
	  </div>
	  
   		 <p>&nbsp;</p>
		<div class="copy">
            <p>Copyright &copy; 2016 DIGITRA. All Rights Reserved | Design by <a href="http://www.digitra.com/" target="_blank">Digitra</a> </p>
	    </div>
		</div>
       </div>
      <!-- /#page-wrapper -->
   </div>
    <!-- /#wrapper -->
    <!-- Bootstrap Core JavaScript 
    <script src="js/bootstrap.min.js"></script>
    -->
    <!-- Modal dialogs here... -->
    <div id="openModalConnected" class="modalDialog">
		<div style="width:80%;">
			<h1>Now connected</h1>
			<a href="#close" title="Close" class="close">X</a>
            <div class="panel panel-warning" data-widget="{&quot;draggable&quot;: &quot;false&quot;}" data-widget-static="">
                <div class="panel-body no-padding">
                	<div class="scrollbar" style="max-height:80%;">
	                	<?php isset($_SESSION['CONNECTED_ADMIN']) ? ($dbView = '100') : ($dbView='0'); ?>
	                    <?php print $member->admin_load_connected($dbView); ?>
	                </div>
                </div>
            </div>
			<p>&nbsp;</p><p>&nbsp;</p>
		</div>
	</div>
	
	<!-- ********************************* Afficher les membres  ******************************************************
      ****************************************************************************************************************-->
      <div id="openModalMembers" class="modalDialog">
      	<div style="width:80%;">
			<h1>Registered associations</h1>
			<a href="#close" title="Close" class="close">X</a>
			<div class="panel panel-warning" data-widget="{&quot;draggable&quot;: &quot;false&quot;}" data-widget-static="">
                <div class="panel-body no-padding">
                	<div class="scrollbar" style="max-height:80%;">
					  <?php $member->limit = $_REQUEST[limite]; ?>
			          <?php isset($_SESSION['CONNECTED_ADMIN']) ? ($dbView = '1') : ($dbView='0'); ?>
			          <?php print $member->admin_load_members(4000); ?>
		          	</div>
		        </div>
            </div>
			<p>&nbsp;</p><p>&nbsp;</p>
		</div>
	</div>
   
   
   <!-- ********************************* Afficher le contenu du fichier log  ******************************************************
      ****************************************************************************************************************-->
      <div id="openModalLog" class="modalDialog">
      	<div style="width:80%;">
			<h1>Connected users activity</h1>
			<a href="#close" title="Close" class="close">X</a>
			<div class="panel panel-warning" data-widget="{&quot;draggable&quot;: &quot;false&quot;}" data-widget-static="">
                <div class="panel-body no-padding">
		          <div class="scrollbar" style="max-height:80%;">
		          	<?php print $member->read_file_content('../log/log.gzk'); ?>
		          </div>
		          <?php if (isset($_SESSION['CONNECTED_ADMIN'])) { ?><div class="buttons"><a onClick="return confirm('Are you sure you want to clear the log file?');" class="btn btn-primary btn-lg" href="?what=clearLog">Clear the log file</a></div><?php } ?>
		        </div>
            </div>
			<p>&nbsp;</p><p>&nbsp;</p>
		</div>
	</div> 
    
    <?php //print_r($mod_lang_output);?>
    
    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
</body>
</html>
