<?php
session_start();
include 'functions.php';

if ($_SERVER["REQUEST_METHOD"] === 'POST') {
    $db = get_db();
    $login = $_POST['login'];
    $password = $_POST['password'];
    $user = $db->users->findOne(['login' => $login]);
    if($user !== null && password_verify($password, $user['password'])) {
        $_SESSION['username'] = $login;
    }
    else {
        setcookie("wrong", "<p>Niepoprawny login lub hasło!</p>", time() + 3, "/");
        header('Location: index.php');
    }
}
include 'index_view.php';
?>