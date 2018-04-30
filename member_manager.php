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
	require_once('../plugins/chartphp/lib/inc/chartphp_dist.php');
	$system		= 	new cwd_system();
	$system->session_checker($_SESSION["CONNECTED_ADMIN"], $_SESSION["CONNECTED_EDIT"]);
	$myMember	= 	new cwd_member();
	$p			=	new chartphp();
?>
<?php 
	//Data for stats
	$nb_membersTotal	=	$myMember->count_members('ALL');
	$nbStudents			=	(int)$myMember->count_members('STUDENTS');
	$nbParents			=	(int)$myMember->count_members('PARENTS');
	$nbTeachers			=	(int)$myMember->count_members('TEACHERS');
	$nbCouncilors		=	(int)$myMember->count_members('COUNCILORS');
	
	$p->data 			= 	array(array(array('El&egrave;ves ('.$nbStudents.')', $nbStudents),
							array('Parents ('.$nbParents.')', $nbParents),
							array('Conseillers d\'orientation ('.$nbCouncilors.')', $nbCouncilors),
							array('Enseignants ('.$nbTeachers.')', $nbTeachers)));
	
	$p->chart_type 		= 	'pie';
	
	// Common Options
	$p->title	= 	"Utilisateurs OTOURIX : $nb_membersTotal";	
	$chartOut	= 	$p->render('c1');
?>
<?php
	//Site settings
	$settings 		= 	$system->get_site_settings();
	//Modules settings
	//$mod_settings	=	$my_users->get_mod_settings();
	
	//Language settings
	$langFile	= isset($_SESSION[LANG]) ? ($_SESSION[LANG]) : ($settings["LANG"]);
	
	//Call the language file pack
	require_once("../scripts/langfiles/".$langFile.".php");  //Global language pack
	require_once("../member/langfiles/".$langFile.".php"); //Module language pack
	
	//Page name
	$admin_pageTitle	=	$mod_lang_output['MODULE_DESCR'];
	
	//Member Categories
	$arr_accountType 	= 	$myMember->arr_assoc_load_field($myMember->tbl_memberType, $myMember->fld_memberTypeId, $myMember->fld_memberTypeLib);
?>

<?php
	//All the form vallidations here
	require_once ('../modules/user/inc/member_validations.php');
?>

<?php include_once('inc/admin_header.php');?>
        	
	
	<p style="font-style: italic;">Il y a actuellement <a href="#openModalConnected"><?php print $myMember->count_member_connected(); ?> membre(s) connect&eacute;(s)</a></p>
	<!-- 
	<p> 
		<?php 
			foreach($arr_accountType as $key => $value){
				print 'Nombre de compte '.$value['LEVEL'].' : '.$myMember->count_member_by_cat($value['ID']).'<br />';
			}
		?>
	</p>
	<p>Le veritable nombre de parents : <?php print $myMember->count_parents(); ?></p>
	 -->
	 
	<div id="openModalConnected" class="modalDialog">
		<div style="width:80%; overflow:auto;">
			<h3><?php print $mod_lang_output['MODULE_NAME']; ?> :: <?php print $mod_lang_output['PAGE_HEADER_MEMBER_NOW_CONNECTED']?></h3>
			<a href="#close" title="Close" class="close">X</a>
			<?php print $myMember->admin_load_connected(); ?>
			<p>&nbsp;</p><p>&nbsp;</p>
		</div>
	</div>
		
	<?php if(isset($action_msgOk)) print $action_msgOk; ?>
	
	<?php if($_REQUEST[what] == 'otourixLoad'){ ?>
	<!-- Tab buttons start -->
	<div class="but_list">
	
		<!-- File load and dump validations -->
		
		<div class="bs-example bs-example-tabs" role="tabpanel" data-example-id="togglable-tabs">
			<ul class="nav nav-tabs" id="myTab" role="tablist">
				<li id="tab_0" class="active" role="presentation">
					<a id="membres-tab" role="tab" aria-expanded="true" aria-controls="membres" href="#membres" data-toggle="tab">Membres</a>
				</li>
				<li id="tab_1" role="presentation">
					<a id="ecolages-tab" role="tab" aria-controls="ecolages" href="#ecolages" data-toggle="tab">Ecolages</a>
				</li>
				<li id="tab_2" role="presentation">
				    <a id="notes-tab" role="tab" aria-controls="notes" href="#notes" data-toggle="tab">Notes</a>
				</li>
			</ul>
			
			<!-- Tabs contents start -->
			<div class="tab-content" id="myTabContent">
				<div class="tab-pane fade in active" id="membres" role="tabpanel" aria-labelledby="membres-tab">
				
					<!-- ********************************* Charger les membres depuis un fichier csv  ******************************************************
				      ****************************************************************************************************************-->
					
						<div class="tab-content">
						
							<?php if(isset($file_uploadMsg)) print $file_uploadMsg; ?>
							<?php if(isset($file_dumpMsg)) print $file_dumpMsg; ?>
							
							<div class="tab-pane active" id="horizontal-form">
								<form class="form-horizontal" enctype="multipart/form-data" action="" method="post">
									
									<h3><?php print $mod_lang_output['PAGE_HEADER_MEMBER_IMPORT']?></h3>
									<div class="form-group">
										<label for="memberFile" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_MEMBER_FILE_IMPORT']?></label>
										<div class="col-sm-8">
											<input class="form-control1" name="memberFile" placeholder="<?php print $mod_lang_output['FORM_LABEL_MEMBER_FILE_IMPORT']?>" type="file" id="memberFile" />
										</div>
										<div class="col-sm-2">
											<p class="help-block redStar"><?php print $mod_lang_output['FORM_HELP_CSV_ONLY']?>!</p>
										</div>
									</div>
									<div class="panel-footer">
						                <div class="row">
						                    <div class="col-sm-8 col-sm-offset-2">
						                        <button type="submit" name="btn_file_send_member" id="btn_file_send_member" class="btn-success btn"><?php print $mod_lang_output['FORM_BUTTON_IMPORT_MEMBER']?></button>
						                    </div>
						                </div>
					             	</div>
								</form>
							</div>
						</div>
						<p>&nbsp;</p><p>&nbsp;</p>
					
				</div>
				
				
				<div class="tab-pane fade" id="ecolages" role="tabpanel" aria-labelledby="ecolages-tab">
				
					<!-- ********************************* Charger les frais d'ecolage  ******************************************************
				      ****************************************************************************************************************-->
					<?php //if($_REQUEST[what] == 'otourixLoad'){ ?>
						<div class="tab-content">
						
							<?php if(isset($file_uploadMsg_scholarship)) print $file_uploadMsg_scholarship; ?>
							<?php if(isset($file_dumpMsg_scholarship)) print $file_dumpMsg_scholarship; ?>
							
							<div class="tab-pane active" id="horizontal-form">
								<form class="form-horizontal" enctype="multipart/form-data" action="" method="post">
									
									<h3><?php print $mod_lang_output['PAGE_HEADER_SCHOLARSHIP_IMPORT']?></h3>
									<div class="form-group">
										<label for="scholarshipFile" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_TUITION_FILE_IMPORT']?></label>
										<div class="col-sm-8">
											<input class="form-control1" name="scholarshipFile" placeholder="<?php print $mod_lang_output['FORM_LABEL_TUITION_FILE_IMPORT']?>"  type="file" id="scholarshipFile" />
										</div>
										<div class="col-sm-2">
											<p class="help-block redStar"><?php print $mod_lang_output['FORM_HELP_CSV_ONLY']?>!</p>
										</div>
									</div>
									<div class="panel-footer">
						                <div class="row">
						                    <div class="col-sm-8 col-sm-offset-2">
						                        <button type="submit" name="btn_file_send_scholarship" id="btn_file_send_scholarship" class="btn-success btn"><?php print $mod_lang_output['FORM_BUTTON_IMPORT_SCHOLARSHIP']?></button>
						                    </div>
						                </div>
					             	</div>
								</form>
							</div>
						</div>
						<p>&nbsp;</p><p>&nbsp;</p>
					<?php //} ?>
				</div>
				
				
				<div class="tab-pane fade" id="notes" role="tabpanel" aria-labelledby="notes-tab">
					<!-- ********************************* Charger les notes de classe  ******************************************************
				      ****************************************************************************************************************-->
					<?php //if($_REQUEST[what] == 'otourixLoad'){ ?>
						<div class="tab-content">
							
							<?php if(isset($file_uploadMsg_note)) print $file_uploadMsg_note; ?>
							<?php if(isset($file_dumpMsg_note)) print $file_dumpMsg_note; ?>
							
							<div class="tab-pane active" id="horizontal-form">
								<h3><?php print $mod_lang_output['PAGE_HEADER_NOTES_IMPORT']?></h3>
								<form class="form-horizontal" enctype="multipart/form-data" action="" method="post" target="_self">
									
									<div class="form-group">
										<label for="noteFile" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_NOTE_FILE_IMPORT']?></label>
										<div class="col-sm-8">
											<input class="form-control1" name="noteFile" placeholder="<?php print $mod_lang_output['FORM_LABEL_NOTE_FILE_IMPORT']?>" type="file" id="noteFile" />
										</div>
										<div class="col-sm-2">
											<p class="help-block redStar"><?php print $mod_lang_output['FORM_HELP_CSV_ONLY']?>!</p>
										</div>
									</div>
									<div class="panel-footer">
						                <div class="row">
						                    <div class="col-sm-8 col-sm-offset-2">
						                        <button type="submit" name="btn_file_send_note" id="btn_file_send_note" class="btn-success btn">Importer le fichier des notes</button>
						                    </div>
						                </div>
					             	</div>
								</form>
							</div>
						</div>
					<!-- Maintenir les Tab actifs apres validation -->
						<?php if(isset($_POST['btn_file_send_member'])) { ?>
							<script> $('a[href="#membres"]').click(); </script>
						<?php }  elseif(isset($_POST['btn_file_send_scholarship'])) { ?>
							<script>
								$('a[href="#ecolages"]').click();
							</script>
						<?php } elseif(isset($_POST['btn_file_send_note'])) { ?>
							<script> $('a[href="#notes"]').click(); </script>
						<?php } ?>
						<!--  -->
				</div>
			</div>
	   	</div>
	</div>
	<!-- Tabs contents end -->
	<?php } ?>
	

	
	<!-- ********************************* Charger les membres depuis un fichier csv  ******************************************************
      ****************************************************************************************************************-->
	<?php if($_REQUEST[what] == 'membersDump'){ ?>
		<h3>Load batch of stakeholders in the system</h3>
		<?php if(isset($file_uploadMsg)) print $file_uploadMsg; ?>
		<?php if(isset($file_dumpMsg)) print $file_dumpMsg; ?>
		
		<div class="tab-content">
			<div class="tab-pane active" id="horizontal-form">
			
				<form class="form-horizontal"  enctype="multipart/form-data" action="" method="post">
					<div class="form-group">
						<label for="memberFile" class="col-sm-2 control-label">File to load</label>
						<div class="col-sm-8">
	                        <input class="form-control1" name="memberFile" type="file" id="memberFile" />
						</div>
						<div class="col-sm-2">
							<p class="help-block">CSV files only</p>
						</div>
					</div>
					
					<div class="panel-footer">
		                <div class="row">
		                    <div class="col-sm-8 col-sm-offset-2">
		                        <button type="submit" name="btn_file_send_member" id="btn_file_send_member" class="btn-success btn">Import file</button>
		                    </div>
		                </div>
	             	</div>
	             	
	             	
             	
				</form>
				
			</div>
		</div>
	<?php } ?>
		
	
	<!-- ********************************* Ajouter les membres  ******************************************************
      ****************************************************************************************************************-->
		<?php if($_REQUEST[what]=="memberInsert") { ?>
			<h3><?php print $mod_lang_output['MODULE_NAME']; ?> :: <?php print $mod_lang_output['PAGE_HEADER_ADD_MEMBER']?></h3>
      
			<?php if(isset($member_insert_err_msg)) {  ?>
				<div class="ADM_err_msg"><?php print $member_insert_err_msg; ?></div>
			<?php } ?>
			<?php if(isset($member_insert_cfrm_msg)) {  ?>
				<div class="ADM_cfrm_msg"><?php print $member_insert_cfrm_msg; ?></div>
			<?php } ?>
			<div class="tab-content">
				<div class="tab-pane active" id="horizontal-form">
					<form class="form-horizontal" action="" method="post">
						<div class="form-group">
	          				<label for="sel_memberType" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_CATEGORY']; ?></label>
	            			<div class="col-sm-8">
	            				<select class="form-control" name="sel_memberType" id="sel_memberType"><?php print $myMember->admin_cmb_show_member_type($_POST[sel_memberType]); ?></select>
	             			</div>
	             			<div class="col-sm-2">
								<!-- <p class="help-block">&nbsp;</p> -->
							</div>
	             		</div>
	             		
						<div class="form-group">
            				<label for="txt_memberName" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_FULL-NAME']; ?><span class="redStar">*</label>
            				<div class="col-sm-8">
            					<input class="form-control1" name="txt_memberName" type="text" value="<?php print $myMember->show_content($member_insert_err_msg, $txt_memberName) ?>" id="txt_memberName" />
            				</div>
            				<div class="col-sm-2">
								<!-- <p class="help-block">&nbsp;</p> -->
							</div>
          				</div>
          				
			          	<div class="form-group">
			            	<label for="txt_memberLogin" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_LOGIN']; ?><span class="redStar">*</span></label>
			            	<div class="col-sm-8">
			            		<input class="form-control1" name="txt_memberLogin" type="text" value="<?php print $myMember->show_content($member_insert_err_msg, $txt_memberLogin) ?>" id="txt_memberLogin" />
			            	</div>
			            	<div class="col-sm-2">
								<!-- <p class="help-block">&nbsp;</p> -->
							</div>
			          	</div>
			          
						<div class="form-group">
			         		<label for="txt_memberPass1" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_PASSWORD']; ?><span class="redStar">*</span></label>
			            	<div class="col-sm-8">
			            		<input class="form-control1" name="txt_memberPass1" type="password" value="<?php print $myMember->show_content($member_insert_err_msg, $txt_memberPass1) ?>" id="txt_memberPass1" />
			            	</div>
			            	<div class="col-sm-2">
								<!-- <p class="help-block">&nbsp;</p> -->
							</div>
			          	</div>
			          	
				        <div class="form-group">
				        	<label for="txt_memberPass2" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_PASSWORD2']; ?><span class="redStar">*</span></label>
				        	<div class="col-sm-8">
				        		<input class="form-control1" name="txt_memberPass2" type="password" value="<?php print $myMember->show_content($member_insert_err_msg, $txt_memberPass2) ?>" id="txt_memberPass2" />
				        	</div>
				        	<div class="col-sm-2">
								<!-- <p class="help-block">&nbsp;</p> -->
							</div>
				        </div>
				        
						<div class="form-group">
            				<label for="sel_memberClass" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_CLASS_STUDENT_ONLY']; ?></label>
            				<div class="col-sm-8">
            					<select class="form-control1" name="sel_memberClass" id="member_selCat"><option value='0'<?php if($_POST[sel_memberClass]=='0') print " SELECTED"; ?>><?php print $mod_lang_output['FORM_VALUE_NO_CLASS']?></option><?php print $myMember->admin_cmb_get_row($myMember->tbl_classes, 'classes_id', 'classes_name', 'classes_name', 'ASC', $_POST[sel_memberClass]); ?></select>
            				</div>
            				<div class="col-sm-2">
								<!-- <p class="help-block">&nbsp;</p> -->
							</div>
          				</div>
          
          				<div class="form-group">
            				<label for="txt_memberTel" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_PARENT_PHONE']?></label>
            				<div class="col-sm-8">
            					<input class="form-control1" name="txt_memberTel" type="text" value="<?php print $myMember->show_content($member_insert_err_msg, $txt_memberTel) ?>" id="txt_memberTel" />
            				</div>
            				<div class="col-sm-2">
								<p class="help-block">Ex: 677977877</p>
							</div>
          				</div>
          				
          				<div class="panel-footer">
			                <div class="row">
			                    <div class="col-sm-8 col-sm-offset-2">
			                        <button type="submit" name="btn_memberInsert" id="btn_memberInsert" class="btn-success btn"><?php print $mod_lang_output['FORM_BUTTON_ADD_MEMBER']?></button>
			                    </div>
			                </div>
		             	</div>
        
				</form>
			</div>
      	</div>
      	
      <?php } ?>
      
      
      <!-- ********************************* Modifier les informations des membres  ******************************************************
      ****************************************************************************************************************-->
      <?php if($_REQUEST[what]=="memberUpdate") { ?>
	      <div style="float:left; width:65%;">
		      <h3><?php print $mod_lang_output['MODULE_NAME']; ?> :: <?php print $mod_lang_output['PAGE_HEADER_UPDATE_MEMBER']?></h3>
		      
		      <?php if(isset($member_update_err_msg)) {  ?>
		      <div class="ADM_err_msg"><?php print $member_update_err_msg; ?></div>
		      <?php } ?>
		      <?php if(isset($member_update_cfrm_msg)) {  ?>
		      <div class="ADM_cfrm_msg"><?php print $member_update_cfrm_msg; ?></div>
		      <?php } ?>
		      	<div class="tab-content">
                		<div class="tab-pane active" id="horizontal-form">
			      			<form class="form-horizontal" action="" method="post">
				    	
					          <div class="form-group">
		                            <label for="sel_memberTypeUpd" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_CATEGORY']?></label>
					            	<div class="col-sm-8">
					            		<select class="form-control" name="sel_memberTypeUpd" id="sel_memberTypeUpd"><?php print $myMember->admin_cmb_show_member_type($memberInfo['m_TYPE']); ?></select>
					             	</div>
					             	<div class="col-sm-2">
										<!-- <p class="help-block">04 Caracters Max</p> -->
									</div>
					          </div>
					          
					          <div class="form-group">
						            <label for="txt_memberNameUpd" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_FULL-NAME']?></label>
						            <div class="col-sm-8">
						            	<input class="form-control1" name="txt_memberNameUpd" type="text" value="<?php print $memberInfo['m_NAME']; ?>" id="txt_memberNameUpd" />
						            </div>
					             	<div class="col-sm-2">
										<!-- <p class="help-block">04 Caracters Max</p> -->
									</div>
					          </div>
					          
					          <div class="form-group">
					            	<label for="txt_memberNameUpd" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_LOGIN']?></label>
					            	<div class="col-sm-8">
					            		<input class="form-control1" name="txt_memberLoginUpd" type="text" value="<?php print $memberInfo['m_LOGIN']; ?>" id="txt_memberLoginUpd" />
					            	</div>
					             	<div class="col-sm-2">
										<!-- <p class="help-block">04 Caracters Max</p> -->
									</div>
					          </div>
					          
					          <div class="form-group">
					            	<label for="txt_memberNameUpd" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_PASSWORD']?></label>
					            	<div class="col-sm-8">
					            		<input class="form-control1" name="txt_memberPassUpd" type="password" value="" id="txt_memberPassUpd" />
					            	</div>
					             	<div class="col-sm-2">
										<!-- <p class="help-block">04 Caracters Max</p> -->
									</div>
					          </div>
					          
					          <div class="form-group">
					            	<label for="txt_memberNameUpd" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_CLASS_STUDENT_ONLY']?></label>
					            	<div class="col-sm-8">
					            		<select class="form-control" name="sel_memberClassUpd" id="sel_memberClassUpd"><option value='0'<?php if($memberInfo['m_CLASSID']=='0') print " SELECTED"; ?>>Aucune classe</option><?php print $myMember->admin_cmb_get_row('cabb_otourix_classes', 'classes_id', 'classes_name', 'classes_name', 'ASC', $memberInfo['m_CLASSID']); ?></select>
					            	</div>
					             	<div class="col-sm-2">
										<!-- <p class="help-block">04 Caracters Max</p> -->
									</div>
					          </div>
					          
					          <div class="form-group">
					            	<label for="txt_memberNameUpd" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_PARENT_PHONE']?></label>
					            	<div class="col-sm-8">
					            		<input class="form-control1" name="txt_memberTelUpd" type="text" value="<?php print $memberInfo['m_PARENT'] ?>" id="txt_memberTelUpd" size="20" /><input name="hd_memberId" type="hidden" value="<?php print $memberInfo['m_ID'] ?>" id="hd_memberId" />
					            	</div>
					             	<div class="col-sm-2">
										<!-- <p class="help-block">04 Caracters Max</p> -->
									</div>
					          </div>
					          
						      <div class="panel-footer">
			                      <div class="row">
			                          <div class="col-sm-8 col-sm-offset-2">
			                           <button name="btn_memberUpdate" id="btn_memberUpdate" class="btn-success btn"><?php print $mod_lang_output['FORM_BUTTON_UPDATE']?></button>
			                          </div>
						          </div>
						      </div>
			      		</form>
		      		</div>
		      	</div>
		      	
		  </div>
		  
		  <!-- Reinitialiser le mot de passe -->
		  <div style="float:right; width:35%;">
           <div class="tab-content">
                <div class="tab-pane active" id="horizontal-form">
			  		<h3><?php print $mod_lang_output['PAGE_HEADER_PASSWORD_REINITIALIZE']?></h3>
			  		<form class="form-horizontal" action="" method="post">
			  			<div class="panel-footer">
	                        <div class="row">
	                            <div class="col-sm-8 col-sm-offset-2">
							  		<input type="hidden" name="hd_passwordIni" id="passwordIni" value="<?php print $_REQUEST['memberId']; ?>" />
							  		<button class="btn-success btn"  type="submit" name="btn_passwordIni" id="btn_passwordInitialize" onclick="return confirm('&Ecirc;tes-vous s&ucirc;r de vouloir r&eacute;initialiser ce mot de passe?')">R&eacute;initialiser...</button>
							  	</div>
							</div>
						</div>
			  		</form>
			  	</div>
			  </div>
		  </div>
      <?php } ?>
      
	
	<!-- ********************************* Afficher les membres  ******************************************************
      ****************************************************************************************************************-->
      <?php if(!isset($_REQUEST[what]) || ($_REQUEST[what]=="memberDisplay")) { ?>
          <h3><?php print $mod_lang_output['MODULE_NAME']; ?> :: <?php print $mod_lang_output['PAGE_HEADER_LIST_MEMBERS']?></h3>
		  <?php $myMember->limit = $_REQUEST[limite]; ?>
          
          <div class="col-sm-7">
	          <?php if(isset($member_display_err_msg)) {  ?>
	          <div class="ADM_err_msg"><?php print $member_display_err_msg; ?></div>
	          <?php } ?>
	          <?php if(isset($member_display_cfrm_msg)) {  ?>
	          <div class="ADM_cfrm_msg"><?php print $member_display_cfrm_msg; ?></div>
	          <?php } ?>
	          <div class="panel panel-warning" data-widget="{&quot;draggable&quot;: &quot;false&quot;}" data-widget-static="">
	          	<div class="panel-body no-padding">
	          		<?php print $myMember->admin_load_members(); ?>
	            </div>
	         </div>
         </div>
         
         <div class="col-sm-5">
         	<style> 
		        /* white color data labels */ 
		        .jqplot-data-label{color:white;} 
		    </style>
         	<?php print $chartOut; ?>
         </div>
         
      <?php } ?>
      
      <!-- ********************************* Afficher les ecolages  ******************************************************
      ****************************************************************************************************************-->
      <?php if($_REQUEST[what]=="scDisplay") { ?>
          <h3><?php print $mod_lang_output['MODULE_NAME']; ?> :: <?php print $mod_lang_output['PAGE_HEADER_LIST_SCHOLARSHIPS']?></h3>
		  <?php $myMember->limit = $_REQUEST[limite]; ?>
          
          <?php if(isset($scholarship_display_err_msg)) {  ?>
          <div class="ADM_err_msg"><?php print $scholarship_display_err_msg; ?></div>
          <?php } ?>
          <?php if(isset($scholarship_display_cfrm_msg)) {  ?>
          <div class="ADM_cfrm_msg"><?php print $scholarship_display_cfrm_msg; ?></div>
          <?php } ?>
			<div class="panel panel-warning" data-widget="{&quot;draggable&quot;: &quot;false&quot;}" data-widget-static="">
				<div class="panel-body no-padding">
          			<?php print $myMember->admin_load_scholarships(); ?>
          		</div>
          	</div>
      <?php } ?>
      
      <!-- ********************************* Afficher les notes  ******************************************************
      ****************************************************************************************************************-->
      <?php if($_REQUEST[what]=="noteDisplay") { ?>
          <h3><?php print $mod_lang_output['MODULE_NAME']; ?> :: <?php print $mod_lang_output['PAGE_HEADER_LIST_NOTES']?></h3>
		  <?php $myMember->limit = $_REQUEST[limite]; ?>
          
          <?php if(isset($note_display_err_msg)) {  ?>
          <div class="ADM_err_msg"><?php print $note_display_err_msg; ?></div>
          <?php } ?>
          <?php if(isset($note_display_cfrm_msg)) {  ?>
          <div class="ADM_cfrm_msg"><?php print $note_display_cfrm_msg; ?></div>
          <?php } ?>
			<div class="panel panel-warning" data-widget="{&quot;draggable&quot;: &quot;false&quot;}" data-widget-static="">
				<div class="panel-body no-padding">
          			<?php print $myMember->admin_load_notes(); ?>
          		</div>
          	</div>
      <?php } ?>
      
      <!-- ********************************* Afficher les requetes  ******************************************************
      ****************************************************************************************************************-->
      <?php if($_REQUEST[what]=="requestDisplay") { ?>
          <h3><?php print $mod_lang_output['MODULE_NAME']; ?> :: <?php print $mod_lang_output['PAGE_HEADER_LIST_REQUESTS']?></h3>
		  <?php $myMember->limit = $_REQUEST[limite]; ?>
          
          <?php if(isset($request_display_err_msg)) {  ?>
          <div class="ADM_err_msg"><?php print $request_display_err_msg; ?></div>
          <?php } ?>
          <?php if(isset($request_display_cfrm_msg)) {  ?>
          <div class="ADM_cfrm_msg"><?php print $request_display_cfrm_msg; ?></div>
          <?php } ?>
			<div class="panel panel-warning" data-widget="{&quot;draggable&quot;: &quot;false&quot;}" data-widget-static="">
				<div class="panel-body no-padding">
          			<?php print $myMember->admin_load_requests(); ?>
          		</div>
          	</div>
      <?php } ?>
      
      <!-- ********************************* Afficher les liens pour purger les tables  ******************************************************
      ****************************************************************************************************************-->
      <?php if($_REQUEST[what]=="otourixEmpty") { ?>
          <h3><?php print $mod_lang_output['MODULE_NAME']; ?> :: <?php print $mod_lang_output['PAGE_HEADER_OTOURIX_DATA_EMPTY']; ?> </h3>          
          <?php if(isset($empty_data_msg)) print $empty_data_msg; ?>
          <div class="panel panel-warning" data-widget="{&quot;draggable&quot;: &quot;false&quot;}" data-widget-static="">
				<div class="panel-body no-padding">
					<ul>
						<li><a onclick = "return confirm('<?php print $mod_lang_output['FORM_CONFIRM_MEMBERS_DELETE']; ?>')" href="?what=otourixEmpty&action=emptyMembers"><?php print $mod_lang_output['PAGE_LINK_EMPTY_MEMBER_TABLE']; ?></a></li>
		          		<li><a onclick = "return confirm('<?php print $mod_lang_output['FORM_CONFIRM_SCHOLARSHIPS_DELETE']; ?>')" href="?what=otourixEmpty&action=emptyScholarships"><?php print $mod_lang_output['PAGE_LINK_EMPTY_SCHOLARSHIP_TABLE']; ?></a></li>
		          		<li><a onclick = "return confirm('<?php print $mod_lang_output['FORM_CONFIRM_NOTES_DELETE']?>')" href="?what=otourixEmpty&action=emptyMarks"><?php print $mod_lang_output['PAGE_LINK_EMPTY_NOTES_TABLE']; ?></a></li>
		          		
		          	</ul>
				</div>
			</div>
      <?php } ?>
      
      
<?php include_once('inc/admin_footer.php');?>
