<?php
// cadastro_post.php
require_once 'conexao.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'] ?? '';
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';

    if (!empty($nome) && !empty($email) && !empty($senha)) {
        $conexao = conectar();

        $stmt = $conexao->prepare("INSERT INTO tb_cadastro (nm_usuario, ds_email, ds_senha) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nome, $email, $senha);
        
        if ($stmt->execute()) {
            $_SESSION['logado'] = true; // Mantém o padrão de login automático após cadastro
            $_SESSION['usuario_logado'] = $email;
            $_SESSION['nome_usuario'] = $nome;
            $_SESSION['id_cadastro'] = $conexao->insert_id; // captura o ID gerado

            flash('Cadastro realizado com sucesso! Bem-vindo.', 'sucesso');
            header("Location: menu.php");
            exit();
        } else {
            flash('Erro ao realizar o cadastro.', 'erro');
            header("Location: cadastro.php");
            exit();
        }
        
        $stmt->close();
        $conexao->close();
    }
}