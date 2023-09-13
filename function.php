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
} elseif ($_POST['function'] == "pic") {
    pic();
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


function pic()
{
    include("database.php");

    $sql = "SELECT name, path FROM images";
    $result = mysqli_query($con, $sql);

    $images = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $images[] = $row;
    }


    header("Content-Type: application/json");
    echo json_encode($images);

    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        if ($_FILES["image"]["error"] === 0) {
            $imageName = $_FILES["image"]["name"];
            $imageTmpName = $_FILES["image"]["tmp_name"];
            $imageType = $_FILES["image"]["type"];
            $imageSize = $_FILES["image"]["size"];

            // Check if the uploaded file is an image
            $allowedTypes = ["image/jpeg", "image/png", "image/gif"];
            if (in_array($imageType, $allowedTypes)) {
                // Move the uploaded file to a folder on the server
                $uploadPath = "uploads/" . $imageName;
                move_uploaded_file($imageTmpName, $uploadPath);

                // Insert image information into the database
                $sql = "INSERT INTO images (name, path) VALUES ('$imageName', '$uploadPath')";
                if (mysqli_query($con, $sql)) {
                    echo "Image uploaded successfully!";
                } else {
                    echo "Error: " . mysqli_error($con);
                }
            } else {
                echo "Only JPEG, PNG, and GIF images are allowed.";
            }
        } else {
            echo "Error uploading the image.";
        }
    }
}





// function qualification_data(){
// include("database.php"); // Include your database connection

// $sql = "SELECT `id`, `name` FROM `qualifications`"; // Adjust the table and column names as needed
// $result = $con->query($sql);
// $data = array();

// if ($result->num_rows > 0) {
// while ($row = $result->fetch_assoc()) {
// $data[] = $row;
// }
// }

// // Return the data as JSON
// echo json_encode($data);
// }