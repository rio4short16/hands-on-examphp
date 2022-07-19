$(document).ready(function () {
  let email_regex = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
  let letters_only = /^[a-zA-Z\s]*$/;
  let alphanumeric_only = /^[a-zA-Z0-9._]*$/;
  let password_regex =
    /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;

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

  $("#registerbtn").on("click", function (e) {
    e.preventDefault();

    const accountObj = {
      req: "register",
      fname: $("#fname").val(),
      lname: $("#lname").val(),
      email: $("#email").val(),
      user: $("#user").val(),
      pass: $("#pass").val(),
      confirm: $("#confirmpass").val(),
    };

    // All fields are required!
    if (
      accountObj.fname == "" ||
      accountObj.lname == "" ||
      accountObj.email == "" ||
      accountObj.user == "" ||
      accountObj.pass == "" ||
      accountObj.confirm == ""
    ) {
      return callSwalMessage(
        "warning",
        "Warning!",
        "No empty fields allowed!",
        "Try again!",
        "orange"
      );
    }

    // First name and last name must accept alphabetical and whitespaces values only.
    if (
      !letters_only.test(accountObj.fname) ||
      !letters_only.test(accountObj.lname)
    ) {
      return callSwalMessage(
        "warning",
        "Letters only!",
        "Name must contain alphabetical values only!",
        "Try again!",
        "orange"
      );
    }

    // Email validation
    if (!email_regex.test(accountObj.email)) {
      $("#email").focus();
      return callSwalMessage(
        "warning",
        "Invalid Email!",
        "Please enter a valid email address!",
        "Try again!",
        "orange"
      );
    }

    // Username must consists alphanumeric values only
    // It can also consists underscore and dot (.)
    if (!alphanumeric_only.test(accountObj.user)) {
      $("#user").focus();
      return callSwalMessage(
        "warning",
        "Invalid Format!",
        "Username must consists alphanumeric values only!",
        "Try again!",
        "orange"
      );
    }

    // Username must be at least 6 characters!
    if (accountObj.user.length < 6) {
      $("#user").focus();
      return callSwalMessage(
        "warning",
        "Invalid Username!",
        "Username must be at least 6 characters!",
        "Try again!",
        "orange"
      );
    }

    // Password validation
    if (!password_regex.test(accountObj.pass)) {
      $("#pass").focus();
      return callSwalMessage(
        "warning",
        "Invalid Password!",
        "Password must have a minimum eight characters, at least one uppercase letter, one lowercase letter, one number and one special character!",
        "Try again!",
        "orange"
      );
    }

    // Password and Confirm Password validation
    if (accountObj.pass !== accountObj.confirm) {
      $("#confirmpass").focus();
      return callSwalMessage(
        "warning",
        "Warning!",
        "Password doesn't matched!",
        "Try again!",
        "orange"
      );
    }
    $.ajax({
      type: "POST",
      dataType: "JSON",
      contentType: "application/x-www-form-urlencoded; charset=UTF-8",
      url: "./controllers/homeControllers.php",
      data: { req: "checkuser", user: $("#user").val() },
      success: function (data) {
        if (data.result) {
          $("#user").focus();
          return callSwalMessage(
            "warning",
            "Warning!",
            data.message,
            "Try again!",
            "orange"
          );
        } else {
          $.ajax({
            type: "POST",
            dataType: "JSON",
            contentType: "application/x-www-form-urlencoded; charset=UTF-8",
            url: "./controllers/homeControllers.php",
            data: accountObj,
            success: function (data) {
              if (data.result) {
                Swal.fire({
                  title: "Success!",
                  text: data.message,
                  icon: "success",
                  confirmButtonText: "Thanks!",
                  confirmButtonColor: "green",
                }).then(() => (window.location = `./index.php`));
              } else {
                Swal.fire({
                  title: "Warning!",
                  text: data.message,
                  icon: "warning",
                  confirmButtonText: "Try again!",
                  confirmButtonColor: "orange",
                });
              }
            },
            error: function (err) {
              Swal.fire({
                title: "Warning!",
                text: "Something went wrong!" + err,
                icon: "warning",
                confirmButtonText: "Try again!",
                confirmButtonColor: "orange",
              });
            },
          });
        }
      },
    });
  });

  $("#loginbtn").on("click", function (e) {
    e.preventDefault();

    const loginObj = {
      req: "login",
      user: $("#user").val(),
      pass: $("#pass").val(),
    };

    // No empty fields allowed!
    if (loginObj.user == "" || loginObj.pass == "") {
      return callSwalMessage(
        "warning",
        "Warning!",
        "No empty fields allowed!",
        "Try again!",
        "orange"
      );
    }

    $.ajax({
      type: "POST",
      dataType: "JSON",
      contentType: "application/x-www-form-urlencoded; charset=UTF-8",
      url: "./controllers/homeControllers.php",
      data: loginObj,
      success: function (data) {
        if (data.result) {
          Swal.fire({
            title: "Login Successful!",
            text: data.message,
            icon: "success",
            confirmButtonText: "Thanks!",
            confirmButtonColor: "green",
          }).then(() => (window.location = `./${data.role}/`));
        } else {
          $("#user").val("");
          $("#user").focus();
          $("#pass").val("");
          Swal.fire({
            title: "Invalid Credentials!",
            text: data.message,
            icon: "warning",
            confirmButtonText: "Try again!",
            confirmButtonColor: "orange",
          });
        }
      },
      error: function (err) {
        Swal.fire({
          title: "Warning!",
          text: "Something went wrong!" + err,
          icon: "warning",
          confirmButtonText: "Try again!",
          confirmButtonColor: "orange",
        });
      },
    });
  });

  // $(
  //   ".regdiv #fname, .regdiv #lname, .regdiv #email, .regdiv #user, .regdiv #pass, .regdiv #confirmpass"
  // ).on("keyup", function (e) {
  //   e.preventDefault();
  //   enableRegisterButton();
  // });

  $(".logindiv #user, .logindiv #pass").on("keyup", function (e) {
    e.preventDefault();
    enableLoginButton();
  });

  function enableLoginButton() {
    if ($("#user").val() != "" && $("#pass").val() != "") {
      $("#loginbtn").attr("disabled", false);
    } else {
      $("#loginbtn").attr("disabled", true);
    }
  }

  // function enableRegisterButton() {
  //   if (
  //     $("#lname").val() != "" &&
  //     $("#fname").val() != "" &&
  //     $("#email").val() != "" &&
  //     $("#user").val() != "" &&
  //     $("#pass").val() != "" &&
  //     $("#confirmpass").val() != ""
  //   ) {
  //     $("#registerbtn").attr("disabled", false);
  //   } else {
  //     $("#registerbtn").attr("disabled", true);
  //   }
  // }
});
