<?php
// Data Source Name
$host = "localhost";
$db = "exam";

// User Credentials
$username = "root";
$password = "";

try {
	$dsn = "mysql:host=$host;dbname=$db;charset=UTF8;";
	$pdo = new PDO($dsn, $username, $password, [
		PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION,
		PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC
	]);

    // $stmt = $pdo->prepare("SELECT * FROM tblusers WHERE username = 'admin' AND password = '12345' AND status = 'active'");
	// $stmt->execute();
	// $user = $stmt->fetch();

    // var_dump($user);

} catch (PDOException $e) {
	echo $e->getMessage();
}