<!DOCTYPE html>
<html lang="pl">
    <head>
        <title>Chesslav</title>
        <meta charset="UTF-8">
        <link href="chesslav.css" type="text/css" rel="stylesheet" />
        <link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>      
        <script src="java/session.js"></script>
        <script src="java/local.js"></script>
    </head>
    <body>
        <div id="page">
            <header>
                <img src="obrazy/logo.jpg" style="width:100%;" alt="logo chesslav" title="chesslav" />
                <div>
                    <a href="index.php">strona główna</a>
                </div>
                <div id="pawnResult"></div>
                <div id="bishopResult"></div>
                <div id="knightResult"></div>
                <div id="rookResult"></div>
                <div id="queenResult"></div>
                <div id="kingResult"></div>
                <h1 id="start">Figury</h1>
            </header>
            <div id="content">
                <section>
                    <?php
                        if(!empty($_SESSION['username'])) {
                            $nick = $_SESSION['username'];
                            echo "<h3>zalogowano $nick</h3>";
                        }
                    ?>
                    <h2>Naukę szachów najlepiej jest zacząć od poznania figur. Oto one:</h2>
                    <div class="galeria">
                        <figure>
                            <img src="obrazy/figury/pionek.svg" style="width:100%;" alt="prowizoryczna wizualizacja szachowego pionka" title="pionek" onclick="pawnClickCounter()">
                                <figcaption>
                                    Pionek
                                </figcaption>
                        </figure>
                    </div>
                    <div class="galeria">
                        <figure>
                            <img src="obrazy/figury/goniec.jpg" style="width:100%;" alt="prowizoryczna wizualizacja szachowego gońca" title="goniec" onclick="bishopClickCounter()">
                                <figcaption>
                                    Goniec
                                </figcaption>
                        </figure>
                    </div>
                    <div class="galeria">
                        <figure>
                            <img src="obrazy/figury/wieza.jpg" style="width:100%;" alt="prowizoryczna wizualizacja szachową wieżę" title="wieża" onclick="rookClickCounter()">
                                <figcaption>
                                    Wieża
                                </figcaption>
                        </figure>
                    </div>
                    <div class="galeria">
                        <figure id="hetman">
                            <img src="obrazy/figury/hetman.jpg" style="width:100%;" alt="prowizoryczna wizualizacja szachowego hetmana" title="hetman" onclick="queenClickCounter()">
                                <figcaption>
                                    Hetman
                                </figcaption>
                        </figure>
                    </div>
                    <div class="galeria">
                        <figure>
                            <img src="obrazy/figury/krol.jpg" style="width:100%;" alt="prowizoryczna wizualizacja szachowego króla" title="król" onclick="kingClickCounter()">
                                <figcaption>
                                    Król
                                </figcaption>
                        </figure>
                    </div>
                    <div class="galeria">
                        <figure>
                            <img src="obrazy/figury/skoczek.jpg" style="width:100%;" alt="prowizoryczna wizualizacja szachowego skoczka" title="skoczek" onclick="knightClickCounter()">
                                <figcaption>
                                    Skoczek
                                </figcaption>
                        </figure>
                    </div>
                </section>
                <section>
                    <?php
                        $i =  $_SESSION["page"]+2;
                        echo '<form action="polubione.php" method="post">';
                        echo "<h1>Figury dodane przez użytkowników:</h1>";
                        for(; $i<($_SESSION["page"]+5) && !empty($galeria[$i]); $i++) {
                            if($i > ($iloscPublicznych)) {
                                $i = $i+2;
                                $path = "obrazy/".$_SESSION['username']."/miniaturki/".$galeria[$i];
                                $pathToWtr = "obrazy/".$_SESSION['username']."/watermark/".$galeria[$i];
                            }
                            else {
                                $path = "obrazy/miniaturki/".$galeria[$i];
                                $pathToWtr = "obrazy/watermark/".$galeria[$i];
                            }
                            $info=get_db();
                            /*
                            $usun = $info->images->find();
                            $info->images->deleteOne($usun);
                            */
                            $piece = $info->images->findOne(['filename' => $galeria[$i]]);
                            $ttl = $piece['tytuł'];
                            $aut = $piece['autor'];
                            $priv = $piece['priv'];
                            echo '<div id="paging" class="galeria">
                                <figure>
                                    <a href="'.$pathToWtr.'" target="_blank">
                                        <img src="'.$path.'" style="width:100%;" alt="'.$galeria[$i].'" title="'.$galeria[$i].'">
                                    </a>                                
                                </figure>
                                <p>tytuł: '.$ttl.'</p>
                                <p>autor: '.$aut.'</p>';
                                if ($priv == 1) echo "<p>grafika prywatna</p>";
                                echo '<p>lubię to:
                                <input type="checkbox" name="piece[]" value="'.$galeria[$i].'" '.hidden().'/></p>
                            </div>';
                        }

                        echo '<input type="submit" value ="Zapamiętaj wybrane" '.hidden().'/>
                        </form>';
                        echo '<h2><a href="paging.php?d=l&n='.$i.'">&lt-</a>';
                        echo "przewiń";
                        echo '<a href="paging.php?d=r';
                        if ($galeria[$i]) {
                            echo '&n=1';
                        }
                        echo '">-&gt</a></h2>';
                        if (empty($_SESSION['username'])) {
                            echo "<p>zaloguj się aby utworzyć kolekcję polubionych</p>";
                        }
                        else echo '<h3><a href="polubione.php">polubione figury</a></h3>';
                        ?>
                </section>
                <section>
                    <h1>dodawanie figur</h1>
                    <form action="figury.php" method="post" enctype="multipart/form-data">
                        Select image to upload:
                        <input type="file" name="fileToUpload" id="fileToUpload">
                        <input type="text" name="tytuł" placeholder="tytuł">
                        <input type="text" name="autor" <?=autor()?>">
                        <input type="text" name="watermark" placeholder="znak wodny" required>
                        <?php
                            if(!empty($_SESSION['username'])) {
                                echo '
                                    <p><input type="radio" name="priv" value="publiczne" />publiczne
                                    <input type="radio" name="priv" value="prywatne" />prywatne</p>                            
                                ';
                            }
                        ?>
                        <input type="submit" value="Upload Image" name="submit">
                    </form>
                    <?php
                        if(isset($_COOKIE["upload"])) {
                            if(isset($_COOKIE["rozszerzenie"])) {
                                echo "<p>Uploadowany plik musi mieć rozszerzenie png lub jpg</p>";
                            }
                            if(isset($_COOKIE["rozmiar"])) {
                                echo "<p>Rozmiar pliku musi być mniejszy niż 1mb</p>";
                            }
                            if(isset($_COOKIE["powodzenie"])) {
                                echo "<p>Plik dodany</p>";
                            }
                            if(isset($_COOKIE["niepowodzenie"])) {
                                echo "<p>Podczas dodawania pliku wystąpił błąd</p>";
                            }
                        }
                        if(isset($_COOKIE["miniaturka"])) {
                            echo "<p>nie udało się utworzyć miniaturki</p>";
                        }
                    ?>
                </section>
                <article>
                    <h2>Pionek</h2>
                    <p>Podstawowa bierka szachowa o materialnej wartości 1pkt. Porusza się do przodu. W pierwszym ruchu o jedno lub dwa pola, później tylko o jedno. Może poruszać się tylko na pola, które nie są zajmowane przez inne figury. Pionek bije na ukos.</p>
                    <p><q>Piony są duszą gry</q> - Philidor</p>            
                    <h2>Goniec</h2>
                    <p>Goniec (potocznie laufer) to lekka figura o materialnej wartości 3pkt. Porusza się wyłącznie na ukos. Jego zasięg jest ograniczony przez pozostałe figury.</p>
                    <p>Goniec ograniczony przez własne pionki (blokujące diagonale) nie może brać aktywnego udziału w grze. Można go wtedy nazwać <q>dużym pionkiem</q></p>            
                    <h2>Wieża</h2>
                    <p>Ciężka figura warta 5pkt. Wieża porusza się po rzędach i kolumnach (poziomo i pionowo). Poza tym zasady działania wieży są takie same jak gońca.</p>
                    <p>Mówi się, że gracz zakończył rozwój, gdy wieże są połączone. Oznacza to, że wszystkie pozostałe figury zostały wprowadzone do gry, a król prawdopodobnie jest już zroszowany.</p>
                    <p>Ulubiona końcówka teoretyczna niemieckiego arcymistrza Jana Gustafssona: "Gdy ja mam wieżę a mój przeciwnik nie ma".</p>            
                    <h2>Hetman</h2>
                    <p>Najsilniejsza (ciężka) figura w grze. Jej potoczna nazwa to królowa. Wartość hetmana wynosi 9pkt. Może poruszać się po rzędach, kolumnach oraz na ukos. Można powiedzieć że łączy cechy gońca i wieży.</p>
                    <p>Hetman powinien być wprowadzany do gry jako ostatnia figura. Niedoświadczeni gracze czasem rozwijają go wcześniej co pozwala przeciwnikowi go atakować rozwijając figury <q>z tempem</q>.</p>            
                    <h2>Król</h2>
                    <p>Najważniejsza figura na szachownicy. Porusza się wyłącznie o jedno pole w dowolnym kierunku. Nie może stawać na polach atakowanych przez wrogie bierki. Po rozwinięciu figur między królem a wieżą można wykonać roszadę. Polega ona na przestawieniu króla o dwa pola w kierunku tej wieży, która staje na polu przez które przeszedł król.</p>
                    <p>Rola króla zmienia się drastycznie w końcowej fazie gry. Często odgrywa on w niej kluczową rolę jako aktywna figura.</p>            
                    <h2>Skoczek</h2>
                    <p>Druga lekka figura warta również 3pkt. Skoczek (potocznie nazywany koniem) porusza się w najciekawszy sposób - w jednym ruchu o dwa pola względem jednej osi i o jedno pole względem drugiej (np. dwa pola w lewo i jedno w górę). Jako jedyna figura może <q>przeskakiwać</q>pozostałe bierki.</p>
                    <p>Skoczek powinien być pierwszą figurą (oprócz pionów) rozwijaną w debiucie.</p>            
                </article>
                <article>
                    <table>
                        <thead>
                            <tr>
                                <th class="np">Figura</th>
                                <th class="p">Wartość</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th class="p">Pionek</th>
                                <th class="np">1</th>
                            </tr>
                            <tr>
                                <th class="np">Goniec</th>
                                <th class="p">3</th>
                            </tr>
                            <tr>
                                <th class="p">Skoczek</th>
                                <th class="np">3</th>
                            </tr>
                            <tr>
                                <th class="np">Wieża</th>
                                <th class="p">5</th>
                            </tr>
                            <tr>
                                <th class="p">Hetman</th>
                                <th class="np">9</th>
                            </tr>
                            <tr>
                                <th class="np">Król</th>
                                <th class="p">&#8734;</th>
                            </tr>
                        </tbody>
                    </table>
                </article>
                <div>
                    <!-- <form action="../form.php"> -->
                        <form>  
                        <h1>Ankieta</h1>
                        <p>Twoje ulubione figury:</p>
                        <p><input type="checkbox" name="piece" value="pawn" id="p" /> Pionek
                        <input type="checkbox" name="piece" value="bishop" id="b" /> Goniec
                        <input type="checkbox" name="piece" value="knight" id="n" /> Skoczek
                        <input type="checkbox" name="piece" value="rook" id="r" /> Wieża
                        <input type="checkbox" name="piece" value="queen" id="q" /> Hetman
                        <input type="checkbox" name="piece" value="king" id="k" /> Król
                        </p>
                        <p>Twój ulubiony debiut: <select name="openings" id="opening">
                            <option value="king pawn">e4</option>
                            <option value="queen pawn">d4</option>
                            <option value="english">c4</option>
                            <option value="reti">Nf3</option>
                        </select></p>
                        <p>Twoja historia:</p>
                        <textarea name="story" cols="30" rows="4" id="story">Jak nauczyłeś/aś się grać w szachy?</textarea>
                        <fieldset>
                            <legend>Twoje dane</legend>
                            <p><label>Imię: <input type="text" name="name" id="name" /></label></p>
                            <p><label>Nazwisko: <input type="text" name="surname" id="surname" /></label></p>
                            <p><label>Konto lichess: <input type="url" name="account" id="lcAccount" /></label></p>
                            <p>Data urodzenia: <input type="text" id="date" /></p>    
                            <p><input type="radio" name="gender" value="kobieta" id="ko" />kobieta
                            <input type="radio" name="gender" value="mężczyzna" id="m" />mężczyzna</p>                            
                        </fieldset>
                        <input type="reset" />
                        <input type="submit" value="Prześlij" onclick="przypisz()" />
                        <input type="button" value="Dane z localStorage" onclick="dial()" />
                    </form>
                    <script>
                        $( function() {
                        $( "#date" ).datepicker();
                        } );
                        var p, n, b, r, q, k, pieces, clear;
                        function dial() {
                            clear = document.getElementById("dialog");
                            while (clear.hasChildNodes()) {
                                clear.removeChild(clear.firstChild);
                            }
                            p = localStorage.getItem("pawn");
                            if(p==="checkboxP.checked") {p = "pionek \n";}
                            if(p==="checkboxP.unchecked") {p = "";}
                            n = localStorage.getItem("knight");
                            if(n==="checkboxN.checked") {n = "skoczek \n";}
                            if(n==="checkboxN.unchecked") {n = "";}
                            b = localStorage.getItem("bishop");
                            if(b==="checkboxB.checked") {b = "goniec \n";}
                            if(b==="checkboxB.unchecked") {b = "";}
                            r = localStorage.getItem("rook");
                            if(r==="checkboxR.checked") {r = "wieża \n";}
                            if(r==="checkboxR.unchecked") {r = "";}
                            q = localStorage.getItem("queen");
                            if(q==="checkboxQ.checked") {q = "hetman \n";}
                            if(q==="checkboxQ.unchecked") {q = "";}
                            k = localStorage.getItem("king");
                            if(k==="checkboxK.checked") {k = "król \n";}
                            if(k==="checkboxK.unchecked") {k = "";}
                            pieces = p + n + b + r +q + k;
                            var pudlo = document.getElementById("dialog");
                            var tresc = document.createElement("P");
                            tresc.innerText = pieces;
                            pudlo.appendChild(tresc);
                            $( function() {
                          $( "#dialog" ).dialog();
                        } );
                        }
                    </script>
                    <div id="dialog" title="Polubione figury"></div>
                </div>
            </div>
            <footer> 
                <p><a href="#hetman">powrót do hetmana</a></p>
                <p><a href="#start">początek strony</a></p>
                <button><a href="wyloguj.php">wyloguj</a></button>
            </footer>
        </div>
    </body>
</html>