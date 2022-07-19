<?php

session_start();
try {
	session_unset();
	session_destroy();
} catch (Exception $e) {
	echo $e->getMessage();
} finally {
	header("location: index.php");
}
