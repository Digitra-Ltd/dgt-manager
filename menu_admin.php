<?php
    $menu = "
    <nav class=\"top1 navbar navbar-default navbar-static-top\" role=\"navigation\" style=\"margin-bottom: 0\">
    		
    	<div class=\"navbar-header\">
        	<button type=\"button\" class=\"navbar-toggle\" data-toggle=\"collapse\" data-target=\".navbar-collapse\">
            	<span class=\"sr-only\">Toggle navigation</span>
                <span class=\"icon-bar\"></span>
                <span class=\"icon-bar\"></span>
                <span class=\"icon-bar\"></span>
            </button>
            <a class=\"navbar-brand\" href=\"dashboard.php\">CAWAD CMS 3.0</a>
        </div>
            
    	<!-- /.navbar-header -->
  
        <ul class=\"nav navbar-nav navbar-right\">
			<li class=\"dropdown\">
				<a class=\"dropdown-toggle\" aria-expanded=\"false\" href=\"#\" data-toggle=\"dropdown\"><i class=\"fa fa-user fa-fw nav_icon\"></i>".$system->greet_by_lang($_SESSION['LANG']).", $userName</a>
           		<ul class=\"dropdown-menu\">
            		<li class=\"m_2\"><a href=\"user_manager.php?what=userUpdate&action=userUpdate&userId=".$_SESSION['uId']."\"><i style=\"color:#669933;\" class=\"fa fa-user nav_icon\"></i>Modifier mon compte</a></li>
            		<li class=\"m_2\"><a href=\"../logout.php\"><i style=\"color:#993300;\" class=\"fa fa-power-off fa-fw nav_icon\"></i>Logout</a></li>
            	</ul>
            </li>
            
			<li><a href=\"dashboard.php\"><i class=\"fa fa-dashboard fa-fw nav_icon\"></i>Dashboard</a></li>
				
			<li class=\"dropdown\">
				<a class=\"dropdown-toggle\" aria-expanded=\"false\" href=\"#\" data-toggle=\"dropdown\"><i class=\"fa fa-question nav_icon\"></i>Help</a>
            	<ul class=\"dropdown-menu\">
            		<li class=\"dropdown-menu-header text-center\">Documentation</li>
            		<li class=\"m_2\"><a href=\"#\"><i class=\"fa fa-download\"></i>Download the Admin manual</a></li>
            		<li class=\"dropdown-menu-header text-center\">Settings...</li>
            		<li class=\"m_2\"><a href=\"server_settings2.php\"><i class=\"fa fa-server\"></i>Server settings</a></li>
            		<li class=\"m_2\"><a href=\"config.php\"><i class=\"fa fa-wrench\"></i>General settings</a></li>
            		<li class=\"m_2\"><a href=\"update_settings.php\"><i class=\"fa fa-refresh\"></i>Update settings</a></li>
            	</ul>
            </li>
        </ul>
			
		<!-- <form class=\"navbar-form navbar-right\">
              <input type=\"text\" class=\"form-control\" value=\"Search...\" onFocus=\"this.value = '';\" onBlur=\"if (this.value == '') {this.value = 'Search...';}\">
        </form> -->
            
        <!-- Our side bar starts here-->
            <div class=\"navbar-default sidebar\" role=\"navigation\">
                <div class=\"sidebar-nav navbar-collapse\">
                    <ul class=\"nav\" id=\"side-menu\">
                    	
                    	<!-- Dashboard call -->
                        <li>
                            <a href=\"dashboard.php\"><i class=\"fa fa-dashboard fa-fw nav_icon\"></i>Dashboard</a>
                        </li>
                        
                        <!-- Users manager-->
                        <li>
                            <a href=\"#\"><i class=\"fa fa-user nav_icon\"></i>Users Manager<span class=\"badge badge-primary\">$nbUsers</span><span class=\"fa arrow\"></span></a>
                            <ul class=\"nav nav-second-level\">
                                <li>
                                    <a href=\"user_manager.php?what=userDisplay\"><i class=\"fa fa-eye nav_icon\"></i>Display users</a>
                                </li>
                                <li>
                                    <a href=\"user_manager.php?what=userInsert\"><i class=\"fa fa-plus nav_icon\"></i>Create users</a>
                                </li>
                                <li>
                                    <a href=\"user_manager.php?what=userCatDisplay\"><i class=\"fa fa-eye nav_icon\"></i>Display categories</a>
                                </li>
								<li>
                                    <a href=\"user_manager.php?what=userCatInsert\"><i class=\"fa fa-plus nav_icon\"></i>Create category</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        
                        <!-- Events manager-->
                        <li>
                            <a href=\"#\"><i class=\"fa fa-calendar nav_icon\"></i>Events Manager<span class=\"badge badge-primary\">$nbEvents</span><span class=\"fa arrow\"></span></a>
                            <ul class=\"nav nav-second-level\">
                                <li class=\"active\">
                                    <a href=\"event_manager.php?what=eventDisplay\"><i class=\"fa fa-eye nav_icon\"></i>Display events</a>
                                </li>
                                <li>
                                    <a href=\"event_manager.php?what=eventInsert\"><i class=\"fa fa-plus nav_icon\"></i>Create events</a>
                                </li>
                                <li>
                                    <a href=\"event_manager.php?what=eventCatDisplay\"><i class=\"fa fa-eye nav_icon\"></i>Display categories</a>
                                </li>
								<li>
                                    <a href=\"event_manager.php?what=eventCatInsert\"><i class=\"fa fa-plus nav_icon\"></i>Create category</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        
                        <!-- Gallery Manager -->
                        <li>
                            <a href=\"#\"><i class=\"fa fa-picture-o nav_icon\"></i>Gallery Manager<span class=\"badge badge-primary\">$nb_galleryPix</span><span class=\"fa arrow\"></span></a>
                            <ul class=\"nav nav-second-level\">
                                <li>
                                    <a href=\"gallery_manager.php?what=galleryDisplay\"><i class=\"fa fa-eye nav_icon\"></i>Display photos</a>
                                </li>
                                <li>
                                    <a href=\"gallery_manager.php?what=galleryInsert\"><i class=\"fa fa-plus nav_icon\"></i>Insert photo</a>
                                </li>
                                <li>
                                    <a href=\"gallery_manager.php?what=galleryCatDisplay\"><i class=\"fa fa-eye nav_icon\"></i>Display albums<span class=\"badge badge-warning\">$nb_galleryAlbums</span></a>
                                </li>
								<li>
                                    <a href=\"gallery_manager.php?what=galleryCatInsert\"><i class=\"fa fa-plus nav_icon\"></i>Create album</a>
                                </li>
                            </ul>
                            
                        </li>
                        
                        <!-- Pages manager-->
                        <li>
                            <a href=\"#\"><i class=\"fa fa-sitemap nav_icon\"></i>Pages Manager<span class=\"badge badge-primary\">$nbPages</span><span class=\"fa arrow\"></span></a>
                            <ul class=\"nav nav-second-level\">
                                <li>
                                    <a href=\"page_manager.php?what=pageDisplay\"><i class=\"fa fa-eye nav_icon\"></i>Display pages</a>
                                </li>
                                <li>
                                    <a href=\"page_manager.php?what=pageInsert\"><i class=\"fa fa-plus nav_icon\"></i>Create pages</a>
                                </li>
                                <li>
                                    <a href=\"page_manager.php?what=contentEdit\"><i class=\"fa fa-edit nav_icon\"></i>Edit page contents</a>
                                </li>
                                <li>
                                    <a href=\"page_manager.php?what=pageModuleAssign\"><i class=\"fa fa-exchange nav_icon\"></i>Assign module</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        
                        <!-- News manager-->
                        <li>
                            <a href=\"#\"><i class=\"fa fa-indent nav_icon\"></i>News Manager<span class=\"badge badge-primary\">$nbNews</span><span class=\"fa arrow\"></span></a>
                            <ul class=\"nav nav-second-level\">
                                <li>
                                    <a href=\"news_manager.php?what=newsDisplay\"><i class=\"fa fa-eye nav_icon\"></i>Display stories</a>
                                </li>
                                <li>
                                    <a href=\"news_manager.php?what=newsInsert\"><i class=\"fa fa-plus nav_icon\"></i>Create story</a>
                                </li>
                                <li>
                                    <a href=\"news_manager.php?what=newsCatDisplay\"><i class=\"fa fa-eye nav_icon\"></i>Display categories</a>
                                </li>
                                <li>
                                    <a href=\"news_manager.php?what=newsCatInsert\"><i class=\"fa fa-plus nav_icon\"></i>Create category</a>
                                </li>
                                <li>
                                
                                	<a href=\"#\"><i class=\"fa fa-cogs nav_icon\"></i>Story settings<span class=\"fa arrow\"></span></a>
                                	<ul class=\"nav nav-third-level\">
                                		<li>
                                    		<a href=\"news_manager.php?what=news_authorDisplay\"><i class=\"fa fa-eye nav_icon\"></i>View authors</a>
		                                </li>
		                                <li>
                                    		<a href=\"news_manager.php?what=news_authorInsert\"><i class=\"fa fa-plus nav_icon\"></i>Add author</a>
		                                </li>
		                                <li>
		                                    <a href=\"news_manager.php?what=news_authorCatDisplay\"><i class=\"fa fa-eye nav_icon\"></i>View authors categories</a>
		                                </li>
		                                <li>
                                    		<a href=\"news_manager.php?what=news_authorGroupInsert\"><i class=\"fa fa-plus nav_icon\"></i>Add author group</a>
		                                </li>
                                	</ul>
                                	
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        
                        <!-- Files manager -->
                        <li>
                            <a href=\"#\"><i class=\"fa fa-file nav_icon\"></i>Files Manager<span class=\"badge badge-primary\">$nbFiles</span><span class=\"fa arrow\"></span></a>
                            <ul class=\"nav nav-second-level\"><!-- <a name=\"FILES\"></a> -->
                                <li>
                                    <a href=\"file_manager.php?what=fileDisplay\"><i class=\"fa fa-eye nav_icon\"></i>Display files</a>
                                </li>
                                <li>
                                    <a href=\"file_manager.php?what=fileInsert\"><i class=\"fa fa-plus nav_icon\"></i>Create file</a>
                                </li>
                                <li>
                                    <a href=\"file_manager.php?what=fileCatDisplay\"><i class=\"fa fa-eye nav_icon\"></i>Display categories</a>
                                </li>
								<li>
                                    <a href=\"file_manager.php?what=fileCatInsert\"><i class=\"fa fa-plus nav_icon\"></i>Create category</a>
                                </li>
                                
                            </ul>
                            
                        </li>
                        
                        <!-- Annonces manager-->
                        <li>
                            <a href=\"#\"><i class=\"fa fa-bullhorn nav_icon\"></i>Notices Manager<span class=\"badge badge-primary\">$nbAnnonces</span><span class=\"fa arrow\"></span></a>
                            <ul class=\"nav nav-second-level\">
                                <li>
                                    <a href=\"annonce_manager.php?what=annonceDisplay\"><i class=\"fa fa-eye nav_icon\"></i>Display announcements</a>
                                </li>
                                <li>
                                    <a href=\"annonce_manager.php?what=annonceInsert\"><i class=\"fa fa-plus nav_icon\"></i>Create announcement</a>
                                </li>
                                <li>
                                    <a href=\"annonce_manager.php?what=annonceCatDisplay\"><i class=\"fa fa-eye nav_icon\"></i>Display categories</a>
                                </li>
								<li>
                                    <a href=\"annonce_manager.php?what=annonceCatInsert\"><i class=\"fa fa-plus nav_icon\"></i>Create categoty</a>
                                </li>
                            </ul>
                            
                        </li>
                        
                        <!-- Banners manager -->
                        <li>
                            <a href=\"#\"><i class=\"fa fa-flag-o nav_icon\"></i>Banners Manager<span class=\"badge badge-primary\">$nbBanners</span><span class=\"fa arrow\"></span></a>
                            <ul class=\"nav nav-second-level\">
                                <li>
                                    <a href=\"banner_manager.php?what=bannerDisplay\"><i class=\"fa fa-eye nav_icon\"></i>Display banners</a>
                                </li>
                                <li>
                                    <a href=\"banner_manager.php?what=bannerInsert\"><i class=\"fa fa-plus nav_icon\"></i>Add a banner</a>
                                </li>
                            </ul>     
                        </li>
                        
                        <!-- Daily quotes manager -->
                        <li>
                            <a href=\"#\"><i class=\"fa fa-quote-left nav_icon\"></i>Daily quote Manager<span class=\"badge badge-primary\">$nbDailyquots</span><span class=\"fa arrow\"></span></a>
                            <ul class=\"nav nav-second-level\">
                                <li>
                                    <a href=\"dailyquot_manager.php?what=dailyquotDisplay\"><i class=\"fa fa-eye nav_icon\"></i>Display quotes</a>
                                </li>
                                <li>
                                    <a href=\"dailyquot_manager.php?what=dailyquotInsert\"><i class=\"fa fa-plus nav_icon\"></i>Add a quote</a>
                                </li>
                                <li>
                                    <a href=\"dailyquot_manager.php?what=dailyquotCatDisplay\"><i class=\"fa fa-eye nav_icon\"></i>Display categories</a>
                                </li>
								<li>
                                    <a href=\"dailyquot_manager.php?what=dailyquotCatInsert\"><i class=\"fa fa-plus nav_icon\"></i>Create category</a>
                                </li>
                            </ul>          
                        </li>
                        
                        <!-- OTOURIX Manager -->
                        <li>
                            <a href=\"#\"><i class=\"fa fa-users nav_icon\"></i>OTOURIX<span class=\"fa arrow\"></span></a>
                            <ul class=\"nav nav-second-level\">
                            	<li>
                            		<a href=\"#\"><i class=\"fa fa-eye nav_icon\"></i>Afficher<span class=\"fa arrow\"></span></a>
                                	<ul class=\"nav nav-third-level\">
                                		<li>
                                    		<a href=\"member_manager.php?what=memberDisplay\"><i class=\"fa fa-user nav_icon\"></i>Les membres<span class=\"badge badge-warning\">$nbMembers</span></a>
		                                </li>
		                                <li>
                                    		<a title=\"".$nb_payStarted.' '.$lang_output['LABEL_TUITION_HAVE_STARTED']."\" href=\"member_manager.php?what=scDisplay\"><i class=\"fa fa-money nav_icon\"></i>Les &eacute;colages<span class=\"badge badge-warning\">$nb_payStarted</span></a>
		                                </li>
		                                <li>
                                    		<a href=\"member_manager.php?what=noteDisplay\"><i class=\"fa fa-tags nav_icon\"></i>Les notes</a>
		                                </li>
		                                <li>
                                    		<a href=\"member_manager.php?what=requestDisplay\"><i class=\"fa fa-question-circle nav_icon\"></i>Les requetes</a>
		                                </li>
                                	</ul>
                                </li>
                                <li>
                                    <a href=\"member_manager.php?what=memberInsert\"><i class=\"fa fa-plus nav_icon\"></i>Ajouter un membre</a>
                                </li>
                                <li>
                                	<a href=\"#\"><i class=\"fa fa-cogs nav_icon\"></i>OTOURIX setting<span class=\"fa arrow\"></span></a>
                                	<ul class=\"nav nav-third-level\">
                                		<li>
                                    		<a href=\"member_manager.php?what=otourixLoad\"><i class=\"fa fa-upload nav_icon\"></i>Charger les donn&eacute;es</a>
		                                </li>
		                                <li>
                                    		<a href=\"member_manager.php?what=otourixEmpty\"><i class=\"fa fa-times nav_icon\"></i>Purger les donn&eacute;es</a>
		                                </li>
                                	</ul>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        
                        <!-- Log out call -->
                        <li>
                            <a href=\"../logout.php\"><i class=\"fa fa-power-off fa-fw nav_icon\"></i>Log out</a>
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
    </nav>";
		
?>