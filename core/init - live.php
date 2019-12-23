<?php
   $db=mysqli_connect("jerseyshoreuser.db.3773187.hostedresource.com","jerseyshoreuser","Rockybear13","jerseyshoreuser");
   if (mysqli_connect_errno()){
	   echo 'Database connection failed with following errors: ' . mysqli_connect_error();
	   die();
   }
   session_start();
  //this is what they defined
 //require_once  $_SERVER["DOCUMENT_ROOT"].'/seakritters/econfig.php';   // this is what they defined
 //require_once BASEURL . 'helpers/helpers.php;
 
define('__ROOT__', dirname(dirname(__FILE__)));
require_once(__ROOT__.'/econfig.php'); 
require_once(__ROOT__.'./helpers/helpers.php'); 

// This is required for stripe to load their API
//require BASEURL.'vendor/autoload.php';


$cart_id = '';
if(isset($_COOKIE[CART_COOKIE])){
	$cart_id = sanitize($_COOKIE[CART_COOKIE]);
}

//$cookie_name="SBwi72UCklwiqzz2";
//$cart_id = '';
//if(isset($_COOKIE[$cookie_name])){
//	$cart_id = sanitize($_COOKIE[$cookie_name]);
//}


if (isset($_SESSION['SBUser'])){
	$user_id = $_SESSION['SBUser']; 
	$query = $db->query("select * from users where id = '$user_id'");
	$user_data = mysqli_fetch_assoc($query);
	$fn = explode(' ', $user_data['full_name']);
	$user_data['first'] = $fn[0];
	$user_data['last'] = $fn[1];
}


if (isset($_SESSION['success_flash'])) {
	echo '<div class="bg-success"><p class="text-success text-center">' . $_SESSION['success_flash'] .'</p></div>';
	unset($_SESSION['success_flash']);
	
}
 
if (isset($_SESSION['error_flash'])) {
	echo '<div class="bg-danger"><p class="text-danger text-center">' . $_SESSION['error_flash'] .'</p></div>';
	unset($_SESSION['error_flash']);
	
}
 
 
 //if file_exists('../econfig.php'){
 //  require_once '../econfig.php';
 //  require_once '../helpers/helpers.php';
 //}
 //else {
 //  require_once './econfig.php';
 //  require_once './helpers/helpers.php'; 
// }

 ?>