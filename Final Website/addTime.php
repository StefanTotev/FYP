<?php
    if(isset($_POST['userID']) && isset($_POST['prevWebsite']) && isset($_POST['currWebsite']) && isset($_POST['time']) && isset($_POST['type'])) {
        $userID = $_POST['userID'];
        $prevWebsite = trim($_POST['prevWebsite']);
        $currWebsite = trim($_POST['currWebsite']);
        $time = $_POST['time'];
        $type = $_POST['type'];

        include_once('config.php');

        $newTime = explode(":", $time);

        $query = 'SELECT webType FROM websites WHERE userId = "' . $userID . '" AND website = "' . $prevWebsite . '" LIMIT 1';
        $result = mysqli_query($dbLink, $query);

        if(mysqli_num_rows($result) > 0){
            $webType = mysqli_fetch_assoc($result);
            $query = 'SELECT dailyTime FROM websiteuse WHERE userId = "' . $userID . '" AND website = "' . $prevWebsite . '" AND currentDate = "' . date("d/m/Y") . '" LIMIT 1';
            $result1 = mysqli_query($dbLink, $query);

            if(mysqli_num_rows($result1) > 0) {
                $dailyTime = mysqli_fetch_assoc($result1);
                $currentTime = explode(":", $dailyTime['dailyTime']);

                if($currentTime[2] + $newTime[2] >= 60) {
                    $currentTime[2] = ($currentTime[2] + $newTime[2]) % 60;
                    $currentTime[1] = $currentTime[1] + 1;
                } else {
                    $currentTime[2] = $currentTime[2] + $newTime[2];
                }
                if($currentTime[1] + $newTime[1] >= 60) {
                    $currentTime[1] = ($currentTime[1] + $newTime[1]) % 60;
                    $currentTime[0] = $currentTime[0] + 1;
                } else {
                    $currentTime[1] = $currentTime[1] + $newTime[1];
                }
                $currentTime[0] = $currentTime[0] + $newTime[0];

                if($type == 'increment') {
                    $query = 'UPDATE websiteuse SET dailyTime = "' . $currentTime[0] . ":" . $currentTime[1] . ":" . $currentTime[2] . '", numberOfAccesses = numberOfAccesses + 1 WHERE userId = ' . $userID . ' AND website = "' . $prevWebsite . '" AND currentDate = "' . date("d/m/Y") . '" LIMIT 1';
                } else {
                    $query = 'UPDATE websiteuse SET dailyTime = "' . $currentTime[0] . ":" . $currentTime[1] . ":" . $currentTime[2] . '" WHERE userId = ' . $userID . ' AND website = "' . $prevWebsite . '" AND currentDate = "' . date("d/m/Y") . '" LIMIT 1';
                }
                mysqli_query($dbLink, $query);
            } else {
                $query = 'INSERT INTO websiteuse SET userId = ("' . mysqli_real_escape_string($dbLink, $userID) . '"), 
                                       website = ("' . mysqli_real_escape_string($dbLink, $prevWebsite) . '"),
                                       dailyTime = "' . $newTime[0] . ":" . $newTime[1] . ":" . $newTime[2] . '",
                                       numberOfAccesses = 1,
                                       currentDate = "' . date("d/m/Y") . '",
                                       xp = 0';
                mysqli_query($dbLink, $query);
            }
        } else {
            $query = 'SELECT dailyTime FROM websiteuse WHERE userId = "' . $userID . '" AND website = "other" AND currentDate = "' . date("d/m/Y") . '" LIMIT 1';
            $result1 = mysqli_query($dbLink, $query);

            if(mysqli_num_rows($result1) > 0) {
                $dailyTime = mysqli_fetch_assoc($result1);
                $currentTime = explode(":", $dailyTime['dailyTime']);

                if($currentTime[2] + $newTime[2] >= 60) {
                    $currentTime[2] = ($currentTime[2] + $newTime[2]) % 60;
                    $currentTime[1] = $currentTime[1] + 1;
                } else {
                    $currentTime[2] = $currentTime[2] + $newTime[2];
                }
                if($currentTime[1] + $newTime[1] >= 60) {
                    $currentTime[1] = ($currentTime[1] + $newTime[1]) % 60;
                    $currentTime[0] = $currentTime[0] + 1;
                } else {
                    $currentTime[1] = $currentTime[1] + $newTime[1];
                }
                $currentTime[0] = $currentTime[0] + $newTime[0];

                if($type == 'increment') {
                    $query = 'UPDATE websiteuse SET dailyTime = "' . $currentTime[0] . ":" . $currentTime[1] . ":" . $currentTime[2] . '", numberOfAccesses = numberOfAccesses + 1 WHERE userId = ' . $userID . ' AND website = "other" AND currentDate = "' . date("d/m/Y") . '" LIMIT 1';
                } else {
                    $query = 'UPDATE websiteuse SET dailyTime = "' . $currentTime[0] . ":" . $currentTime[1] . ":" . $currentTime[2] . '" WHERE userId = ' . $userID . ' AND website = "other" AND currentDate = "' . date("d/m/Y") . '" LIMIT 1';
                }
                mysqli_query($dbLink, $query);
            } else {
                $query = 'INSERT INTO websiteuse SET userId = ("' . mysqli_real_escape_string($dbLink, $userID) . '"), 
                                       website = "other",
                                       dailyTime = "' . $newTime[0] . ":" . $newTime[1] . ":" . $newTime[2] . '",
                                       numberOfAccesses = 1,
                                       currentDate = "' . date("d/m/Y") . '",
                                       xp = "0"';
                mysqli_query($dbLink, $query);
            }
        }

        $query = 'SELECT preferedTime, webType FROM websites WHERE userId = "' . $userID . '" AND website = "' . $currWebsite . '" LIMIT 1';
        $result = mysqli_query($dbLink, $query);

        if(mysqli_num_rows($result) > 0) {
            $query = 'SELECT dailyTime, reminder, xp FROM websiteuse WHERE userId = "' . $userID . '" AND website = "' . $currWebsite . '" AND currentDate = "' . date("d/m/Y") . '" LIMIT 1';
            $result1 = mysqli_query($dbLink, $query);
            $row = mysqli_fetch_row($result);
            $webType = $row[1];
            if(mysqli_num_rows($result1) > 0) {

                $result1 = mysqli_fetch_row($result1);
                $reminder = $result1[1];
                $xp = $result1[2];

                $prefTime = explode(":", $row[0]);
                $currTime = explode(":", $result1[0]);

                $prefSecs = $prefTime[2] + $prefTime[1]*60 + $prefTime[0]*3600;
                $currSecs = $currTime[2] + $currTime[1]*60 + $currTime[0]*3600;

                $final = $prefSecs - $currSecs;

                if($final > 0) {
                    if ($final <= 300 && $reminder != 'four') {
                        if ($webType == 'negative'){
                            $xp = 0;
                            echo 'neg5min ';
                        } else {
                            $xp = 4;
                            echo 'pos5min ';
                        }
                        $query = 'UPDATE websiteuse SET reminder = "four", xp = "' . $xp . '" WHERE userId = ' . $userID . ' AND website = "' . $currWebsite . '" AND currentDate = "' . date("d/m/Y") . '" LIMIT 1';
                        mysqli_query($dbLink, $query);
                    } else if ($final <= 600 && $reminder != 'three' && $reminder != 'four') {
                        if ($webType == 'negative'){
                            $xp = 0;
                            echo 'neg10min ';
                        } else {
                            $xp = 3;
                            echo 'pos10min ';
                        }
                        $query = 'UPDATE websiteuse SET reminder = "three", xp = "' . $xp . '" WHERE userId = ' . $userID . ' AND website = "' . $currWebsite . '" AND currentDate = "' . date("d/m/Y") . '" LIMIT 1';
                        mysqli_query($dbLink, $query);
                    } else if ($final <= 1200 && $reminder != 'two' && $reminder != 'three' && $reminder != 'four') {
                        if ($webType == 'negative'){
                            $xp = 0;
                            echo 'neg20min ';
                        } else {
                            $xp = 2;
                            echo 'pos20min ';
                        }
                        $query = 'UPDATE websiteuse SET reminder = "two", xp = "' . $xp . '" WHERE userId = ' . $userID . ' AND website = "' . $currWebsite . '" AND currentDate = "' . date("d/m/Y") . '" LIMIT 1';
                        mysqli_query($dbLink, $query);
                    } else if ($prefSecs/$currSecs <= 2 && $currSecs > 0 && $reminder != 'one' && $reminder != 'two' && $reminder != 'three' && $reminder != 'four') {
                        if ($webType == 'negative') {
                            $xp = 0;
                            echo 'negHalf ';
                        } else {
                            $xp = 1;
                            echo 'posHalf ';
                        }
                        $query = 'UPDATE websiteuse SET reminder = "one", xp = "' . $xp . '" WHERE userId = ' . $userID . ' AND website = "' . $currWebsite . '" AND currentDate = "' . date("d/m/Y") . '" LIMIT 1';
                        mysqli_query($dbLink, $query);
                    }
                    echo $final;
                } else if ($final < 0 && $webType == 'negative') {
                    $xp = 0;
                    if($reminder != 'zero') {
                        $query = 'UPDATE websiteuse SET reminder = "zero", xp = "' . $xp . '" WHERE userId = ' . $userID . ' AND website = "' . $currWebsite . '" AND currentDate = "' . date("d/m/Y") . '" LIMIT 1';
                        mysqli_query($dbLink, $query);
                    }
                    echo 'block';
                } else if ($final < 0 && $webType == 'positive') {
                    if($reminder != 'zero') {
                        $xp = 5;
                        $query = 'UPDATE websiteuse SET reminder = "zero", xp = "' . $xp . '" WHERE userId = ' . $userID . ' AND website = "' . $currWebsite . '" AND currentDate = "' . date("d/m/Y") . '" LIMIT 1';
                        mysqli_query($dbLink, $query);
                        echo 'done';
                    } else {
                        echo 'pass';
                    }
                }
            } else {
                $query = 'INSERT INTO websiteuse SET userId = ("' . mysqli_real_escape_string($dbLink, $userID) . '"), 
                                       website = ("' . mysqli_real_escape_string($dbLink, $currWebsite) . '"),
                                       dailyTime = "00:00:00",
                                       numberOfAccesses = 0,
                                       currentDate = "' . date("d/m/Y") . '",
                                       xp =  0';
                mysqli_query($dbLink, $query);
                echo 'pass';
            }
        } else {
            $query = 'SELECT dailyTime FROM websiteuse WHERE userId = "' . $userID . '" AND website = "other" AND currentDate = "' . date("d/m/Y") . '" LIMIT 1';
            $result1 = mysqli_query($dbLink, $query);
            
            if(mysqli_num_rows($result1) > 0) {
                echo $currWebsite;
            } else {
                $query = 'INSERT INTO websiteuse SET userId = ("' . mysqli_real_escape_string($dbLink, $userID) . '"), 
                                       website = "other",
                                       dailyTime = "00:00:00",
                                       numberOfAccesses = 0,
                                       currentDate = "' . date("d/m/Y") . '",
                                       xp = "0"';
                mysqli_query($dbLink, $query);
                echo 'pass';
            }
        }
    }
?>