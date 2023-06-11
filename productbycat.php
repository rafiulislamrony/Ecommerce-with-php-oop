<?php include 'inc/header.php' ?>
<?php
if (!isset($_GET['catId']) || $_GET['catId'] == NULL) {
	echo "<script>window.location = '404.php';</script>";
} else {
	$id = preg_replace('/[^-a-zA-Z0-9]/', '', $_GET['catId']);
}
?>
<div class="main">
	<div class="content">
		<div class="content_top">
			<div class="heading">
				<?php
				$getCatName = $pd->catNameById($id);
				if ($getCatName) {
					while ($result = $getCatName->fetch_assoc()) { ?>
						<h3>Latest from
							<?php echo $result['catName']; ?>
						</h3>
					<?php }
				}
				?> 
			</div>
			<div class="clear"></div>
		</div>
		<div class="section group" style="display: flex; flex-wrap: wrap;">
			<?php
			$productByCat = $pd->productByCat($id);
			if ($productByCat) {
				while ($result = $productByCat->fetch_assoc()) { ?>
					<div class="grid_1_of_4 images_1_of_4">
						<a href="details.php?proid=<?php echo $result['productId']; ?>"><img
								src="admin/<?php echo $result['image']; ?>" alt="" /></a>
						<h2>
							<?php echo $result['productName']; ?>
						</h2>
						<p>
							<?php echo $fm->textShorten($result['body'], 20); ?>
						</p>
						<p><span class="price">$
								<?php echo $result['price']; ?>
							</span></p>
						<div class="button"><span><a href="details.php?proid=<?php echo $result['productId']; ?>"
									class="details">Details</a></span></div>
					</div>
				<?php }
			} else {
				//echo "<p>Products of this category are not avaiable</p>";
				header("Location:404.php");
			}
			?>

		</div>
	</div>
</div>
<?php include 'inc/footer.php' ?>