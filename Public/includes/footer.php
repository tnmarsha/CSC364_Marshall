</div><br><br>
<div class="col-md-12 text-center">&copy; Copyright 2017-2018 Trizzles Gaming</div>


<!--help-->
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
	function detailsmodal(id){
		var data = {"id" : id};
		jQuery.ajax({
			url: '/Public/includes/detailmodal.php',
			method : "post",
			data : data,
			success: function(data){
				jQuery('body').append(data);
				jQuery('#details-modal').modal('toggle');
			},
			error: function(){
				alert("Something Went Wrong");
			}
		});
	}
	function update_cart(mode,edit_id,edit_system){
		var data = {"mode" : mode, "edit_id" : edit_id, "edit_system" : edit_system};
		jQuery.ajax({
		url : '/Public/admin/parsers/update_cart.php',
		method : "post",
		data : data,
		success : function(){location.reload();},
		error : function(){alert("Something went wrong.");},
		});
		
		
		}
	
	
	function add_to_cart(){
		jQuery('#modal_errors').html("");
		var size = jQuery('#system').val();
		var quantity = jQuery('#quantity').val();
		var available = jQuery('#available').val(); 
		var error = '';
		var data = jQuery('#add_product_form').serialize();
		if(system == '' || quantity == '' || quantity == 0){
			error += '<p class="text-danger text-center">You must choose a system and quantity.</p>';
			jQuery('#modal_errors').html(error);
			return;
			}else if(quantity > available){
			error += '<p class="text-danger text-center">There are only '+available+' available.</p>';
			jQuery('#modal_errors').html(error);
			}else{
			jQuery.ajax({
			url: '/Public/admin/parsers/add_cart.php',
			method: 'post',
			data : data,
			success : function(){
			location.reload();
				},
			error : function(){alert("something went wrong");}
			});
			

		}
	}
</script>
</body>
</html>