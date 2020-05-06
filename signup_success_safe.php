<!DOCTYPE html>
<html>
<head>
<title>Secured Signup Success</title>
    <link href="https://fonts.googleapis.com/css?family=Poiret+One|Raleway|Montserrat" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Anton" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Roboto Condensed' rel='stylesheet'>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php

    include 'aes.php';

    if(isset($_POST['submit_button']))
    {
        $name=$_POST['name'];
        $email=$_POST['u_name'];
        $password=$_POST['u_pass'];

        $key_number=1345;

        $blockSize=256;

        //$vulnerablity = array("--" , "#", "admin","root" , "'", "*", "/", "/!", ";", " ");

        //echo "TEST PHP-1"


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
                    

                $aes_name = new AES($name, $encryption_key, $blockSize);
                $enc_name = $aes_name->encrypt();
                $aes_name->setData($enc_name);
                $dec_name=$aes_name->decrypt();

                // UNCOMMENT THE LINE BELOW TO NAME ENTERED
                //echo "Entered Name: ".$dec_name."<br/>";

                $aes_email = new AES($email, $encryption_key, $blockSize);
                $enc_email = $aes_email->encrypt();
                $aes_email->setData($enc_email);
                $dec_email=$aes_email->decrypt();

                // UNCOMMENT THE LINE BELOW TO EMAIL ENTERED
                //echo "Entered Email: ".$dec_email."<br/>";

                $aes_password = new AES($password, $encryption_key, $blockSize);
                $enc_password = $aes_password->encrypt();
                $aes_password->setData($enc_password);
                $dec_password=$aes_password->decrypt();

                // UNCOMMENT THE LINE BELOW TO PASSWORD ENTERED
                //echo "Entered Password: ".$dec_password."<br/>";


                    if (strpos($dec_name, "'") !== FALSE
                    || strpos($dec_name, "-") !== FALSE
                    || strpos($dec_name, "#") !== FALSE
                    || strpos($dec_name, "admin") !== FALSE
                    || strpos($dec_name, "root") !== FALSE
                    || strpos($dec_name, "*") !== FALSE
                    || strpos($dec_name, "/") !== FALSE
                    || strpos($dec_name, "!") !== FALSE
                    || strpos($dec_name, ";") !== FALSE
                    || strpos($dec_name, "_") !== FALSE
                    || strpos($dec_name, "=") !== FALSE
                    || strpos($dec_name, "\"") !== FALSE
                    || strpos($dec_name, "+") !== FALSE
                    || strpos($dec_name, "%") !== FALSE
                    || strpos($dec_name, "&") !== FALSE
                    || strpos($dec_name, "|") !== FALSE
                    || strpos($dec_name, "^") !== FALSE
                    || strpos($dec_name, "=") !== FALSE
                    || strpos($dec_name, ">") !== FALSE
                    || strpos($dec_name, "<") !== FALSE
                    || strpos($dec_name, "^") !== FALSE

                    || strpos($dec_email, "'") !== FALSE
                    || strpos($dec_email, "-") !== FALSE
                    || strpos($dec_email, "#") !== FALSE
                    || strpos($dec_email, "admin") !== FALSE
                    || strpos($dec_email, "root") !== FALSE
                    || strpos($dec_email, "*") !== FALSE
                    || strpos($dec_email, "/") !== FALSE
                    || strpos($dec_email, "!") !== FALSE
                    || strpos($dec_email, ";") !== FALSE
                    || strpos($dec_email, " ") !== FALSE
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

                    || strpos($dec_password, "'") !== FALSE
                    || strpos($dec_password, "-") !== FALSE
                    || strpos($dec_password, "#") !== FALSE
                    || strpos($dec_password, "admin") !== FALSE
                    || strpos($dec_password, "root") !== FALSE
                    || strpos($dec_password, "*/") !== FALSE
                    || strpos($dec_password, "/*") !== FALSE
                    || strpos($dec_password, "!") !== FALSE
                    || strpos($dec_password, ";") !== FALSE
                    || strpos($dec_password, " ") !== FALSE
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
                    }
                
                    else{
                        $query_signup = "INSERT INTO user_details (full_name,user_email,user_password) VALUES ('".$enc_name."','".$enc_email."','".$enc_password."')";
                        $result_signup = mysqli_query($conn_main,$query_signup);
                                        
                        if($query_signup){
                                
                            echo "<div class=\"header\">
                                        <h2>SIGN-UP SUCCESSFUL!</h2>
                                    </div>
                                <form>
                                    <button formaction='http://192.168.1.8/DP_AT/login_1.php' class='btn'>Go To Unsecure Login Page</button>
                                    <button formaction='http://192.168.1.8/DP_AT/login_safe.php' class='btn'>Go To Secure Login Page</button>
                                </form>";
                        }
                        else{
                            echo "<div class=\"header\">
                                    <h2>SIGN-UP ERROR! TRY AGAIN</h2>
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
</body>