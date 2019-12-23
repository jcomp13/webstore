<?php 

 $db=mysqli_connect("localhost","root","","seakritters");
 $parentID=(int)$_POST['parentID'];
 $selected = ($_POST['selected']);
 $childQuery = $db->query("select * from categories where parent = '$parentID' order by category");
  ob_start();
  ?>
 
  <option value=""></option>
  <?php while($child=mysqli_fetch_assoc($childQuery)) : ?>
       <option value="<?=$child['id'];?>"<?=(($selected == $child['id'])?' selected':'');?>><?=$child['category'];?></option>
  <?php  endwhile; ?>
 
 
  <? echo ob_get_clean(); ?>

  
  

