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
	require_once("../modules/event/library/event.inc.php");
	$system		= 	new cwd_system();
	$event		= 	new cwd_event();
	$myCal		=	new CALENDAR($_POST['cmbYear'], $_POST['cmbMonth']);
	$system->db_connect($thewu32_host, $thewu32_db, $thewu32_user, $thewu32_pass);
	$system->session_checker($_SESSION["CONNECTED_ADMIN"], $_SESSION["CONNECTED_EDIT"]);
	//$modDir	=	'../modules/event/';
?>

<?php	
	//Site settings
	$settings 		= 	$system->get_site_settings();
	//Modules settings
	//$mod_settings	=	$my_users->get_mod_settings();
	
	//Language settings
	$langFile	= isset($_SESSION[LANG]) ? ($_SESSION[LANG]) : ($settings["LANG"]);
	
	//Call the language file pack
	require_once("../scripts/langfiles/".$langFile.".php");  		//Global language pack
	require_once("../modules/event/langfiles/".$langFile.".php");	//Module language pack
	
	//Page name
	$admin_pageTitle	=	$mod_lang_output['MODULE_DESCR'];
?>

<?php 
	require_once('../modules/event/inc/event_validations.php');
	//$event->spry_ds_create();
?>

<?php 
	ob_end_flush();
?>

<?php include_once('inc/admin_header.php');?>
     	
        	<!-- ********************************* Create event cat  ******************************************************
      ****************************************************************************************************************-->
      <?php if($_REQUEST[what]=="eventCatInsert"){ ?>
      <h3><?php print $mod_lang_output['MODULE_NAME']; ?> :: <?php print $mod_lang_output['PAGE_HEADER_ADD_EVENT_CATEGORY']; ?></h3>
      
      <?php if(isset($rub_insert_err_msg)) {  ?>
      <div class="ADM_err_msg"><?php print $rub_insert_err_msg; ?></div>
      <?php } ?>
      <?php if(isset($rub_insert_cfrm_msg)) {  ?>
      <div class="ADM_cfrm_msg"><?php print $rub_insert_cfrm_msg; ?></div>
      <?php } ?>
            
      <div class="tab-content">
      	<div class="tab-pane active" id="horizontal-form">
        	<form class="form-horizontal" id="frm_rub_insert" name="frm_rub_insert" method="post" action="">
            	<div class="form-group">
                	<label for="selLang" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_LANGUAGE']; ?></label>
                    <div class="col-sm-8">
                       	<select class="form-control" name="selLang" id="selLang">
							<?php print $event->cmb_showLang($_POST[selLang]); ?>
                        </select>
                    </div>
                    <div class="col-sm-2">
                       	<!-- <p class="help-block">Your help text!</p> -->
                    </div>
                 </div>
                 <div class="form-group">
                 	<label for="txt_cat_id" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_CODE']; ?></label>
                    <div class="col-sm-8">
                    	<input class="form-control1" name="txt_cat_id" type="text" id="txt_cat_id" value="<?php print $event->show_content($rub_insert_err_msg, $txt_cat_id) ?>" maxlength="4" />
                     </div>
                     <div class="col-sm-2">
                     	<!-- <p class="help-block">Your help text!</p> -->
                     </div>
                  </div>
                 <div class="form-group">
                 	<label for="txt_cat_lib" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_LABEL']; ?></label>
                    <div class="col-sm-8">
                    	<input class="form-control1" name="txt_cat_lib" type="text" id="txt_cat_lib" value="<?php print $event->show_content($rub_insert_err_msg, $txt_cat_lib) ?>" />
                     </div>
                     <div class="col-sm-2">
                     	<!-- <p class="help-block">Your help text!</p> -->
                     </div>
                  </div>
                  <div class="panel-footer">
                  	<div class="row">
                    	<div class="col-sm-8 col-sm-offset-2">
                            <button name="btn_cat_insert" id="btn_cat_insert" class="btn-success btn"><?php print $mod_lang_output['FORM_BUTTON_ADD_CATEGORY']; ?></button>
                        </div>
                    </div>
                 </div>
              </form>
          </div>
      </div>
      
      <?php } ?>
      
      <!-- ********************************* Update event cat  ******************************************************
      ****************************************************************************************************************-->
      
      <?php if($_REQUEST['what'] == eventCatUpdate) {//if(isset($rub_displayUpd)){ ?>
      <h3><?php print $mod_lang_output['MODULE_NAME']; ?> :: <?php print $mod_lang_output['PAGE_HEADER_UPDATE_EVENT_CATEGORY']; ?></h3>
      
      <?php if(isset($rub_update_err_msg)) {  ?>
      <div class="ADM_err_msg"><?php print $rub_update_err_msg; ?></div>
      <?php } ?>
      <?php if(isset($rub_update_cfrm_msg)) {  ?>
      <div class="ADM_cfrm_msg"><?php print $rub_update_cfrm_msg; ?></div>
      <?php } ?>
      
      <div class="tab-content">
      	<div class="tab-pane active" id="horizontal-form">
        	<form class="form-horizontal" id="frm_cat_update" name="frm_cat_update" method="post" action="">
            	<div class="form-group">
                	<label for="selLangUpd" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_LANGUAGE']; ?></label>
                    <div class="col-sm-8">
                    
                       	<select class="form-control" name="selLangUpd" id="selLangUpd">
							<?php print $event->cmb_showLang($tabCatUpd[eventLangID]); ?>
                        </select>
                     <!--
                        <select class="form-control" name="selLangUpd" id="selLang">
							<?php //print $event->cmb_showLang($tabCatUpd[eventLangID]); ?>
                        </select>-->
                    </div>
                    <div class="col-sm-2">
                       	<!-- <p class="help-block">Your help text!</p> -->
                    </div>
                 </div>
                 <div class="form-group">
                 	<label for="txt_cat_lib_upd" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_LABEL']; ?></label>
                    <div class="col-sm-8">
                    	<input class="form-control1" name="txt_cat_lib_upd" value="<?php print $tabCatUpd[eventTYPELIB]; ?>" type="text" id="txt_cat_lib_upd" />
                     </div>
                     <div class="col-sm-2">
                     	<!-- <p class="help-block">Your help text!</p> -->
                     </div>
                  </div>
                  <div class="panel-footer">
                  	<div class="row">
                    	<div class="col-sm-8 col-sm-offset-2">
                        	<input type="hidden" name="hd_cat_id" value="<?php print $tabCatUpd[eventTYPEID]; ?>" />
                            <button name="btn_cat_upd" id="btn_cat_upd" class="btn-success btn"><?php print $mod_lang_output['FORM_BUTTON_UPDATE']; ?></button>
                        </div>
                    </div>
                 </div>
              </form>
          </div>
      </div>
      
      <?php } ?>
      
      <!-- ********************************* Display event cats  ******************************************************
      ****************************************************************************************************************-->
      <?php if($_REQUEST[what]=="eventCatDisplay") { ?>
          <h3><?php print $mod_lang_output['MODULE_NAME']; ?> :: <?php print $mod_lang_output['PAGE_HEADER_LIST_EVENTS_CATEGORIES']; ?></h3>
          
          <?php if(isset($rub_display_err_msg)) {  ?>
          <div class="ADM_err_msg"><?php print $rub_display_err_msg; ?></div>
          <?php } ?>
          <?php if(isset($rub_display_cfrm_msg)) {  ?>
          <div class="ADM_cfrm_msg"><?php print $rub_display_cfrm_msg; ?></div>
          <?php } ?>
          	<div class="panel panel-warning" data-widget="{&quot;draggable&quot;: &quot;false&quot;}" data-widget-static="">
          		<div class="panel-body no-padding">
          			<table class="table table-bordered">
						<tr>
							<th>&num;</th>
							<th><?php print $mod_lang_output['TABLE_HEADER_CATEGORY']; ?></th>
							<th><?php print $mod_lang_output['TABLE_HEADER_ACTION']; ?></th>
						</tr>
          			<?php print $event->admin_load_events_cat(); ?>
                </div>
            </div>
      <?php } ?>
      
      <!-- ********************************* Create events  ******************************************************
      ****************************************************************************************************************-->
      <?php if($_REQUEST[what]=="eventInsert") { ?>
      		<?php 
      			//Initialisation des dates
      			if(isset($_GET['date'])){
      				$arrDate	=	$system->array_extract_date($_GET['date']);
      				//checkdate($arrDate['MONTH'], $arrDate['DAY'], $arrDate['YEAR']) ? $arrDate : '';
      			}
      		?>
	      <?php $currentLang = (($_REQUEST[langId] != '') ? ($_REQUEST[langId]) : ($_SESSION['LANG'])); ?>
	      <h3><?php print $mod_lang_output['MODULE_NAME']; ?> :: <?php print $mod_lang_output['PAGE_HEADER_ADD_EVENT']; ?></h3>
	      
	      <?php if(isset($event_insert_err_msg)) {  ?>
	      <div class="ADM_err_msg"><?php print $event_insert_err_msg; ?></div>
	      <?php } ?>
	      <?php if(isset($event_insert_cfrm_msg)) {  ?>
	      <div class="ADM_cfrm_msg"><?php print $event_insert_cfrm_msg; ?></div>
	      <?php } ?>
	      
	      <div class="tab-content">
	      	<div class="tab-pane active" id="horizontal-form">
	        	<form class="form-horizontal" action="" method="post" name="frm_event_insert" id="frm_event_insert">
	            	<div class="form-group">
	                	<label for="sel_eventLang" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_LANGUAGE']; ?></label>
	                    <div class="col-sm-8">
	                       	<select class="form-control"  name="sel_eventLang" id="jumpMenu" onChange="MM_jumpMenu('parent',this,0)">
								<?php print stripslashes($event->redir_cmb_load_langs($_REQUEST[langId], $event->admin_modPage, "eventInsert")); ?>
	                          </select>
	                          <input name="hdLang" type="hidden" value="<?php print $_REQUEST[langId];?>" />
	                    </div>
	                    <div class="col-sm-2">
	                       	<!-- <p class="help-block">Your help text!</p> -->
	                    </div>
	                 </div>
	                 <div class="form-group">
	                 	<label for="event_selCat" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_CATEGORY']; ?></label>
	                    <div class="col-sm-8">
	                    	<select class="form-control" name="event_selCat" id="event_selCat">
								<?php print $event->admin_cmb_show_rub_by_lang($currentLang, $_POST[event_selCat]); ?>
	                        </select>
	                     </div>
	                     <div class="col-sm-2">
	                     	<!-- <p class="help-block">Your help text!</p> -->
	                     </div>
	                  </div>
	                  <div class="form-group">
	                 	<label for="txt_event_title" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_TITLE']; ?></label>
	                    <div class="col-sm-8">
	                    	<input class="form-control1" name="txt_event_title" type="text" value="<?php print $event->show_content($event_insert_err_msg, $txt_event_title) ?>" id="txt_event_title" />
	                     </div>
	                     <div class="col-sm-2">
	                     	<!-- <p class="help-block">Your help text!</p> -->
	                     </div>
	                  </div>
	                  <div class="form-group">
	                 	<label for="ta_event_content" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_DESCRIPTION']; ?></label>
	                    <div class="col-sm-8">
	                    	<textarea class="form-control1" name="ta_event_content" cols="60" rows="5" id="ta_event_content"><?php print $event->show_content($event_insert_err_msg, $ta_event_content) ?></textarea>
	                        <script language="JavaScript1.2" type="text/javascript">
								generate_wysiwyg('ta_event_content');
							</script>
	                     </div>
	                     <div class="col-sm-2">
	                     	<!-- <p class="help-block">Your help text!</p> -->
	                     </div>
	                  </div>
	                  <div class="form-group">
	                 	<label for="txt_event_location" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_VENUE']; ?></label>
	                    <div class="col-sm-8">
	                    	<input class="form-control1" name="txt_event_location" type="text" value="<?php print $event->show_content($event_insert_err_msg, $txt_event_location) ?>" id="txt_event_location" />
	                     </div>
	                     <div class="col-sm-2">
	                     	<!-- <p class="help-block">Your help text!</p> -->
	                     </div>
	                  </div>
	                  <div class="form-group">
	                 	<label for="event_selDateStart" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_DATE-START']; ?></label>
	                    <div class="col-sm-8">
	                    	<?php print $event->combo_datetime($arrDate['DAY'], $arrDate['MONTH'], $arrDate['YEAR'], '', '', '', '1', $_SESSION[LANG]); //print $event->combo_datetime(date('d'), date('m'), date('Y'), '', '', '', '1', $_SESSION[LANG]); ?>
	                    	<?php //print $event->combo_datetime('0', '0', '0', '0', '0', '0', '1'); //$event->combo_datetimeEn($_POST[cmbDay], $_POST[cmbMonth], $_POST[cmbYear], 1); ?>
	                     </div>
	                     <div class="col-sm-2">
	                     	<!-- <p class="help-block">Your help text!</p> -->
	                     </div>
	                  </div>
	                  <div class="form-group">
	                 	<label for="event_selDateEnd" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_DATE-END']; ?></label>
	                    <div class="col-sm-8">
	                    	<?php print $event->combo_datetime($arrDate['DAY'], $arrDate['MONTH'], $arrDate['YEAR'], '', '', '', '2', $_SESSION[LANG]); //print $event->combo_datetime(date('d'), date('m'), date('Y'), '', '', '', '2', $_SESSION[LANG]); ?>
	                     </div>
	                     <div class="col-sm-2">
	                     	<!-- <p class="help-block">Your help text!</p> -->
	                     </div>
	                  </div>
	                  <div class="form-group">
	                 	<label for="txt_event_url" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_URL']; ?></label>
	                    <div class="col-sm-8">
	                    	<input class="form-control1" name="txt_event_url" type="text" value="<?php print $event->show_content($event_insert_err_msg, $txt_event_url) ?>" id="txt_event_url" />
	                     </div>
	                     <div class="col-sm-2">
	                     	<!-- <p class="help-block">Your help text!</p> -->
	                     </div>
	                  </div>
	                  <div class="panel-footer">
	                  	<div class="row">
	                    	<div class="col-sm-8 col-sm-offset-2">
	                            <button name="btn_event_insert" id="btn_event_insert" class="btn-success btn"><?php print $mod_lang_output['FORM_BUTTON_ADD_EVENT']; ?></button>
	                        </div>
	                    </div>
	                 </div>
	              </form>
	          </div>
	      </div>
      <?php } ?>
      
     
      <!-- ********************************* Display events  ******************************************************
      ****************************************************************************************************************-->
      <?php if(!isset($_REQUEST[what]) || ($_REQUEST[what]=="eventDisplay")) { ?>
      
      <h3><?php print $mod_lang_output['MODULE_NAME']; ?> :: <?php print $mod_lang_output['PAGE_HEADER_LIST_EVENTS']; ?></h3>
      
      	<!-- Tab buttons start -->
		<div class="but_list">
		
		<div class="bs-event bs-event-tabs" role="tabpanel" data-event-id="togglable-tabs">
			<ul class="nav nav-tabs" id="myTab" role="tablist">
				<li id="tab_0" class="active" role="presentation">
					<a id="eventcal-tab" role="tab" aria-expanded="true" aria-controls="eventcal" href="#eventcal" data-toggle="tab">Calendrier</a>
				</li>
				<li id="tab_1" role="presentation">
					<a id="eventlist-tab" role="tab" aria-controls="eventcal" href="#eventlist" data-toggle="tab">Tableau</a>
				</li>
			</ul>
			
			<!-- Tabs contents start -->
			<div class="tab-content" id="myTabContent">
			
				<!-- Content 01 -->
				<div class="tab-pane fade in active" id="eventcal" role="tabpanel" aria-labelledby="eventcal-tab">
				
					<!-- ********************************* Charger les evennement dans un calendrier  ******************************************************
				      ****************************************************************************************************************-->
          			<div class='col-sm-8'>
	        			<div class="panel panel-warning" data-widget="{&quot;draggable&quot;: &quot;false&quot;}" data-widget-static="">
	          				<div class="panel-body no-padding">
			      				<?php
			      					/*:::::: Calendar settings :::::*/
			      						//Initialize months
			      						$myCal->months		=	$myCal->arr_get_months($_SESSION['LANG']);
			      						
			      						//Initialize weekdays
			      						$myCal->weekdays	=	$myCal->arr_get_weedays($_SESSION['LANG']);
			      						
			      						//Show or hide week days
			      						$myCal->weekNumbers	=	false;
			      						
			      						//Cells width and height
			      						$myCal->trWidth		=	'5em';
			      						$myCal->trHeight	=	'5em';
			      						
			      						//Fonts sizes
			      							//Units:
			      							$myCal->sizeUnit	=	'em';
			      							//Title
			      							$myCal->tFontSize	=	'1.8';
			      							//Days
			      							$myCal->dFontSize	=	'1.2';
			      							//Headings
			      							$myCal->hFontSize	=	'1.2';
			      							//Weeks
			      							$myCal->wFontSize	=	'1.2';
			      							
			      						//Font colors
			      							$myCal->hilightColor	=	'#cdfdc6';
			      							$myCal->hBGColor		=	'#009966';
			      							$myCal->tBGColor		=	'#06d995';
			      							$myCal->tdBorderColor	=	'#009933';
			      							$myCal->saFontColor		=	'#003399';
			      							
			      						//Calendar borders
			      						$myCal->calBorder	=	'1';
			      						
			      						//Adding an event
			      						$myCal->urlTitle	=	$mod_lang_output['LABEL_CLICK_TO_ADD_EVENT'];
			      						$myCal->link		=	$thewu32_site_url.'/modern_admin/'.$event->admin_modPage.'?what=eventInsert';
	
			      					/*:::::: Calendar processing :::::*/
			      					if(isset($_POST[btn_calDisplay])){
			      						$datetimeEvent	=	$_POST['cmbYear'].'-'.$_POST['cmbMonth'].'-'.$_POST['cmbDay'].' '.'00:00:00';
			      						$arrEvents	=	$event->calendar_get_events($datetimeEvent);
			      						if(is_array($arrEvents)){
				      						foreach($arrEvents as $calEvent){
				      							$myCal->viewEvent($calEvent['DAY-START'], $calEvent['DAY-END'], '#ccc', $calEvent['TITLE'], '/cabb.edu/modern_admin/event_manager.php?what=eventUpdate&action=eventUpdate&pmId='.$calEvent['ID']);
				      						}
			      						} 
			      					}	
			      						
			      					//Rendu final	
			      					print $myCal->create(); 
			      				?>
	      					</div>
	      				</div>
      				</div>
      			
      				<div class='col-sm-4'>
	      				<form method="post">
		      				<div class='form-group'>
		      					<?php print $event->combo_date($_POST['cmbDay'], $_POST['cmbMonth'], $_POST['cmbYear']);?>
		      				</div>
		      				<div class="panel-footer">
		               			<div class="row">
		                   			<div class="col-sm-8 col-sm-offset-2">
		                           		<button id="btn_calDisplay" arialabelledby="eventcal" name="btn_calDisplay" class="btn-success btn">Afficher la date</button>
		                       		</div>
		                   		</div>
		               		</div>
		               	</form>
      				</div>
      			</div>
				
				<!-- Content 02 -->
				<div class="tab-pane fade" id="eventlist" role="tabpanel" aria-labelledby="eventlist-tab">
				
					<!-- ********************************* Charger les evennements dans un tableau  ******************************************************
				      ****************************************************************************************************************-->					
					<?php if(isset($event_display_err_msg)) {  ?>
			        	<div class="ADM_err_msg"><?php print $event_display_err_msg; ?></div>
			        <?php } ?>
			        <?php if(isset($event_display_cfrm_msg)) {  ?>
			          	<div class="ADM_cfrm_msg"><?php print $event_display_cfrm_msg; ?></div>
			        <?php } ?>
			          
			        <div class="panel panel-warning" data-widget="{&quot;draggable&quot;: &quot;false&quot;}" data-widget-static="">
			        	<div class="panel-body no-padding">
			        		<table class="table table-bordered">
								<tr>
									<th>&num;</th>
									<th><?php print $mod_lang_output['TABLE_HEADER_CATEGORY']; ?></th>
									<th><?php print $mod_lang_output['TABLE_HEADER_TITLE']; ?></th>
									<th><?php print $mod_lang_output['TABLE_HEADER_AUTHOR']; ?></th>
									<th><?php print $mod_lang_output['TABLE_HEADER_DATE-START']; ?></th>
									<th><?php print $mod_lang_output['TABLE_HEADER_DATE-END']; ?></th>
									<th><?php print $mod_lang_output['TABLE_HEADER_DATE-CREA']; ?></th>
									<th><?php print $mod_lang_output['TABLE_HEADER_ACTION']; ?></th>
								</tr>
			        		<?php print $event->admin_load_events(); ?>
			           	</div>
			        </div>											
				</div>
			</div>
	</div>
	<!-- Tabs contents end -->        
      <?php } ?>	
      
      <!-- Fix the Tab  -->
      	<?php if(isset($_REQUEST['action'])) { ?>
			<script> $('a[href="#eventlist"]').click(); </script>
		<?php } ?>
      
            
      <!-- ********************************* Update events  ******************************************************
      ****************************************************************************************************************-->
      <?php 
      	if($_REQUEST[what] == "eventUpdate") { // Si on a clique sur modifier l'event... 
	  		$tabUpd	= $event->get_event($_REQUEST[$event->mod_queryKey]);
	  ?>
      <h3><?php print $mod_lang_output['MODULE_NAME']; ?> :: <?php print $mod_lang_output['PAGE_HEADER_UPDATE_EVENT']; ?></h3>
      <?php if(isset($event_update_err_msg)) { ?>
      <div class="ADM_err_msg"><?php print $event_update_err_msg; ?></div>
      <?php } ?>
      <?php if(isset($event_update_cfrm_msg)) { ?>
      <div class="ADM_cfrm_msg"><?php print $event_update_cfrm_msg; ?></div>
      <?php } ?>
      
      <div class="tab-content">
      	<div class="tab-pane active" id="horizontal-form">
        	<form class="form-horizontal" action="" method="post" name="frm_event_insert" id="frm_event_insert">
            	<div class="form-group">
                	<label for="sel_eventLangUpdate" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_LANGUAGE']; ?></label>
                    <div class="col-sm-8">
                       	<select class="form-control" name="sel_eventLangUpdate" id="sel_eventLangUpdate">
							<?php print $event->cmb_showLang($tabUpd['eventLANG']); ?>
                          </select>
                    </div>
                    <div class="col-sm-2">
                       	<!-- <p class="help-block">Your help text!</p> -->
                    </div>
                 </div>
                 <div class="form-group">
                 	<label for="event_selCatUpd" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_CATEGORY']; ?></label>
                    <div class="col-sm-8">
                    	<select class="form-control" name="event_selCatUpd" id="event_selCatUpd">
							<?php print $event->admin_cmb_show_rub($tabUpd["eventTYPEID"]); ?>
                        </select>
                     </div>
                     <div class="col-sm-2">
                     	<!-- <p class="help-block">Your help text!</p> -->
                     </div>
                  </div>
                  <div class="form-group">
                 	<label for="txt_event_title_upd" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_TITLE']; ?></label>
                    <div class="col-sm-8">
                    	<input class="form-control1" name="txt_event_title_upd" type="text" value="<?php print stripslashes($tabUpd["eventNAME"]); ?>" id="txt_event_title_upd" />
                     </div>
                     <div class="col-sm-2">
                     	<!-- <p class="help-block">Your help text!</p> -->
                     </div>
                  </div>
                  <div class="form-group">
                 	<label for="ta_event_content_upd" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_DESCRIPTION']; ?></label>
                    <div class="col-sm-8">
                    	<textarea name="ta_event_content_upd" cols="40" rows="5" id="ta_event_content_upd"><?php print stripslashes($tabUpd["eventDESCR"]); ?></textarea>
						<script language="JavaScript1.2" type="text/javascript">
                            generate_wysiwyg('ta_event_content_upd');
                        </script>
                     </div>
                     <div class="col-sm-2">
                     	<!-- <p class="help-block">Your help text!</p> -->
                     </div>
                  </div>
                  <div class="form-group">
                 	<label for="txt_event_location_upd" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_VENUE']; ?></label>
                    <div class="col-sm-8">
                    	<input class="form-control1" name="txt_event_location_upd" type="text" value="<?php print stripslashes($tabUpd["eventLOCATION"]); ?>" id="txt_event_location_upd" />
                     </div>
                     <div class="col-sm-2">
                     	<!-- <p class="help-block">Your help text!</p> -->
                     </div>
                  </div>
                  <div class="form-group">
                 	<label for="event_selDateStart" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_DATE-START']; ?></label>
                    <div class="col-sm-8">
                    	<?php print $event->combo_datetime_update($tabUpd[eventSTART], 1, $_SESSION['LANG'], 'form-control');//$event->combo_datetimeEnUpd($tabUpd[eventSTART], '2012', 1); ?>
                     </div>
                     <div class="col-sm-2">
                     	<!-- <p class="help-block">Your help text!</p> -->
                     </div>
                  </div>
                  <div class="form-group">
                 	<label for="event_selDateEnd" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_DATE-END']; ?></label>
                    <div class="col-sm-8">
                    	<?php print $event->combo_datetime_update($tabUpd[eventEND], 2, $_SESSION['LANG'], 'form-control'); //$event->combo_datetimeEnUpd($tabUpd[eventEND], '2012', 2); ?>
                     </div>
                     <div class="col-sm-2">
                     	<!-- <p class="help-block">Your help text!</p> -->
                     </div>
                  </div>
                  <div class="form-group">
                 	<label for="txt_event_url" class="col-sm-2 control-label"><?php print $mod_lang_output['FORM_LABEL_URL']; ?></label>
                    <div class="col-sm-8">
                    	<input class="form-control1" name="txt_event_url_upd" type="text" value="<?php print $tabUpd[eventURL]; ?>" id="txt_event_url_upd" />
                     </div>
                     <div class="col-sm-2">
                     	<!-- <p class="help-block">Your help text!</p> -->
                     </div>
                  </div>
                  <div class="panel-footer">
                  	<div class="row">
                    	<div class="col-sm-8 col-sm-offset-2">
                        	<input type="hidden" name="hd_event_id" value="<?php print $tabUpd[eventID]; ?>" />
                            <button name="btn_event_upd" id="btn_event_upd" class="btn-success btn"><?php print $mod_lang_output['FORM_BUTTON_UPDATE']; ?></button>
                        </div>
                    </div>
                 </div>
              </form>
          </div>
      </div>
      
      <?php } ?>
        	
<?php include_once('inc/admin_footer.php');?>