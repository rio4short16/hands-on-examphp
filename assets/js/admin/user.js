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

  const fetchAllUsers = () => {
    $.ajax({
      type: "POST",
      dataType: "JSON",
      contentType: "application/x-www-form-urlencoded; charset=UTF-8",
      url: "../controllers/adminControllers.php",
      data: {
        req: "fetchusers",
      },
      success: function (data) {
        console.log(data);
        if (data.length > 0) {
          var strAppend = "";
          var rowCount = 0;
          $("#table-body").empty();
          data.forEach((user) => {
            strAppend += `
                <tr>
                  <td class="d-none">${rowCount++}</td>
                  <td class="d-none">${user.userId}</td>
                  <td>${user.username}</td>
                  <td>${user.fname}</td>
                  <td>${user.lname}</td>
                  <td>${user.email}</td>
                  <td>${user.date_created}</td>
                </tr>`;
          });

          $("#table-body").append(strAppend);
        }
      },
    });
  };
  fetchAllUsers();
});
