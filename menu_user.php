<?php
	session_save_path('../sessions/');
	session_start();
?>
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
            <!-- <ul class=\"nav navbar-nav navbar-right\">
				<li class=\"dropdown\">
	        		<a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\" aria-expanded=\"false\"><i class=\"fa fa-comments-o\"></i><span class=\"badge\">4</span></a>
	        		<ul class=\"dropdown-menu\">
						<li class=\"dropdown-menu-header\">
							<strong>Messages</strong>
							<div class=\"progress thin\">
							  <div class=\"progress-bar progress-bar-success\" role=\"progressbar\" aria-valuenow=\"40\" aria-valuemin=\"0\" aria-valuemax=\"100\" style=\"width: 40%\">
							    <span class=\"sr-only\">40% Complete (success)</span>							  </div>
							</div>
						</li>
				  <li class=\"avatar\">
							<a href=\"#\">
								<img src=\"images/1.png\" alt=\"\"/>
								<div>New message</div>
								<small>1 minute ago</small>
								<span class=\"label label-info\">NEW</span>							</a>						</li>
		  <li class=\"avatar\">
							<a href=\"#\">
								<img src=\"images/2.png\" alt=\"\"/>
								<div>New message</div>
								<small>1 minute ago</small>
								<span class=\"label label-info\">NEW</span>							</a>						</li>
		  <li class=\"avatar\">
							<a href=\"#\">
								<img src=\"images/3.png\" alt=\"\"/>
								<div>New message</div>
								<small>1 minute ago</small>							</a>						</li>
		  <li class=\"avatar\">
							<a href=\"#\">
								<img src=\"images/4.png\" alt=\"\"/>
								<div>New message</div>
								<small>1 minute ago</small>							</a>						</li>
		  <li class=\"avatar\">
							<a href=\"#\">
								<img src=\"images/5.png\" alt=\"\"/>
								<div>New message</div>
								<small>1 minute ago</small>							</a>						</li>
		  <li class=\"avatar\">
							<a href=\"#\">
								<img src=\"images/pic1.png\" alt=\"\"/>
								<div>New message</div>
								<small>1 minute ago</small>							</a>						</li>
		  <li class=\"dropdown-menu-footer text-center\">
							<a href=\"#\">View all messages</a>						</li>	
        		  </ul>
	      		</li>
			    <li class=\"dropdown\">
	        		<a href=\"#\" class=\"dropdown-toggle avatar\" data-toggle=\"dropdown\"><img src=\"images/1.png\"><span class=\"badge\">9</span></a>
	        		<ul class=\"dropdown-menu\">
						<li class=\"dropdown-menu-header text-center\">
							<strong>Account</strong>						</li>
					  <li class=\"m_2\"><a href=\"#\"><i class=\"fa fa-bell-o\"></i> Updates <span class=\"label label-info\">42</span></a></li>
					  <li class=\"m_2\"><a href=\"#\"><i class=\"fa fa-envelope-o\"></i> Messages <span class=\"label label-success\">42</span></a></li>
					  <li class=\"m_2\"><a href=\"#\"><i class=\"fa fa-tasks\"></i> Tasks <span class=\"label label-danger\">42</span></a></li>
					  <li><a href=\"#\"><i class=\"fa fa-comments\"></i> Comments <span class=\"label label-warning\">42</span></a></li>
<li class=\"dropdown-menu-header text-center\">
							<strong>Settings</strong>						</li>
					  <li class=\"m_2\"><a href=\"#\"><i class=\"fa fa-user\"></i> Profile</a></li>
					  <li class=\"m_2\"><a href=\"#\"><i class=\"fa fa-wrench\"></i> Settings</a></li>
					  <li class=\"m_2\"><a href=\"#\"><i class=\"fa fa-usd\"></i> Payments <span class=\"label label-default\">42</span></a></li>
					  <li class=\"m_2\"><a href=\"#\"><i class=\"fa fa-file\"></i> Projects <span class=\"label label-primary\">42</span></a></li>
					  <li class=\"divider\"></li>
					  <li class=\"m_2\"><a href=\"#\"><i class=\"fa fa-shield\"></i> Lock Profile</a></li>
					  <li class=\"m_2\"><a href=\"#\"><i class=\"fa fa-lock\"></i> Logout</a></li>	
        		  </ul>
	      		</li>
			</ul> -->
            <ul class=\"nav navbar-nav navbar-right\">
				<li><a href=\"#\"><i class=\"fa fa-user fa-fw nav_icon\"></i>Hi, $userName</a></li>
            	<li><a href=\"help.php\"><i class=\"fa fa-question fa-fw nav_icon\"></i>Help</a></li>
            	<li><a href=\"../logout.php\"><i style=\"color:#993300;\" class=\"fa fa-power-off fa-fw nav_icon\"></i>Logout</a></li>
            </ul>
			<!-- <form class=\"navbar-form navbar-right\">
              <input type=\"text\" class=\"form-control\" value=\"Search...\" onFocus=\"this.value = '';\" onBlur=\"if (this.value == '') {this.value = 'Search...';}\">
            </form> -->
            <div class=\"navbar-default sidebar\" role=\"navigation\">
                <div class=\"sidebar-nav navbar-collapse\">
                    <ul class=\"nav\" id=\"side-menu\">
                        <li>
                            <a href=\"dashboard.php\"><i class=\"fa fa-dashboard fa-fw nav_icon\"></i>Dashboard</a>
                        </li>
                        
                        <li>
                            <a href=\"#\"><i class=\"fa fa-calendar nav_icon\"></i>Events Manager<span class=\"fa arrow\"></span></a>
                            <ul class=\"nav nav-second-level\">
                                <li>
                                    <a href=\"event_manager.php?what=eventDisplay\"><i class=\"fa fa-eye nav_icon\"></i>Display events</a>
                                </li>
                                <li>
                                    <a href=\"event_manager.php?what=eventInsert\"><i class=\"fa fa-plus nav_icon\"></i>Create events</a>
                                </li>
                                <li>
                                    <a href=\"event_manager.php?what=eventCatDisplay\"><i class=\"fa fa-eye nav_icon\"></i>Display categories</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <!--
                        <li>
                            <a href=\"#\"><i class=\"fa fa-picture-o nav_icon\"></i>Gallery Manager<span class=\"fa arrow\"></span></a>
                            <ul class=\"nav nav-second-level\">
                                <li>
                                    <a href=\"gallery_manager.php?what=galleryDisplay\"><i class=\"fa fa-eye nav_icon\"></i>Display photos</a>
                                </li>
                                <li>
                                    <a href=\"gallery_manager.php?what=galleryInsert\"><i class=\"fa fa-plus nav_icon\"></i>Insert photo</a>
                                </li>
                                <li>
                                    <a href=\"gallery_manager.php?what=galleryCatDisplay\"><i class=\"fa fa-eye nav_icon\"></i>Display albums</a>
                                </li>
								<li>
                                    <a href=\"gallery_manager.php?what=galleryCatInsert\"><i class=\"fa fa-plus nav_icon\"></i>Create album</a>
                                </li>
                            </ul>
                            
                        </li>
                        -->
                        <li>
                            <a href=\"#\"><i class=\"fa fa-sitemap nav_icon\"></i>Pages Manager<span class=\"fa arrow\"></span></a>
                            <ul class=\"nav nav-second-level\">
                                <li>
                                    <a href=\"page_manager.php?what=pageDisplay\"><i class=\"fa fa-eye nav_icon\"></i>Display pages</a>
                                </li>
                                <li>
                                    <a href=\"page_manager.php?what=contentEdit\"><i class=\"fa fa-edit nav_icon\"></i>Edit page contents</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href=\"#\"><i class=\"fa fa-indent nav_icon\"></i>News Manager<span class=\"fa arrow\"></span></a>
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
                                    <a href=\"news_manager.php?what=news_authorDisplay\"><i class=\"fa fa-eye nav_icon\"></i>View authors</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href=\"#\"><i class=\"fa fa-file nav_icon\"></i>Files Manager<span class=\"fa arrow\"></span></a>
                            <ul class=\"nav nav-second-level\">
                                <li>
                                    <a href=\"file_manager.php?what=fileDisplay\"><i class=\"fa fa-eye nav_icon\"></i>Display files</a>
                                </li>
                                <li>
                                    <a href=\"file_manager.php?what=fileInsert\"><i class=\"fa fa-plus nav_icon\"></i>Create file</a>
                                </li>
                                <li>
                                    <a href=\"file_manager.php?what=fileCatDisplay\"><i class=\"fa fa-eye nav_icon\"></i>Display categories</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                       
                        <li>
                            <a href=\"#\"><i class=\"fa fa-users nav_icon\"></i>OTOURIX<span class=\"fa arrow\"></span></a>
                            <ul class=\"nav nav-second-level\">
                                <li>
                                    <a href=\"member_manager.php?what=memberDisplay\"><i class=\"fa fa-eye nav_icon\"></i>Display members</a>
                                </li>
                                
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        
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