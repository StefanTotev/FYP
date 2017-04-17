<?php
    if(isset($_POST['email']) && isset($_POST['password'])) {
        $loginEmail = trim($_POST['email']);
        $loginPassword  = trim($_POST['password']);

        include_once('config.php');

        $query  = 'SELECT * FROM users WHERE email = "' . mysqli_real_escape_string($dbLink, $loginEmail) . '" AND password = MD5("' . $loginPassword . '") LIMIT 1';
        $result = mysqli_query($dbLink,$query);
        if(mysqli_num_rows($result) == 1){
            $user = mysqli_fetch_assoc($result);
            $query = 'UPDATE users SET session_id = "' . session_id() . '" WHERE id = ' . $user['id'] . ' LIMIT 1';
            mysqli_query($dbLink,$query);
            echo $user['id'];


            /*$query = 'SELECT website FROM websites WHERE userId = "' . $user['id'] . '";';
            $result = mysqli_query($dbLink,$query);

            $return_arr = array();

            while ($websites = mysqli_fetch_assoc($result)){
                $row_array['website'] = $websites["website"];
                array_push($return_arr,$row_array);

            }

            echo json_encode($return_arr);

            */
            //echo '<script type="text/javascript">BootstrapDialog.show({type:"type-warning", title: "Warning",message: "test"});</script>';

        }else{
            $errors['login'] = 'No user was found with the details provided.';
            //echo '<script type="text/javascript">BootstrapDialog.show({type:"type-warning", title: "Warning",message: "User credentials could not be verified!"});</script>';
        }
    } else {
        echo 'Missing credentials';
    }
?>