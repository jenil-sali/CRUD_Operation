<?php
include("./backend/config.php");

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Collapase Form | Jenil @ Agami Tech</title>
  <!-- BootStrap CSS CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
  <!-- Font Awsome 4.7.0 CDN -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha512-SfTiTlX6kk+qitfevl/7LibUOeJWlt9rbyDn92a1DqWOw9vWG2MFoays0sgObmWazO5BQPiFucnnEAjpAB+/Sw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <!-- Local StyleSheet -->
  <link rel="stylesheet" href="./CSS/style.css" />
</head>

<body>
  <!-- header -->

    <div class="d-flex justify-content-around">
      <h3>USER</h3>
      <div class="input-group mb-3" style="width:auto; margin-top:10px;">
        <span class="input-group-text" id="addon-wrapping">@</span>
        <input type="text" class="form-control" id="search" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" placeholder="Search">
      </div>
      <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
        ADD USER
      </button>
    </div>


  <!-- form -->
  <div class="collapse" id="collapseExample">
    <div class="container">
      <div class="card card-body" style="background-color: transparent; border: none;">
        <form class="row g-3" method="post" name="register" id="register">
          <div class="col-md-4">
            <label for="validationDefault01" class="form-label">First name</label>
            <input type="text" class="form-control" id="fname" placeholder="Jenil" name="fname" autocomplete="off" required>
          </div>
          <div class="col-md-4">
            <label for="validationDefault02" class="form-label">Last name</label>
            <input type="text" class="form-control" id="lname" name="lname" placeholder="Sali" autocomplete="off" required>
          </div>
          <div class="col-md-4">
            <label for="validationDefaultUsername" class="form-label">Email</label>
            <div class="input-group">
              <span class="input-group-text" id="inputGroupPrepend2">@</span>
              <input type="text" class="form-control" id="email" name="email" aria-describedby="inputGroupPrepend2" autocomplete="off" placeholder="abc@email.com" required>
            </div>
          </div>
          <div class="col-md-4">
            <label for="validationDefault03" class="form-label">Phone</label>
            <input type="tel" class="form-control" id="mobile" name="mobile" placeholder="0123456789" autocomplete="off" required>
          </div>
          <div class="col-md-8">
            <label for="validationDefault04" class="form-label">Status </label>
            <label class="switch form-label">
              <input type="checkbox" value="" id="status" name="status" checked required>
              <span class="slider "></span>
            </label>
          </div>

          <div class="col-4">
            <input type="hidden" name="uid" id="uid" value="">
            <button class="btn btn-primary" id="insertbtn" type="submit">SUBMIT</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- Display Table -->
  <!-- <div class="container displaydata" id="displaydata">

  </div> -->

  <!-- Pagination Data -->
  <div id="paginationData"></div>
  <div class="pagination-container">

    <div id="paginationLinks"></div>
  </div>



  </div>
  <!-- JQuery CDN -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

  <!-- JQuery Validate CDN -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>

  <!-- BootStrap Js CDN -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

  <!-- Sweet Alert CDN -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!-- Local JS -->
  <script src="./js/script.js"></script>


</body>

</html>