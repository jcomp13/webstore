<?php
require_once '../../core/init.php';

//$cookie_name="SBwi72UCklwiqzz2";

$product_id = sanitize($_POST['product_id']);
$size = sanitize($_POST['size']);
$available = sanitize($_POST['available']);
$quantity = sanitize($_POST['quantity']);



$item = array();
$item[] = array(
    'id' => $product_id,
	'size' => $size,
	'quantity' => $quantity,
);

$domain = ($_SERVER['HTTP_HOST'] != 'localhost')?'.'.$_SERVER['HTTP_HOST']:false;
$query = $db->query("select * from products where id = '{$product_id}'");
$product = mysqli_fetch_assoc($query);


//  check to see if the cart cookie exists
if ($cart_id != '' ){
	$cartQ=$db->query("select * from cart where id = '{$cart_id}'");
	$cart = mysqli_fetch_assoc($cartQ);
	$previous_items = json_decode($cart['items'], true);
	$item_match = 0;
	$new_items = array();
	foreach($previous_items as $pitem){
		if($item[0]['id'] == $pitem['id'] && $item[0]['size'] == $pitem['size']){
			$pitem['quantity'] = $pitem['quantity'] + $item[0]['quantity'];
			if($pitem['quantity']> $available) {
				$pitem['quantity'] = $available;
			}
			$item_match = 1;
		}
		$new_items[] = $pitem;
	}
	if ($item_match != 1) {
		$new_items = array_merge($item, $previous_items);
	}
	
	$items_json = json_encode($new_items);
	$cart_expire = date("Y-m-d H:i:s", strtotime("+30 days"));	
	$db->query("update cart set items = '{$items_json}', expire_date = '{$cart_expire}' where id= '{$cart_id}'");

	// destroy cookie
//	setcookie($cookie_name,'',1 '/', $domain, false ); 
//	setcookie($cookie_name,$cart_id,CART_COOKIE_EXPIRE,'/',$domain,false); 	
	setcookie(CART_COOKIE,'',1, '/', $domain, false ); 
	setcookie(CART_COOKIE, $cart_id ,CART_COOKIE_EXPIRE,'/',$domain,false);  
//	$_SESSION['success_flash'] = "cart already open";
	$_SESSION['success_flash'] = $product['title']. ' added to your cart same cart  ';	
	
}else {
	// add the cart to the datbase and set cookie
	$items_json = json_encode($item);
	$cart_expire = date("Y-m-d H:i:s", strtotime("+30 days"));
	$db->query("insert into cart(items, expire_date) values('{$items_json}','{$cart_expire}')");
	$cart_id = $db->insert_id;
//	setcookie($cookie_name,$card_id,CART_COOKIE_EXPIRE,'/',$domain,false);	
	setcookie(CART_COOKIE, $cart_id ,CART_COOKIE_EXPIRE,'/',$domain,false);
    $_SESSION['success_flash'] = $product['title']. ' placed in your cart   new cart';
	
}

?>
