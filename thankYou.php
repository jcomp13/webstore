<?php
require_once 'core/init.php';

function NewGuid() {
   $s = strtoupper(md5(uniqid(rand(), true)));
   $guidText = 
          substr($s,0,8). '-' .
          substr($s,8,4). '-' .
          substr($s,12,4). '-' .
          substr($s,16,4). '-' .
          substr($s,20);
   return $guidText;
}


// Set your secret key: remember to change this to your live secret key in production
// See your keys here https://dashboard.stripe.com/account/apikeys
//\Stripe\Stripe::setApiKey(STRIPE_PRIVATE);

// Get the credit card details submitted by the form
//$token=$_POST['stripeToken'];
// get rest of the post data
$full_name = sanitize($_POST['full_name']);
$email = sanitize($_POST['email']);
$street = sanitize($_POST['street']);
$street2 = sanitize($_POST['street2']);
$city = sanitize($_POST['city']);
$state = sanitize($_POST['state']);
$zip_code = sanitize($_POST['zip_code']);
$country = sanitize($_POST['country']);
$tax = sanitize($_POST['tax']);
$sub_total = sanitize($_POST['sub_total']);
$grand_total = sanitize($_POST['grand_total']);
$cart_id = sanitize($_POST['cart_id']);
$description = sanitize($_POST['description']);
$charge_amount = number_format($grand_total,2) * 100;     // place money in cents
$metadata = array(
    "cart_id => $cart_id",
	"tax" => $tax,
	"sub_total" => $sub_total,
);

// Create the charge on Stripe's servers - this will charge the user's card
try {
	$testnum=10;
	if ($testnum < 20)  {

	// adjust inventory
	$itemQ=$db->query("select * from cart where id = '{$cart_id}'");
	$iresults = mysqli_fetch_assoc($itemQ);
	$items = json_decode($iresults['items'],true);
	foreach($items as $item) {
		$newSizes = array();
		$item_id = $item['id'];
		$productQ = $db->query("select sizes from products where id='{$item_id}'");
		$product = mysqli_fetch_assoc($productQ);
		$sizes = sizesToArray($product['sizes']);
		foreach($sizes as $size) {
			if ($size['size'] == $item['size']){
				$q = $size['quantity'] - $item['quantity'];
				$newSizes[] = array('size'=>$size['size'],'quantity'=>$q, 'threshold' => $size['threshold']);
			} else {
				$newSizes[] = array('size'=>$size['size'], 'quantity' => $size['quantity'], 'threshold' => $size['threshold']);
 			}
		}
		$sizeString = sizesToString($newSizes);
		$db->query("update products set sizes = '{$sizeString}' where id = '{$item_id}'");
	}

	// update cart
	$db->query("update cart set paid =1 where id= '{$cart_id}'");	
	
	// $charge_id is a unique blob
	// txn_type will be returned as "charge"
	$charge_id = NewGuid();
	$charge_type = 'Charge';
//$dbsql = "insert into transactions
//	   (charge_id, cart_id, full_name, email, street, street2, city, state, zip_code,country,sub_total, tax, grand_total, description, txn_type) values
//	   ('$charge_id','$cart_id','$full_name','$email','$street','$street2','$city','$state','$zip_code',
//	   '$country','$sub_total','$tax','$grand_total','$description','$charge_type')";

//	   echo $dbsql;
//	   die();
      
	$db->query("insert into transactions
	   (charge_id, cart_id, full_name, email, street, street2, city, state, zip_code,country,sub_total, tax, grand_total, description, txn_type) values
	   ('$charge_id','$cart_id','$full_name','$email','$street','$street2','$city','$state','$zip_code',
	   '$country','$sub_total','$tax','$grand_total','$description','$charge_type')");

           $domain = ($_SERVER['HTTP_HOST'] != 'localhost')?'.'.$_SERVER['HTTP_HOST']:false;
	   setcookie(CART_COOKIE, '', 1 ,"/", $domain, false);
	   include 'includes/head.php';
	   include 'includes/navigation.php';
	   include 'includes/headerpartial.php';
   ?>
	   <h1 class="text-center text-success">Thank You!</h1>
       <p> Your card has been successfully charges 	<?=money($grand_total);?>. You have been emailed a receipt.  
           Please check your spam folder if it is not in your inbox.  Additionally you can print this page as a receipt</p>
       <p>Your receipt number is: <strong><?=$cart_id;?></strong></p>
       <p>Your order will be shipped to the address below.</p>	
        <address>
		   <?=$full_name;?><br>
		   <?=$street;?><br>		   
		   <?=(($street2 != '')?$street2.'<br>':'');?>			   
		   <?=$city. ', '.$state.' '. $zip_code;?><br>			   
		   <?=$country;?><br>			   
		   
		</address>	   
	<?php   
	   include 'includes/footer.php';
	}
} catch(Exception $e) {
  // The card has been declined	
  echo "Process failed";
}

///////////     try block for processing

//try {
//	$charge=\Stripe\Charge::create(array(
//	  "amount" => $charge_amount,  // amount in cents, again
//	  "currency" => CURRENCY,
//	  "source" => $token,
//	  "description" => $description,
//	  "receipt_email" => $email,
//	  "metadata" => $metadata)
//	);

	
//	$db->query("update cart set paid =1 where id= '{$cart_id}'");
//	$db->query("insert into transactions
//	   (charge_id, cart_id, full_name, email, street, street2, city, state, zip_code,country,sub_total, tax, grand_total, description, txn_type) values
//	   ('$charge-id','$cart_id','$full_name','$email','$street','$street2','$city','$state','$zip_code','$contry','$sub_total','$tax','$grand_total','$description','$charge->object')");
		   
//	   $domain = ($_SERVER['HTTP_HOST'] != 'localhost')?'.'.$_SERVER['HTTP_HOST']:false;
//	   setcookie(CART_COOKIE, '', 1 ,"/", $domain, false);
//	   include 'includes/head.php';
//	   include 'includes/navigation.php';
//	   include 'includes/headerpartial.php';
 //  ? >
 
//  <h1 class="text-center text-success">Thank You!</h1>
 //    <p> Your card has been successfully charges 	<?=money($grand_total);? >. You have been emailed a receipt.  
 //       Please check your spam folder if it is not in your inbox.  Additionally you can print this page as a receipt</p>
//       <p>Your receipt number is: <strong><?=$cart_id;?/></strong></p>
//       <p>Your order will be shipped to the address below.</p>	
//        <address>
//		   <?=$full_name;?/><br>
//		   <?=$street;?/><br>		   
//		   <?=(($street2 != '')?$street2.'<br>':'');?/>			   
//		   <?=$city. ', '.$state.' '. $zip_code;?/><br>			   
//		   <?=$country;? ><br>			   
		   
//		</address>	   
//	<?php   
//	   include 'includes/footer.php';
	   
//	)
//} catch(\Stripe\Error\Card $e) {
  // The card has been declined	
  //echo $e;
//}

?>