<!DOCTYPE html>
<html>
<head>
<title>Secured Login</title>
    <link href="https://fonts.googleapis.com/css?family=Poiret+One|Raleway|Montserrat" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Anton" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Roboto Condensed' rel='stylesheet'>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php

date_default_timezone_set('Asia/Kolkata');

include 'aes.php';

    if(isset($_POST['submit_button']))
    {
        $email=$_POST['u_name'];
        $password=$_POST['u_pass'];

        //echo "TEST PHP-1"

        $key_number=1345;

        $blockSize=256;

        //$vulnerablity = array("--" , "#", "admin","root" , "'", "*", "/", "/!", ";", " ");

        //echo "TEST PHP-1"

        //whether ip is from share internet
        if (!empty($_SERVER['HTTP_CLIENT_IP']))   
        {
        $ip_address = $_SERVER['HTTP_CLIENT_IP'];
        }
        //whether ip is from proxy
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))  
        {
        $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        //whether ip is from remote address
        else
        {
        $ip_address = $_SERVER['REMOTE_ADDR'];
        }

        $date_current = date("Y-m-d");
        $time_current = date("h:i:sa");


        $conn_main = mysqli_connect("localhost","root","","dp_advanced_technology");
        $conn_key_manager = mysqli_connect("localhost","root","","alliance_key_manager");
        $conn_key_connection = mysqli_connect("localhost","root","","key_connection");
        

        if(!$conn_main && !$conn_key_manager && !$conn_key_connection){
            echo "<br><br> UNABLE TO CONNECT TO THE DATABASE";
        }
        else{
            
            //echo "MIAN DATABASE CONNECTION SUCCESSFUL";

            $query_key_connection = "SELECT key_id FROM key_info WHERE key_number='$key_number' ";
            $result_key_connection = mysqli_query($conn_key_connection,$query_key_connection);
            
            $row_key = mysqli_fetch_assoc($result_key_connection);
            $key_id = $row_key['key_id'];

            // UNCOMMENT THE LINE BELOW TO SHOW KEY ID
            //echo "<br/>Key ID = ".$key_id."<br/>";
   
            $query_secret_key = "SELECT secret_key FROM encryption_key WHERE key_id='$key_id' ";
            $result_secret_key = mysqli_query($conn_key_manager,$query_secret_key);

            $row_key_secret = mysqli_fetch_assoc($result_secret_key);
            $encryption_key = $row_key_secret['secret_key'];
    
            // UNCOMMENT THE LINE BELOW TO SHOW ENCRYPTION KEY
            //echo "<br/>Encryption Key = ".$encryption_key."<br/>";

            if($query_secret_key){

                // ENCRYPTION OF USER'S NAME, EMAIL AND PASSWORD
                    
                $aes_email = new AES($email, $encryption_key, $blockSize);
                $enc_email = $aes_email->encrypt();
                $aes_email->setData($enc_email);
                $dec_email=$aes_email->decrypt();

                // UNCOMMENT THE LINE BELOW TO EMAIL ENTERED
                //echo "Encrypted Email: ".$enc_email."<br/>";
                //echo "Entered Email: ".$dec_email."<br/>";

                $aes_password = new AES($password, $encryption_key, $blockSize);
                $enc_password = $aes_password->encrypt();
                $aes_password->setData($enc_password);
                $dec_password=$aes_password->decrypt();

                // UNCOMMENT THE LINE BELOW TO PASSWORD ENTERED
                //echo "Encrypted Password: ".$enc_password."<br/>";
                //echo "Entered Password: ".$dec_password."<br/>";


                    if (strpos($dec_email, "-") !== FALSE
                    || strpos($dec_email, "#") !== FALSE
                    || strpos($dec_email, "admin") !== FALSE
                    || strpos($dec_email, "root") !== FALSE
                    || strpos($dec_email, "*") !== FALSE
                    || strpos($dec_email, "/") !== FALSE
                    || strpos($dec_email, "!") !== FALSE
                    || strpos($dec_email, ";") !== FALSE
                    || strpos($dec_email, " ") !== FALSE
                    || strpos($dec_email, "'") !== FALSE
                    || strpos($dec_email, "=") !== FALSE
                    || strpos($dec_email, "\"") !== FALSE
                    || strpos($dec_email, "+") !== FALSE
                    || strpos($dec_email, "%") !== FALSE
                    || strpos($dec_email, "&") !== FALSE
                    || strpos($dec_email, "|") !== FALSE
                    || strpos($dec_email, "^") !== FALSE
                    || strpos($dec_email, "=") !== FALSE
                    || strpos($dec_email, ">") !== FALSE
                    || strpos($dec_email, "<") !== FALSE
                    || strpos($dec_email, "^") !== FALSE

                    || strpos($dec_password, "-") !== FALSE
                    || strpos($dec_password, "#") !== FALSE
                    || strpos($dec_password, "admin") !== FALSE
                    || strpos($dec_password, "root") !== FALSE
                    || strpos($dec_password, "*") !== FALSE
                    || strpos($dec_password, "/") !== FALSE
                    || strpos($dec_password, "!") !== FALSE
                    || strpos($dec_password, ";") !== FALSE
                    || strpos($dec_password, " ") !== FALSE
                    || strpos($dec_password, "'") !== FALSE
                    || strpos($dec_password, "=") !== FALSE
                    || strpos($dec_password, "\"") !== FALSE
                    || strpos($dec_password, "+") !== FALSE
                    || strpos($dec_password, "%") !== FALSE
                    || strpos($dec_password, "&") !== FALSE
                    || strpos($dec_password, "|") !== FALSE
                    || strpos($dec_password, "^") !== FALSE
                    || strpos($dec_password, "=") !== FALSE
                    || strpos($dec_password, ">") !== FALSE
                    || strpos($dec_password, "<") !== FALSE
                    || strpos($dec_password, "^") !== FALSE
                    
                    ) {
                        echo "<div class=\"header\">
                                 <h2>VULNERABLITY DETECTED!</h2>
                              </div>";
                        
                        $query_check_ip = "SELECT * FROM vulnerable_user WHERE ip_address='$ip_address' ";
                        $result_check_ip = mysqli_query($conn_main,$query_check_ip);

                        if(mysqli_num_rows($result_check_ip) == 1){

                            $query_update_attacker = "UPDATE vulnerable_user SET attack_count = attack_count + 1 WHERE ip_address='$ip_address' ";
                            $result_update_attacker = mysqli_query($conn_main,$query_update_attacker);

                            $row_attacker = mysqli_fetch_assoc($result_update_attacker);
                            $attack_count = $row_attacker['attack_count'];
                        }
                        else{

                            $query_new_attacker = "INSERT INTO vulnerable_user (ip_address,attack_count) VALUES ('".$ip_address."','1') ";
                            $result_new_attacker = mysqli_query($conn_main,$query_new_attacker);
                        }
                        
                    }
                
                    else{
                        $query_login = "SELECT * FROM user_details WHERE user_email='$enc_email' AND user_password='$enc_password' ";
                        $result_login = mysqli_query($conn_main,$query_login);

                        if(mysqli_num_rows($result_login) == 1){

                            $row_user = mysqli_fetch_assoc($result_login);                            
                            $enc_user_current = $row_user['full_name'];

                            $aes_user = new AES($enc_user_current, $encryption_key, $blockSize);                            
                            $dec_user_current=$aes_user->decrypt();
                            $aes_user->setData($dec_user_current);

                            $query_check_blocked_status = "SELECT MAX(vulnerable_user.attack_count) FROM vulnerable_user,login_logs WHERE login_logs.ip_address = vulnerable_user.ip_address AND login_logs.user_email='$dec_email' ";
                            $result_check_blocked_status = mysqli_query($conn_main,$query_check_blocked_status);

                            if(mysqli_num_rows($result_check_blocked_status) == 1){
                                
                                $row_check_attack_count = mysqli_fetch_assoc($result_check_blocked_status);
                                $check_attack_count = $row_check_attack_count['MAX(vulnerable_user.attack_count)'];

                                if($check_attack_count > 3){
                                    echo "<div class=\"header\">
                                            <h2>YOUR ACCOUNT IS TEMPORARILY BLOCKED</h2><br>
                                            <h2>ATTACK COUNT: ".$check_attack_count."</h2>
                                            <h2>BLOCKED USER: ".$dec_user_current."</h2>
                                        </div>";
                                }
                                else{
                                    echo "<div class=\"header\">
                                            <h2>LOGGED IN SUCCESSFULLY</h2><br>
                                            <h2>CURRENT USER: ".$dec_user_current."</h2>
                                        </div>";
                                    
                                    $query_login_logs = "INSERT INTO login_logs (user_email,date_current,time_current,ip_address) VALUES ('".$dec_email."','".$date_current."','".$time_current."','".$ip_address."')";
                                    $result_login_logs = mysqli_query($conn_main,$query_login_logs); 
                                }

                            }
                            
                            else{

                            echo "<div class=\"header\">
                                    <h2>LOGGED IN SUCCESSFULLY</h2><br>
                                    <h2>CURRENT USER: ".$dec_user_current."</h2>
                                </div>";
                                
                                $query_login_logs = "INSERT INTO login_logs (user_email,date_current,time_current,ip_address) VALUES ('".$dec_email."','".$date_current."','".$time_current."','".$ip_address."')";
                                $result_login_logs = mysqli_query($conn_main,$query_login_logs);                           

                            }

                        }
                        else{
                            echo "<div class=\"header\">
                                 <h2>INVALID LOGIN CREDENTIALS</h2>
                              </div>";
                        }
                    }
                }
                else{
                    echo "Key not Found <br/>";
                }
            }
    }
?>

    <!-- <h1>Successful</h1> -->
</body>