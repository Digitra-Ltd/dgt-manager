<?php
	session_save_path("../_sessions/");
	session_start();
?>
<?php 
	//require_once("../modules/user/library/user.inc.php");
	require_once("../member/library/member.inc.php");
	$my_fileTransact	=	new cwd_system();
	//Chargement dynamique des bibliotheques depuis /site_dir/modules/
	$site_libs = $my_fileTransact->list_dir($thewu32_site_dir.'modules/'); //Lister tous les  sous-répertoires directs du répertoire /modules/
	foreach($site_libs as $library){	
		//Load each module
		require_once('../modules/'.$library.'/library/'.$library.'.inc.php');
	
	}
	
	//$my_memberStats		=	new cwd_member();
	$my_eventStats		=	new cwd_event();
	$my_newsStats		=	new cwd_news();
	$my_pagesStats		=	new cwd_page();
	$my_fileStats		=	new cwd_file();
	$my_userStats		=	new cwd_user();
	$my_annonceStats	=	new cwd_annonce();
	$my_dailyquotStats	=	new cwd_dailyquot();
	$my_galleryStats	=	new cwd_gallery();
	$my_bannerStats		=	new cwd_banner();
	
	//$nbMembers			=	$my_memberStats->count_members();
	//$nb_payStarted		=	$my_memberStats->count_tuitions_started();
	$nbEvents			=	$my_eventStats->count_events();
	$nbNews				=	$my_newsStats->count_news();
	$nbPages			=	$my_pagesStats->count_pages();
	$nbFiles			=	$my_fileStats->count_files();
	$nbUsers			=	$my_userStats->count_users();
	$nbAnnonces			=	$my_annonceStats->count_annonces();
	$nbDailyquots		=	$my_dailyquotStats->count_dailyquots();
	$nb_galleryPix		=	$my_galleryStats->count_gallery('0');
	$nb_galleryAlbums	=	$my_galleryStats->count_gallery('1');
	$nbBanners			=	$my_bannerStats->count_banners();
?>
<?php
	$userName = $_SESSION['ud_Name'];
	if(isset($_SESSION['CONNECTED_ADMIN']))
		include('menu_admin.php');
	elseif(isset($_SESSION['CONNECTED_EDIT']))
		include('menu_user.php');
?>
<?php 
	print $menu;
?>