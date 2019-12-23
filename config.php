<?php
define('BASEURL', $_SERVER['DOCUMENT_ROOT'].'/teststore/');

define('CART_COOKIE','SBwi72UCklwiqzz2');
define('CART_COOKIE_EXPIRE', time()+(86400 * 30));
define('TAXRATE',0.07);


//   Used with STRIPE
define('CURRENCY', 'usd');
define('CHECKOUTMODE','TEST');    // change TEST to LIVE when done testing

if (CHECKOUTMODE == 'TEST'){
	define ('STRIPE_PRIVATE','sk_test_RFdU8WZU7FX0ypMyeqNGv4EH');
	define ('STRIPE_PUBLIC', 'pk_test_KznbA9avfEU4IevDUCmp3c1M');	
}

if (CHECKOUTMODE == 'LIVE'){
	define ('STRIPE_PRIVATE','sk_live_lxBfBTsx8chg1C86x6giua4U');
	define ('STRIPE_PUBLIC', 'pk_live_vP7M3y0BNZ569ligQyZ5zHFf');	
}



?>