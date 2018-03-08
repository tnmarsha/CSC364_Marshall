    <?php
    require_once 'core/init.php';
	include 'includes/head.php';
	include 'includes/navagation.php';
	include 'includes/headerfull.php';
	include 'includes/leftbar.php';
	
	$sql = "SELECT * FROM products Where featured = 1";
	$featured = $db->query($sql); 
 ?>
 <!--main content -->
 <div class="col-md-8"> 
	<div class="row">
	  <h2 class="text-center">Featured Products</h2>
	  <?php while($product = mysqli_fetch_assoc($featured)) : ?>
	  <?php var_dum($product); ?>
		<div class="col-sm-3 text-center">
	    	<h4>GTA5</h4>
			<img src="img/gta5.png" alt="GTA5" class="img-thumb"/>
			<p class="list-price text-danger"> List Price <s>$59.99</s></p>
			<p class="price">Our Price $34.99</p>
			<button type = "button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#details-1">Details</button>
		</div>
	<?php endwhile; ?>	
			</div>
		</div>
		
		<?php
        include 'includes/detailmodal.php';
		include 'includes/rightbar.php';
		include 'includes/footer.php';
		
?>