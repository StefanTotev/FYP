<?php
$dbLink = new mysqli('localhost', 'root');
if (!$dbLink) die('Can\'t establish a connection to the database: ' . mysqli_error());

$dbSelected = mysqli_select_db($dbLink, "fyp_database");
if (!$dbSelected) die ('We\'re connected, but can\'t use the table: ' . mysqli_error());

// Create user attempt  
if(isset($_POST['email']) && isset($_POST['password'])){

    $userEmail = $_POST['email'];
    $userPassword = $_POST['password'];

    $query = 'INSERT INTO users SET email = "' . mysqli_real_escape_string($dbLink, $userEmail) . '", 
                                    password = "' . mysqli_real_escape_string($dbLink, md5($userPassword)) . '"';

    if(mysqli_query($dbLink,$query)){
        echo 'success';
    }else{
        echo $userEmail . " " . $userPassword;
    }
}
?>