<?php
error_reporting(1);
// Start the session (pretty important!)  
session_start();  
  
// Establish a link to the database  
$dbLink = new mysqli('localhost', 'root', 'fypfinalpassword');
if (!$dbLink) die('Can\'t establish a connection to the database: ' . mysqli_error());
  
$dbSelected = mysqli_select_db($dbLink, "fyp_database");
if (!$dbSelected) die ('We\'re connected, but can\'t use the table: ' . mysqli_error());
  
// Run a quick check to see if we are an authenticated user or not  
// First, we set a 'is the user logged in' flag to false by default.
$isUserLoggedIn = false;  
$query      = 'SELECT * FROM users WHERE session_id = "' . session_id() . '" LIMIT 1';
$userResult     = mysqli_query($dbLink, $query);  
if(mysqli_num_rows($userResult) == 1){  
    $_SESSION['user'] = mysqli_fetch_assoc($userResult);
    $tempUserId = $_SESSION['user']['id'];
    echo $tempUserId;
    $isUserLoggedIn = true;  
}else{  
    echo 'fail'; 
}  


?>