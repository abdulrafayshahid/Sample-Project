<?php

if ($_POST['function'] == "save_content") {
 SaveContent();
 
}elseif($_POST['function'] == "ShowContent"){
    ShowContent();
}elseif($_POST['function'] == "deletedata"){
    deletedata();
 }

function SaveContent(){
    include("database.php");
    $name = $_POST['name'];
    $age = $_POST['age'];
    
    $sql = "INSERT INTO `user`(`Name`, `Age`) VALUES ('$name','$age')";
    
    $result = mysqli_query($con , $sql);
    
    if ($result) {
        echo 'Success   ';
    }
}

function ShowContent(){
    include("database.php");
    $sql = "SELECT `Name`, `Age`, `id` FROM `user`"; // Adjust the table and column names as needed
$result = $con->query($sql);
$data = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}



// Return the data as JSON

echo json_encode($data);
}
function deletedata(){
    include("database.php");
    $sql = "DELETE FROM `user`";
    
    $result = mysqli_query($con , $sql);
    
    if ($result) {
        echo 'Success   ';
     } //else{
    //     echo'error';
    // }
}
?>