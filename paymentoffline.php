<?php include 'inc/header.php' ?>
<?php
$login = Session::get("customarlogin");
if ($login == false) {
    header("Location:login.php");
}
?>

<div class="main">
    <div class="content">
        <div class="section-group " style="display: flex;">
            <div class="division">
                <table class="tblone">
                    <tr>
                        <th>SL No.</th>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Total Price</th>
                    </tr>
                    <?php
                    $getPro = $ct->getCartProduct();
                    if ($getPro) {
                        $i = 0;
                        $sum = 0;
                        $qty = 0;
                        while ($result = $getPro->fetch_assoc()) {
                            $i++; ?>
                            <tr>
                                <td>
                                    <?php echo $i; ?>
                                </td>
                                <td>
                                    <?php echo $result['productName']; ?>
                                </td>
                                <td>$
                                    <?php echo $result['price']; ?>
                                    X
                                    <?php echo $result['quantity']; ?>
                                </td>
                                <td>
                                    <?php
                                    $total = $result['price'] * $result['quantity'];
                                    echo $total;
                                    ?>
                                </td>
                            </tr>
                            <?php
                            $qty = $qty + $result['quantity'];
                            $sum = $sum + $total;
                            ?>
                        <?php }
                    }
                    ?>
                </table>

                <table class="tbltwo">
                    <tr>
                        <th>Sub Total </th>
                        <th> : </th>
                        <td>$
                            <?php
                            if (isset($sum)) {
                                echo $sum;
                            } else {
                                echo "0.00";
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <th>VAT </th>
                        <th> : </th>
                        <td>$10% ($
                            <?php echo $vat = $sum * 0.1; ?>)
                        </td>
                    </tr>
                    <tr>
                        <th>Quantity </th>
                        <th> : </th>
                        <td>
                            <?php echo $qty; ?> Item
                        </td>
                    </tr>
                    <tr>
                        <th>Grand Total</th>
                        <th> :</th>
                        <td>
                            $
                            <?php
                            if (isset($sum)) {
                                $vat = $sum * 0.1;
                                $gtotal = $sum + $vat;
                                echo $gtotal;
                            } else {
                                echo "0.00";
                            }
                            ?>
                        </td>
                    </tr>
                </table>
            
            </div>

            <div class="division">

                <?php
                $id = Session::get('customerId');
                $getData = $cmr->getCustomerData($id);
                if ($getData) {
                    while ($result = $getData->fetch_assoc()) { ?>
                        <table class="tblone">

                            <tr>
                                <td colspan="3">
                                    <h2>Your Profile Details</h2>
                                </td>
                            </tr>
                            <tr>
                                <td width="20%">Name</td>
                                <td width="5%">:</td>
                                <td>
                                    <?php echo $result['name']; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td>:</td>
                                <td>
                                    <?php echo $result['email']; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Phone</td>
                                <td>:</td>
                                <td>
                                    <?php echo $result['phone']; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Address</td>
                                <td>:</td>
                                <td>
                                    <?php echo $result['address']; ?>
                                </td>
                            </tr>
                            <tr>
                                <td> City</td>
                                <td>:</td>
                                <td>
                                    <?php echo $result['city']; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Zip Code</td>
                                <td>:</td>
                                <td>
                                    <?php echo $result['zip']; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Country</td>
                                <td>:</td>
                                <td>
                                    <?php echo $result['country']; ?>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td> <a href="editprofile.php">Update Profile</a> </td>
                            </tr>
                        </table>
                    <?php }
                } ?>

            </div>

        </div>
        <div class="back">
           <a href="payment.php">Previous</a> 
           <a href="payment.php">Order</a> 
          
        </div>

    </div>
</div>

<style>
     .back{
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .back a {
        background: #555;
        color: #fff;
        font-size: 22px;
        padding: 8px 30px;
        border-radius: 5px;
        display: inline-block; 
        margin-top: 20px;
        transition: 0.2s ease-in;
        margin: 10px;
    } 

    .back a:hover {
        background: #7d7676; 
    }
    .tblone {
        max-width: 700px;
        margin: 0px auto;
        border: 2px solid #ddd;
    }

    .tblone td {
        text-align: justify;
    }

    .division {
        width: 50%;
    }

    .tbltwo td,
    .tblone th {
        text-align: justify;
    }

    .tbltwo td,
    .tbltwo th {
        padding: 7px 10px;
    }

    .tbltwo {
        float: right;
        text-align: left;
        margin-top: 20px !important;
        width: 60%;
        border: 2px solid #ddd;
        margin-top: 12px;
        margin-right: 14px;

    }
</style>


<?php include 'inc/footer.php' ?>