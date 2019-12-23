 <nav class="navbar navbar-default navbar-fixed-top">
	     <div class="container-fluid">

            <div class="navbar-header">
               <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                 <span class="icon-bar"></span>
                 <span class="icon-bar"></span>
                 <span class="icon-bar"></span>                        
               </button>

      		   <a href="/teststore/admin/index.php" class="navbar-brand">SeaKritters Admin</a>
            </div>
	    <div class="collapse navbar-collapse" id="myNavbar">		 
	           <ul class="nav navbar-nav">
				   
				   <!-- menu items  -->
				   <li><a href="index.php">Dashboard</a></li>				   
				   <li><a href="brands.php">Brands</a></li>
				   <li><a href="categories.php">Categories</a></li>	
				   <li><a href="products.php">Products</a></li>	
				   <li><a href="archive.php">Archive</a></li>
				   <?php if (has_permission('admin')):  ?>
				       <li><a href="users.php">Users</a></li>				   
				   <?php endif; ?>
				   <li class="dropdown">
				       <a href='#' class="dropdown-toggle"  data-toggle="dropdown">Hello <?=$user_data['first'];?>!
					      <span class="caret"><span>
					   </a>
					   <ul class="dropdown-menu" role="menu">
					      <li><a href="change_password.php">Change Password</a></li>
					      <li><a href="logout.php">Logout</a></li>	
                       </ul>						  
					</li>   
		<!--	       <li class="dropdown">
				      <a href="#" class="dropdown-toggle" data-toggle="dropdown">< ?php echo $parent['category'];?><span class="caret"></span></a>
					    <ul class="dropdown-menu" role="menu">

						     <li><a href="#"></a></li>

                        </ul>							 
					</li>   -->
	
                 </ul>
			</div>    <!-- collapse nav bar -->	 
         </div>
       </nav>