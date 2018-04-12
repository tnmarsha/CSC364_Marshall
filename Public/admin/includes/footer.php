</div><br><br>
<div class="col-md-12 text-center">&copy; Copyright 2017-2018 Trizzles Gaming</div>
	<script>
	function updateSizes(){
		var systemString = '';
		alert('#')
		for(var i=1;i<=12;i++){
			if(jQuery('#systems'+i).val() !=''){
				systemString += jQuery('#systems'+i).val()+':'+jQuery('#qty'+i).val()+',';
				}
			}
			
			jQuery('#systems').val(systemString);
		}
	
	function get_child_options(){
		var parentID = jQuery('#parent').val();
		jQuery.ajax({
			url: '/Public/admin/parsers/child_categories.php',
			type: 'POST',
			data: {parentID : parentID},
			success: function(data){
				jQuery('#child').html(data);
		},
		error: function(){alert("Something went wrong with the child options.")},
			});
		}
		jQuery('select[name="parent"]').change(get_child_options);
		</script>
	</body>
</html>