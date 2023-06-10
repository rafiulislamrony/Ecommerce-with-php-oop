<?php include 'inc/header.php' ?>
<?php
 
if (!isset($_GET['proid']) || $_GET['proid'] == NULL) {
	echo "<script>window.location = '404.php';</script>";
} else {
	$id = preg_replace('/[^-a-zA-Z0-9]/', '', $_GET['proid']);
}

// if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//     $brandName = $_POST['brandName']; 
//     $updateBrand = $brand->BrandUpdate($brandName, $id);
// }
?>
<div class="main">
	<div class="content">
		<div class="section group">
			<div class="cont-desc span_1_of_2">
				<?php
				$getPd = $pd->getSingleProduct($id);
				if ($getPd) {
					while ($result = $getPd->fetch_assoc()) { ?>

						<div class="grid images_3_of_2">
							<img src="admin/<?php echo $result['image'];?>" alt="" />
						</div>
						<div class="desc span_3_of_2">
							<h2><?php echo $result['productName'];?> </h2> 
							<div class="price">
								<p>Price: <span>$<?php echo $result['price'];?></span></p>
								<p>Category: <span><?php echo $result['catName'];?></span></p>
								<p>Brand:<span><?php echo $result['brandName'];?></span></p>
							</div>
							<div class="add-cart">
								<form action="cart.html" method="post">
									<input type="number" class="buyfield" name="" value="1" />
									<input type="submit" class="buysubmit" name="submit" value="Buy Now" />
								</form>
							</div>
						</div>
						<div class="product-desc">
							<h2>Product Details</h2>
							<?php echo $result['body'];?>  
						</div>

					<?php }
				} ?>
			</div>
			<div class="rightsidebar span_3_of_1">
				<h2>CATEGORIES</h2>
				<ul>
					<li><a href="productbycat.html">Mobile Phones</a></li>
					<li><a href="productbycat.html">Desktop</a></li>
					<li><a href="productbycat.html">Laptop</a></li>
					<li><a href="productbycat.html">Accessories</a></li>
					<li><a href="productbycat.html#">Software</a></li>
					<li><a href="productbycat.html">Sports & Fitness</a></li>
					<li><a href="productbycat.html">Footwear</a></li>
					<li><a href="productbycat.html">Jewellery</a></li>
					<li><a href="productbycat.html">Clothing</a></li>
					<li><a href="productbycat.html">Home Decor & Kitchen</a></li>
					<li><a href="productbycat.html">Beauty & Healthcare</a></li>
					<li><a href="productbycat.html">Toys, Kids & Babies</a></li>
				</ul>

			</div>
		</div>
	</div>
</div>
<?php include 'inc/footer.php' ?>