<?php
session_start();
if (isset($_SESSION["role"])) {
	if ($_SESSION["role"] != "admin") {
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
    
	<title>Admin | Users</title>

    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<div class="admin-section">
	<div class="d-flex justify-content-start">
		<?php require_once('./sidenav.php'); ?>
		<div class="main-container container-md pt-5">
			<h1 class="container-title display-6 fs-3 fw-normal text-center">USERS</h1>
            <div class="table-wrapper mt-3 mt-md-4">
					<div id="table-container" class="table-users">
						<table id="user-table" align="center" class="table table-striped table-hover">
								<thead text-center">
									<tr class="table-header">
										<td class="d-none">#</td>
                                        <td class="d-none">userID</td>
										<td>Username</td>
										<td>First Name</td>
										<td>Last Name</td>
										<td>Email Address</td>
										<td>Date Registered</td>
									</tr>
								</thead>
								<tbody id="table-body" class="table-body table-hover">
									<tr>
										<td colspan="4" rowspan="5">NO USERS FOUND</td> 
									</tr>
								</tbody>
						</table>
					</div>
				</div>
		</div>
	</div>
</body>
<?php require_once('../views/partials/script.php'); ?>
</div>
<script src="../assets/js/admin/user.js"></script>
</html>