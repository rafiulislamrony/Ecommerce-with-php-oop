<?php include 'inc/header.php' ?>

<?php
if (isset($_GET['delpro'])) { 
	$delId = preg_replace('/[^-a-zA-Z0-9]/', '', $_GET['delpro']);
	$delProduct = $ct->delProductByCart($delId);
}
?>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$cartId = $_POST['cartId'];
	$quantity = $_POST['quantity'];
	$updateCart = $ct->updateCartQuantity($cartId, $quantity); 
	if($quantity  <= 0){
		$delProduct = $ct->delProductByCart($cartId); 
	}
}
?>

<div class="main">
	<div class="content">
		<div class="cartoption">
			<div class="cartpage">
				<h2>Your Cart</h2>
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
						<th>Image</th>
						<th>Price</th>
						<th>Quantity</th>
						<th>Total Price</th>
						<th>Action</th>
					</tr>

					<?php
					$getPro = $ct->getCartProduct();
					if ($getPro) {
						$i = 0;
						$sum = 0;
						while ($result = $getPro->fetch_assoc()) {
							$i++; ?>
							<tr>
								<td>
									<?php echo $i; ?>
								</td>
								<td>
									<?php echo $result['productName']; ?>
								</td>
								<td><img src="admin/<?php echo $result['image']; ?>" alt="" /></td>
								<td>$
									<?php echo $result['price']; ?>
									X
									<?php echo $result['quantity']; ?>
								</td>
								<td>
 
									<form action="" method="POST">
										<input type="hidden" name="cartId" value="<?php echo $result['cartId']; ?>"/>
										<input type="number" name="quantity" value="<?php echo $result['quantity']; ?>"/>
										<input type="submit" name="submit" value="Update"/>
									</form>

								</td>
								<td>
									<?php
									$total = $result['price'] * $result['quantity'];
									echo $total;
									?>
								</td>
								<td><a href="?delpro=<?php echo $result['cartId']; ?>" onclick="return confirm('Are you sure to delete!')">X</a></td>
							</tr>
							<?php
							$sum = $sum + $total;
							?>
						<?php }
					}
					?>


				</table>
				<table style="float:right;text-align:left;" width="40%">
					<tr>
						<th>Sub Total : </th>
						<td>$
							<?php 
							if(isset($sum)) {
								echo $sum; 
							}else{ 
								echo "0.00";
							}
							?>
						</td>
					</tr>
					<tr>
						<th>VAT : </th>
						<td>$10%</td>
					</tr>
					<tr>
						<th>Grand Total :</th>
						<td>
							$
							<?php
							if(isset($sum)) {
								$vat = $sum * 0.1;
								$gtotal = $sum + $vat;
								echo $gtotal;
							}else{
								echo "0.00";
							}
							?>
						</td>
					</tr>
				</table>
			</div>
			<div class="shopping">
				<div class="shopleft">
					<a href="index.html"> <img src="images/shop.png" alt="" /></a>
				</div>
				<div class="shopright">
					<a href="login.html"> <img src="images/check.png" alt="" /></a>
				</div>
			</div>
		</div>
		<div class="clear"></div>
	</div>
</div>

<?php include 'inc/footer.php' ?>