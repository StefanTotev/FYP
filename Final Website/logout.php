<?php

include_once('config.php');
$userID  = trim($_POST['userID']);
echo $userID;
$query = 'UPDATE users SET session_id = NULL WHERE id = ' . $userID . ' LIMIT 1';
mysqli_query($dbLink, $query);  
unset($_SESSION['user']);
exit;  

?>