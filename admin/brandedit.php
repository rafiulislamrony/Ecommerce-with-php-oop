<?php include 'inc/header.php'; ?>
<?php include 'inc/sidebar.php'; ?>
<?php
include_once '../classes/Brand.php';
$brand = new Brand();

if (!isset($_GET['brandid']) || $_GET['brandid'] == NULL) {
    echo "<script>window.location = 'brandlist.php';</script>";
} else {
    $id = preg_replace('/[^-a-zA-Z0-9]/', '', $_GET['brandid']);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $brandName = $_POST['brandName']; 
    $updateBrand = $brand->BrandUpdate($brandName, $id);
}
?>

<div class="grid_10">
    <div class="box round first grid">
        <h2>Edit Brand</h2>
        <div class="block copyblock">
            <?php
            if (isset($updateBrand)) {
                echo $updateBrand;
            }

            $getBrand = $brand->getBrandById($id);
            if ($getBrand) {
                while ($result = $getBrand->fetch_assoc()) { ?>
                    <form action="" method="POST">
                        <table class="form">
                            <tr>
                                <td>
                                    <input type="text" name="brandName" value="<?php echo $result['brandName']?>" class="medium" />
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="submit" name="submit" Value="Save" />
                                </td>
                            </tr>
                        </table>
                    </form>
                <?php }
            } ?>
        </div>
    </div>
</div>
<?php include 'inc/footer.php'; ?>