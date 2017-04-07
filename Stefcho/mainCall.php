<?php

header('Content-Type: application/json');

date_default_timezone_set('Etc/UTC');
error_reporting(1);

include_once('config.php');
  
$errors = array();  
$success = array();

$query = 'SELECT website, preferedTime, webType FROM websites WHERE userId = "'  . $_SESSION['user'][id] . '"';
$result = mysqli_query($dbLink, $query);
$data2 = array();

foreach ($result as $row) {
    $time = explode(":", $row['preferedTime']);
    $row['preferedTime'] = $time[2] + $time[1]*60 + $time[0]*3600;

    $data2[] = $row;
}
$data1 = array();

for($i = 4; $i >= 0; $i--) {
    $days_ago = date('d/m/Y', mktime(0, 0, 0, date("m") , date("d") - $i, date("Y")));
    $query = 'SELECT website, dailyTime, numberOfAccesses, currentDate, xp FROM websiteuse WHERE userId = "'  . $_SESSION['user'][id] . '" AND currentDate = "' . $days_ago . '" order by dailyTime desc';
    $result1 = mysqli_query($dbLink, $query);
    $tempArray = array();

    foreach ($result as $row) {
        $check = false;
        foreach ($result1 as $row1) {
            if($row['website'] == $row1['website']) {
                $time = explode(":", $row1['dailyTime']);
                $row1['dailyTime'] = $time[2] + $time[1]*60 + $time[0]*3600;
                $row1['numberOfAccesses'] = intval($row1['numberOfAccesses']);
                $tempArray[] = $row1;
                $check = true;
            }
        }
        if($check == false) {
            $newRow['website'] = $row['website'];
            $newRow['dailyTime'] = 0;
            $newRow['numberOfAccesses'] = 0;
            $newRow['currentDate'] = $days_ago;
            if($row['webType'] == 'negative')$newRow['xp'] = 4;
            else if($row['webType'] == 'positive')$newRow['xp'] = 0;
            $tempArray[] = $newRow;
        }
    }
    $data1[] = $tempArray;
}

echo json_encode(array($data1, $data2));
?>