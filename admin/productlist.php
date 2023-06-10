<?php include 'inc/header.php'; ?>
<?php include 'inc/sidebar.php'; ?>
<?php include '../classes/Product.php'; ?> 

<?php
$pd = new Product();
$fm = new Format();
?>

<div class="grid_10">
	<div class="box round first grid">
		<h2>Product List</h2>
		<div class="block">
			<table class="data display datatable" id="example">
				<thead>
					<tr>
						<th>Sl No.</th>
						<th>Product name</th>
						<th>Category</th>
						<th>Brand</th>
						<th>Description</th>
						<th>Price</th>
						<th>Image</th>
						<th>Type</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php

					$getProduct = $pd->getAllProduct();
					if ($getProduct) {
						$i = 0;
						while ($result = $getProduct->fetch_assoc()) {
							$i++; ?>
							<tr class="odd gradeX">
								<td>
									<?php echo $i; ?>
								</td>
								<td>
									<?php echo $result['productName']; ?>
								</td>
								<td>
									<?php echo $result['catName']; ?>
								</td>
								<td>
									<?php echo $result['brandName']; ?>
								</td>
								<td>
									<?php echo $fm->textShorten($result['body'], 50); ?>
								</td>
								<td>$
									<?php echo $result['price']; ?>
								</td>
								<td> <img src="<?php echo $result['image']; ?>" style="margin-top: 20px;" height="40px" width="60px" alt=""> </td>
								<td>
									<?php
									if ($result['type'] == 0) {
										echo "Featured";
									} else {
										echo "Genarel";
									}
									?>
								</td>
								<td>
								 <a href="productedit.php?proid=<?php echo $result['productId']; ?>">Edit</a> ||
								 <a href="?delpro=<?php echo $result['productId']; ?>"
										onclick="return confirm('Are you sure to delete?')">Delete</a>
							    </td>
							</tr>
						<?php }
					} ?>

				</tbody>
			</table>


		</div>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function () {
		setupLeftMenu();
		$('.datatable').dataTable();
		setSidebarHeight();
	});
</script>
<?php include 'inc/footer.php'; ?>