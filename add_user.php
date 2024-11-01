<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $users = json_decode(file_get_contents('users.json'), true);
    $users[] = ['username' => $username, 'password' => $password];

    file_put_contents('users.json', json_encode($users, JSON_PRETTY_PRINT));
    header("Location: admin_users.html");
}
?>
