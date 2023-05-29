<?php
    session_start();
    require_once 'functions.php';
    $galeria = scandir("obrazy/miniaturki");
    $privGal = scandir("obrazy/".$_SESSION["username"]."/miniaturki");
    $db = get_db();
    for($i=0; !empty($privGal[$i]); $i++) {
        $galeria[] = $privGal[$i];
    }
    $iloscPublicznych = 0;
    while(!empty($galeria[$iloscPublicznych])) $iloscPublicznych++;
    //$db->liked->deleteOne(['user' => $_SESSION['username']]);
    $user = $db->liked->findOne(['user' => $_SESSION['username']]);
    if($user !== null) $piecesInDb = $user->figury;
    if(empty($piecesInDb) && $user !== null) $db->liked->deleteOne(['user' => $_SESSION['username']]);
    if ($_SERVER["REQUEST_METHOD"] === 'POST' && !empty($_POST["piece"])) {
        foreach($_POST["piece"] as $piece) {
            if($user == null) {
                $pieces[] = $piece;
            }
            else {
                $pieceOK = 1;
                for($i=0;!empty($piecesInDb[$i]);$i++) {
                    if($piecesInDb[$i] == $piece) {
                        $pieceOK = 0;
                    }
                }
                if($pieceOK == 1) {
                    $piecesInDb[] = $piece;
                }
            }
        }
        if($user == null) {
            $liked = [
                'user' => $_SESSION['username'],
                'figury' => $pieces
            ];
            $db->liked->insertOne($liked);
            header('Location: figury.php#paging');
            exit;
        }
        else {
            $db->liked->replaceOne(['user' => $_SESSION['username']], $user);
            header('Location: figury.php#paging');
            exit;
        }
    }
    if ($_SERVER["REQUEST_METHOD"] === 'GET' && isset($_GET["piece"])) {
        for($i=0;!empty($piecesInDb[$i]);$i++) {
            $stayOK = 1;
            foreach($_GET["piece"] as $piece) {
                if ($piecesInDb[$i] == $piece) {
                    $stayOK = 0;
                }
            }
            if ($stayOK == 1) {
                $piecesStayin[] = $piecesInDb[$i];
            }
        }

        if(empty($piecesStayin)) {
            $db->liked->deleteOne(['user' => $_SESSION['username']]);
        }
        else {
            $stayin = [
                'user' => $_SESSION['username'],
                'figury' => $piecesStayin
            ];
            $db->liked->deleteOne(['user' => $_SESSION['username']]);
            $db->liked->insertOne($stayin);
        }
        header('Location: polubione.php');
    }


    include 'polubione_view.php';
?>