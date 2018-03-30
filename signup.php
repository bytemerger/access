<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Quiz</title>
</head>
<link rel="stylesheet" type="text/css" href="que.css">
<body id="whole">
    <h2><a class="tem2" href="home.html">Quest</a></h2>
  <!-- <div> <img src="images/new.png" height="100px" width="100%"></div>=-->
    <div class="middle">
        <span class="bold">Create an account</span><br> <br>
        <small id="int">Already have an account?<a id="sign" href="signIn.html"> Sign in here</a> </small><br><br><br>
        <div id="sign"> <?php echo $_SESSION['error'];?> </div>
        <form method="POST" action="create.php">
            <input class="roun" required type="text"     name="fname" placeholder="First Name" size="35"><br><br>
            <input class="roun" required type="email"    name="email" placeholder="your-email@example.com" size="35"><br><br>
            <input class="roun" required type="password" name="pass" placeholder="password" size="35" minlength="8"><br><br>
            <input class="roun" required type="tel"      name="telo" placeholder="mobile no" minlength="11" maxlength="15" size="35" pattern="^[0-9\-\+]{9,15}$"><br><br>
            <input type="submit" value="CREATE FREE ACCOUNT" id="subdes">
        </form>
    </div>
</body>
</html>
<?php session_destroy(); ?>