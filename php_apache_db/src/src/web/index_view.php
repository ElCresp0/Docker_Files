<!DOCTYPE html>
<html lang="pl">
        <head>
            <title>Chesslav</title>
            <link href="chesslav.css" type="text/css" rel="stylesheet" />
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        </head>
        <body>
            <div id="page">
                <header>
                    <img src="obrazy/logo.jpg" style="width:100%;" alt="logo chesslav" title="chesslav" />
                    <h1>Moje hobby: szachy</h1>
                    <nav>
                        <div class="navbar">
                            <a href="rejestracja.php">rejestracja</a>
                            <a href="historia/historia.html">historia</a>
                            <a href="warianty/warianty.html">warianty</a>
                            <div class="dropdown">
                                <button class="dropbtn">Rozwiń</button>
                                <div class="dropdown-content">
                                    <a href="figury.php">figury</a>
                                    <a href="roszada/roszada1.html" >roszada_css</a>
                                    <a href="roszada/roszada2.html" >roszada_js</a>
                                </div>
                            </div>
                        </div>
                    </nav>
                    <?php if (empty($_SESSION['username'])): ?>
                        <form method="post">
                            <input type="text" name="login" placeholder="login"/>
                            <input type="password" name="password" placeholder="password"/>
                            <input type="submit" value="Zaloguj"/>
                        </form>
                    <?php endif ?>
                    <?php
                        if(!empty($_SESSION['username'])) {
                            $nick = $_SESSION['username'];
                            echo "<p>zalogowano $nick</p>";
                        }
                        if(isset($_COOKIE["wrong"])) {
                            $wrong = $_COOKIE["wrong"];
                            echo "$wrong";
                        }
                    ?>
                </header>
                <div id="content">
                    <article>
                        <div id="myStory">
                            <h2>Kilka słów o mnie :)</h2>
                            <p>Zacząłem interesować się szachami w pierwszej klasie liceum, kiedy to zgłosiłem się jako chętny do reprezentowania szkoły w licealiadzie. Ze względu na turniej podjąłem próbę przyswojenia pryncypialnych zasad gry, najprostszych taktyk i debiutów. Szybko się wciągnąłem i niedługo po zawodach, zachęcony pozytywnym wynikiem założyłem pierwsze konto na szachowej stronie internetowej <a href="https://lichess.org/" target="_blank">lichess.org</a>. Tak rozpoczęło się moje uzależnienie - potrafiłem przesiadywać całe dni i noce grając z internetowymi rywalami i doskonaląc swoje umiejętności. Bardzo wiele godzin poświęciłem również na oglądanie materiałów (edukacyjnych i rozrywkowych) o szachowej tematyce. Do dziś brałem udział w 2 turniejach rankingowych na których zdobyłem dwa puchary i IV kategorię Polskiego Związku Szachowego.</p> 
                        </div>
                        <div id="tip">
                            <h2>Jak zostać arcymistrzem - prosty trick:</h2>
                            <p id="secret">[sposób na osiągnięcie mistrzostwa]</p>
                            <script>$("#secret").hide()</script>
                        </div>
                    </article>
                </div>
            </div>
            <footer>
                <p>
                    Autor strony: Jakub Kiliańczyk s184301
                </p>
                <p>
                    <a href="https://lichess.org/@/COUNTERREVOLUTIONAXE" target="_blank">moje konto na lichess</a>
                </p>
                <button><a href="wyloguj.php">wyloguj</a></button>
            </footer>
        </body>
</html>