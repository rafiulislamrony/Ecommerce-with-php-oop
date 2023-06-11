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
            <div class="payment">
                <h2>Chose Payment Option</h2>
                <a href="paymentoffline.php">Cash On Delivary</a>
                <a href="paymentonline.php">Pay With Card </a> 
            </div>
            <div class="back">
                    <a href="cart.php">Previous</a>
               
             </div>


        </div>
    </div>
</div>

<style>
    .payment {
        width: 500px; 
        text-align: center;
        border: 1px solid #ddd;
        margin: 0 auto;
        padding: 100px 0px;
    }

    .payment h2 {
        border-bottom: 1px solid #ddd;
        margin-bottom: 30px;
        padding-bottom: 10px;

    }

    .payment a {
        background: red;
        color: #fff;
        font-size: 22px;
        padding: 8px 30px;
        border-radius: 5px;
        display: inline-block;
        transition: 0.2s ease-in;  
    }

    .payment a:hover {
        background: #f14848;
    }
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
    } 

    .back a:hover {
        background: #7d7676; 
    }

</style>

<?php include 'inc/footer.php' ?>