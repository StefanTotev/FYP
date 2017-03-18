<?php
    if(isset($_POST['userID']) && isset($_POST['website'])) {
        $userID = $_POST['userID'];
        $website = trim($_POST['website']);

        include_once('Stefcho/config.php');

        $query = 'SELECT * FROM websites WHERE userId = "' . $userID . '" AND website = "' . $website . '" LIMIT 1';
        $result = mysqli_query($dbLink, $query);

        if(mysqli_num_rows($result) > 0){
            echo 'true';
        } else {
            echo 'false';
        }
    }
?>