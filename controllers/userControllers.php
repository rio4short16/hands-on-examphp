<?php
if(isset($_POST["req"])){
    session_start();
	include_once('../db/database.php');
	try{
        $returnArr = array();
		$request = $_POST["req"];
		if($request == "fetchactivepages"){
            $fetchStatement = $pdo->prepare("SELECT * FROM tblpages WHERE status = 1 ORDER BY id DESC");
            $fetchStatement->execute([]);
            while($pageRow = $fetchStatement->fetch(PDO::FETCH_ASSOC)){
                $returnArr[] = array(
                    "pageId" => $pageRow["id"],
                    "pageTitle" => $pageRow["title"],
                    "pageDesc" => $pageRow["description"],
                    "status" => $pageRow["status"],
                );
            }
        }
        else if($request == "fetchspecificpage"){
            $pageId = $_POST["pageId"];
            $fetchStatement = $pdo->prepare("SELECT * FROM tblpages WHERE id = ?");
            $fetchStatement->execute([intval($pageId)]);
            $page = $fetchStatement->fetch();
            if($page){
                $returnArr[] = array(
                    "pageId" => $pageId,
                    "pageTitle" => $page["title"],
                    "pageDesc" => $page["description"],
                    "publishedBy" => $page["publishedby"],
                    "datePublished" => date('F d, Y', strtotime($page["date_published"])),
                );
            }
        }
        else if($request == "getuser"){
            $userId = $_SESSION["userid"];
            $fetchStatement = $pdo->prepare("SELECT * FROM tblusers WHERE id = ?");
            $fetchStatement->execute([intval($userId)]);
            $page = $fetchStatement->fetch();
            if($page){
                $returnArr[] = array(
                    "fname" => $page["fname"],
                    "lname" => $page["lname"],
                    "email" => $page["email"],
                    "username" => $page["username"],
                    "role" => $page["accesslevel"],
                    "date_created" => date('F d, Y', strtotime($page["date_created"])),
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