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
    
	<title>Admin | Pages</title>

    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<div class="admin-section">
	<div class="d-flex justify-content-start">
		<?php require_once('./sidenav.php'); ?>
		<div class="main-container container-md pt-5">
			<h1 class="container-title display-6 fs-3 fw-normal text-center">PAGES LIST</h1>
            <button class="btn btn-success rounded-pill px-2 px-md-3" data-bs-toggle="modal" data-bs-target="#addPageModal">
                <i class="fa-solid fa-file-circle-plus me-1"></i>
                Add Page</button>
            <div class="table-wrapper mt-3 mt-md-4">
					<div id="table-container">
						<table id="user-table" align="center" class="table table-striped table-hover">
								<thead text-center">
									<tr class="table-header">
										<td class="d-none">#</td>
                                        <td class="d-none">pageID</td>
                                        <td class="d-none">pageDesc</td>
                                        <td class="d-none">pageStatus</td>
										<td style="width: 60%;">Page Title</td>
										<td style="width: 15%;">Status</td>
										<td style="width: 15%;" colspan="2">Action</td>
									</tr>
								</thead>
								<tbody id="table-body" class="table-body table-hover">
									<tr>
										<td colspan="4" rowspan="5">NO RECORDS FOUND</td> 
									</tr>
								</tbody>
						</table>
					</div>
				</div>
		</div>
	</div>
</body>
<?php require_once('../views/partials/script.php'); ?>

<script>
        tinymce.init({
            selector: 'textarea#editPageDesc' 
        });
        tinymce.init({
            selector: 'textarea#addPageDesc' 
        });
</script>
    <!-- Start of AddPageModal -->
    <div class="modal fade" id="addPageModal" tabindex="-1" aria-labelledby="addPageModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addPageModalLabel">Add Page</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label role="button" for="addPageTitle" class="h6">Page Title*</label>
                        <input id="addPageTitle" type="text" class="form-control mt-2" placeholder="Must have alphabetical values only and have a minimum of 3 characters!"> 
                    </div>
                    <div class="form-group mb-3">
                        <label role="button" for="addPageDesc" class="h6 mb-2">Page Description*</label>
                        <textarea class="form-control" id="addPageDesc" cols="30" rows="10"></textarea>
                    </div>
                    <div class="form-group mb-3">
                        <input type="checkbox" id="addPagePublished" checked="checked">
                        <label role="button" for="addPagePublished" class="h6 ms-3">Published</label>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button id="addPageButton" type="button" class="btn btn-success">Save</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End of AddPageModal -->
    <!-- Start of EditPageModal -->
    <div class="modal fade" id="editPageModal" tabindex="-1" aria-labelledby="editPageModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPageModalLabel">Edit Page</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label role="button" for="editPageTitle" class="h6">Edit Page Title*</label>
                        <input id="editPageTitle" type="text" class="form-control mt-2" placeholder="Must have alphabetical values only and have a minimum of 3 characters!"> 
                    </div>
                    <div class="form-group mb-3">
                        <label role="button" for="editPageDesc" class="h6 mb-2">Edit Page Description*</label>
                        <textarea class="form-control" id="editPageDesc" cols="30" rows="10"></textarea>
                    </div>
                    <div class="form-group mb-3">
                        <input type="checkbox" id="editPagePublished">
                        <label role="button" for="editPagePublished" class="h6 ms-3">Published</label>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button id="editPageButton" type="button" class="btn btn-info text-white">Update</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End of EditPageModal -->
</div>
<script src="../assets/js/admin/page.js"></script>
</html>