<?php
session_start();
if (isset($_SESSION["role"])) {
    $root = "http://localhost/hands-on-exam/".$_SESSION['role']."/";
	header("location: $root");
} 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once('./views/partials/head.php') ?>
    <link rel="stylesheet" href="./assets/css/style.css">
    <title>Sign In</title>
</head>
<body class="bg-success">
    <div class="container-fluid">
        <div class="container-md mx-auto">
            <div  class="row justify-content-center align-items-center">
                <div class="bg-white rounded col-10 col-sm-9 col-md-8 col-lg-7 col-xl-6 mt-5 mx-auto py-5 px-4 px-lg-5 logindiv shadow">
                    <h1 class="display-6 fw-bolder text-center mb-2">Welcome Back!</h1>
                    <h6 class="small fw-normal text-center text-dark mb-3">Enter your credentials to login.</h6>
                    <div class="form-group mb-4">
                        <label role="button" for="user">Username*</label>
                        <input id="user" name="user" type="text" class="form-control mt-2">
                    </div>
                    <div class="form-group mb-4">
                        <label role="button" for="pass">Password*</label>
                        <div class="input-group d-flex align-items-center" id="divpass">
                                <input id="pass" name="pass" type="password" class="form-control mt-2"> 
								<span role="button" toggle="#pass" class="fa fa-fw fa-eye text-success field-icon toggle-password ps-2 my-auto mt-3"></span>
						</div>
                    </div>
                    <div class="form-group mb-4">
                        <button id="loginbtn" disabled class="btn btn-success py-3 rounded-pill w-100 fw-bold text-uppercase">Login</button>
                    </div>
                    <div class="form-group">
                        <h6 class="small fw-normal text-center text-dark">Don't have an account yet? <a href="./register.php">Sign Up</a> </h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php require_once('./views/partials/footer.php'); ?>
</body>
<?php require_once('./views/partials/script.php'); ?>
<script src="./assets/js/home.js"></script>
</html>