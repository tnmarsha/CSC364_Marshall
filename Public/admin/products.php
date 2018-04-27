<?php
    require_once '../core/init.php';
    include 'includes/head.php';
	include 'includes/navagation.php';
	
	//Delete product
	if(isset($_GET['delete'])){
		$id = sanitize($_GET['delete']);
		$db->query("UPDATE products SET deleted = 1 WHERE id = '$id'");
		header('Location: products.php');
		}
	$dbpath = '';
	if(isset($_GET['add']) || isset($_GET['edit'])){
	$brandquery= $db->query ("SELECT * FROM brand ORDER BY brand");
	$parentQuery = $db->query("SELECT * FROM categories WHERE parent = 0 ORDER BY category ");
	$title = ((isset($_POST['title']) && $_POST['title'] != '')?sanitize($_POST['title']):'');
	$brand = ((isset($_POST['brand']) && !empty($_POST['brand']))?sanitize($_POST['brand']): '');
	$parent = ((isset($_POST['parent']) && !empty($_POST['parent']))?sanitize($_POST['parent']): '');
	$category = ((isset($_POST['child'])) && !empty($_POST['child'])?sanitize($_POST['child']): '');
	$price = ((isset($_POST['price']) && $_POST['price'] != '')?sanitize($_POST['price']):'');
	$list_price = ((isset($_POST['list_price']) && $_POST['list_price'] != '')?sanitize($_POST['list_price']):'');
    $description = ((isset($_POST['description']) && $_POST['description'] != '')?sanitize($_POST['description']):'');
	$systems = ((isset($_POST['systems']) && $_POST['systems'] != '')?sanitize($_POST['systems']):'');
    $systems =rtrim($systems,',');
	$saved_image = '';
	
	if(isset($_GET['edit'])){
        $edit_id = (int)$_GET['edit'];
		$productResults = $db->query("SELECT * FROM products WHere id = '$edit_id'");
		$product = mysqli_fetch_assoc($productResults);
		if(isset($_GET['delete_image'])){
		$image_url = $_SERVER['DOCUMENT_ROOT'].$product['image'];echo $image_url;
			unset($image_url);
			$db->query("UPDATE products SET image = '' WHERE id= = '$edit_id'");
			header('Location: products.php?$edit='.$edit_id);
		}
		$category =((isset($_POST['child']) && $_POST['child'] != '')?sanitize($_POST['child']):$product['categories']);
		$title =((isset($_POST['title']) && !empty($_POST['title']))?sanitize($_POST['title']):$product['title']);
		$brand =((isset($_POST['brand']) && !empty($_POST['brand']))?sanitize($_POST['brand']):$product['brand']);
		$parentQ = $db->query("SELECT * FROM categories WHERE id = '$category'");
		$parentResult = mysqli_fetch_assoc($parentQ);
		$parent =((isset($_POST['parent']) && !empty($_POST['parent']))?sanitize($_POST['parent']):$parentResult['parent']);
		$price =((isset($_POST['price']) && !empty($_POST['price']))?sanitize($_POST['price']):$product['price']);
		$list_price =((isset($_POST['list_price']) && !empty($_POST['list_price']))?sanitize($_POST['list_price']):$product['list_price']);
		$description =((isset($_POST['description']) && !empty($_POST['description']))?sanitize($_POST['description']):$product['description']);
		$systems =((isset($_POST['systems']) && !empty($_POST['systems']))?sanitize($_POST['systems']):$product['systems']);
        $systems =rtrim($systems,',');
		$saved_image = (($product['image'] != '')?$product['image']: '');
	    $dbpath = $saved_image;
	}
	

	if (!empty($systems)){
		$systemString = sanitize($systems);
		$systemString = rtrim($systemString,',');echo $systemString;
		$systemsArray = explode(',',$systemString);
		$sArray= array();
		$qArray= array();
		foreach($systemsArray as $ss){
			$s = explode(':', $ss);
			$sArray[] = $s[0];
		    $qArray[] = $s[1];
		}
	}else{$systemsArray = array();}
	
	if($_POST){
	$errors = array();
	$required = array ('title','brand','price','parent','child','systems');
	foreach($required as $field){
         if($_POST[$field] == ''){
		$errors[] = 'All Fields with and Astrisk are required.';
		break;
		}  
	}
	// print_r($_FILES);
	if (!empty($_FILES)) {
		$photo = $_FILES['photo'];
		
		$name = $photo['name'];
		$nameArray = explode('.',$name);
		$fileName = $nameArray[0];
		$fileExt = $nameArray[1];
		$mime = explode('/',$photo['type']);
		$mimeType = $mime[0];
		$mimeExt = $mime[1];
		$tmpLoc = $photo['tmp_name'];
		$fileSize = $photo['size'];
		$allowed = array('png','jpg','jpeg','gif');
		$uploadName = md5(microtime()).'.'.$fileExt;
		$uploadPath = BASEURL.'/Public/img/'.$uploadName;
		$dbpath = '/Public/img/'.$uploadName;
		}
		if(!empty($errors)){
		echo display_errors($errors);
		}else{
		//upload file and insert into database
		if(!empty($_FILES)){
		move_uploaded_file($tmpLoc,$uploadPath);
		}
		$insertSql = "INSERT INTO products (`title`,`brand`,`price`,`list_price`,`categories`,`systems`,`image`,`description`)
		VALUES ('$title','$brand','$price','$list_price','$category','$systems','$dbpath','$description')";
		if(isset($_GET['edit'])){
			$insertSql = "UPDATE products SET title = '$title', brand ='$brand', price = '$price', list_price = '$list_price', 
			categories = '$category', systems ='$systems' image = '$dbpath', description = '$description'
			WHERE id ='$edit_id'";
			}
		$db->query($insertSql);
		header('Loacation: products.php');
		}
	}
	
	?>
	<h2 class="text-center"><?=((isset($_GET['edit']))?'Edit':'Add A New');?>Product</h2><hr>
	<form action="products.php?<?=((isset($_GET['edit']))?'edit='.$edit_id: 'add=1');?>" method= "POST" enctype="multipart/form-data">
		<div class= "form-group col-md-3">
				<label for="title">Title*:</label>
				<input type="text" id="title" name="title" class="form-control"value= "<?=$title;?>">
			</div>
			<div class= "form-group col-md-3">
				<label for="brand">Brand*:</label>
				<select class="form-control" name="brand" id="brand">
					<option value=""<?=(($brand =='')?' selected':'');?>></option>
					<?php while($b = mysqli_fetch_assoc($brandquery)) :?>
					<option value="<?=$b['id'];?>"<?=(($brand == $b['id'])?' selected': '');?>><?=$b['brand'];?></option>
					<?php endwhile; ?>
				</select>
			</div>
			<!-- parent category -->
			<div class = "form-group col-md-3">
				<label for="parent">Parent Category*:</label>
				<select class="form-control" id="parent" name="parent">
					<option value=""<?=(( $parent =='')?' selected':'');?>></option>
					<?php while($p = mysqli_fetch_assoc($parentQuery)): ?>
					<option value="<?=$p['id'];?>"<?=(( $parent == $p['id'])?' selected': '');?>><?=$p['category'];?></option>
					<?php endwhile; ?>
					</select>
			</div>
			
			<!-- child category -->
			<div class = "form-group col-md-3">
				<label for="child">Child Category*:</label>
				<select id="child" name="child" class="form-control">
				</select>
			</div>
			
			<!-- Price -->
			<div class = "form-group col-md-3">
			<label for="price">Price*:</label>
			<input type="text" id= "price" name="price" class="form-control" value="<?=$price;?>">
			</div>
			<!-- list_price -->
			<div class = "form-group col-md-3">
			<label for="price">List Price*:</label>
			<input type="text" id= "list_price" name="list_price" class="form-control" value="<?=$list_price;?>">
			</div>
			
			<!-- Quantity & Sizes -->
			<div class = "form-group col-md-3">
			<label>Quantity & Systems*:</label>
			<button class = "btn btn-default form-control" onclick="jQuery('#sizesModal').modal('toggle');return false;">Quantity & Systems</button>
			</div>
			
			<!-- systems & Qty Preview -->
			<div class = "form-group col-md-3">
			<label for="systems">Systems & Qty Preview</label>
			<input type="text" class="form-control" name="systems" id= "systems" value="<?=$systems;?>" readonly>
			</div>
			
			<!-- photo -->
			<div class = "form-group col-md-6">
			<?php if($saved_image != ''): ?>
			<div class= "saved-image">
			<img src="<?=$saved_image;?>" alt="saved image"/><br>
			<a href ="products.php?delete_image=1&edit=<?=$edit_id;?>" class="text-danger"> Delete Image</a>
			</div>
			<?php else: ?>
				<label for="photo">Product Photo:</label>
				<input type="file" name="photo" id= "photo" class="form-control">
			<?php endif; ?>
			</div>
			
			<!-- description -->
			<div class = "form-group col-md-6">
			<label for="description">Description:</label>
			<textarea id= "description" class="form-control" name="description" rows="6"><?=$description;?></textarea>
			</div>
			
			<!-- ADD -->
			<div class = "form-group pull-right">
			<a href="products.php" class="btn btn-default">Cancel</a> 
			<input type="submit" value="<?=((isset($_GET['edit']))?'Edit':'Add');?> Product" class="btn btn-success">
			</div><div class="clearfix"></div>
		</form>
		
		<!-- Modal -->
<div class="modal fade" id="sizesModal" tabindex="-1" role="dialog" aria-labelledby="sizesModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
	  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title" id="sizesModalLabel">Systems & Quantity</h5>
      </div>
	   <div class="modal-body">
              <div class="container-fluid">
              <?php for($i = 1; $i <= 12; $i++): ?>
                <div class="form-group col-md-4">
                    <label for="systems<?=$i;?>">Systems:</label>
                    <input type="systems" name="systems<?=$i;?>" id="systems<?=$i;?>" value="<?=((!empty($sArray[$i-1]))?$sArray[$i-1]:'');?>" class="form-control">
                </div>
                <div class="form-group col-md-2">
                    <label for="qty<?=$i;?>">Quanitity:</label>
                    <input type="number" name="qty<?=$i;?>" id="qty<?=$i;?>" value="<?=((!empty($qArray[$i-1]))?$qArray[$i-1]:'');?>" min="0" class="form-control">
                </div>
              <?php endfor; ?>
            </div>
          </div>﻿ 
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="updateSystems();jQuery('#sizesModal').modal('toggle');return false;">Save changes</button>
      </div>
    </div>
  </div>
</div>
<?php }else{
	$sql="SELECT * FROM products WHERE deleted = 0 ";
	$presult = $db->query($sql);
    if(isset($_GET['featured'])){
	    $id = (int)$_GET['id'];
	    $featured = (int)$_GET['featured'];
	    $featuredsql="UPDATE products SET featured ='$featured' WHERE id = '$id'";
	    $db->query($featuredsql);
	    header ('Location: products.php');
    }
    ?>
	<h2 class="text-center">Products</h2>
	<a href ="products.php?add=1" class="btn btn-success pull-right" id="add-product-btn">Add Product</a><div class = "clearfix"></div>
	<hr>
    <table class="table table-bordered table-condensed table-striped">
	    <thead><th></th><th>Product</th><th>Price</th><th>Category</th><th>Featured</th><th>Sold</th></thead>
	    <tbody>
	 <!--category -->
		<?php while($product = mysqli_fetch_assoc($presult)): 
			$childID = $product['categories'];
			$catSql = "SELECT * FROM categories WHERE id= '$childID'";
			$result = $db->query($catSql);
			$child = mysqli_fetch_assoc($result);
			$parentID = $child['parent'];
			$pSql = "SELECT * FROM categories WHERE id ='$parentID'";
            $presult1 = $db->query($pSql);
			$parent = mysqli_fetch_assoc($presult1);
			$category = $parent['category'].'~'.$child['category'];
			?>
			<tr class="bg-info">
				<td>
					<a href ="products.php?edit=<?=$product['id'];?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-pencil"></span></a>
					<a href ="products.php?delete=<?=$product['id'];?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-remove-sign"></span></a>
				</td>
 				<td><?=$product['title'];?></td>
				<td><?= money($product['price']);?></td>
				<td><?=$category;?></td>
				<td><a href ="products.php?featured=<?=(($product['featured'] == 0)?'1':'0');?>& id=<?=$product['id'];?>" class="btn btn-xs btn-default">
				    <span class="glyphicon glyphicon-<?=(($product['featured'] == 1)?'minus':'plus');?>"></span>
				    </a>&nbsp <?=(($product['featured']==1)?'Featured Product' : '');?></td>
				<td>0</td> 
			</tr>
		<?php endwhile;?>
	</tbody>
</table> 
	<?php } include 'includes/footer.php';?>
	<script> 
		jQuery('document').ready(function(){
		get_child_options('<?=$category;?>');
		
		});
	</script>