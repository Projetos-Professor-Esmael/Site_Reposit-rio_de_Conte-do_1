<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit;
}

// Função para processar o upload
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['pdf_file'])) {
    // Diretório para salvar os arquivos
    $target_dir = "docs/";
    $target_file = $target_dir . basename($_FILES['pdf_file']['name']);
    $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Verifica se o arquivo é um PDF
    if ($file_type !== 'pdf') {
        echo "Erro: Apenas arquivos PDF são permitidos.";
    } else {
        // Move o arquivo para a pasta docs/
        if (move_uploaded_file($_FILES['pdf_file']['tmp_name'], $target_file)) {
            // Adiciona as informações do documento no arquivo JSON
            $documents = file_exists('documents.json') ? json_decode(file_get_contents('documents.json'), true) : [];
            $documents[] = [
                'name' => basename($_FILES['pdf_file']['name']),
                'path' => $target_file,
                'date_uploaded' => date("Y-m-d H:i:s")
            ];
            file_put_contents('documents.json', json_encode($documents, JSON_PRETTY_PRINT));

            echo "O arquivo foi enviado com sucesso!";
        } else {
            echo "Erro ao enviar o arquivo.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload de Documentos - Projetos Professor Esmael</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Upload de Documentos</h1>
    </header>

    <section class="upload-form">
        <form action="upload_document.php" method="POST" enctype="multipart/form-data">
            <label for="pdf_file">Escolha um arquivo PDF:</label>
            <input type="file" id="pdf_file" name="pdf_file" accept=".pdf" required>
            <button type="submit">Enviar Documento</button>
        </form>
    </section>

    <footer>
        <p>&copy; 2024 Projetos Professor Esmael. Todos os direitos reservados.</p>
    </footer>
</body>
</html>
