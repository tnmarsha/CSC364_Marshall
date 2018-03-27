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
		</script>
	</body>
</html>