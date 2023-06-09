<?php
include_once '../classes/Category.php';
$cat = new Category();

if (!isset($_GET['catid']) || $_GET['catid'] == NULL) {
    echo "<script>window.location = 'catlist.php';</script>";
} else {
    $id = $_GET['catid'];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $catName = $_POST['catName'];

    $insertCat = $cat->catInsert($catName);
}
?>


<?php include 'inc/header.php'; ?>
<?php include 'inc/sidebar.php'; ?>
<div class="grid_10">
    <div class="box round first grid">
        <h2>Edit Category</h2>
        <div class="block copyblock">
            <?php
            if (isset($insertCat)) {
                echo $insertCat;
            }

            $getCat = $cat->getCatById($id);
            if ($getCat) {
                while ($result = $getCat->fetch_assoc()) { ?>
                    <form action="catedit.php" method="POST">
                        <table class="form">
                            <tr>
                                <td>
                                    <input type="text" name="catName" value="<?php echo $result['catName']?>" class="medium" />
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