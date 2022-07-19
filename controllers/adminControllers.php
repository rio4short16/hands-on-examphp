<?php
if(isset($_POST["req"])){
    session_start();
	include_once('../db/database.php');
	try{
        $returnArr = array();
		$request = $_POST["req"];
		if($request == "editpage"){
			$id = $_POST["pageid"];
			$title = $_POST["title"];
			$desc = $_POST["desc"];
			$published = filter_var($_POST["published"], FILTER_VALIDATE_BOOLEAN);

			$editPageStmt = $pdo->prepare("UPDATE tblpages SET title=?, description=?, status=? WHERE id = ?");
			$editPageStmt->execute([$title, $desc, $published, intval($id)]);
            if ($editPageStmt->rowCount() > 0) {
                $returnArr[] = array(
					"result" => true,
					"message" => "Page has been updated successfully!"
				);
            }else{
                $returnArr[] = array(
                    "result" => false,
                    "id" => intval($id),
                    "published" => $published,
                    "message" => "Please try again!"
                );
            }
		}else if($request == "addpage"){
			$title = $_POST["title"];
			$desc = $_POST["desc"];
			$published = filter_var($_POST["published"], FILTER_VALIDATE_BOOLEAN);
            $publishedby = $_SESSION["username"];

			$addPageStmt = $pdo->prepare("INSERT INTO tblpages (title, description, status, publishedby) VALUES (?, ?, ?, ?)");
			$addPageStmt->execute([$title, $desc, $published, $publishedby]);
            
            if ($addPageStmt->rowCount() > 0) {
                $returnArr[] = array(
					"result" => true,
					"message" => "New page has been saved successfully!"
				);
            }else{
                $returnArr[] = array(
                    "result" => false,
                    "message" => "Please try again!"
                );
            }
		}else if($request == "fetchpages"){
            $fetchStatement = $pdo->prepare("SELECT * FROM tblpages ORDER BY id DESC");
            $fetchStatement->execute([]);
            while($pageRow = $fetchStatement->fetch(PDO::FETCH_ASSOC)){
                $returnArr[] = array(
                    "pageId" => $pageRow["id"],
                    "pageTitle" => $pageRow["title"],
                    "pageDesc" => $pageRow["description"],
                    "status" => $pageRow["status"],
                );
            }
        }else if($request == "fetchusers"){
            $fetchStatement = $pdo->prepare("SELECT * FROM tblusers WHERE accesslevel='user' ORDER BY id DESC");
            $fetchStatement->execute([]);
            while($pageRow = $fetchStatement->fetch(PDO::FETCH_ASSOC)){
                $returnArr[] = array(
                    "userId" => $pageRow["id"],
                    "username" => $pageRow["username"],
                    "fname" => $pageRow["fname"],
                    "lname" => $pageRow["lname"],
                    "email" => $pageRow["email"],
                    "date_created" => date('F d, Y', strtotime($pageRow["date_created"])),
                );
            }
        }else if($request == "deletepage"){
            $id = $_POST["pageid"];
            $deletePageStmt = $pdo->prepare("DELETE FROM tblpages WHERE id = ?");
            $deletePageStmt->execute([intval($id)]);
            if ($deletePageStmt->rowCount() > 0) {
                $returnArr[] = array(
					"result" => true,
					"message" => "Page has been deleted successfully!"
				);
            }else{
                $returnArr[] = array(
                    "result" => false,
                    "message" => "Please try again!"
                );
            }
        }
	} catch (PDOException $e) {
		$returnArr[] = array(
			"result" => false,
			"error" => $e->getMessage()
		);
	} finally {
		echo json_encode($returnArr);
	}
	
}