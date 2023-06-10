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

    public function addToCart($quantity, $id){
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

        if($getPro) {
            $message = "Product Already Added.";
            return $message;
        } else { 
            $query = "INSERT INTO  tbl_cart(sId, productId, productName, price, quantity, image) 
            VALUES('$sId','$productId','$productName','$price', '$quantity','$image')";

            $inserted_row = $this->db->insert($query);

            if ($result) {
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
    public function updateCartQuantity($cartId, $quantity){ 
        $cartId = $this->fm->validation($cartId);  
        $quantity = $this->fm->validation($quantity);  
        $cartId = $this->db->link->real_escape_string($cartId); 
        $quantity = $this->db->link->real_escape_string($quantity);

        $query = "UPDATE tbl_cart SET quantity = '$quantity' WHERE cartId ='$cartId'"; 
        
        $result = $this->db->update($query);
         
        if($result){
           $message = "<span class='success'> Quantity Updated Successfully. </span>"; 
           return $message;
        }else{
            $message = "<span class='error'>Quantity Not Updated.</span>"; 
            return $message;
        } 
    }

    public function delProductByCart($delId){
        $delId = $this->fm->validation($delId);  
        $delId = $this->db->link->real_escape_string($delId); 
 
        $query  = "DELETE FROM tbl_cart WHERE cartId ='$delId'";  
        $result = $this->db->delete($query);
           
        if($result){ 
            echo "<script>window.location='cart.php';</script>";
         }else{ 
             $message = "<span class='error'>Product Not Delete.</span>"; 
             return $message;
         }
    }

    public function checkCartTable(){
        $sId = session_id();
        $query = "SELECT * FROM tbl_cart WHERE sId='$sId'"; 
        $result = $this->db->select($query);
        return $result; 
    }

}

?>