<!DOCTYPE html>
<html>
<head>
<title>Unsafe Signup Success</title>
    <link href="https://fonts.googleapis.com/css?family=Poiret+One|Raleway|Montserrat" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Anton" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Roboto Condensed' rel='stylesheet'>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php
    if(isset($_POST['submit_button']))
    {
        $name=$_POST['name'];
        $email=$_POST['u_name'];
        $password=$_POST['u_pass'];

        //echo "TEST PHP-1"

        $conn = mysqli_connect("localhost","root","","dp_advanced_technology");
        if(!$conn){
            echo "<br><br> UNABLE TO CONNECT TO THE DATABASE. CHECK PHP CODE";
        }
        else{
            
            //echo "CONNECTION SUCCESSFUL";

            $query1 = "INSERT INTO user_details (full_name,user_email,user_password) VALUES ('".$name."','".$email."','".$password."')";
            $result1 = mysqli_query($conn,$query1);

            if($query1){
                
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
?>
</body>