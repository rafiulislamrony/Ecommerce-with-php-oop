<?php include 'inc/header.php'; ?>
<?php include 'inc/sidebar.php'; ?>

<?php
include_once '../classes/Utility.php';
$utility = new Utility();

if (!isset($_GET['sliderid']) || $_GET['sliderid'] == null) {
    // header("Location:catlist.php");
    echo "<script>window.location = 'sliderlist.php';</script>";
} else {
    $sliderid = $_GET['sliderid'];
}

?>

<div class="grid_10">
    <div class="box round first grid">
        <h2>Update Slider Image</h2>
        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
            $updateSliderImage = $utility->updateSliderImage($sliderid, $_FILES);
        }

        ?>
        <?php
        if (isset($updateSliderImage)) {
            echo $updateSliderImage;
        }
        ?>
        <div class="block">
            <?php
            $getSliderById = $utility->getSliderById($sliderid);
            if ($getSliderById) {
                while ($result = $getSliderById->fetch_assoc()) { ?>

                    <form action="" method="POST" enctype="multipart/form-data">
                        <table class="form">
                            <tr>
                                <td>
                                    <label>Slider Image</label>
                                </td>
                                <td>
                                    <img src="<?php echo $result['sliderImage'] ?>" alt="" height="100px" width="150px">
                                    <br><br>
                                    <input type="file" name="sliderImage" />
                                </td>
                            </tr>

                            <tr>
                                <td></td>
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
<!-- Load TinyMCE -->
<script src="js/tiny-mce/jquery.tinymce.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function () {
        setupTinyMCE();
        setDatePicker('date-picker');
        $('input[type="checkbox"]').fancybutton();
        $('input[type="radio"]').fancybutton();
    });
</script>
<!-- Load TinyMCE -->
<?php include 'inc/footer.php'; ?>