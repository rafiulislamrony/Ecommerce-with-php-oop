<?php 
include '../lib/Session.php';
Session::checkLogin(); 
include_once '../lib/Database.php'; 
include_once '../helpers/Format.php';
?>


<?php 

class Adminlogin{

    private $db;
    private $fm;
      
    public function __construct(){
        $this->db = new Database();
        $this->fm = new Format();
    }

    public function adminLogin($adminUser, $adminPass){
        $adminUser = $this->fm->validation($adminUser); 
        $adminPass = $this->fm->validation($adminPass);
      
        $adminUser = $this->db->link->real_escape_string($adminUser); 
        $adminPass = $this->db->link->real_escape_string($adminPass); 

        if(empty($adminUser) || empty($adminPass)){
            $loginmsg = "Username or Password must not be empty !";
            return $loginmsg;
        }else{
            $query = "SELECT * FROM tbl_admin WHERE adminUser='$adminUser' AND adminPass='$adminPass' ";
            $result = $this->db->select($query);

            if($result != false) {
                $value = $result->fetch_assoc();
                Session::set("adminlogin", true);
                Session::set("adminId", $value['adminId']);
                Session::set("adminUser", $value['adminUser']);
                Session::set("adminName", $value['adminName']);
                header("Location: dashbord.php");
            }else{
                $loginmsg = "Username or Password not match!";
                return $loginmsg;
            } 

        }
    }
}


?>