<?php
$dbLink = new mysqli('localhost', 'root', 'fypfinalpassword');
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
    	$query  = 'SELECT id FROM users WHERE email = "' . mysqli_real_escape_string($dbLink, $userEmail) . '" LIMIT 1';
        $result = mysqli_query($dbLink, $query);
        $id = mysqli_fetch_assoc($result);
        $id = $id['id'];

        if(mysqli_num_rows($result) > 0) {
        	$query = 'INSERT INTO websites SET userId = ("' . mysqli_real_escape_string($dbLink, $id) . '"), 
                                       website = "other",
                                       preferedTime = "24:00:00",
                                       webType = "other"';
			mysqli_query($dbLink, $query);
			echo 'success';
        }
    }else{
        echo 'failure';
    }
}
?>