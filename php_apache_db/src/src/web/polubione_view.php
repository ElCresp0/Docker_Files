<!DOCTYPE html>
<html>
    <head>
        <title>Chesslav</title>
        <link href="../chesslav.css" type="text/css" rel="stylesheet" />
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <header>
            <a href="figury.php#paging">figury</a>
            <a href="index.php">strona główna</a>
        </header>
        <section>

            <?php
                if($user == null || $piecesInDb == null) {
                    echo "<h1>Brak polubionych figur</h1>";
                }
                else {
                    echo '<form action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'">';
                    for($j=0;!empty($piecesInDb[$j]);$j++) {
                        for($i=0;!empty($galeria[$i]);$i++) {
                            if($piecesInDb[$j] == $galeria[$i]) {
                                if($db->images->findOne(['filename' => $galeria[$i]])->priv == 1) {
                                    $path = 'obrazy/'.$_SESSION['username'].'/miniaturki/'.$galeria[$i];
                                }
                                else
                                $path = "obrazy/miniaturki/".$galeria[$i];
                                echo '<div class="galeria">
                                    <figure>
                                        <img src="'.$path.'" style="width:100%;" alt="'.$galeria[$i].'" title="'.$galeria[$i].'" />
                                        <p>jednak nie lubię:
                                        <input type="checkbox" name="piece[]" value="'.$galeria[$i].'" /></p>
                                        </figure>
                                </div>';
                            }
                        }
                    }
                    echo '
                        <input type="submit" value ="Usuń zaznaczone z zapamiętanych" />
                        </form>
                    ';
                }
            ?>
        </section>
    </body>
</html>