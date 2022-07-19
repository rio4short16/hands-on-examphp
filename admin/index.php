<?php
session_start();
if (isset($_SESSION["role"])) {
	if ($_SESSION["role"] != "admin") {
		header("location: ../index.php");
	}
} else {
	header("location: ../index.php");
}
include_once('../db/database.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<?php require_once('../views/partials/head.php') ?>
    <link rel="stylesheet" href="../assets/css/style.css">
	<title>Admin | Dashboard</title>
</head>
<body>
<div class="admin-section">
	<div class="d-flex justify-content-start">
		<?php 
		require_once('./sidenav.php'); 
		$totalUsers = $pdo->query("SELECT COUNT(*) FROM tblusers")->fetch();
		$totalActiveUsers = $pdo->query("SELECT COUNT(*) FROM tblusers WHERE status = 'active'")->fetch();
		$totalPages = $pdo->query("SELECT COUNT(*) FROM tblpages")->fetch();
		$totalPublishedPages = $pdo->query("SELECT COUNT(*) FROM tblpages WHERE status = 1")->fetch();
		// echo "Total Users: ".$totalUsers[0];
		// echo "Total Active Users: ".$totalActiveUsers[0];
		// echo "Total Pages: ".$totalPages[0];
		// echo "Published Pages: ".$totalPublishedPages[0];
		
		?>
		<div class="main-container pt-5">
			<h1 class="container-title display-6 fs-3 fw-normal text-center">DASHBOARD</h1>
			<section class="px-md-5">
			<div class="container bg-white shadow px-md-5 py-4 py-md-5">
				<div class="row justify-content-evenly align-items-center">
					<div class="col-5 text-center">
						<p class="mb-1 fw-bold fs-3"><?= $totalUsers[0]; ?></p>
						<h6 class="text-muted fw-normal small text-uppercase">Total Users</h6>
					</div>
					<div class="col-5 text-center">
						<p class="mb-1 fw-bold fs-3"><?= $totalActiveUsers[0]; ?></p>
						<h6 class="text-muted fw-normal small text-uppercase">Active Users</h6>
					</div>
				</div>
				<div class="row justify-content-evenly align-items-center mt-4 mt-md-5">
					<div class="col-5 text-center">
						<p class="mb-1 fw-bold fs-3"><?= $totalPages[0]; ?></p>
						<h6 class="text-muted fw-normal small text-uppercase">Total Pages</h6>
					</div>
					<div class="col-5 text-center">
						<p class="mb-1 fw-bold fs-3"><?= $totalPublishedPages[0]; ?></p>
						<h6 class="text-muted fw-normal small text-uppercase">Published Pages</h6>
					</div>
				</div>
          	</div>
			</section>
		</div>
	</div>
</div>
</body>
<?php require_once('../views/partials/script.php'); ?>
</html>