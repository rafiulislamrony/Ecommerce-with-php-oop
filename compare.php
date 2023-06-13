<?php include 'inc/header.php' ?>
<?php
$login = Session::get("customarlogin");
if ($login == false) {
	header("Location:login.php");
}
?>
<div class="main">
	<div class="content">
		<div class="cartoption">
			<div class=" ">
				<h2>Compare Product.</h2>
				<?php
				if (isset($updateCart)) {
					echo $updateCart;
				}
				if (isset($delProduct)) {
					echo $delProduct;
				}
				?>
				<table class="tblone">
					<tr>
						<th>SL No.</th>
						<th>Product Name</th>
						<th>Price</th>
						<th>Image</th>
						<th>Action</th>
					</tr>

					<?php
					$cmrId = Session::get("customerId");
					$getPd = $pd->getComapareData($cmrId);
					if ($getPd) {
						$i = 0;
						while ($result = $getPd->fetch_assoc()) {
							$i++; ?>
							<tr>
								<td>
									<?php echo $i; ?>
								</td>
								<td>
									<?php echo $result['productName']; ?>
								</td>
								<td> $
									<?php echo $result['price']; ?>
								</td>
								<td><img src="admin/<?php echo $result['image']; ?>" alt=""
										style="width:150px; height:100px; object-fit: cover; " /></td>
								<td><a href="details.php?proid=<?php echo $result['productId']; ?>">View</a></td>
							</tr>
						<?php }
					}
					?>
				</table>
			</div>
			<div class="shopping">
				<div class="" style="text-align: center;">
					<a href="index.php"> <img src="images/shop.png" alt="" /></a>
				</div>
			</div>
		</div>
		<div class="clear"></div>
	</div>
</div>

<?php include 'inc/footer.php' ?>