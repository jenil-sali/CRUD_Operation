<?php
include("config.php");


// Validation of mobile & email & insert data into db
if ($_REQUEST['action'] == 'insert_data') {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $status = $_POST['status'];

    function validateEmail($email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        } else {
            return true;
        }
    }
    function validateMobile($mobile)
    {
        $phoneNumberDigits = preg_replace("/[^0-9]/", "", $mobile);

        if (strlen($phoneNumberDigits) != 10) {
            return false;
        }
        return true;
    }

    $response = array();
    if (!validateEmail($email)) {
        $response["status"] = 0;
        $response["message"] = "Email id is Invalid";
        echo json_encode($response);
        exit();
    }
    if (!validateMobile($mobile)) {
        $response["status"] = 0;
        $response["message"] = "Mobile Number is Invalid";
        echo json_encode($response);
        exit();
    }


    $sql = "INSERT INTO `register_data`(`fname`, `lname`, `email`, `mobile`, `status`) VALUES ('$fname','$lname','$email','$mobile','$status')";
    // die($sql);

    $result = $conn->query($sql);
    if ($result) {
        $response["status"] = 1;
        $response["msg"] = "Record Inserted Successfully";
        echo json_encode($response);
    } else {
        $response["status"] = 0;
        $response["msg"] = "Something Went Wrong.";
        echo json_encode($response);
    }
}

// function to display data 
function displayData($result){
    if (mysqli_num_rows($result) > 0) {
        echo '<div class="container-fluid">';
        echo '<h4>USER RECORDS</h4>';
        echo '<table class="table table-striped">';
        echo '<thead>';
        echo '<tr>';
        echo '<th scope="col">UID</th>';
        echo '<th scope="col">FIRST NAME</th>';
        echo '<th scope="col">LAST NAME</th>';
        echo '<th scope="col">EMAIL</th>';
        echo '<th scope="col">MOBILE NO</th>';
        echo '<th scope="col">STATUS</th>';
        echo '<th scope="col">EDIT</th>';
        echo '<th scope="col">DELETE</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody id="data">';

        // Output data of each row
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<tr>';
            echo '<td>' . $row["uid"] . '</td>';
            echo '<td>' . $row["fname"] . '</td>';
            echo '<td>' . $row["lname"] . '</td>';
            echo '<td>' . $row["email"] . '</td>';
            echo '<td>' . $row["mobile"] . '</td>';
            echo '<td>' . $row["status"] . '</td>';
            echo "<td>"  . '<a href="" id="editbtn" name="editbtn" data-id=' . base64_encode($row["uid"]) . ' class="editbtn"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>' . "</td>";
            echo "<td>"  . '<a href="" id="deletebtn" name="deletebtn" data-id=' . base64_encode($row["uid"]) . ' class="deletebtn"><i class="fa fa-trash" aria-hidden="true"></i></a>' . "</td>";


            // Add more columns as needed
            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';
        echo '</div>';
    } else {
        echo "<h4>No User Registered Yet. </h4>";
    }
}
 
// if ($_REQUEST['action'] == 'display_data') {
//     $sql = "SELECT * FROM register_data";
//     $result = mysqli_query($conn, $sql);
//     displayData($result);

// }

// Delete User Data
if ($_REQUEST['action'] == 'delete_data') {
    $uid = base64_decode($_POST["uid"]);
    $response = array();
    $sql = "DELETE FROM register_data WHERE uid = '$uid'";
    $result = $conn->query($sql);

    if ($result) {
        $response['status'] = 1;
        if ($conn->affected_rows > 0) {
            $response['message'] = 'User deleted successfully';
        } else {
            $response['message'] = 'No user found with provided ID';
        }
        echo json_encode($response);
    } else {
        $response['status'] = 0;
        $response['message'] = 'Someting Went Wrong..!';
        echo json_encode($response);
    }
}

// fetch data 
if ($_REQUEST['action'] == 'fetch_data') {
    $uid = base64_decode($_POST['uid']);

    $sql = "SELECT * FROM register_data WHERE uid = '$uid'";
    $result = $conn->query($sql);
    $response = array();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $response['user'] = array(
            'uid' => $row['uid'],
            'fname' => $row['fname'],
            'lname' => $row['lname'],
            'email' => $row['email'],
            'mobile' => $row['mobile'],
            'status' => $row['status'],
        );
        $response['status'] = 1;
        $response['message'] = "User Data Fetched.";
    } else {
        $response['user'] = null;
        $response['status'] = 0;
        $response['message'] = "No User Found";
    }

    echo json_encode($response);
}

// Edit Data
if ($_REQUEST["action"] == "edit_data") {
    $uid  = $_POST["uid"];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $status = $_POST['status'];
    // var_dump($_POST['fname']);
    $update = "UPDATE `register_data` SET `fname`='$fname',`lname`='$lname',`mobile`='$mobile',`status`='$status' WHERE `uid`= '$uid'";

    $result = $conn->query($update);

    if ($result) {
        $response["status"] = 1;
        $response["message"] = "Record Updated Successfully";
        echo json_encode($response);
        // displayData($result);
    } else {
        $response["status"] = 0;
        $response["message"] = "Something Went Wrong.";
        echo json_encode($response);
    }
}

// filter Data
if ($_REQUEST["action"] == "search_data") {
    $searchData = $_POST["searchData"];

    $sql = "SELECT * FROM register_data  WHERE 
    fname LIKE '%$searchData%' OR 
    lname LIKE '%$searchData%' OR 
    email LIKE '%$searchData%' OR 
    mobile LIKE '%$searchData%'";
    $result = $conn->query($sql);

    displayData($result);

}

// pagination

if ($_REQUEST['action'] == "pagination_data") {
    $recordsPerPage = 5;
    $page = isset($_POST['page']) ? $_POST['page'] : 1;
    $offset = ($page - 1) * $recordsPerPage;

    // Query to fetch data for the current page
    $sql = "SELECT * FROM register_data LIMIT $offset, $recordsPerPage";
    $result = $conn->query($sql);

    // Output HTML for paginated data
    displayData($result);

        $totalRecordsQuery = "SELECT COUNT(*) AS total FROM register_data";
        $totalRecordsResult = $conn->query($totalRecordsQuery);
        $totalRecordsRow = $totalRecordsResult->fetch_assoc();
        $totalRecords = $totalRecordsRow['total'];
        $totalPages = ceil($totalRecords / $recordsPerPage);

        echo '<div class="pagination">';
        for ($i = 1; $i <= $totalPages; $i++) {
            echo '<a href="#" class="pagination-link" data-page="' . $i . '">' . $i . '</a>';
        }
        echo '</div>';
    }
    // } else {
    //     echo "<p>No data available</p>";
    // } 

    // $total  = "SELECT COUNT(*) FROM register_data";
    // $result = $conn->query($total);
    // Calculate total number of records
    



//  pagination, search remaining 