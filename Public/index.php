<?php
	require_once 'core/init.php';
	include 'includes/head.php';
	include 'includes/navagation.php';
	include 'includes/headerfull.php';
	include 'includes/leftbar.php';
	?>
			<!--main content -->
			<div class="col-md-8"> 
				<div class="row">
					<h2 class="text-center">Featured Products</h2>
					<div class="col-sm-3 text-center">
						<h4>GTA5</h4>
						<img src="img/gta5.png" alt="GTA5" class="img-thumb"/>
						<p class="list-price text-danger"> List Price <s>$59.99</s></p>
						<p class="price">Our Price $34.99</p>
						<button type = "button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#details-1">
						Details</button>
					</div>
					<div class="col-sm-3 text-center"> 
					<h4>PS4</h4>
					<img src="img/PS4.jpg" alt="PS4" class="img-thumb"/>
					<p class="list-price text-danger"> List Price <s>$59.99</s></p>
					<p class="price">Our Price $34.99</p>
					<button type = "button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#details-1">
					Details</button>
				</div>
				
				<div class="col-sm-3 text-center"> 
					<h4>WiiU</h4>
					<img src="img/WiiU.png" alt="WiiU" class="img-thumb" />
					<p class="list-price text-danger"> List Price <s>$175.00</s></p>
					<p class="price">Our Price $95.00</p>
					<button type = "button" class="btn btn-sm btn-success" data-toggle="modal" data-target="details-1">
					Details</button>
				</div>
				
				<div class="col-sm-3 text-center"> 
					<h4>PlaystationVR</h4>
					<img src="img/VR.jpg" alt="PlaystationVR" class="img-thumb"/>
					<p class="list-price text-danger"> List Price <s>$200.00</s></p>
					<p class="price">Our Price $100.00</p>
					<button type = "button" class="btn btn-sm btn-success" data-toggle="modal" data-target="details-1">
					Details</button>
				</div>
				
				<div class="col-sm-3 text-center"> 
					<h4>xboxOne</h4>
					<img src="img/xbox1.png" alt="xboxOne" class="img-thumb"/>
					<p class="list-price text-danger"> List Price <s>$250.00</s></p>
					<p class="price">Our Price $185.00</p>
					<button type = "button" class="btn btn-sm btn-success" data-toggle="modal" data-target="details-1">
					Details</button>
				</div>
				
				<div class="col-sm-3 text-center"> 
					<h4>switch</h4>
					<img src="img/switch.png" alt="switch" class="img-thumb"/>
					<p class="list-price text-danger"> List Price <s>$300.00</s></p>
					<p class="price">Our Price $200.00</p>
					<button type = "button" class="btn btn-sm btn-success" data-toggle="modal" data-target="details-1">
					Details</button>
				</div>
				
				<<div class="col-sm-3 text-center"> 
					<h4>gamecube</h4>
					<img src="img/gamecube1.png" alt="gamecube" class="img-thumb"/>
					<p class="list-price text-danger"> List Price <s>$100.00</s></p>
					<p class="price">Our Price $50.00</p>
					<button type = "button" class="btn btn-sm btn-success" data-toggle="modal" data-target="details-1">
					Details</button>
				</div>
				
				<div class="col-sm-3 text-center"> 
					<h4>Asus</h4>
					<img src="img/Asus.png" alt="Asus" class="img-thumb"/>
					<p class="list-price text-danger"> List Price <s>$500.00</s></p>
					<p class="price">Our Price $300.00</p>
					<button type = "button" class="btn btn-sm btn-success" data-toggle="modal" data-target="details-1">
					Details</button>
				</div>
			</div>
		</div>
		
		<?php
        include 'includes/detailmodal.php';
		include 'includes/rightbar.php';
		include 'includes/footer.php';
		
?>