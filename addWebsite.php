<?php
    if(isset($_POST['userID']) && isset($_POST['website']) && isset($_POST['time'])) {
        $userID = $_POST['userID'];
        $website = trim($_POST['website']);
        $time = $_POST['time'];
        $dailyTime = "00:00";

        include_once('Stefcho/config.php');

        $query = 'INSERT INTO websites SET userId = ("' . mysqli_real_escape_string($dbLink, $userID) . '"), 
                                       website = ("' . mysqli_real_escape_string($dbLink, $website) . '"),
                                       preferedTime = ("' . mysqli_real_escape_string($dbLink, $time) . '"),
                                       dailyTime = ("' . $dailyTime . '")';
        if(mysqli_query($dbLink, $query)) {
            echo 'User created!';
        } else {
            echo 'User creation failed!';
        }
    }
?>