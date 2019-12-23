<?php
 require_once '../core/init.php';
  if (!is_logged_in()){
	 login_error_redirect();
 }
 include 'includes/head.php';
 include 'includes/navigation.php';

 
 
  if (isset($_GET['restore'])){
	  $id = sanitize($_GET['restore']);
	  $db->query("update products set deleted=0 where id = '$id'");
	  header('Location: archive.php');
 }
   ?>
 
 
  <?php 
     $sql = "select * from products where deleted = 1";
      $presults =  $db->query($sql);
   ?>
 
 
 
  <h2 class="text-center"><?=((isset($_GET['edit']))?'Edit':'Add A New');?> Archived Products</h2><br>
 
  <table class="table table-bordered table-condensed table-striped">
    <thead>
	    <th></th>
		<th>Product</th>
		<th>Price</th>
	    <th>Category</th>	
		<th>Sold</th>
	</thead>
	
 	<tbody>
	<?php while($product = mysqli_fetch_assoc($presults)):   
        $childID = $product['categories'];
		$catSql = "select * from categories where id= '$childID'";
		$result = $db->query($catSql);
		$child = mysqli_fetch_assoc($result);
		$parentID = $child['parent'];
		$pSql = "select * from categories where id = '$parentID'";
		$presult=$db->query($pSql);
		$parent=mysqli_fetch_assoc($presult);
		$category = $parent['category'] . '~' . $child['category']
	?>
	    <tr>
		    <td>
			   <a href="archive.php?restore=<?=$product['id'];?>"  class="btn btn-xs btn-default"><span class="glyphicon glyphicon-refresh"></span></s>
			</td>
		    <td><?=$product['title'];?></td>			
		    <td><?=money($product['price']);?></td>			
		    <td><?=$category;?></td>			
		    <td>0</td>			
			
			
	    </tr>
	<?php   endwhile;   ?>
	

	</tbody>
 </table>
 
 
 
 
 <?php  include 'includes/footer.php'; ?>
 
