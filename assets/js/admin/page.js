$(document).ready(function () {
  let email_regex =
    /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  let password_regex1 =
    /([a-z].*[A-Z])|([A-Z].*[a-z])([0-9])+([!,%,&,@,#,$,^,*,?,_,~])/;
  let password_regex2 = /([0-9])/;
  let password_regex3 = /([!,%,&,@,#,$,^,*,?,_,~])/;
  let letters_only = /^[a-zA-Z\s]*$/;

  let selectedPageID = null;

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

  const fetchAllPages = () => {
    $.ajax({
      type: "POST",
      dataType: "JSON",
      contentType: "application/x-www-form-urlencoded; charset=UTF-8",
      url: "../controllers/adminControllers.php",
      data: {
        req: "fetchpages",
      },
      success: function (data) {
        if (data.length > 0) {
          var strAppend = "";
          var rowCount = 0;
          $("#table-body").empty();
          data.forEach((page) => {
            strAppend += `
            <tr>
                <td class="d-none">${rowCount++}</td>
                <td class="d-none">${page.pageId}</td>
                <td class="d-none">${page.pageDesc}</td>
                <td class="d-none">${page.status}</td>
                <td>${page.pageTitle}</td>`;

            strAppend += `
            <td>
                <button class="btn btn-status ${
                  page.status == 1 ? "btn-success" : "btn-dark"
                } btn-sm w-100 disabled" disabled>${
              page.status == 1 ? "Published" : "Not Published"
            }</button>
            </td>`;

            strAppend += `<td>
                <div class="d-flex justify-content-evenly align-items-center">
                <button class="btn btn-info text-white btn-sm w-100 px-2 mx-1 btn-edit">Edit</button>
                <button class="btn btn-danger btn-sm w-100 px-2 mx-1 btn-delete">Delete</button>
                </div>
            </td>
            </tr>`;
          });

          $("#table-body").append(strAppend);
          $(".btn-edit").on("click", function (e) {
            e.preventDefault();
            $tr = $(this).closest("tr");
            var data = $tr
              .children("td")
              .map(function () {
                return $(this).html();
              })
              .get();
            selectedPageID = data[1];

            // Transfering the values into our edit modal
            $("#editPageTitle").val($.trim(data[4]));
            tinymce.get("editPageDesc").setContent(data[2]);

            if ($.trim(data[3]) == "1")
              $("#editPagePublished").prop("checked", true);
            else $("#editPagePublished").prop("checked", false);

            $("#editPageModal").modal({ backdrop: "static", keyboard: false });
            $("#editPageModal").modal("show");
          });
          $(".btn-delete").on("click", function (e) {
            e.preventDefault();
            $tr = $(this).closest("tr");
            var data = $tr
              .children("td")
              .map(function () {
                return $(this).text();
              })
              .get();
            selectedPageID = data[1];

            if (selectedPageID === null) {
              callSwalMessage(
                "warning",
                "Please try again!",
                "Something went wrong!",
                "Try again!",
                "orange"
              );
            }

            Swal.fire({
              icon: "question",
              title: "Are you sure?",
              text: "You won't be able to revert this!",
              showCancelButton: true,
              confirmButtonText: "Yes, delete it",
              confirmButtonColor: "red",
            }).then((result) => {
              if (result.isConfirmed) {
                $.ajax({
                  type: "POST",
                  dataType: "JSON",
                  contentType:
                    "application/x-www-form-urlencoded; charset=UTF-8",
                  url: "../controllers/adminControllers.php",
                  data: { req: "deletepage", pageid: selectedPageID },
                  success: function (data) {
                    if (!data[0].result) {
                      console.log(data[0]);
                      return callSwalMessage(
                        "warning",
                        "Something went wrong!",
                        data[0].message,
                        "Try again!",
                        "orange"
                      );
                    }
                    callSwalMessage(
                      "success",
                      "Deleted!",
                      data[0].message,
                      "Thanks!",
                      "green"
                    );
                    fetchAllPages();
                  },
                  error: function (err) {
                    callSwalMessage(
                      "warning",
                      "Something went wrong!",
                      err,
                      "Try again!",
                      "orange"
                    );
                  },
                });
              }
            });
          });
        }
      },
    });
  };

  fetchAllPages();

  $("#addPageButton").on("click", (e) => {
    e.preventDefault();
    const addPageObj = {
      req: "addpage",
      title: $("#addPageTitle").val(),
      desc: tinymce.get("addPageDesc").getContent(),
      published: $("#addPagePublished").is(":checked"),
    };

    if (addPageObj.title.length < 3) {
      $("#addPageTitle").focus();
      return callSwalMessage(
        "warning",
        "Please try again!",
        "Title must contain at least 3 characters!",
        "Try again!",
        "orange"
      );
    }

    if (!letters_only.test(addPageObj.title)) {
      $("#addPageTitle").focus();
      return callSwalMessage(
        "warning",
        "Please try again!",
        "Title must contain alphabetical values only!",
        "Try again!",
        "orange"
      );
    }

    $.ajax({
      type: "POST",
      dataType: "JSON",
      contentType: "application/x-www-form-urlencoded; charset=UTF-8",
      url: "../controllers/adminControllers.php",
      data: addPageObj,
      success: function (data) {
        if (!data[0].result) {
          return callSwalMessage(
            "warning",
            "Something went wrong!",
            data[0].message,
            "Try again!",
            "orange"
          );
        }
        callSwalMessage(
          "success",
          "Saved!",
          data[0].message,
          "Thanks!",
          "green"
        );
        fetchAllPages();
        $("#addPageModal .btn-close").click();

        // Reset the form
        $("#addPageTitle").val("");
        tinymce.get("addPageDesc").setContent("");
        $("#addPagePublished").prop("checked", true);
      },
      error: function (err) {
        callSwalMessage(
          "warning",
          "Something went wrong!",
          err,
          "Try again!",
          "orange"
        );
      },
    });
  });

  $("#editPageButton").on("click", (e) => {
    e.preventDefault();
    const editPageObj = {
      req: "editpage",
      pageid: selectedPageID,
      title: $("#editPageTitle").val(),
      desc: tinymce.get("editPageDesc").getContent(),
      published: $("#editPagePublished").is(":checked"),
    };
    if (editPageObj.title.length < 3) {
      $("#editPageTitle").focus();
      return callSwalMessage(
        "warning",
        "Please try again!",
        "This field must contain at least 3 characters!",
        "Try again!",
        "orange"
      );
    }

    if (!letters_only.test(editPageObj.title)) {
      $("#editPageTitle").focus();
      return callSwalMessage(
        "warning",
        "Please try again!",
        "This field must contain alphabetical values only!",
        "Try again!",
        "orange"
      );
    }

    if (selectedPageID === null) {
      callSwalMessage(
        "warning",
        "Please try again!",
        "Something went wrong!",
        "Try again!",
        "orange"
      );
      return $("#editPageModal .btn-close").click();
    }

    $.ajax({
      type: "POST",
      dataType: "JSON",
      contentType: "application/x-www-form-urlencoded; charset=UTF-8",
      url: "../controllers/adminControllers.php",
      data: editPageObj,
      success: function (data) {
        if (!data[0].result) {
          return callSwalMessage(
            "warning",
            "Something went wrong!",
            data[0].message,
            "Try again!",
            "orange"
          );
        }
        callSwalMessage(
          "success",
          "Updated!",
          data[0].message,
          "Thanks!",
          "green"
        );
        fetchAllPages();
        $("#editPageModal .btn-close").click();

        // Reset the form
        $("#editPageTitle").val("");
        tinymce.get("editPageDesc").setContent("");
      },
      error: function (err) {
        callSwalMessage(
          "warning",
          "Something went wrong!",
          err,
          "Try again!",
          "orange"
        );
      },
    });
  });
});
