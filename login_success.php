<!DOCTYPE html>
<html>
<head>
<title>Unsafe Login</title>
    <link href="https://fonts.googleapis.com/css?family=Poiret+One|Raleway|Montserrat" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Anton" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Roboto Condensed' rel='stylesheet'>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php
    if(isset($_POST['submit_button']))
    {
        $email=$_POST['u_name'];
        $password=$_POST['u_pass'];

        //echo "TEST PHP-1"

        $conn = mysqli_connect("localhost","root","","dp_advanced_technology");
        if(!$conn){
            echo "<br><br> UNABLE TO CONNECT TO THE DATABASE. CHECK PHP CODE";
        }
        else{
            
            //echo "CONNECTION SUCCESSFUL";

            $query1 = "SELECT * FROM user_details WHERE user_email='$email' AND user_password='$password' ";
            $result1 = mysqli_query($conn,$query1);

            if(mysqli_num_rows($result1) == 1){

                $row_user = mysqli_fetch_assoc($result1);
                $user_current = $row_user['full_name'];
                
                echo "<div class=\"header\">
                     <h2>LOGGED IN SUCCESSFULLY</h2><br>
                     <h2>CURRENT USER: ".$user_current."</h2>
                  </div>";

            }
            else{
                echo "<div class=\"header\">
                     <h2>INVALID LOGIN CREDENTIALS</h2>
                  </div>";
            }
        }

    }
?>

    <!-- <h1>Successful</h1> -->
</body>