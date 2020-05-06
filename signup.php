<!DOCTYPE html>
<html>
<head>
<title>Unsafe Signup</title>
    <link href="https://fonts.googleapis.com/css?family=Poiret+One|Raleway|Montserrat" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Anton" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Roboto Condensed' rel='stylesheet'>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="header">
        <h2>UNSECURE SIGN-UP</h2>
    </div>
    <form action="signup_success.php" method="post" autocomplete="off">
    <div class="input-group">
            <label for="name">FULL NAME:</label>
            <input type="text" name="name" id="name" required><br><br>
        </div>
        <div class="input-group">
            <label for="u_name">EMAIL ADDRESS:</label>
            <input type="text" name="u_name" id="u_name" required><br><br>
        </div>
        <div class="input-group">
            <label for="u_pass">PASSWORD:</label>
            <input type="password" name="u_pass" id="u_pass" required><br><br>
        </div>
        <div class="input-group">
            <button type=submit class='btn' name='submit_button'>SUBMIT</button>
        </div>
    </form>
</body>