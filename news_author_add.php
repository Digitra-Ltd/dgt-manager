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
	//require_once("../scripts/langfiles/".$_SESSION[LANG].".php");
	require_once("../scripts/langfiles/EN.php");
	require_once("../scripts/incfiles/config.inc.php");
	require_once("../modules/user/library/user.inc.php");
	require_once("../modules/news/library/news.inc.php");
	$system		= new cwd_system();
	$news		= new cwd_news();
	$news->db_connect($thewu32_host, $thewu32_db, $thewu32_user, $thewu32_pass);
	$system->session_checker($_SESSION["CONNECTED_ADMIN"], $_SESSION["CONNECTED_EDIT"]);
?>
<?php
	$txtNom				= 	strtoupper($_POST[txtNom]);
	$txtPrenom			= 	ucwords($_POST[txtPrenom]);
	$selSex				= 	$_POST[selSex];
	$selGroup			= 	$_POST[selGroup];
	$btn_authorInsert	= 	$_POST[btn_authorInsert];
	
	if(isset($btnInsertAuthor)){
		if($selSex == "NULL"){
			$err_newsAuthorInsert	= "Veuillez choisir le sexe svp!";
		}
		elseif((empty($txtNom)) && (empty($txtPrenom))){
			$err_newsAuthorInsert = "Error!<br />You must provide a first or last name for the author";
		}
		elseif($news->chk_entry_trice($news->tbl_newsAuth, $news->fld_newsAuthLastName, $news->fld_newsAuthFirstName, $news->fld_newsAuthCatId, $txtNom, $txtPrenom, $selGroup))
			$err_newsAuthorInsert	= "Sorry!<br />This author exists already";
		elseif($news->set_news_author($txtNom, $txtPrenom, $selSex, $selGroup)){
			$cfrm_newsAuthorInsert	= "Congratulations!<br />Author created successfully.";
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
	<!-- ********************************* Create news authors ******************************************************
      ****************************************************************************************************************-->       
        
        	<h3>News manager :: Insert an author</h3>
			<?php if(isset($err_newsAuthorInsert)) { ?>
		  		<div class="ADM_err_msg"><?php print $err_newsAuthorInsert; ?></div>
		    <?php } ?>
			<?php if(isset($cfrm_newsAuthorUpdate)) { ?>
		  		<div class="ADM_cfrm_msg"><?php print $cfrm_newsAuthorInsert; ?></div>
		    <?php } ?>
            
            <div class="tab-content">
                <div class="tab-pane active" id="horizontal-form">
                      <form class="form-horizontal" action="" method="post" name="frm_newsAuthorInsert" id="frm_newsAuthorInsert">
                        <div class="form-group">
                            <label for="txtNom" class="col-sm-2 control-label">Last Name</label>
                            <div class="col-sm-8">
                                <input class="form-control1" name="txtNom" type="text" id="txt_newsAuthorLastUpdate" size="30" value="<?php print $tab_newsAuthorUpd["AUTH_LAST"]; ?>" />
                            </div>
                            <div class="col-sm-2">
                                <!-- <p class="help-block">Your help text!</p> -->
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="txtPrenom" class="col-sm-2 control-label">First Name</label>
                            <div class="col-sm-8">
                                <input class="form-control1" name="txtPrenom" type="text" id="txt_newsAuthorFirstUpdate" size="30" value="<?php print $tab_newsAuthorUpd["AUTH_FIRST"]; ?>" />
                            </div>
                            <div class="col-sm-2">
                                <!-- <p class="help-block">Your help text!</p> -->
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="selSex" class="col-sm-2 control-label">Sex</label>
                            <div class="col-sm-8">
                                <select class="form-control" name="selSex" id="selSex">
                                    <option value="NULL">[ Choose ]</option>
								        <option value="M">Male</option>
								        <option value="F">Female</option>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <!-- <p class="help-block">Your help text!</p> -->
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="selGroup" class="col-sm-2 control-label">Group</label>
                            <div class="col-sm-8">
                                <select class="form-control" name="selGroup" id="sel_newsAuthorCatUpdate">
									<?php print $news->cmb_get_news_author_cat(); ?>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <!-- <p class="help-block">Your help text!</p> -->
                            </div>
                        </div>
                        <div class="panel-footer">
                            <div class="row">
                                <div class="col-sm-8 col-sm-offset-2">
                                    <button onclick="javascript:parent.opener.location.reload();" name="bt_authorInsert" id="bt_authorInsert" class="btn-success btn">Add a new author</button>
                                </div>
                            </div>
                        </div>            
        			</form>
        		</div>
              </div>
        

</body>
</html>
