<?php
 require_once '../core/init.php';

 if (!is_logged_in()){
     header('Location: login.php');    // avoid error of initial screen
; }

 include 'includes/head.php';
 include 'includes/navigation.php';
 ?>
<!-- Orders to Fill  -->
<?php
  $txnQuery = "select t.id, t.cart_id, t.full_name, t.description, t.txn_date, t.grand_total, c.items, c.paid, c.shipped
    from transactions t 
    left join cart c on t.cart_id = c.id
    where c.paid = 1 and c.shipped = 0
    order by t.txn_date";
	
	$txnResults= $db->query($txnQuery);

?>

<div class="col-md-12">
    <h3 class="text-center">Orders To Ship</h3>
	<table  class="table table-condensed table-bordered table-striped">
	   <thead>
	      <th></th>
	      <th>Name</th>
	      <th>Description</th>
	      <th>Total</th>
	      <th>Date</th>
		</thead>
		<tbody>
		   <?php while($order = mysqli_fetch_assoc($txnResults)):   ?>
		     <tr>
		        <td><a href="orders.php?txn_id=<?= $order['id']?>" class="btn btn-info">Details</a></td>
		        <td><?= $order['full_name'];   ?></td>
		        <td><?= $order['description'];  ?></td>
		        <td><?=money($order['grand_total']);?></td>
		        <td><?=pretty_date($order['txn_date']);?></td>			  
		     </tr>
			 <?php endwhile;  ?>
		</tbody>
    </table>
</div>


<div class="row">
<!--  Sales by Month  -->
<?php
    $thisYr = date("Y");
	$lastYr  = $thisYr -1;
    $thisYrQ = $db->query("select grand_total, txn_date from transactions where YEAR(txn_date)= '{$thisYr}'");
    $lastYrQ = $db->query("select grand_total, txn_date from transactions where YEAR(txn_date)= '{$lastYr}'");
	$current = array();
	$last = array();
	$currentTotal=0;
	$lastTotal=0;
	while($x = mysqli_fetch_assoc($thisYrQ)){
		$month = date("m", strtotime($x['txn_date']));
		if (!array_key_exists($month, $current)) {
			$current[(int)$month] = $x['grand_total'];
		} else {
			$current[(int)$month]+= $x['grand_total'];
		}
		$currentTotal += $x['grand_total'];
	}
	
	while($y = mysqli_fetch_assoc($lastYrQ)){
		$month = date("m", strtotime($y['txn_date']));
		if (!array_key_exists($month, $current)) {
			$last[(int)$month] = $y['grand_total'];
		} else {
			$last[(int)$month]+= $y['grand_total'];
		}
		$lastTotal += $y['grand_total'];
	}	
	
?>
   <div class="col-md-4">
      <h3 class="text-center">Sales2 By Month</h3>
	     <table class="table table-condensed table-striped table-bordered">
		    <thead>
			    <th></th>
			    <th><?=$lastYr;?></th>				
			    <th><?=$thisYr;?></th>
            </thead>
            <tbody>
			  <?php for($i=1;$i<=12;$i++): 
                  switch($i) {
					  case 1: $mn='January'; break;
				      case 2: $mn='February'; break;
					  case 3: $mn='March'; break;
				      case 4: $mn='April'; break;
					  case 5: $mn='May'; break;
				      case 6: $mn='June'; break;
					  case 7: $mn='July'; break;
				      case 8: $mn='August'; break;
					  case 9: $mn='September'; break;
				      case 10: $mn='October'; break;
					  case 11: $mn='November'; break;
				      case 12: $mn='December'; break;
				  }			  
//			    $dt = DateTime::createFromFormat('!m', $i);   version 5.0 or greater
			  ?>
                <tr <?=(date("m")== $i)?' class="info"':'';?>>
                   <td><?=$mn?></td>	    <!-- $dt->format("F");    -->
                   <td><?=(array_key_exists($i, $last))?money($last[$i]):money(0);?></td>	
                   <td><?=(array_key_exists($i, $current))?money($current[$i]):money(0);?></td>	
			    </tr>
			  <?php endfor;  ?>
			     <tr>
                   <td>Total</td>	
                   <td><?=money($lastTotal);?></td>	
                   <td><?=money($currentTotal);?></td>	
     			 </tr>
            </tbody>			  
		</table>		
	</div>			
				
 <!-- Inventory  -->
 <?php
   $iQuery = $db->query("select * from products where deleted = 0");
   $lowItems = array();
   while ($product=mysqli_fetch_array($iQuery) ){
	   $item = array();
	   $sizes = sizesToArray($product['sizes']);
	   foreach($sizes as $size){
		  if($size['quantity'] <= $size['threshold']) { 
	  	     $cat = get_category($product['categories']);
		     $item=array(
		         'title' => $product['title'],
		         'size' => $size['size'],
		         'quantity' => $size['quantity'],
		         'threshold' => $size['threshold'],
		         'category' => $cat['parent'] . ' ~ ' . $cat['child']		   
			  );
			  $lowItems[] = $item;
		  }
	   }
   }
   
 ?>
   <div class="col-md-8">
      <h3 class="text-center">Low Inventory</h3>
	  <table class="table table-condensed table-striped table-bordered">
	     <thead>
		    <th>Product</th>
		    <th>Category</th>			
		    <th>Size</th>			
		    <th>Quantity</th>			
		    <th>Threshold</th>			
	     </thead>
         <tbody>
		   <?php foreach($lowItems as $item):  ?>
		    <tr <?=($item['quantity'] == 0)?' class="danger"':'';?>>
               <td><?=$item['title'];?></td>
               <td><?=$item['category'];?></td>			 
               <td><?=$item['size'];?></td>			 
               <td><?=$item['quantity'];?></td>			 
               <td><?=$item['threshold'];?></td>
            </tr>	
          <?php endforeach;  ?>			
         </tbody>
	  </table> 
   </div>  
   
 </div>  
	
 <?php include 'includes/footer.php'; ?>
 