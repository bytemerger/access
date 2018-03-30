<?php
/**
 * Created by PhpStorm.
 * User: franc
 * Date: 10/31/17
 * Time: 11:12 PM
 */
session_start();
?>
    <!DOCTYPE html>
    <header>
        <meta charset="UTF-8">
        <title>Quiz</title>
    </header>
    <link rel="stylesheet" type="text/css" href="que.css">
    <body>
    <div class="head3">
        <h3 class="suu">Error</h3>
        <span class="mes"><?php echo $_SESSION["message"]; ?></span><br><br><br><br><br>
        <a href="home.html" class="sucHome">Home</a>
    </div>
    </body>
    </html>
<?php
session_destroy();
?>