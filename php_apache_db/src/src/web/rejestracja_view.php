<!DOCTYPE html>
<html>
    <head>
        <title>Chesslav</title>
        <link href="chesslav.css" type="text/css" rel="stylesheet" />
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <form method="post">
            <h2>rejestracja</h2>
            <p><label>e-mail: <input type="text" name="mail" placeholder="example@email.com"/></label></p>
            <p><label>nick: <input type="text" name="login" placeholder="login"/></label></p>
            <p><label>password: <input type="password" name="password" placeholder="password"/></label></p>                    
            <p><label>repeat password: <input type="password" name="repassword" placeholder="repeat password"/></label></p>                    
            <input type="submit" value="zarejestruj" onclick="zarejestruj()"/>
        </form>
        <?php
            if(isset($_COOKIE["twoPas"])) {
                $twoPas = $_COOKIE["twoPas"];
                echo "$twoPas";
            }
            if(isset($_COOKIE["user"])) {
                $user = $_COOKIE["user"];
                echo "$user";
            }
        ?>
        <a href="index.php">strona główna</a>
    </body>
</html>