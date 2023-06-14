<?php include 'inc/header.php'; ?>
<?php include 'inc/sidebar.php'; ?>
<?php include_once '../classes/Utility.php'; ?>
<?php
$utility = new Utility();
 
if(isset($_GET['sliderdel'])){
	$id = $_GET['sliderdel'];
	$sliderdelete = $utility->sliderdel($id);
} 
?> 

<div class="grid_10">
	<div class="box round first grid">
		<h2>Slider List</h2>

		<div class="block">
			<table class="data display datatable" id="example">
				<thead>
					<tr>
						<th>No.</th>
						<th>Slider Image</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>

					<?php

					$getSlider = $utility->getSlider();

					if ($getSlider) {
						$i = 0;
						while ($result = $getSlider->fetch_assoc()) { 
							$i++;
							?> 
							<tr class="odd gradeX">
								<td><?php echo $i; ?></td> 
								<td>
									<img src="<?php echo $result['sliderImage']; ?>" height="100px" width="150px" />
								</td>

								<td>
									<a href="slideredit.php?sliderid=<?php echo $result['id']; ?>">Edit</a> ||
									<a href="?sliderdel=<?php echo $result['id']; ?>" onclick="return confirm('Are you sure to Delete!');">Delete</a>
								</td>
							</tr>

						<?php }
					}
					?>


				</tbody>
			</table>

		</div>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function () {
		setupLeftMenu();
		$('.datatable').dataTable();
		setSidebarHeight();
	});
</script>
<?php include 'inc/footer.php'; ?>