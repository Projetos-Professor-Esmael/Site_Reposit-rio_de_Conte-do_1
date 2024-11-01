<?php
// Inicia a sessão
session_start();

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Coleta os dados do formulário
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Criptografa a senha

    // Carrega o arquivo JSON de usuários
    $users = file_exists('users.json') ? json_decode(file_get_contents('users.json'), true) : [];

    // Verifica se o e-mail já está cadastrado
    foreach ($users as $user) {
        if ($user['email'] === $email) {
            echo "Erro: Este e-mail já está cadastrado.";
            exit;
        }
    }

    // Adiciona o novo usuário ao array
    $users[] = [
        'name' => $name,
        'email' => $email,
        'password' => $password
    ];

    // Salva o novo array de usuários no arquivo JSON
    file_put_contents('users.json', json_encode($users, JSON_PRETTY_PRINT));

    // Redireciona para a página de login com uma mensagem de sucesso
    header("Location: register.html");
}
?>
