<?php
    session_start();
    session_unset();

    include 'functions.php';

if ($_SERVER["REQUEST_METHOD"] === 'POST') {
    $db = get_db();
    $login = $_POST['login'];
    $user = $db->users->findOne(['login' => $login]);
    if ($user !== null) {
        setcookie("user", "<p>ta nazwa użytkownika jest już zajęta</p>", time() +3, "/");
        header('Location: rejestracja.php');
    }
    else {
        $password = $_POST['password'];
        $repassword = $_POST['repassword'];
        if ($password === $repassword) {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $user = [
                'login' => $login,
                'password' => $hash
            ];
            $db->users->insertOne($user);
            header('Location: index.php');
            exit;
        }
        else {
            setcookie("twoPas", "<p>Podano dwa różne hasła</p>", time() + 3, "/");
            header('Location: rejestracja.php');
        }
    }
}
include 'rejestracja_view.php';
?>