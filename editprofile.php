<?php include 'inc/header.php' ?>
<?php
$login = Session::get("customarlogin");
if ($login == false) {
    header("Location:login.php");
}
?>
<?php 
 $cmrId = Session::get("customerId"); 
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
    $updateCustomer = $cmr->customerUpdate($_POST, $cmrId); 
}   
?>



<style>
    .tblone {
        max-width: 700px;
        margin: 0px auto;
        border: 2px solid #ddd;
    }

    .tblone td {
        text-align: justify;
    }

    .tblone input {
        width: 400px;
        padding: 5px;
        font-size: 15px;
    }

    .tblone input.button {
        width: unset;
        padding: 10px 25px !important;
        font-size: 15px !important;
    }
</style>

<div class="main">
    <div class="content">
        <div class="section-group">
            <?php
            $id = Session::get('customerId');
            $getData = $cmr->getCustomerData($id);
            if ($getData) {
                while ($result = $getData->fetch_assoc()) { ?>
                    <form action="" method="POST">
                        <table class="tblone">
                            <?php
                            if (isset($updateCustomer)) { 
                                echo $updateCustomer; 
                            }
                            ?>
                            <tr>
                                <td colspan="2">
                                    <h2>Update Profile Details</h2>
                                </td>
                            </tr>
                            <tr>
                                <td width="20%">Name</td>
                                <td>
                                    <input type="text" name="name" value=" <?php echo $result['name']; ?>">
                                </td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td>
                                    <input type="email" name="email" value=" <?php echo $result['email']; ?>">
                                </td>
                            </tr>
                            <tr>
                                <td>Phone</td>
                                <td>
                                    <input type="text" name="phone" value=" <?php echo $result['phone']; ?>">
                                </td>
                            </tr>
                            <tr>
                                <td>Address</td>
                                <td>
                                    <input type="text" name="address" value=" <?php echo $result['address']; ?>">
                                </td>
                            </tr>
                            <tr>
                                <td> City</td>
                                <td>
                                    <input type="text" name="city" value=" <?php echo $result['city']; ?>">
                                </td>
                            </tr>
                            <tr>
                                <td>Zip Code</td>
                                <td>
                                    <input type="text" name="zip" value=" <?php echo $result['zip']; ?>">
                                </td>
                            </tr>
                            <tr>
                                <td>Country</td>
                                <td>
                                    <input type="text" name="country" value=" <?php echo $result['country']; ?>">
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td> <input class="button" name="submit" type="submit" value="Save"> </td>
                            </tr>
                        </table>
                    </form>
                <?php }
            } ?>
        </div>
    </div>
</div>
<?php include 'inc/footer.php' ?>