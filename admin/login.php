<?php include '../classes/Adminlogin.php'; ?>
<?php include '../helpers/Format.php'; ?>
<?php include '../lib/Database.php'; ?>
<?php 
 $al = new Adminlogin(); 
 $db = new Database();  
 $fm = new Format(); 
 
 if($_SERVER['REQUEST_METHOD'] == 'POST'){
	$adminUser = $fm->validation($_POST['adminUser']); 
	$adminPass = md5($fm->validation($_POST['adminPass']));
 
	$adminUser = $db->link->real_escape_string($adminUser); 
	$adminPass = $db->link->real_escape_string($adminPass); 

	$loginChk =  $al->adminLogin($adminUser, $adminPass);
 }
 
 ?>




<!DOCTYPE html>
<head>
<meta charset="utf-8">
<title>Admin Login</title>
    <link rel="stylesheet" type="text/css" href="css/stylelogin.css" media="screen" />
</head>
<body>
<div class="container">
	<section id="content">
		<form action="login.php" method="post">
			<h1>Admin Login</h1>
			<div>
				<input type="text" placeholder="Username" required="" name="adminUser"/>
			</div>
			<div>
				<input type="password" placeholder="Password" required="" name="adminPass"/>
			</div>
			<div>
				<input type="submit" value="Log in" />
			</div>
		</form><!-- form -->
		<div class="button">
			<a href="#">Training with live project</a>
		</div><!-- button -->
	</section><!-- content -->
</div><!-- container -->
</body>
</html>