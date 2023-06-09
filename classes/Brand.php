<?php
include_once '../lib/Database.php'; 
include_once '../helpers/Format.php';
?>


<?php 

class Brand{

    private $db;
    private $fm;
      
    public function __construct(){
        $this->db = new Database();
        $this->fm = new Format();
    } 

    public function brandInsert($brandName){
        $brandName = $this->fm->validation($brandName);  
        $brandName = $this->db->link->real_escape_string($brandName); 

        if(empty($brandName)){
            $message = "<span class='error'>Brand field must not be empty !  </span>";
            return $message;
        }else{
            $query = "INSERT INTO tbl_brands(brandName) VALUES('$brandName') "; 
            $result = $this->db->insert($query);

            if($result) {
               $message = "<span class='success'>Brand Inserted Successfully. </span>"; 
               return $message;
            }else{
                $message = "<span class='error'>Brand Not Inserted. </span>"; 
                return $message;
            }  
        }
    } 

    public function getAllBrand(){
        $query  = "SELECT * FROM tbl_brands ORDER BY brandId DESC";
        $result = $this->db->select($query); 
        return $result;
    }
    public function getBrandById($id){
        $query  = "SELECT * FROM tbl_brands WHERE brandId='$id'";
        $result = $this->db->select($query); 
        return $result;
    }
    public function BrandUpdate($brandName, $id){
        $brandName = $this->fm->validation($brandName);   
        $id = $this->fm->validation($id);  
        $brandName = $this->db->link->real_escape_string($brandName); 
        $id = $this->db->link->real_escape_string($id); 

        if(empty($brandName)){
            $message = "<span class='error'>Brand field must not be empty !  </span>";
            return $message;
        }else{ 
            $query = "UPDATE tbl_brands SET brandName = '$brandName' WHERE brandId ='$id'"; 
            $result = $this->db->update($query);
             
            if($result){
               $message = "<span class='success'>Brand Updated Successfully. </span>"; 
               return $message;
            }else{
                $message = "<span class='error'>Brand Not Updated.</span>";  
                return $message;
            }
        } 
    }
    
    public function delBrandById($id){
        $query  = "DELETE FROM tbl_brands WHERE brandId='$id'"; 
        $result = $this->db->delete($query);
           
        if($result){
            $message ="<span class='success'>Brand Deleted Successfully. </span>"; 
            return $message;
         }else{ 
             $message ="<span class='error'>Brand Not Delete.</span>";  
             return $message;
         }
    }

}

?>