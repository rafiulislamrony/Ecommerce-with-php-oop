<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>

<?php
include_once '../classes/Utility.php';
$utility = new Utility();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) { 
    $insertSliderImage = $utility->insertSliderImage($_FILES);  
} 

?>

<div class="grid_10">
    <div class="box round first grid">
        <h2>Add New Slider</h2>
    <div class="block">       
        <?php 
        if(isset($insertSliderImage)){
            echo $insertSliderImage; 
        }
        ?>        
         <form action="" method="POST" enctype="multipart/form-data">
            <table class="form">      
                <tr>
                    <td>
                        <label>Slider Image</label>
                    </td>
                    <td>
                        <input type="file" name="sliderImage"/>
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
<?php include 'inc/footer.php';?>