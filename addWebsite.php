<?php
    if(isset($_POST['userID']) && isset($_POST['website']) && isset($_POST['time']) && isset($_POST['type'])) {
        $userID = $_POST['userID'];
        $website = trim($_POST['website']);
        $time = $_POST['time'];
        $type = $_POST['type'];
        $xp = 4;

        if($type == 'negative') {
            $xp = 4;
        } else {
            $xp = 0;
        }

        include_once('Stefcho/config.php');

        $query = 'INSERT INTO websites SET userId = ("' . mysqli_real_escape_string($dbLink, $userID) . '"), 
                                       website = ("' . mysqli_real_escape_string($dbLink, $website) . '"),
                                       preferedTime = ("' . mysqli_real_escape_string($dbLink, $time) . '"),
                                       webType = "' . $type . '"';
        if(mysqli_query($dbLink, $query)) {
            $query = 'INSERT INTO websiteuse SET userId = ("' . mysqli_real_escape_string($dbLink, $userID) . '"), 
                                       website = ("' . mysqli_real_escape_string($dbLink, $website) . '"),
                                       dailyTime = "00:00:00",
                                       numberOfAccesses = 0,
                                       currentDate = "' . date("d/m/Y") . '",
                                       xp = "' . $xp . '"';
            if(mysqli_query($dbLink, $query)) {
                echo 'User created!';
            } else {
                echo 'User creation failed for use!';
            }
        } else {
            echo 'User creation failed!';
        }
    }
?>