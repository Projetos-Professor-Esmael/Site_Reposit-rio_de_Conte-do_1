<?php
session_start();

// Verifica se o formulário foi enviado corretamente
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica se os campos 'username' e 'password' foram enviados
    $username = isset($_POST['username']) ? $_POST['username'] : null;
    $password = isset($_POST['password']) ? $_POST['password'] : null;

    if ($username && $password) {
        // Carrega os usuários do arquivo JSON
        $users = file_exists('users.json') ? json_decode(file_get_contents('users.json'), true) : [];

        // Procura o usuário com o nome e senha corretos
        foreach ($users as $user) {
            if ($user['email'] === $username && password_verify($password, $user['password'])) {
                $_SESSION['username'] = $username;
                header("Location: admin_dashboard.html"); // Redireciona para o painel administrativo
                exit;
            }
        }

        echo "Usuário ou senha incorretos.";
    } else {
        echo "Erro: Preencha todos os campos.";
    }
} else {
    echo "Acesso não autorizado.";
}
?>