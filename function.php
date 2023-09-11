<?php

if ($_POST['function'] == "save_content") {
    SaveContent();
} elseif ($_POST['function'] == "ShowContent") {
    ShowContent();
} elseif ($_POST['function'] == "delete_data") {
    delete_data();
} elseif ($_POST['function'] == "deletedata") {
    deletedata();
} elseif ($_POST['function'] == "update_data") {
    update_data();
} elseif ($_POST['function'] == "filterRecords") {
    filterRecords();
}
// } elseif ($_POST['function'] == "qualification_data") {
//     qualification_data();
// }

function SaveContent()
{
    include("database.php");
    $name = $_POST['name'];
    $age = $_POST['age'];
    $verification = $_POST['verification'];
    $sql = "INSERT INTO `user`(`Name`, `Age`, `verification`) VALUES ('$name','$age','$verification')";
    $result = mysqli_query($con, $sql);

    if ($result) {
        echo 'Success   ';
    }
}

function ShowContent()
{
    include("database.php");
    $sql = "SELECT `Name`, `Age`, `id` FROM `user`"; // Adjust the table and column names as needed
    $result = $con->query($sql);
    $data = array();

    if ($result) {
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
    }

    // Return the data as JSON

    echo json_encode($data);
}
function deletedata()
{
    include("database.php");
    $sql = "DELETE FROM `user`";

    $result = mysqli_query($con, $sql);

    if ($result) {
        echo 'Success   ';
    } //else{
    //     echo'error';
    // }


}
function delete_data()
{
    include("database.php");
    $id = $_POST['id'];

    $sql = "DELETE FROM `user` where id=$id";

    $result = mysqli_query($con, $sql);

    if ($result) {
        echo 'Success   ';
    } //else{
    //     echo'error';
    // }

}

function update_data()
{
    include("database.php");
    $name = $_POST['name'];
    $age = $_POST['age'];
    $id = $_POST['id'];
    $verification = $_POST['verification'];

    $sql = "UPDATE `user` SET `Name`='$name',`Age`='$age',`verification`='$verification' where id=$id";

    $result = mysqli_query($con, $sql);

    if ($result) {
        echo 'Success   ';
    } //else{
    //     echo'error';
    // }

}

function filterRecords()
{
    // Include your database connection
    include("database.php");

    // Retrieve and sanitize input values
    $minAge = isset($_POST['minAge']) ? intval($_POST['minAge']) : null;
    $maxAge = isset($_POST['maxAge']) ? intval($_POST['maxAge']) : null;

    // Prepare the SQL query
    $query = "SELECT * FROM user WHERE 1=1";

    if (!empty($minAge)) {
        $query .= " AND Age >= $minAge";
    }

    if (!empty($maxAge)) {
        $query .= " AND Age <= $maxAge";
    }

    // Execute the query and fetch results
    $result = $con->query($query);
    $data = array();

    if ($result) {
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        // Return the filtered records as JSON data
        echo json_encode($data);
    } else {
        // Handle the case where the query failed
        echo 'Error executing query: ' . $con->error;
    }
}
     
    




// function qualification_data(){
//     include("database.php"); // Include your database connection

//     $sql = "SELECT `id`, `name` FROM `qualifications`"; // Adjust the table and column names as needed
//     $result = $con->query($sql);
//     $data = array();

//     if ($result->num_rows > 0) {
//         while ($row = $result->fetch_assoc()) {
//             $data[] = $row;
//         }
//     }

//     // Return the data as JSON
//     echo json_encode($data);
// }
