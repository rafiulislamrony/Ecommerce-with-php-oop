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
    public function getCatById($id){
        $query  = "SELECT * FROM tbl_category WHERE catId='$id'";
        $result = $this->db->select($query); 
        return $result;
    }
    public function catUpdate($catName, $id){
        $catName = $this->fm->validation($catName);  
        $id = $this->fm->validation($id);  
        $catName = $this->db->link->real_escape_string($catName); 
        $id = $this->db->link->real_escape_string($id); 

        if(empty($catName)){
            $message = "<span class='error'>Category field must not be empty !  </span>";
            return $message;
        }else{
            $query = "UPDATE tbl_category SET catName = '$catName' WHERE catId ='$id'"; 
            $result = $this->db->update($query);
             
            if($result){
               $message = "<span class='success'>Category Updated Successfully. </span>"; 
               return $message;
            }else{
                $message = "<span class='error'>Category Not Updated.</span>"; 
                return $message;
            }
        } 
    }
    
    public function delCatById($id){
        $query  = "DELETE FROM tbl_category WHERE catId='$id'"; 
        $result = $this->db->delete($query);
           
        if($result){
            $message = "<span class='success'>Category Deleted Successfully. </span>"; 
            return $message;
         }else{ 
             $message = "<span class='error'>Category Not Delete.</span>"; 
             return $message;
         }
    }

}

?>