<?php
$filepath = realpath(dirname(__FILE__));
include_once($filepath . '/../lib/Database.php');
include_once($filepath . '/../helpers/Format.php');
?>

<?php
class Customer
{

    private $db;
    private $fm;

    public function __construct()
    {
        $this->db = new Database();
        $this->fm = new Format();
    }
    public function customerRegistration($data)
    {
        $name = $this->fm->validation($data['name']);
        $city = $this->fm->validation($data['city']);
        $zip = $this->fm->validation($data['zip']);
        $email = $this->fm->validation($data['email']);
        $address = $this->fm->validation($data['address']);
        $country = $this->fm->validation($data['country']);
        $phone = $this->fm->validation($data['phone']);
        $password = md5($this->fm->validation($data['password']));

        $name = $this->db->link->real_escape_string($name);
        $city = $this->db->link->real_escape_string($city);
        $zip = $this->db->link->real_escape_string($zip);
        $email = $this->db->link->real_escape_string($email);
        $address = $this->db->link->real_escape_string($address);
        $country = $this->db->link->real_escape_string($country);
        $phone = $this->db->link->real_escape_string($phone);
        $password = $this->db->link->real_escape_string($password);


        if ($name == "" || $city == "" || $zip == "" || $email == "" || $address == "" || $country == "" || $phone == "" || $password == "") {
            $message = "<span class='error'>Field must not be empty.</span>";
            return $message;
        }
        $mailquery = "SELECT * FROM tbl_customer WHERE email='$email' LIMIT 1";
        $mailCheck = $this->db->select($mailquery);
        if ($mailCheck != false) {
            $message = "<span class='error'>Email already Exist.</span>";
            return $message;
        } else {
            $query = "INSERT INTO tbl_customer(name, address, city, country, zip, phone, email, password) 
            VALUES('$name','$address','$city','$country', '$zip','$phone', '$email', '$password')";
            $result = $this->db->insert($query);
            if ($result) {
                $message = "<span class='success'>Registration Successfully. </span>";
                return $message;
            } else {
                $message = "<span class='error'>Registration Not Successful. </span>";
                return $message;
            }
        }
    }
    public function customerLogin($data)
    {
        $email = $this->fm->validation($data['email']);
        $password = $this->fm->validation(md5($data['password']));

        $email = $this->db->link->real_escape_string($email);
        $password = $this->db->link->real_escape_string($password);

        if ($email == "" || $password == "") {
            $message = "<span class='error'>Field must not be empty.</span>";
            return $message;
        } else {
            $query = "SELECT * FROM tbl_customer WHERE email='$email' AND password='$password'";
            $result = $this->db->select($query); 

            if ($result != false) {
                $value = $result->fetch_assoc();
                Session::set("customarlogin", true);
                Session::set("customerId", $value['id']);
                Session::set("customerName", $value['name']);
                header("Location:cart.php");
            } else {
                $message = "<span class='error'>Email or Password are not matched!</span>";
                return $message;
            }
        }
    }

    public function getCustomerData($id)
    {
        $query = "SELECT * FROM tbl_customer WHERE id='$id'";
        $result = $this->db->select($query);
        return $result;
    }

    public function customerUpdate($data, $customerId) 
    {  
        $name = $this->fm->validation($data['name']);
        $city = $this->fm->validation($data['city']);
        $zip = $this->fm->validation($data['zip']);
        $email = $this->fm->validation($data['email']);
        $address = $this->fm->validation($data['address']);
        $country = $this->fm->validation($data['country']);
        $phone = $this->fm->validation($data['phone']);

        $name = $this->db->link->real_escape_string($name);
        $city = $this->db->link->real_escape_string($city);
        $zip = $this->db->link->real_escape_string($zip);
        $email = $this->db->link->real_escape_string($email);
        $address = $this->db->link->real_escape_string($address);
        $country = $this->db->link->real_escape_string($country);
        $phone = $this->db->link->real_escape_string($phone);

        if ($name == "" || $city == "" || $zip == "" || $email == "" || $address == "" || $country == "" || $phone == "") {
            $message = "<span class='error'>Field must not be empty.</span>";
            return $message;
        }else {
            $query = "UPDATE tbl_customer 
            SET 
            name    = '$name',
            address = '$address',
            city    = '$city',
            country = '$country',
            zip     = '$zip',
            phone   = '$phone',
            email   = '$email'
            WHERE id ='$customerId'"; 

            $result = $this->db->update($query);
             
            if($result){
               $message = "<span class='success'>Profile Updated Successfully. </span>"; 
               return $message;
            }else{
                $message = "<span class='error'>Profile Not Updated.</span>"; 
                return $message;
            }
        }
    }


}

?>