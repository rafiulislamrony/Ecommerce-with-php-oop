<?php include 'inc/header.php' ?>

<?php
$login = Session::get("customarlogin");
if ($login == false) {
    header("Location:login.php");
}
?>

<?php
  if (isset($_GET['confirmid'])) {
    $id = $_GET['confirmid'];
    $time = $_GET['time'];
    $price = $_GET['price'];
    $confirm = $ct->productShifConfirm($id, $time, $price);
}  
?>

<div class="main">
    <div class="content">
        <div class="section-group">
            <div class="order">
                <h2>Your Order Details</h2>

                <table class="tblone">
                    <tr>
                        <th>SL No.</th>
                        <th>Product Name</th>
                        <th>Image</th>
                        <th>Quantity</th>
                        <th>Total Price</th>
                        <th>Date </th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>

                    <?php
                    $customerId = Session::get("customerId");

                    $getOrder = $ct->getOrderProduct($customerId);
                    if ($getOrder) {
                        $i = 0;
                        while ($result = $getOrder->fetch_assoc()) {
                            $i++; ?>
                            <tr>
                                <td>
                                    <?php echo $i; ?>
                                </td>
                                <td>
                                    <?php echo $result['productName']; ?>
                                </td>
                                <td><img src="admin/<?php echo $result['image']; ?>" alt="" /></td>

                                <td>
                                    <?php echo $result['quantity']; ?>
                                </td>
                                <td>
                                    $<?php echo $result['price']; ?>
                                </td>
                                <td>
                                    <?php echo $fm->formatDate($result['date']); ?>
                                </td>
                                <td>
                                    <?php
                                    if ($result['status'] == '0') {
                                        echo "Pending";
                                    } elseif($result['status'] == '1'){ ?> 
										<a href="?confirmid=<?php 
											echo $customerId; ?>&price=<?php 
											echo $result['price']; ?>&time=<?php 
											echo $result['date']; ?>">Shifted
										</a> 
                                  <?php  }else{
                                        echo "Confirm";  
                                    }
                                    ?>
                                </td>


                                <?php
                                if ($result['status'] == '2') { ?>
                                    <td>
                                        <a href="" onclick="return confirm('Are you sure to delete!')">X</a>
                                    </td>
                                <?php } else { ?>
                                    <td>
                                        <p>N/A</p>
                                    </td>
                                <?php } ?>
                            </tr>
                        <?php }
                    }
                    ?>
                </table>

            </div>
        </div>

        <div class="clear"></div>
    </div>
</div>

<?php include 'inc/footer.php' ?>