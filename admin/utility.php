<?php include 'inc/header.php'; ?>
<?php include 'inc/sidebar.php'; ?>

<?php
include_once '../classes/Utility.php';
$utility = new Utility();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) { 
    $updateUtility = $utility->updateUtility($_POST, $_FILES);  
}
?>

<div class="grid_10">
    <div class="box round first grid">
        <h2>Update Site Title and Description</h2>
        <div class="block sloginblock">
            <?php 
            if(isset($updateUtility)){
                echo $updateUtility; 
            } 
            $getUtility = $utility->getUtility();
            if($getUtility){
                while($result = $getUtility->fetch_assoc()){   ?>
 
            <form action="" method="POST" enctype="multipart/form-data">
                <table class="form">
                    <tr>
                        <td>
                            <label>Website Logo</label>
                        </td>
                        <td>
                            <img src="<?php echo $result['logo']; ?>" height="70px" width="100px" alt=""> <br>  <br>
                            <input type="file" name="logo" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Copyright</label>
                        </td>
                        <td>
                            <input type="text" value="<?php echo $result['copyright']; ?>" name="copyright" class="medium" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Contact Number</label>
                        </td>
                        <td>
                            <input type="text" value="<?php echo $result['phone']; ?>" name="phone" class="medium" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Contact Email</label>
                        </td>
                        <td>
                            <input type="emil" value="<?php echo $result['email']; ?>" name="email" class="medium" />
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align: top; padding-top: 9px;">
                            <label>Our Address</label>
                        </td>
                        <td>
                            <textarea class="tinymce" name="address"> 
                            <?php echo $result['address']; ?>
                            </textarea> 
                        </td>
                    </tr>
                    <tr>
                        <td>
                        </td>
                        <td>
                            <input type="submit" name="submit" Value="Update" />
                        </td>
                    </tr>
                </table>
            </form>
            <?php }  }  ?>
        </div>
    </div>
</div>
<?php include 'inc/footer.php'; ?>

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