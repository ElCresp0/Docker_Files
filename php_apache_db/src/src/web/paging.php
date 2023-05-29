<?php
    session_start();
    $galeria = scandir("obrazy/miniaturki");
    if($_GET["d"]=="l" && ($_GET["n"]-3)>2) {
        $_SESSION["page"]--;
    }
    if($_GET["d"]=="r" && $_GET["n"] == 1) {
        $_SESSION["page"]++;
    }
    header('Location: figury.php#paging');
    exit;
?>