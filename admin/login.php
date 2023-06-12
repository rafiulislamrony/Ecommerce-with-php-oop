<?php include '../classes/Adminlogin.php'; ?>
<?php
$al = new Adminlogin();
 
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
	$loginChk = $al->adminLogin($_POST);
}
?>


<!DOCTYPE html>
<head>
	<meta charset="utf-8">
	<title>Admin Login </title>
	<link rel="stylesheet" type="text/css" href="css/stylelogin.css" media="screen" />
</head>

<body>
	<div class="container">
		<section id="content">
			<form action="" method="POST">
				<h1>Admin Login</h1>
				<span style="color:red; font-size:18px;">
					<?php
					if (isset($loginChk)) {
						echo $loginChk;
					}
					?>
				</span>
				<div>
					<input type="text" placeholder="Username" name="adminUser" />
				</div>
				<div>
					<input type="password" placeholder="Password" name="adminPass" />
				</div>
				<div>
					<input type="submit"  name="login"  value="Login" />
				</div>
			</form><!-- form -->
			<div class="button">
				<a href="#">Online Shopping Ecommerce</a>
			</div><!-- button -->
		</section><!-- content -->
	</div><!-- container -->
</body>

</html>