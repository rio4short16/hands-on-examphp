<?php
session_start();
if (isset($_SESSION["role"])) {
	if ($_SESSION["role"] != "user") {
		header("location: ../index.php");
	}
} else {
	header("location: ../index.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<?php require_once('../views/partials/head.php') ?>
    <link rel="stylesheet" href="../assets/css/style.css">
	<title>User | Dashboard</title>
</head>
<body>
<div class="admin-section">
	<div class="d-flex justify-content-start">
		<?php require_once('./sidenav.php'); ?>
		<div class="main-container bg-light container-md pt-5">
			<h1 id="page-title" class="container-title display-6 fs-3 fw-normal text-center">HOME PAGE</h1>
            <section id="section-container" class="px-md-5">

			</section>
		</div>
	</div>
</div>
</body>
<?php require_once('../views/partials/script.php'); ?>
<script src="../assets/js/user/page.js"></script>
</html>