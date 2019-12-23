<?php
define('BASEURL', $_SERVER['DOCUMENT_ROOT'].'/teststore/');

define('CART_COOKIE','SBwi72UCklwiqzz2');
define('CART_COOKIE_EXPIRE', time()+(86400 * 30));
define('TAXRATE',0.07);


//   Used with STRIPE
define('CURRENCY', 'usd');
define('CHECKOUTMODE','TEST');    // change TEST to LIVE when done testing

if (CHECKOUTMODE == 'TEST'){
	define ('STRIPE_PRIVATE','sk_test_xxxxxxxxxxxxxxxxxxxxxxxx');
	define ('STRIPE_PUBLIC', 'pk_test_xxxxxxxxxxxxxxxxxxxxxxxx');	
}

if (CHECKOUTMODE == 'LIVE'){
	define ('STRIPE_PRIVATE','sk_live_xxxxxxxxxxxxxxxxxxxxxxxx');
	define ('STRIPE_PUBLIC', 'pk_live_xxxxxxxxxxxxxxxxxxxxxxxx');	
}



?>
