<?php include 'inc/header.php' ?>
<?php 
 
if(isset($_GET['detwlist'])){
    $productId = $_GET['detwlist'];
    $delWlist = $pd->delWlistData($cmrId, $productId);
}

?>
 
<div class="main">
	<div class="content">
		<div class="cartoption">
			<div class=" ">
				<h2>Wishlist Product.</h2> 
				<table class="tblone">
					<tr>
						<th>SL No.</th>
						<th>Product Name</th> 
						<th>Price</th>
                        <th>Image</th>  
						<th>Action</th>
					</tr>

					<?php 
					$checkWlist = $pd->checkWlist($cmrId); 
					if ($checkWlist) {
						$i = 0; 
						while ($result = $checkWlist->fetch_assoc()) {
							$i++; ?>
            <tr>
                <td> <?php echo $i; ?> </td>
                <td> <?php echo $result['productName']; ?> </td>
                <td> $<?php echo $result['price']; ?> </td>
                <td><img src="admin/<?php echo $result['image']; ?>" alt="" style="width:150px; height:100px; object-fit: cover; " /></td>
                <td>
                    <a href="details.php?proid=<?php echo $result['productId']; ?>">Buy Now</a>||
                    <a href="?detwlist=<?php echo $result['productId']; ?>">Remove</a>
                </td>  
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