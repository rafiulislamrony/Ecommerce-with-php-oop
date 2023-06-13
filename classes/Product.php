<?php
$filepath = realpath(dirname(__FILE__));
include_once($filepath . '/../lib/Database.php');
include_once($filepath . '/../helpers/Format.php');
?>

<?php

class Product
{
    private $db;
    private $fm;

    public function __construct()
    {
        $this->db = new Database();
        $this->fm = new Format();
    }

    public function productInsert($data, $file)
    {
        $productName = $this->fm->validation($data['productName']);
        $catId = $this->fm->validation($data['catId']);
        $brandId = $this->fm->validation($data['brandId']);
        $body = $data['body'];
        $price = $this->fm->validation($data['price']);
        $type = $this->fm->validation($data['type']);

        $productName = $this->db->link->real_escape_string($productName);
        $catId = $this->db->link->real_escape_string($catId);
        $brandId = $this->db->link->real_escape_string($brandId);
        $body = $this->db->link->real_escape_string($body);
        $price = $this->db->link->real_escape_string($price);
        $type = $this->db->link->real_escape_string($type);

        $permited = array('jpg', 'jpeg', 'png', 'gif');
        $file_name = $file['image']['name'];
        $file_size = $file['image']['size'];
        $file_temp = $file['image']['tmp_name'];

        $div = explode('.', $file_name);
        $file_ext = strtolower(end($div));
        $unique_image = substr(md5(time()), 0, 10) . '.' . $file_ext;
        $uploaded_image = "upload/" . $unique_image;

        if ($productName == "" || $catId == "" || $brandId == "" || $body == "" || $price == "" || $file_name == "" || $type == "") {
            echo "<span class='error'>Field must not be empty.</span>";
        } elseif ($file_size > 1048567) {
            echo "<span class='error'>Image Size should be less then 1MB! </span>";
        } elseif (in_array($file_ext, $permited) === false) {
            echo "<span class='error'>You can upload only:-" . implode(', ', $permited) . "</span>";
        } else {
            move_uploaded_file($file_temp, $uploaded_image);
            $query = "INSERT INTO tbl_product(catId, brandId, productName, body, price, image, type) 
            VALUES('$catId','$brandId','$productName','$body', '$price','$uploaded_image', '$type')";
            $result = $this->db->insert($query);
            if ($result) {
                $message = "<span class='success'>Product Inserted Successfully. </span>";
                return $message;
            } else {
                $message = "<span class='error'>Product Not Inserted. </span>";
                return $message;
            }
        }
    }

    public function getAllProduct()
    {

        /* Alises query  */
        $query = "SELECT p.*, c.catName, b.brandName
        FROM tbl_product as p, tbl_category as c, tbl_brands as b 
        WHERE p.catId = c.catId AND p.brandId = b.brandId
        ORDER BY p.productId DESC";

        /* $query = "SELECT tbl_product.*, tbl_category.catName, tbl_brands.brandName 
        FROM tbl_product
        INNER JOIN tbl_category 
        ON tbl_product.catId = tbl_category.catId
        INNER JOIN tbl_brands 
        ON tbl_product.brandId = tbl_brands.brandId 
        ORDER BY productId DESC"; */

        $result = $this->db->select($query);
        return $result;
    }

    public function getProductById($id)
    {
        $query = "SELECT * FROM tbl_product WHERE productId='$id'";
        $result = $this->db->select($query);
        return $result;
    }

    public function productUpdate($data, $file, $id)
    {
        $productName = $this->fm->validation($data['productName']);
        $catId = $this->fm->validation($data['catId']);
        $brandId = $this->fm->validation($data['brandId']);
        $body = $data['body'];
        $price = $this->fm->validation($data['price']);
        $type = $this->fm->validation($data['type']);

        $productName = $this->db->link->real_escape_string($productName);
        $catId = $this->db->link->real_escape_string($catId);
        $brandId = $this->db->link->real_escape_string($brandId);
        $body = $this->db->link->real_escape_string($body);
        $price = $this->db->link->real_escape_string($price);
        $type = $this->db->link->real_escape_string($type);

        $permited = array('jpg', 'jpeg', 'png', 'gif');
        $file_name = $file['image']['name'];
        $file_size = $file['image']['size'];
        $file_temp = $file['image']['tmp_name'];

        $div = explode('.', $file_name);
        $file_ext = strtolower(end($div));
        $unique_image = substr(md5(time()), 0, 10) . '.' . $file_ext;
        $uploaded_image = "upload/" . $unique_image;

        if ($productName == "" || $catId == "" || $brandId == "" || $body == "" || $price == "" || $type == "") {
            $message = "<span class='error'>Field must not be empty.</span>";
            return $message;
        } else {
            if (!empty($file_name)) {
                if ($file_size > 1048567) {
                    echo "<span class='error'>Image Size should be less then 1MB! </span>";
                } elseif (in_array($file_ext, $permited) === false) {
                    echo "<span class='error'>You can upload only:-" . implode(', ', $permited) . "</span>";
                } else {

                    // Delete previous image 
                    $deloldimg = "SELECT * FROM tbl_product WHERE productId='$id'";
                    $getproductall = $this->db->select($deloldimg);
                    if ($getproductall) {
                        while ($productimge = $getproductall->fetch_assoc()) {
                            $old_image = $productimge['image'];
                            if (file_exists($old_image)) {
                                unlink($old_image);
                            }
                        }
                    }

                    move_uploaded_file($file_temp, $uploaded_image);
                    $query = "UPDATE tbl_product 
                    SET 
                    productName ='$productName',
                    catId       ='$catId',
                    brandId     ='$brandId',
                    body        ='$body',
                    price       ='$price',
                    image       ='$uploaded_image',
                    type        ='$type'
                    WHERE productId = '$id' ";

                    $result = $this->db->update($query);

                    if ($result) {
                        $message = "<span class='success'>Product Updated Successfully. </span>";
                        return $message;
                    } else {
                        $message = "<span class='error'>Product Not Updated. </span>";
                        return $message;
                    }
                }
            } else {
                $query = "UPDATE tbl_product 
                SET 
                productName ='$productName',
                catId       ='$catId',
                brandId     ='$brandId',
                body        ='$body',
                price       ='$price', 
                type        ='$type'
                WHERE productId = '$id' ";

                $result = $this->db->update($query);

                if ($result) {
                    $message = "<span class='success'>Product Updated Successfully. </span>";
                    return $message;
                } else {
                    $message = "<span class='error'>Product Not Updated. </span>";
                    return $message;
                }
            }
        }
    }

    public function delProById($id)
    {
        // Delete previous image 
        $deloldimg = "SELECT * FROM tbl_product WHERE productId='$id'";
        $getproductall = $this->db->select($deloldimg);
        if ($getproductall) {
            while ($productimge = $getproductall->fetch_assoc()) {
                $old_image = $productimge['image'];
                if (file_exists($old_image)) {
                    unlink($old_image);
                }
            }
        }

        $query = "DELETE FROM tbl_product WHERE productId='$id'";
        $result = $this->db->delete($query);

        if ($result) {
            $message = "<span class='success'>Product Deleted Successfully. </span>";
            return $message;
        } else {
            $message = "<span class='error'>Product Not Delete.</span>";
            return $message;
        }
    }
    public function getFeaturedProduct()
    {
        $query = "SELECT * FROM tbl_product WHERE type='0' ORDER BY productId DESC LIMIT 4";
        $result = $this->db->select($query);
        return $result;
    }
    public function getNewProduct()
    {
        $query = "SELECT * FROM tbl_product ORDER BY productId DESC LIMIT 4";
        $result = $this->db->select($query);
        return $result;
    }

    public function getSingleProduct($id)
    {
        $query = "SELECT p.*, c.catName, b.brandName
        FROM tbl_product as p, tbl_category as c, tbl_brands as b 
        WHERE p.catId = c.catId AND p.brandId = b.brandId AND p.productId='$id'";
        $result = $this->db->select($query);
        return $result;
    }
    public function latestFromIphone()
    {
        $query = "SELECT * FROM tbl_product WHERE brandId ='2' ORDER BY productId DESC LIMIT 1";
        $result = $this->db->select($query);
        return $result;
    }
    public function latestFromSamsung()
    {
        $query = "SELECT * FROM tbl_product WHERE brandId ='1' ORDER BY productId DESC LIMIT 1";
        $result = $this->db->select($query);
        return $result;
    }
    public function latestFromCanon()
    {
        $query = "SELECT * FROM tbl_product WHERE brandId ='4' ORDER BY productId DESC LIMIT 1";
        $result = $this->db->select($query);
        return $result;
    }
    public function latestFromAcer()
    {
        $query = "SELECT * FROM tbl_product WHERE brandId ='3' ORDER BY productId DESC LIMIT 1";
        $result = $this->db->select($query);
        return $result;
    }

    public function productByCat($id)
    {
        $query = "SELECT * FROM tbl_product WHERE catId='$id'";
        $result = $this->db->select($query);
        return $result;
    }
    public function catNameById($id)
    {
        $query = "SELECT * FROM tbl_category WHERE catId='$id'";
        $result = $this->db->select($query);
        return $result;
    }
    public function insertCompareData($productId, $customerId)
    {
        $customerId = $this->fm->validation($customerId);
        $productId = $this->fm->validation($productId); 
        $customerId = $this->db->link->real_escape_string($customerId);
        $productId = $this->db->link->real_escape_string($productId);

        $comparequery = "SELECT * FROM tbl_compare WHERE cmrId='$customerId' AND productId='$productId' "; 
        $checkresult = $this->db->select($comparequery);
        if ($checkresult) {   
            $message = "<span class='error'>Allready Added to Compare.</span>";
            return $message; 
        }

        $query = "SELECT * FROM tbl_product WHERE productId='$productId'";
        $result = $this->db->select($query)->fetch_assoc();
        if ($result) {
            $productId = $result['productId'];
            $productName = $result['productName']; 
            $price = $result['price'];
            $image = $result['image'];

            $query = "INSERT INTO tbl_compare(cmrId, productId, productName, price, image)  
                VALUES('$customerId','$productId','$productName', '$price', '$image')";

            $inserted_row = $this->db->insert($query);

            if($inserted_row){
                $message = "<span class='success'>Added to Compare.</span>";
                return $message;
            } else {
                $message = "<span class='error'>Product Not Added. </span>";
                return $message;
            }
        }
    }
}
?>