<?php 
	require_once '../core/init.php';
	include 'includes/head.php';
	include 'includes/navagation.php';
	
	$sql="SELECT * FROM categories WHERE parent = 0";
	$result = $db->query($sql);
	$errors = array();
	
	//Edit Category
	if(isset($_GET['edit']) && !empty($_GET['edit'])){
	$edit_id = (int)$_GET['edit'];
	$edit_id = sanitize($edit_id);
	$edit_sql ="SELECT * FROM categories WHERE id = '$edit_id'";
	$edit_result = $db->query($edit_sql);
	$category = mysqli_fetch_assoc($edit_result);
	
		}
	
	
	//Delete Category
	if(isset($_GET['delete']) && !empty($_GET['delete'])){
	$delete_id = (int)$_GET['delete'];
	$delete_id = sanitize($delete_id);
	$sql ="SELECT * FROM categories WHERE id= '$delete_id'";
	$result = $db->query($sql);
	$category = mysqli_fetch_assoc($result);
	if($category['parent'] == 0){
		$sql = "DELETE FROM categories WHERE parent = '$delete_id'";
		$db->query($sql);
		}
	$dsql ="DELETE FROM categories WHERE id = '$delete_id'";
	$db->query($dsql);
	header('LOCATION: categories.php');
	}
	
	//Process Form
	if(isset($_POST) && !empty($_POST)){
		$parent = sanitize($_POST['parent']);
		$category = sanitize($_POST['category']);
		$sqlform = "SELECT * FROM categories WHERE category = '$category' AND parent = '$parent'";
		$fresult = $db->query($sqlform);
		$count = mysqli_num_rows($fresult);
		// check if category is blank 
		if($category == ''){
			$errors[] .= 'The category cannot be left blank.';
		}
		
		//If Exist in database 
		if($count > 0){
		   $errors[] .= $category. ' alrady exists. Please choose a new category.';
		}	
		
		//Display Errors or Update Database
		if(!empty($errors)){
			//display errors
			$display = display_errors($errors);?>
			<script>
				jQuery('document').ready(function(){
					jQuery('#errors').html('<?=$display; ?>');
					});
				</script>
			 <?php }else{
			//update database
			$updatesql = "INSERT INTO categories (category, parent) VALUES ('$category','$parent')";
			$db->query($updatesql);
			header('location: categories.php');
			}
			
			
	} 
	?>
<h2 class="text-center">Categories</h2><hr>
<div class= "row">
	
	<!-- Form -->
	<div class="col-md-6">
		<form class="form" action="categories.php" method= "post">
			<legend>Add A Category</legend>
			<div id="errors"></div>
			<div class= "form-group">
				<label for="parent">Parent</label>
				<select class="form-control" name="parent" id="parent">
					<option value="0">Parent</option>
					<?php while($parent = mysqli_fetch_assoc($result)) :?>
					<option value="<?=$parent['id'];?>"><?=$parent['category'];?></option>
					<?php endwhile; ?>
				</select>
			</div>
			<div class = "form-group">
				<label for="category">Category</label>
				<input type="text" class="form-control" id="category" name="category">
			</div>
			<div class="form-group">
			<input type="submit" value="Add Category" class= "btn btn-success">
		</div>
		</form>	
		</div>
	
	<!-- Catergory Table -->
	<div class="col-md-6">
		<table class="table table-bordered"> 
			<thead>
				<th>Category</th><th>Parent</th><th></th>
			</thead>
			<tbody>
				<?php
					$sql="SELECT * FROM categories WHERE parent = 0";
					$result = $db->query($sql);
					while($parent = mysqli_fetch_assoc($result)): 
					$parent_id = (int)$parent['id'];
					$sql2 = "SELECT * FROM categories WHERE parent='$parent_id'";
				$cresult = $db->query($sql2);	
				?>
				<tr class="bg-primary">
				<td><?=$parent['category']?></td>
				<td>Parent</td>
				<td>
				<a href ="categories.php?edit=<?=$parent['id'];?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-pencil"></span></a>
				<a href ="categories.php?delete=<?=$parent['id'];?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-remove-sign"></span></a>
				</td>
				</tr>
				<?php while($child = mysqli_fetch_assoc($cresult)): ?>
				<tr class="bg-info">
					<td><?=$child['category']?></td>
					<td><?=$parent['category']?></td>
                    <td>
						<a href ="categories.php?edit=<?=$child['id'];?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-pencil"></span></a>
						<a href ="categories.php?delete=<?=$child['id'];?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-remove-sign"></span></a>
					</td>
				</tr>
				<?php endwhile;?>
				<?php endwhile;?>
			</tbody>
		</table>
	</div>
</div>
<?php include 'includes/footer.php';?>