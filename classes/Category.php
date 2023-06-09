<?php
include_once '../lib/Database.php'; 
include_once '../helpers/Format.php';
?>


<?php 

class Category{

    private $db;
    private $fm;
      
    public function __construct(){
        $this->db = new Database();
        $this->fm = new Format();
    } 
    public function catInsert($catName){
        $catName = $this->fm->validation($catName);  
        $catName = $this->db->link->real_escape_string($catName); 

        if(empty($catName)){
            $message = "<span class='error'>Category field must not be empty !  </span>";
            return $message;
        }else{
            $query = "INSERT INTO tbl_category(catName) VALUES('$catName') "; 
            $result = $this->db->insert($query);

            if($result) {
               $message = "<span class='success'>Category Inserted Successfully. </span>"; 
               return $message;
            }else{
                $message = "<span class='error'>Category Not Inserted. </span>"; 
                return $message;
            } 

        }
    } 


}

?>