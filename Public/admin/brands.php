<?php 
	require_once '../core/init.php';
	include 'includes/head.php';
	include 'includes/navagation.php';
	//get systems from database
	$sql = "SELECT * From brand ORDER BY brand ";
	$results = $db->query($sql);
?>
<h2 class="text-center">Systems</h2>
<table class="table table-bordered table-striped table-auto">
	<thead>
		<th></th><th>Systems</th><th></th>
		</thead>
	<tbody>
	<?php while($brand = mysqli_fetch_assoc($results)): ?>
		<tr>
			<td><a href="brands.php?edit=<?=$brand['id']; ?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-pencil"></span></a></td>
			<td><?php echo $brand['brand'];?></td>
			<td><a href="brands.php?delete=<?=$brand['id']; ?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-remove-sign"></span></a></td>
			</tr>
			<?php endwhile; ?>
		</tbody>
	</table>
<?php include 'includes/footer.php';?>