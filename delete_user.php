<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit;
}

if (isset($_GET['username'])) {
    $usernameToDelete = $_GET['username'];

    $users = json_decode(file_get_contents('users.json'), true);
    $updatedUsers = array_filter($users, function ($user) use ($usernameToDelete) {
        return $user['username'] !== $usernameToDelete;
    });

    file_put_contents('users.json', json_encode($updatedUsers, JSON_PRETTY_PRINT));
    header("Location: admin_users.html");
}
?>