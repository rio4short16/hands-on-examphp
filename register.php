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
    <title>Sign Up</title>
</head>
<body class="bg-success">
    <div class="container-fluid">
        <div class="container-md mx-auto">
            <div  class="row justify-content-center align-items-center">
                <div class="bg-white rounded col-10 col-sm-9 col-md-8 col-lg-7 col-xl-6 mt-4 mx-auto py-5 px-4 px-lg-5 shadow regdiv">
                    <h1 class="display-6 fw-bolder text-center mb-2">Hello, Friend!</h1>
                    <h6 class="small fw-normal text-center text-dark mb-3">Enter your details to register.</h6>
                    <div class="form-group mb-3">
                        <label role="button" for="fname">First Name*</label>
                        <input id="fname" name="fname" type="text" class="form-control mt-2">
                    </div>
                    <div class="form-group mb-3">
                        <label role="button" for="lname">Last Name*</label>
                        <input id="lname" name="lname" type="text" class="form-control mt-2">
                    </div>
                    <div class="form-group mb-3">
                        <label role="button" for="email">Email Address*</label>
                        <input id="email" name="email" type="email" class="form-control mt-2">
                    </div>
                    <div class="form-group mb-3">
                        <label role="button" for="username">Username*</label>
                        <input id="user" name="user" type="text" class="form-control mt-2">
                    </div>
                    <div class="form-group mb-3">
                        
                        <label role="button" for="pass">Password*</label>
                        <div class="input-group d-flex align-items-center" id="divpass">
                                <input id="pass" name="pass" type="password" class="form-control mt-2"> 
								<span role="button" toggle="#pass" class="fa fa-fw fa-eye text-success field-icon toggle-password ps-2 my-auto mt-3"></span>
						</div>
                    </div>
                    <div class="form-group mb-3">
                        <label role="button" for="confirmpass">Confirm Password*</label>
                        <div class="input-group d-flex align-items-center" id="divpass">
                                <input id="confirmpass" name="confirmpass" type="password" class="form-control mt-2"> 
								<span role="button" toggle="#confirmpass" class="fa fa-fw fa-eye text-success field-icon toggle-password ps-2 my-auto mt-3"></span>
						</div>
                    </div>
                    <div class="form-group mb-3">
                        <button id="registerbtn" class="btn btn-success py-3 rounded-pill w-100 fw-bold text-uppercase">Register</button>
                    </div>
                    <div class="form-group">
                        <h6 class="small fw-normal text-center text-dark">Already have an account? <a href="./index.php">Sign In</a> </h6>
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