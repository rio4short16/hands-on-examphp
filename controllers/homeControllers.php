<?php
if(isset($_POST["req"])){
	session_start();
	include_once('../db/database.php');
	try{
		$returnArr = array();
		$request = $_POST["req"];
		
		if($request == "login"){
			$user = $_POST["user"];
			$pass = $_POST["pass"];
			$stmt = $pdo->prepare("SELECT * FROM tblusers WHERE username = ? AND password = ? AND status = 'active'");
			$stmt->execute([$user, $pass]);
			$user = $stmt->fetch();
			if($user){
				$_SESSION["role"] = $user["accesslevel"];
				$_SESSION["userid"] = $user["id"];
				$_SESSION["username"] = $user["username"];
				$_SESSION["fname"] = $user["fname"];
				$_SESSION["lname"] = $user["lname"];
				$_SESSION["email"] = $user["email"];
				$_SESSION["date_created"] = $user["date_created"];

				$returnArr[] = array(
					"result" => true,
					"role" => $user["accesslevel"],
					"message" => "Welcome back, ".ucfirst($user["accesslevel"])." ".$user["fname"]."!"
				);
			}else{
				$returnArr[] = array(
					"result" => false,
					"message" => "Your username and password is incorrect!"
				);
			}
		}else if($request == "register"){
			$fname = $_POST["fname"];
			$lname = $_POST["lname"];
			$email = $_POST["email"];
			$user = $_POST["user"];
			$pass = $_POST["pass"];
			$insertedUser = $pdo->prepare("INSERT INTO tblusers (fname, lname, email, username, password, accesslevel, status) VALUES (?, ?, ?, ?, ?, 'user', 'active')");
			$insertedUser->execute([$fname, $lname, $email, $user, $pass]);
			if($insertedUser->rowCount() > 0){
				$returnArr[] = array(
					"result" => true,
					"message" => "Thanks for signing up!"
				);
			}else{
				$returnArr[] = array(
					"result" => false,
					"message" => "Please try again!"
				);
			}
		}else if($request == "checkuser"){
			$user = $_POST["user"];
			$checkUser = $pdo->prepare("SELECT * FROM tblusers WHERE username = ?");
			$checkUser->execute([$user]);
			if($checkUser->rowCount() > 0){
				$returnArr[] = array(
					"result" => true,
					"message" => "Username is already exists!"
				);
			}else{
				$returnArr[] = array(
					"result" => false,
					"message" => "Please try again!"
				);
			}
		}else{
			$returnArr[] = array(
				"result" => false,
				"message" => "No request found!"
			);
		}
	} catch (PDOException $e) {
		$returnArr[] = array(
			"result" => false,
			"error" => $e->getMessage()
		);
	} finally {
		// Encoding array in JSON format
		echo json_encode($returnArr[0]);
	}
}