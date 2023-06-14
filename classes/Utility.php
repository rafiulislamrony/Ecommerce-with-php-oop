<?php
$filepath = realpath(dirname(__FILE__));
include_once($filepath . '/../lib/Database.php');
include_once($filepath . '/../helpers/Format.php');
?>

<?php

class Utility
{
    private $db;
    private $fm;

    public function __construct()
    {
        $this->db = new Database();
        $this->fm = new Format();
    }
    public function insertSliderImage($sliderImage)
    {
        $permited = array('jpg', 'jpeg', 'png', 'gif');
        $file_name = $sliderImage['sliderImage']['name'];
        $file_size = $sliderImage['sliderImage']['size'];
        $file_temp = $sliderImage['sliderImage']['tmp_name'];

        $div = explode('.', $file_name);
        $file_ext = strtolower(end($div));
        $unique_image = substr(md5(time()), 0, 10) . '.' . $file_ext;
        $uploaded_image = "upload/" . $unique_image;

        if ($file_name == "") {
            echo "<span class='error'>Field must not be empty.</span>";
        } elseif ($file_size > 1048567) {
            echo "<span class='error'>Image Size should be less then 1MB! </span>";
        } elseif (in_array($file_ext, $permited) === false) {
            echo "<span class='error'>You can upload only:-" . implode(', ', $permited) . "</span>";
        } else {
            move_uploaded_file($file_temp, $uploaded_image);
            $query = "INSERT INTO tbl_slider(sliderImage)  
            VALUES('$uploaded_image')";

            $result = $this->db->insert($query);
            if ($result) {
                $message = "<span class='success'>Slider Image Inserted Successfully. </span>";
                return $message;
            } else {
                $message = "<span class='error'>Slider Image Not Inserted. </span>";
                return $message;
            }
        }
    }
    public function getSlider()
    {
        $query = "SELECT * FROM tbl_slider ORDER BY id DESC";

        $result = $this->db->select($query);
        return $result;
    }
    public function getSliderById($id)
    {
        $query = "SELECT * FROM tbl_slider WHERE id='$id'";
        $result = $this->db->select($query);
        return $result;
    }
    public function updateSliderImage($id, $image) {
        $permited = array('jpg', 'jpeg', 'png', 'gif');
        $file_name = $image['sliderImage']['name'];
        $file_size = $image['sliderImage']['size'];
        $file_temp = $image['sliderImage']['tmp_name'];

        $div = explode('.', $file_name);
        $file_ext = strtolower(end($div));
        $unique_image = substr(md5(time()), 0, 10) . '.' . $file_ext;
        $uploaded_image = "upload/" . $unique_image;
        
        if (empty($file_name)) { 
            $message = "<span class='error'>Field must not be empty.</span>";
            return $message;
        }elseif ($file_size > 1048567) {
            echo "<span class='error'>Image Size should be less then 1MB! </span>";
        } elseif (in_array($file_ext, $permited) === false) {
            echo "<span class='error'>You can upload only:-" . implode(', ', $permited) . "</span>";
        } else {
            // Delete previous image 
            $deloldimg = "SELECT * FROM tbl_slider WHERE id='$id'";
            $getproductall = $this->db->select($deloldimg);
            if ($getproductall) {
                while ($productimge = $getproductall->fetch_assoc()) {
                    $old_image = $productimge['sliderImage'];
                    if (file_exists($old_image)) {
                        unlink($old_image);
                    }
                }
            }
            move_uploaded_file($file_temp, $uploaded_image); 
            $query = "UPDATE tbl_slider SET sliderImage='$uploaded_image' WHERE id='$id'";
            $result = $this->db->update($query);
            if ($result) {
                $message = "<span class='success'>Slider Updated Successfully. </span>";
                return $message;
            } else {
                $message = "<span class='error'>Slider Not Updated. </span>";
                return $message;
            }
        }


    }
    public function sliderdel($id){ 
        // Delete previous image 
        $deloldimg = "SELECT * FROM tbl_slider WHERE id='$id' ";
        $getproductall = $this->db->select($deloldimg);
        if ($getproductall) {
            while ($productimge = $getproductall->fetch_assoc()) {
                $old_image = $productimge['sliderImage'];
                if (file_exists($old_image)) {
                    unlink($old_image);
                }
            }
        }

        $query = "DELETE FROM tbl_slider WHERE id='$id'";

        $result = $this->db->delete($query);

        if ($result) {
            $message = "<span class='success'>Slider Deleted Successfully. </span>";
            return $message;
        } else {
            $message = "<span class='error'>Slider Not Delete.</span>"; 
            return $message;
        }
    }
    public function showSlider()
    {
        $query = "SELECT * FROM tbl_slider ORDER BY id DESC LIMIT 4";
    
        $result = $this->db->select($query);
        return $result;
    }
    public function updateUtility($data, $file) 
    {
        $copyright = $this->fm->validation($data['copyright']);
        $phone = $this->fm->validation($data['phone']);
        $email = $this->fm->validation($data['email']);
        $address = $data['address']; 

        $copyright = $this->db->link->real_escape_string($copyright);
        $phone = $this->db->link->real_escape_string($phone);
        $email = $this->db->link->real_escape_string($email);
        $address = $this->db->link->real_escape_string($address); 
 
        $permited = array('jpg', 'jpeg', 'png', 'gif');
        $file_name = $file['logo']['name'];
        $file_size = $file['logo']['size'];
        $file_temp = $file['logo']['tmp_name'];

        $div = explode('.', $file_name);
        $file_ext = strtolower(end($div));
        $unique_image = substr(md5(time()), 0, 10) . '.' . $file_ext;
        $uploaded_image = "upload/" . $unique_image;
  
        if (empty($copyright) || empty($phone) || empty($email) || empty($address)) {
            echo "<span class='error'>Field must not be empty.</span>";
        } elseif ($file_size > 1048567) {
            echo "<span class='error'>Image Size should be less then 1MB! </span>";
        } elseif (in_array($file_ext, $permited) === false) {
            echo "<span class='error'>You can upload only:-" . implode(', ', $permited) . "</span>";
        } else {
             // Delete previous image 
             $deloldimg = "SELECT * FROM tbl_utility WHERE id='1'";
             $getproductall = $this->db->select($deloldimg);
             if ($getproductall) {
                 while ($productimge = $getproductall->fetch_assoc()) {
                     $old_image = $productimge['logo'];
                     if (file_exists($old_image)) {
                         unlink($old_image);
                     }
                 }
             }

            move_uploaded_file($file_temp, $uploaded_image);
            $query = "UPDATE tbl_utility
            SET 
            logo='$uploaded_image',
            copyright='$copyright',
            phone='$phone',
            email='$email',
            address='$address' WHERE id='1'";  

            $result = $this->db->insert($query);
            if ($result) {
                $message = "<span class='success'>Data Updated Successfully. </span>";
                return $message;
            } else {
                $message = "<span class='error'>Data Not Updated. </span>";
                return $message;
            }
        }
    }
    public function getUtility()
    {
        $query = "SELECT * FROM tbl_utility WHERE id='1'";
        $result = $this->db->select($query);
        return $result;
    }

    public function insertContact($data){

        $name = $this->fm->validation($data['name']); 
        $email = $this->fm->validation($data['email']);
        $phone = $this->fm->validation($data['phone']);
        $body = $data['body'];
    
        $name = $this->db->link->real_escape_string($name);
        $email = $this->db->link->real_escape_string($email);
        $phone = $this->db->link->real_escape_string($phone);
        $body = $this->db->link->real_escape_string($body); 
 
        if(empty($name)){
            $message = "<span style='color:red;'>Name Must Not be Empty.</span>";
            return $message;
        }elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){ 
            $message = "<span style='color:red;'>Invalide Email Address.</span>";
            return $message;
        }elseif(empty($phone)){ 
            $message = "<span style='color:red;'>Phone Number Must Not be Empty.</span>";
            return $message;
        }elseif(empty($body)){ 
            $message = "<span style='color:red;'>Message Must Not be Empty.</span>";
            return $message;
        }else{
            $query = "INSERT INTO tbl_contact (name, email, phone, body) VALUES ('$name', '$email','$phone','$body')";
            $result = $this->db->insert($query); 
            if ($result) { 
                $message = "<span style='color:green;'>Message Send successfully.</span>";
                return $message;
            } else { 
                $message = "<span style='color:red;'>Message Not Send.</span>"; 
                return $message;
            }
        }
    } 
    
}
?>