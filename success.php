<?php include 'inc/header.php' ?>
<?php
$login = Session::get("customarlogin");
if ($login == false) {
    header("Location:login.php");
}
?>

<div class="main">
    <div class="content">
        <div class="section-group">
            <div class="success">
                <h2>Success </h2>
                <?php
                $customerId = Session::get("customerId");
                $amount = $ct->payableAmount($customerId);
                $sum = 0;
                if ($amount) { 
                    while ($result = $amount->fetch_assoc()) {
                        $price = $result['price'];
                        $sum = $sum + $price; 
                    }
                }
                ?>
                <p>Total Payable Amount(Including Vat): $
                    <?php
                        if($sum != 0) { 
                            $vat = $sum * 0.1;
                            $total = $sum + $vat;
                            echo $total;
                        }
                    ?>
                </p>
                <p>Successfully Place Your Order.</p>
                <p>
                    Thanks for Purchase. Revice Your Order Successfully.
                    We Will contact you as soon as possible.
                    Here is your order details....... <a href="orderdetails.php">Visit Here</a>
                </p>

            </div>
            <div class="back">
                <a href="index.php">Back to Home</a>
            </div>
        </div>
    </div>
</div>

<style>
    .success p {
        color: green;
        line-height: 25px;
        font-size: 18px;
    }

    .success {
        width: 500px;
        text-align: center;
        border: 1px solid #ddd;
        margin: 0 auto;
        padding: 100px 50px;
    }

    .success h2 {
        border-bottom: 1px solid #ddd;
        margin-bottom: 30px;
        padding-bottom: 10px;

    }

    /* .success a {
        background: red;
        color: #fff;
        font-size: 22px;
        padding: 8px 30px;
        border-radius: 5px;
        display: inline-block;
        transition: 0.2s ease-in;  
    }

    .success a:hover {
        background: #f14848;
    } */
    .back {
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
    }

    .back a:hover {
        background: #7d7676;
    }
</style>

<?php include 'inc/footer.php' ?>