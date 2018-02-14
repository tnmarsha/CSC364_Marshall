<!DOCTYPE html>
<html>
	<head>
		<title> Trizzles Gaming </title>
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<link rel="stylesheet" href="css/main.css">
		<meta name="viewport" content="width=device-width, initial-scale=1,user-scalable=no">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
		<script src = "js/bootstrap.min.js"> </script>
	</head>
	<body>
		<!-- Top Nav Bar -->
		<nav class="navbar navbar-default navbar-fixed-top">
			<div class="container">
				<a href="index.php" class="navbar-brand"> Trizzles Gaming </a>
				<ul class="nav navbar-nav">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">PS4<span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li><a href="#">Games</a></li>
							<li><a href="#">Deals</a></li>
							<li><a href="#">Accessories</a></li>
						</ul>
					</li>
				</ul>
			</div>
		</nav>
		
		<!-- Header -->
		<div id="headerWrapper">
			<div id="back=flower"></div>
			<div id="logotext"></div>
			<div id="logoimage"></div>
			<div id="nremote"> </div>
		</div>
		
		<!-- //////bootstrapclass that alows everything to be responsive ///  -->
<div class="container-fluid">
	<!--left side bar -->
	<div class = "col-md-2"> Left Side Bar </div>
	
	<!--main content -->
	<div class="col-md-8"> Main 
		<div class="row">
		<h2 class="text-center">Featured Products</h2>
		<div class="col-md-3">
		<h4>GTA5</h4>
		<img src="img/gta5.png" alt="GTA5" />
		<p class="list-price text-danger"> List Price <s>$59.99</s></p>
		<p class="price">Our Price $34.99</p>
		<button type = "button" class="btn btn-sm btn-success" data-toggle="modal" data-target="details-1">
			Details</button>
		</div>
			</div>
	</div>
	
	<!--right side bar-->
	<div class="col-md-2"> Right Side Bar </div>
</div>
		
		<script> 
			jQuery(window).scroll(function(){
				var vscroll = jQuery(this).scrollTop();
				
				jQuery('#logotext').css({
					"transform" : "translate(0px, "+vscroll/2+"px)"
				});
				
				var vscroll = jQuery(this).scrollTop();
				jQuery('#logoimage').css({
					"transform" : "translate("+vscroll/5+"0x, -"+vscroll/12+"px)"
				});
				
				var vscroll = jQuery(this).scrollTop();
				jQuery('#nremote').css({
					"transform" : "translate(0px, -"+vscroll/2+"px)"
				});
			});
		</script>
	</body>
</html