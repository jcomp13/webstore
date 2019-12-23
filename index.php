<?php 
   require_once 'core/init.php';
   include 'includes/head.php'; 
   include 'includes/navigation.php';
   include 'includes/headerfull.php';
   include 'includes/leftbar.php';
    
   $sql="SELECT * FROM products WHERE featured = 1";
   $featured=$db->query($sql);
?>
   <!-- top nav bar  -->
		 
			


			
		     <!-- main content   -->		
		    <div class="col-md-8">
			    <div class="row">
				    <h2 class="text-center">Special Sales</h2>

				    
					<?php while($product=mysqli_fetch_assoc($featured)) : ?>
					   <div class="col-md-3 text-center">
					   	   <h4><?php echo $product['title']; ?></h4>
						   <?php $photos = explode(',', $product['image']); ?>
						   <img src="<?php echo $photos[0]; ?>" alt="<?php echo $product['title']; ?>" class="img-thumb"/>
						   <p class="list-price text-danger">List Price<s>$<?php echo $product['list_price']; ?></s></p>
						   <p class="price">Our Price: $<?php echo $product['price']; ?></p>

						   <?php if(in_stock($product['sizes'])): ?>
						        <button type="button" class="btn btn-sm btn-success" onclick="detailsmodal(<?php echo $product['id']; ?>)">Details</button>
						   <?php  else: ?>	
						      <h5 class="text-center text-danger">Out of Stock</h5>
						   <?php endif ?>
					   </div>
					<?php endwhile; ?>   

					   
					   
					   
				</div>
			</div>			
			
<?php  
  include 'includes/rightbar.php';
  include 'includes/footer.php';  
?>  
		
