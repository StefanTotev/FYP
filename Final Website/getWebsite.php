<?php
    if(isset($_POST['userID']) && isset($_POST['website'])) {
        $userID = $_POST['userID'];
        $website = trim($_POST['website']);

        include_once('config.php');

        $query = 'SELECT * FROM websites WHERE userId = "' . $userID . '" AND website = "' . $website . '" LIMIT 1';
        $result1 = mysqli_query($dbLink, $query);

	$query = 'SELECT dailyTime, numberOfAccesses FROM websiteuse WHERE userId = "' . $userID . '" AND website = "' . $website . '" AND currentDate = "' . date("d/m/Y") . '" LIMIT 1';
        $result2 = mysqli_query($dbLink, $query);
	
	$row1 = mysqli_fetch_assoc($result1);
	$sampleTime = explode(":", $row1['preferedTime']);
	$row1['preferedTime'] = $sampleTime[0] . ":" . $sampleTime[1];
	$row2 = mysqli_fetch_assoc($result2);
	$sampleTime = explode(":", $row2['dailyTime']);
	$row2['dailyTime'] = $sampleTime[0] . ":" . $sampleTime[1];
	array_push($row1 , $row2['dailyTime'] , $row2['numberOfAccesses']);
        if(mysqli_num_rows($result1) > 0){
            echo json_encode($row1);
        } else {
            echo 'false';
        }
    }
?>