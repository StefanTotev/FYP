<?php
    if(isset($_POST['userID']) && isset($_POST['website'])) {
        $userID = $_POST['userID'];
        $website = trim($_POST['website']);

        include_once('config.php');

        $query = 'DELETE FROM websites WHERE userId = "' . $userID . '" AND website = "' . $website . '"';

        if(mysqli_query($dbLink, $query)) {
            echo 'Website Removed!';
        } else {
            echo 'Website removal failed!';
        }
    }
?>