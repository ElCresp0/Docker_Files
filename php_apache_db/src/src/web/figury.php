<?php
    session_start();
    require_once 'functions.php';

    if ($_SERVER["REQUEST_METHOD"] === 'POST') {
        $priv = 0;
        if (isset($_POST["priv"])) {
            if ($_POST["priv"] == "prywatne") {
                $priv = 1;
                $privPath = "obrazy/".$_SESSION['username'];
                if (is_dir($privPath) == false) {
                    mkdir($privPath);
                    mkdir($privPath."/uploads");
                    mkdir($privPath."/watermark");
                    mkdir($privPath."/miniaturki");
                }
            }
        }
        setcookie("upload", "1", time() + 3, "/");
        if ($priv == 1) {
            $target_dir = $privPath."/uploads/";
        }
        else $target_dir = "obrazy/uploads/";
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        if ($imageFileType != "png" && $imageFileType != "jpg") {
            setcookie("rozszerzenie", "1", time() + 3, "/");
            $uploadOk = 0;
        }
        $size = $_FILES["fileToUpload"]["size"];
        if ($_FILES["fileToUpload"]["size"] > 1000000) {
            setcookie("rozmiar", "1", time() + 3, "/");
            $uploadOk = 0;
        }
        if ($uploadOk == 1) {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                $watermark = $_POST["watermark"];
                if ($imageFileType == "jpg") {
                    zamienNaPng($target_dir, basename($_FILES["fileToUpload"]["name"]));
                }
                utworzMiniature($target_file, basename($_FILES["fileToUpload"]["name"]), $_POST["watermark"], $priv);
                $db = get_db();
                if($_POST["tytuł"]) {
                    $ttl = $_POST["tytuł"];
                }
                else {
                    $ttl = "unknown";
                }
                if($_POST["autor"]) {
                    $aut = $_POST["autor"];
                }
                else {
                    $aut = "unknown";
                }
                $info = [
                    'filename' => jpgToPng(basename($_FILES["fileToUpload"]["name"])),
                    'tytuł' => $ttl,
                    'autor' => $aut,
                    'priv' => $priv
                ];
                $db->images->insertOne($info);
                setcookie("powodzenie", "1", time() + 3, "/");
            }
            else {
                setcookie("niepowodzenie", "1", time() + 3, "/");
            }
        }
        header('Location: figury.php');
    }
    if(empty($_SESSION['page'])) {
        $_SESSION["page"] = 0;
    }
    $galeria = scandir("obrazy/miniaturki");
    for($i=0; !empty($galeria[$i]);$i++) {
        $iloscPublicznych = $i;
    }
    if(!empty($_SESSION['username'])) {
        $privGal = scandir("obrazy/".$_SESSION['username']."/miniaturki");
        for($k=0; !empty($privGal[$k]); $k++) {
            $galeria[] = $privGal[$k];
        }
    }
    $info = get_db();
    function autor() {
        if(empty($_SESSION['username'])) $autor = 'placeholder="autor"';
        else $autor = 'value="'.$_SESSION['username'].'"';
        return $autor;
    }
    include 'figury_view.php';
?>