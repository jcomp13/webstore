<?php
 require_once '../core/init.php';
 if (!is_logged_in()){
	 login_error_redirect();
 }
 
 include 'includes/head.php';
$user_id =$user_data['id'];
$db_hashed =$user_data['password'];

$old_password = ((isset($_POST['old_password']))?sha1(sanitize($_POST['old_password'])):'');
$password = ((isset($_POST['password']))?sanitize($_POST['password']):'');
$password = trim($password);
$confirm = ((isset($_POST['confirm']))?sanitize($_POST['confirm']):'');
$confirm = trim($confirm);

$hashed = sha1($password);
$errors=array();
  ?>
 
 <div id = "login-form">
    <div>
	    <?php
		   if($_POST){
			  // form validation 
			  if(empty($_POST['old_password']) || empty($_POST['password']) || empty($_POST['confirm'])){
				$errors[] = 'You must fill out all fields';  
			  }
			  
			  // password is more than 6 characters
			  if(strlen($password)< 6){
				  $errors[] = 'Password must be a least 6 characters';
			  }
		  
		      // if new passowrd matches confirm
			  if ($password != $confirm){
				  $errors[] = 'The new passwords do not match';
			  }
		  
	//		  if (!password_verify($password, )){   works with password_hash
	//		  }
				  
				if (strcmp($old_password, $db_hashed) != 0) {
					$errors[] = 'The old password does not match our records';
				} 
			  
			  // check for errors
			  if (!empty($errors)){
				  echo display_errors($errors);
			  } else{
				  // change password
				  $db->query("update users set password = '$hashed' where id='$user_id'");
				  $_SESSION['success_flash'] = 'Your password has been updated!';
				  header('Location: index.php');
				  
			  }
		   }
		
		?>
	
	
	</div>
	<h2 class="text-center">Change Password</h2><hr>
	<form action="change_password.php" method="post">
	   <div class="form-group">
	      <label for="old_password">Old Password:</label>
		  <input type="password" name="old_password" id="old_password" class="form-control" value="<?=$old_password;?>">
		</div>
	   <div class="form-group">
	      <label for="password">New Password:</label>
		  <input type="password" name="password" id="password" class="form-control" value="<?=$password;?>">
		</div>	
	   <div class="form-group">
	      <label for="confirm">Confirm New Password:</label>
		  <input type="password" name="confirm" id="confirm" class="form-control" value="<?=$confirm;?>">
		</div>
		<div class="form=group">
		   <a href="index.php" class="btn btn-default">Cancel</a>
		   
		   <input type="submit" value="Login" class="btn btn-primary">
		</div>
    </form>
	<p class="text-right"><a href="../index.php" alt="home">Visit Site</a></p>
</div>	
 
 <?   include 'includes/footer.php'; ?>