$(document).ready(function () {
  let email_regex =
    /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  let password_regex1 =
    /([a-z].*[A-Z])|([A-Z].*[a-z])([0-9])+([!,%,&,@,#,$,^,*,?,_,~])/;
  let password_regex2 = /([0-9])/;
  let password_regex3 = /([!,%,&,@,#,$,^,*,?,_,~])/;
  let letters_only = /^[a-zA-Z\s]*$/;

  const callSwalMessage = (
    swalIcon,
    swalTitle,
    swalText,
    confirmText,
    confirmColor
  ) => {
    Swal.fire({
      icon: swalIcon,
      title: swalTitle,
      text: swalText,
      confirmButtonText: confirmText,
      confirmButtonColor: confirmColor,
    });
  };

  const fetchActivePages = () => {
    $.ajax({
      type: "POST",
      dataType: "JSON",
      contentType: "application/x-www-form-urlencoded; charset=UTF-8",
      url: "../controllers/userControllers.php",
      data: {
        req: "fetchactivepages",
      },
      success: function (data) {
        if (data.length > 0) {
          var strAppend = "";
          $("#navpage-container").empty();
          data.forEach((page) => {
            strAppend += `<li><a href="javascript:void(0)" page-id="${page.pageId}" class="btn-selectpage link-dark d-inline-flex text-decoration-none rounded">${page.pageTitle}</a></li>`;
          });
          $("#navpage-container").append(strAppend);

          $(".btn-selectpage").on("click", function (e) {
            e.preventDefault();
            $pageID = $(this).attr("page-id");
            $.ajax({
              type: "POST",
              dataType: "JSON",
              contentType: "application/x-www-form-urlencoded; charset=UTF-8",
              url: "../controllers/userControllers.php",
              data: {
                req: "fetchspecificpage",
                pageId: $pageID,
              },
              success: function (data) {
                if (data.length > 0) {
                  let page = data[0];
                  $("section#section-container").empty();
                  $("h1#page-title").text(page.pageTitle);
                  var strAppend = `${page.pageDesc}<p class="small my-0 py-0">Published By: <strong>${page.publishedBy}</strong></p>
                  <p class="small my-0 py-0">Date Created: <strong>${page.datePublished}</strong></p>`;
                  $("section#section-container").html(strAppend);
                }
              },
            });
          });
        }
      },
    });
  };

  fetchActivePages();

  const homePageCallBack = () => {
    $("#section-container").empty();
    $("h1#page-title").text("HOME PAGE");
    $.ajax({
      type: "POST",
      dataType: "JSON",
      contentType: "application/x-www-form-urlencoded; charset=UTF-8",
      url: "../controllers/userControllers.php",
      data: {
        req: "getuser",
      },
      success: function (data) {
        if (data.length > 0) {
          let user = data[0];
          var strAppend = `
          <div class="container bg-white shadow px-md-5 py-4 py-md-5">
            <div class="row justify-content-evenly align-items-center">
              <div class="col-11 col-sm-11 col-md-4 col-lg-3 text-center">
                <p class="mb-1 fw-bold">${user.fname}</p>
                <h6 class="text-muted fw-normal small text-uppercase">First Name</h6>
              </div>
              <div class="col-11 col-sm-11 col-md-4 col-lg-3 text-center">
                <p class="mb-1 fw-bold">${user.lname}</p>
                <h6 class="text-muted fw-normal small text-uppercase">Last Name</h6>
              </div>
              <div class="col-11 col-sm-11 col-md-4 col-lg-3 text-center">
                <p class="mb-1 fw-bold">${user.email}</p>
                <h6 class="text-muted fw-normal small text-uppercase">Email</h6>
              </div>
            </div>
            <div class="row justify-content-evenly align-items-center mt-4 mt-lg-5">
                <div class="col-11 col-sm-11 col-md-4 col-lg-3 text-center">
                  <p class="mb-1 fw-bold">${user.username}</p>
                  <h6 class="text-muted fw-normal small text-uppercase">Username</h6>
                </div>
                <div class="col-11 col-sm-11 col-md-4 col-lg-3 text-center">
                  <p class="mb-1 fw-bold">${user.role}</p>
                  <h6 class="text-muted fw-normal small text-uppercase">Position</h6>
                </div>
                <div class="col-11 col-sm-11 col-md-4 col-lg-3 text-center">
                  <p class="mb-1 fw-bold">${user.date_created}</p>
                  <h6 class="text-muted fw-normal small text-uppercase">Date Created</h6>
                </div>
            </div>
          </div>`;
          $("section#section-container").html(strAppend);
        }
      },
    });
  };
  homePageCallBack();

  $("#btnhome").on("click", function (e) {
    e.preventDefault();
    homePageCallBack();
  });
});
