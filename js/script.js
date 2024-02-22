$(document).ready(function () {
  // load table data
  function loadTableData() {
    console.log("LOAD-TABLE-FUNC-CALLED.!");
    $.ajax({
      url: "./backend/users.php",
      type: "POST",
      data: {
        action: "pagination_data",
      },
      dataType: "html",
      success: function (response) {
        $("#paginationData").html(response);
      },
    });
  }
loadTableData();
  // validatation of user inputed data
  $("#register").validate({
    rules: {
      name: {
        required: true,
        minlength: 2,
      },
      userName: {
        required: true,
        minlength: 2,
      },
      email: {
        required: true,
        email: true,
      },
      mobile: {
        required: true,
        number: true,
        minlength: 10,
        maxlength: 12,
      },
      password: {
        required: true,
        minlength: 6,
      },
      confirmPassword: {
        required: true,
        equalTo: "#password",
      },
      gender: {
        required: true,
      },
    },
    messages: {
      name: {
        required: "Please enter your full name",
        minlength: "Your name must consist of at least 2 characters",
      },
      userName: {
        required: "Please enter your username",
        minlength: "Your username must consist of at least 2 characters",
      },
      email: {
        required: "Please enter your email address",
        email: "Please enter a valid email address",
      },
      mobile: {
        required: "Please enter your phone number",
        minlength: "Your phone number must consist of at least 10 characters",
        maxlength: "Your phone number must not exceed 12 characters",
      },
      password: {
        required: "Please provide a password",
        minlength: "Your password must be at least 6 characters long",
      },
      confirmPassword: {
        required: "Please confirm your password",
        equalTo: "Passwords do not match",
      },
      gender: {
        required: "Please select your gender",
      },
    },
  });

  // insert data on click of submit button
  $(document).on("click", "#insertbtn", function (e) {
    e.preventDefault();
    var fname = $("#fname").val();
    var lname = $("#lname").val();
    var email = $("#email").val();
    var mobile = $("#mobile").val();
    // var status = $("#status").val();
    var statusValue = $("#status").prop("checked") ? 1 : 0;

    if ($("#uid").val() == "") {
      // data display funtion
      $.ajax({
        url: "./backend/users.php",
        type: "POST",
        data: {
          fname: fname,
          lname: lname,
          email: email,
          mobile: mobile,
          status: statusValue,
          action: "insert_data",
        },
        dataType: "JSON",
        success: function (response) {
          if (response.status == 1) {
            Swal.fire({
              title: "Inserted!",
              text: "Your data has been Inserted.",
              icon: "success",
            });
            $("#register")[0].reset();
            loadTableData();
          } else {
            Swal.fire({
              icon: "error",
              title: "Oops...",
              text: response.message
              // footer: '<a href="#">Why do I have this issue?</a>'
            });
          }
        },
      });
    }
  });

  // Delete Data
  $(document).on("click", ".deletebtn", function (e) {
    e.preventDefault();
    var uid = $(this).data("id");
    confirmStatus = confirm("Are you sure you want to delete?");
    if (confirmStatus) {
      // Corrected typo in the confirm message
      $.ajax({
        url: "./backend/users.php",
        method: "POST",
        data: {
          uid: uid,
          action: "delete_data",
        },
        dataType: "JSON",
        success: function (response) {
          var status = response.status;

          if (status == 1) {
            // toastr.success(response.message);
            // alert(response.message);
            Swal.fire({
              title: "Deleted!",
              text: "Your file has been deleted.",
              icon: "success",
            });
            loadTableData();
            // location.reload();
          } else {
            // toastr.error(response.message);
            alert("Error: " + response.message);
            loadTableData();
          }
        },
      });
    }
  });

  // fetch Data
  $(document).on("click", ".editbtn", function (e) {
    e.preventDefault();
    var uid = $(this).data("id");
    if (uid != null || uid != "") {
      $.ajax({
        type: "POST",
        url: "./backend/users.php",
        data: {
          uid: uid,
          action: "fetch_data",
        },
        dataType: "JSON",
        success: function (response) {
          console.log("DEV-CHECK-USEREDIT-RES : ", response);
          if (response.status == 1) {
            $("#collapseExample").addClass("show");
            $("#insertbtn").addClass("update_user");
            $("#insertbtn").html("Update");
            $("#uid").val(response.user.uid);
            $("#fname").val(response.user.fname);
            $("#lname").val(response.user.lname);
            $("#email").val(response.user.email).prop("readonly", true);
            $("#mobile").val(response.user.mobile);
            $("#uid").val(response.user.uid);
            if (response.user.status == "1") {
              $("#status").prop("checked", true);
            } else {
              $("#status").prop("checked", false);
            }
            // $('#insertbtn').val('UPDATE');
          }
        },
      });
    }
  });

  // Update User
  $(document).on("click", ".update_user", function (e) {
    e.preventDefault();
    console.log("btn clicked");
    var uid = $("#uid").val();
    var fname = $("#fname").val();
    var lname = $("#lname").val();
    var email = $("#email").val();
    var mobile = $("#mobile").val();
    // var status = $("#status").val();
    var statusValue = $("#status").prop("checked") ? 1 : 0;
    if ($("#uid").val() != null) {
      $.ajax({
        url: "./backend/users.php",
        type: "POST",
        data: {
          uid: uid,
          fname: fname,
          lname: lname,
          email: email,
          mobile: mobile,
          status: statusValue,
          action: "edit_data",
        },
        dataType: "JSON",
        success: function (response) {
          console.log("INSIDE IF....", response);

          if (response.status == 1) {
            $("#insertbtn").removeClass("update_user");
            $("#collapseExample").removeClass("show");
            $("#insertbtn").html("SUBMIT");
            $("#uid").val(null);
            Swal.fire({
              title: "Updated!",
              text: "Your data has been Updated.",
              icon: "success",
            });
            $("#register")[0].reset();
            $("#email").prop("readonly", false);
            loadTableData();
          } else {
            alert("Error: " + response.message);
            loadTableData();
          }
        },
      });
    }
  });
  //   filter data
  $(document).on("keyup", "#search", function (e) {
    e.preventDefault();
    var searchData = $("#search").val();
    if(searchData.length > 0){

    
    $("#paginationData").html("");
    $.ajax({
      url: "./backend/users.php",
      type: "POST",
      data: {
        searchData: searchData,
        action: "search_data",
      },  
      dataType: "html",
      success: function (response) {
        $("#paginationData").html(response);
        
      },
    });
  }else{
    loadTableData();
  }
  });

  //   pagination

  function loadPage(page) {
    $.ajax({
      url: "./backend/users.php",
      type: "POST",
      dataType: "html",
      data: {
        page: page,
        action: "pagination_data",
      },
      success: function (response) {
        $("#paginationData").html(response);
      },
    });
  }
  loadPage(1);
  $(document).on("click", ".pagination-link", function (e) {
    e.preventDefault();
    var page = $(this).attr("data-page");
    loadPage(page);
  });
});
