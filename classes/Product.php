<?php
include_once '../lib/Database.php';
include_once '../helpers/Format.php';
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


}

?>