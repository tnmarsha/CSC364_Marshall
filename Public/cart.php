<?php
	require_once 'core/init.php';  
	include 'includes/head.php';
	include 'includes/navagation.php';
	include 'includes/headerfull.php';
	
	
	
	if($cart_id != ''){
		$cartQ = $db->query("SELECT * FROM cart WHERE id ='{$cart_id}'");
		$result = mysqli_fetch_assoc($cartQ);
		$items = json_decode($result['items'],true);var_dump($items);
		$i = 1;
		$sub_total = 0;
		$item_count = 0;
	}
?> 

<div class="col-md-12">
	<div class="row">
		<h2 class ="text-center">My Shopping Cart</h2><hr>
		<?php if($cart_id == '');?>
		<div class="bg-danger">
			<p class="text-center text-danger">
				Your shopping cart is empty!
			</p>
		</div>
		
		<table class ="table table-bordered table-condensed table-striped">
			<thead><th>#</th><th>Item</th><th>Price</th><th>Quantity</th><th>Size</th><th>Sub Total</th></head>
			<tbody>
				<?php
					foreach($items as $item){
						$product_id = $item['id'];
						$productQ = $db->query("SELECT * FROM products WHERE id = '{$product_id}'");
						$product = mysqli_fetch_assoc($productQ);
						$sArray = explode(',',$product['systems']);
						foreach($sArray as $systemString){
							$s = explode(':',$systemString);
							if($s[0] == $item['system']){
								$available = $s[1];
							}
						}
					?>
					<tr>
						<td><?=$i;?></td>
						<td><?=$product['title'];?></td>
						<td><?=money($product['price']);?></td>
						<td>
							<button class="btn btn-xs btn-default" onclick="update_cart
							('removeone','<?=$product['id'];?>','<?=$item['system'];?>');">-</button>
							<?=$item['quantity'];?>
							<?php if($item['quantity'] < $available): ?>
							<button class="btn btn-xs btn-default" onclick="update_cart
							('addone','<?=$product['id'];?>','<?=$item['system'];?>');">+</button>
							<?php else: ?>
							<span class="text-danger">Max Reached</span>
							<?php endif; ?>
						</td>
						<td><?$item['system'];?></td>
						<td><?=money($item['quantity'] = $product['price']);?></td>
					</tr>
					<?php 
						$i++;
						$item_count += $item['quantity'];
						$sub_total += ($product['price'] * $item['quantity']);
					} 
					$tax = TAXRATE * $sub_total;
					$tax = number_format($tax,2);
					$grand_total = $tax + $sub_total;
				?>
			</tbody>
		</table>
		<table class ="table table-bordered table-condensed text-right">
			<legend>Totals</legend>
			<thead class="totals-table-header"><th>Total Items</th><th>Sub Total</th><th>Tax</th><th>Grand Total</th></thead>
			<tbody>
				<tr>
					<td><?=$item_count;?></td>	
					<td><?=money($sub_total);?></td>
					<td><?=money($tax);?></td>
					<td class="bg-success"><?=money($grand_total);?></td>
				</tr>
			</tbody>
		</table>
		<!-- Check Out Button -->
		<button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#checkoutModal">
			<span class="glyphicon glyphicon-shopping-cart"</span>Check Out >>
			</button>
			
			<!-- Modal -->
			<div class="modal fade" id="checkoutModal" tabindex="-1" role="dialog" aria-labelledby="checkoutModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h5 class="modal-title" id="checkoutModalLabel">Shipping Address</h5>
						</div>
						<div class="modal-body">
							<div class="row">
								<form action="thankYou.php" method="post" id="payment-form">
									<span class="bg-danger" id="payment-errors"></span>
									<div id="step1" style="display:block;"></div>
									<div class="form-group col-md-6">
										<label for="full_name">Full Name:</label>
										<input class="form-control" id="full_name" name="full_name"type="text">
									</div>
									<div class="form-group col-md-6">
										<label for="email">Email:</label>
										<input class="form-control" id="email" name="email"type="email">
									</div>
									<div class="form-group col-md-6">
										<label for="street">Street Address:</label>
										<input class="form-control" id="street" name="street"type="text">
									</div>
									<div class="form-group col-md-6">
										<label for="street2">Street Address 2:</label>
										<input class="form-control" id="street2" name="street2"type="text">
									</div>
									<div class="form-group col-md-6">
										<label for="full_name">City:</label>
										<input class="form-control" id="city" name="city"type="text">
									</div>
									<div class="form-group col-md-6">
										<label for="full_name">State:</label>
										<input class="form-control" id="state" name="state"type="text">
									</div>
									<div class="form-group col-md-6">
										<label for="full_name">Zip Code:</label>
										<input class="form-control" id="zip_code" name="zip_code"type="text">
									</div>
								</div>
								<div class="form-group col-md-6">
							<label for="full_name">Country:</label>
						<input class="form-control" id="country" name="country"type="text">
								</div>
							</div>
							<div id="step2" style="display:none;"></div>
						</form>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary" onclick="check_address();">Next >></button>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
<script>
	function check_address(){
		var data ={
			'full_name' : jQuery('#full_name').val(),
			'email' : jQuery('#email').val(),
			'street' : jQuery('#street').val(),
			'street2' : jQuery('#street2').val(),
			'city' : jQuery('#city').val(),
			'state' : jQuery('#state').val(),
			'zip_code' : jQuery('#zip_code').val(),
			'country' : jQuery('#country').val(),
		};
		jQuery.ajax({
			url : '/Public/admin/parsers/check_address.php',
			method : 'POST',
			data : data,
			success : function(data){
			if(data != 'passed'){
			jQuery('#payment-errors').html(data);
			}
			if(data == 'passsed'){
			alert('Passed!');
			}
		},
			error : function(){alert("something went wrong");},
		});
	}
	
</script>
<?php include 'includes/footer.php'?>