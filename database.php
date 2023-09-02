<?php
$servername="localhost";
$username="root";
$password="";
$database="employee_list";
$con=mysqli_connect($servername,$username,$password,$database);

if(!$con)
{
    die("Connection Not Established".mysqli_error($con));
}
// } else{
//     // echo("Connection is Established");
// }


?>