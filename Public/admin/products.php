<?php
	require_once '../core/init.php';
	include 'includes/head.php';
	include 'includes/navagation.php';
	if(isset($_GET['add'])){
	$brandquery= $db->query ("SELECT * FROM brand ORDER BY brand");
	$parentQuery = $db->query("SELECT * FROM categories WHERE parent = 0 ORDER BY category ");
	if ($_POST){
		if (!empty($_POST['systems'])){
		$systemString = sanitize($_POST['systems']);
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
		}
	?>
	<h2 class="text-center">Add a New Product</h2><hr>
	<form action="products.php?add=1" method= "POST" enctype="multipart/form-data">
		<div class= "form-group col-md-3">
				<label for="title">Title*:</label>
				<input type="text" id="title" name="title" class="form-control"value= "<?=((isset($_POST['title']))?sanitize($_POST['title']):'');?>">
			</div>
			<div class= "form-group col-md-3">
				<label for="brand">Brand*:</label>
				<select class="form-control" name="brand" id="brand">
					<option value=""<?=((isset($_POST['brand']) && $_POST['brand'] =='')?' selected':'');?>></option>
					<?php while($brand = mysqli_fetch_assoc($brandquery)) :?>
					<option value="<?=$brand['id'];?>"<?=((isset($_POST['brand']) && $_POST['brand'] == $brand['id'])?' selected ': '');?>><?=$brand['brand'];?></option>
					<?php endwhile; ?>
				</select>
			</div>
			<!-- parent category -->
			<div class = "form-group col-md-3">
				<label for="parent">Parent Category*:</label>
				<select class="form-control" name="parent" id="parent">
					<option value=""<?=((isset($_POST['parent']) && $_POST['parent'] =='')?' selected':'');?>></option>
					<?php while($parent = mysqli_fetch_assoc($parentQuery)): ?>
					<option value="<?=$parent['id'];?>"<?=((isset($_POST['parent']) && $_POST['parent'] == $parent['id'])?' selected ': '');?>><?=$parent['category'];?></option>
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
			<input type="text" id= "price" name="price" class="form-control" value="<?=((isset($_POST['price']))?sanitize($_POST['price']): '');?>">
			</div>
			<!-- list_price -->
			<div class = "form-group col-md-3">
			<label for="price">List Price*:</label>
			<input type="text" id= "list_price" name="list_price" class="form-control" value="<?=((isset($_POST['list_price']))?sanitize($_POST['list_price']): '');?>">
			</div>
			
			<!-- Quantity & Sizes -->
			<div class = "form-group col-md-3">
			<label>Quantity & Systems*:</label>
			<button class = "btn btn-default form-control" onclick="jQuery('#sizesModal').modal('toggle');return false;">Quantity & Systems</button>
			</div>
			
			<!-- systems & Qty Preview -->
			<div class = "form-group col-md-3">
			<label for="systems">Systems & Qty Preview</label>
			<input type="text" class="form-control" name="systems" id= "systems" value="<?=((isset($_POST['systems']))?$_POST['systems']:'');?>" readonly>
			</div>
			<!-- photo -->
			<div class = "form-group col-md-6">
			<label for="photo">Product Photo:</label>
			<input type="file" id= "photo" class="form-control" name="photo">
			</div>
			
			<!-- discription -->
			<div class = "form-group col-md-6">
			<label for="description">Description:</label>
			<textarea id= "description" class="form-control" name="description" rows="6"><?=((isset($_POST['description']))?sanitize($_POST['description']):'');?></textarea>
			</div>
			
			<!-- ADD -->
			<div class = "form-group pull-right">
				<input type="submit" value="Add Product" class="form-control btn btn-success pull-right">
				
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
        <?php for($i=1;$i <= 12; $i++): ?>
		<div class="form-group col-md-4">
			<label for="systems<?=$i;?>">Systems:</label>
			<input type="text" name="systems<?=$i;?>" id="systems<?$i;?>" value="<?=((!empty($sArray[$i-1]))?$sArray[$i-1]:'');?>" class="form-control">
			</div>
			<div class="form-group col-md-2">
			<label for="qty<?=$i;?>">Quantity:</label>
			<input type="number" name="qty<?=$i;?>" id="qty<?$i;?>" value="<?=((!empty($qArray[$i-1]))?$qArray[$i-1]:'');?>" min="0" class="form-control">
			</div>
		<?php endfor; ?>
		</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="updateSizes();jQuery('#sizesModal').modal('toggle');return false;">Save changes</button>
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
	<thead>
	<th></th><th>Product</th><th>Price</th><th>Category</th><th>Featured</th><th>Sold</th></thead>
	<tbody>
	<!--category -->
		<?php while($product = mysqli_fetch_assoc($presult)): 
			$childID = $product['categories'];
			$catSql = "SELECT * FROM categories WHERE id= $childID";
			$result = $db->query($catSql);
			$child = mysqli_fetch_assoc($result);
			$parentID = $child['parent'];
			$pSql = "SELECT * FROM categories WHERE id ='$parentID'";
            $presult = $db->query($pSql);
			$parent = mysqli_fetch_assoc($presult);
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
					<td><?=$parent['category']?></td> 
				</tr>
		<?php endwhile;?>
	</tbody>
</table> 
		<?php } include 'includes/footer.php';?>