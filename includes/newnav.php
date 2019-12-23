
<?php
   $sql = "select * from categories where parent = 0";
   $pquery = $db->query($sql);
?>



<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
        <a href="index.php" class="navbar-brand">SeaKritters</a>
    </div>
	
    <div class="collapse navbar-collapse" id="myNavbar">
        <ul class="nav navbar-nav">
       <?php while($parent = mysqli_fetch_assoc($pquery)) : ?>
       <?php 
	   $parent_id = $parent['id']; 
	   $sql2 = "select * from categories where parent = '$parent_id'";
	   $cquery=$db->query($sql2);
        ?>
	<!-- menu items  -->
	   <li class="dropdown">
	     <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $parent['category'];?><span class="caret"></span></a>
	     <ul class="dropdown-menu" role="menu">
	       <?php while($child=mysqli_fetch_assoc($cquery)) : ?>
	           <li><a href="category.php?cat=<?=$child['id'];?>"><?php echo $child['category']; ?></a></li>
	       <?php endwhile; ?>	 
            </ul>							 
	  </li>
       <?php  endwhile;  ?>
      	<li><a href="cart.php"><span class="glyphicon glyphicon-shopping-cart"></span> My Cart</a></li>
        </ul>
    </div>
	
  </div>
</nav>