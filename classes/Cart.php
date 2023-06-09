<?php
$filepath = realpath(dirname(__FILE__));
include_once($filepath . '/../lib/Database.php');
include_once($filepath . '/../helpers/Format.php');
?>

<?php
class Cart
{

    private $db;
    private $fm;

    public function __construct()
    {
        $this->db = new Database();
        $this->fm = new Format();
    }

    public function addToCart($quantity, $id)
    {
        $quantity = $this->fm->validation($quantity);
        $quantity = $this->db->link->real_escape_string($quantity);
        $productId = $this->db->link->real_escape_string($id);
        $sId = session_id();

        $squery = "SELECT * FROM tbl_product WHERE productId='$productId' ";
        $result = $this->db->select($squery)->fetch_assoc();
        $productName = $result['productName'];
        $price = $result['price'];
        $image = $result['image'];

        $checkquery = "SELECT * FROM tbl_cart WHERE productId='$productId' AND sId='$sId' ";
        $getPro = $this->db->select($checkquery);

        if ($getPro) {
            $message = "Product Already Added.";
            return $message;
        } else {
            $query = "INSERT INTO  tbl_cart(sId, productId, productName, price, quantity, image) 
            VALUES('$sId','$productId','$productName','$price', '$quantity','$image')";

            $inserted_row = $this->db->insert($query);

            if ($inserted_row) {
                header("Location:cart.php");
            } else {
                header("Location:404.php");
            }
        }
    }

    public function getCartProduct()
    {
        $sId = session_id();
        $query = "SELECT * FROM tbl_cart WHERE sId='$sId'";
        $result = $this->db->select($query);
        return $result;
    }
    public function updateCartQuantity($cartId, $quantity)
    {
        $cartId = $this->fm->validation($cartId);
        $quantity = $this->fm->validation($quantity);
        $cartId = $this->db->link->real_escape_string($cartId);
        $quantity = $this->db->link->real_escape_string($quantity);
        $query = "UPDATE tbl_cart SET quantity = '$quantity' WHERE cartId ='$cartId'";
        $result = $this->db->update($query);
        if ($result) {
            header("Location:cart.php");
        } else {
            $message = "<span class='error'>Quantity Not Updated.</span>";
            return $message;
        }
    }

    public function delProductByCart($delId)
    {
        $delId = $this->fm->validation($delId);
        $delId = $this->db->link->real_escape_string($delId);

        $query = "DELETE FROM tbl_cart WHERE cartId ='$delId'";
        $result = $this->db->delete($query);

        if ($result) {
            echo "<script>window.location='cart.php';</script>";
        } else {
            $message = "<span class='error'>Product Not Delete.</span>";
            return $message;
        }
    }

    public function checkCartTable()
    {
        $sId = session_id();
        $query = "SELECT * FROM tbl_cart WHERE sId='$sId'";
        $result = $this->db->select($query);
        return $result;
    }

    public function delCustomarCart()
    {
        $sId = session_id();
        $query = "DELETE FROM tbl_cart WHERE sId='$sId'";
        $this->db->delete($query);
    }

    public function orderProduct($customerId)
    {
        $sId = session_id();
        $query = "SELECT * FROM tbl_cart WHERE sId='$sId'";
        $getProduct = $this->db->select($query);

        if ($getProduct) {
            while ($result = $getProduct->fetch_assoc()) {
                $productId = $result['productId'];
                $productName = $result['productName'];
                $quantity = $result['quantity'];
                $price = $result['price'] * $quantity;
                $image = $result['image'];

                $query = "INSERT INTO  tbl_order(sId, productId, productName, quantity, price,  image) 
                VALUES('$customerId','$productId','$productName', '$quantity', '$price', '$image')";
                $inserted_row = $this->db->insert($query);
            }
        }
    }

    public function payableAmount($customerId)
    {
        $query = "SELECT price FROM tbl_order WHERE sId='$customerId' AND date=now()";
        $result = $this->db->select($query);
        return $result;
    }
    public function getOrderProduct($customerId)
    {
        $query = "SELECT * FROM tbl_order WHERE sId='$customerId' ORDER BY date DESC";
        $result = $this->db->select($query);
        return $result;
    }
    public function checkOrder($customerId)
    {
        $query = "SELECT * FROM tbl_order WHERE sId='$customerId'";
        $result = $this->db->select($query);
        return $result;
    }

    public function getAllOrderProduct()
    {
        $query = "SELECT * FROM tbl_order ORDER BY date DESC";
        $result = $this->db->select($query);
        return $result;
    }
    public function productShifted($id, $date, $price)
    {

        $id = $this->fm->validation($id);
        $date = $this->fm->validation($date);
        $price = $this->fm->validation($price);

        $id = $this->db->link->real_escape_string($id);
        $date = $this->db->link->real_escape_string($date);
        $price = $this->db->link->real_escape_string($price);


        $query = "UPDATE tbl_order SET 
            status = '1' 
            WHERE sId ='$id' AND date='$date' AND price='$price' ";
        $result = $this->db->update($query);

        if ($result) {
            $message = "<span class='success'>Updated Successfully. </span>";
            return $message;
        } else {
            $message = "<span class='error'>Not Updated.</span>";
            return $message;
        }
    }
    public function delproductShifted($id, $date, $price)
    {

        $id = $this->fm->validation($id);
        $date = $this->fm->validation($date);
        $price = $this->fm->validation($price);

        $id = $this->db->link->real_escape_string($id);
        $date = $this->db->link->real_escape_string($date);
        $price = $this->db->link->real_escape_string($price);

        $query = "DELETE FROM tbl_order WHERE sId ='$id' AND date='$date' AND price='$price' ";
        $result = $this->db->delete($query);

        if ($result) {
            $message = "<span class='success'>Data Deleted Successfully. </span>";
            return $message;
        } else {
            $message = "<span class='error'>Data Not Delete.</span>";
            return $message;
        }
    }

    public function productShifConfirm($id, $date, $price)
    {
        $id = $this->fm->validation($id);
        $date = $this->fm->validation($date);
        $price = $this->fm->validation($price);

        $id = $this->db->link->real_escape_string($id);
        $date = $this->db->link->real_escape_string($date);
        $price = $this->db->link->real_escape_string($price);


        $query = "UPDATE tbl_order SET 
            status = '2' 
            WHERE sId ='$id' AND date='$date' AND price='$price' ";
        $result = $this->db->update($query);

        if ($result) {
            $message = "<span class='success'>Updated Successfully. </span>";
            return $message;
        } else {
            $message = "<span class='error'>Not Updated.</span>";
            return $message;
        }
    }


}

?>