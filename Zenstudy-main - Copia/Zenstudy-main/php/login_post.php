<?php
// login_post.php
require_once 'conexao.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';

    if (!empty($email) && !empty($senha)) {
        $conexao = conectar();

        // Utilizando Prepared Statements contra SQL Injection (Equivalente ao %s do Python)
        $stmt = $conexao->prepare("SELECT * FROM tb_cadastro WHERE ds_email = ? AND ds_senha = ?");
        $stmt->bind_param("ss", $email, $senha);
        $stmt->execute();
        
        $resultado = $stmt->get_result();
        $user = $resultado->fetch_assoc();

        $stmt->close();
        $conexao->close();

        if ($user) {
            $_SESSION['logado'] = true;
            $_SESSION['email'] = $user['ds_email'];
            $_SESSION['id_cadastro'] = $user['id'];
            
            header("Location: menu.php");
            exit();
        } else {
            flash("Usuário ou senha incorretos.", "erro");
            header("Location: login.php");
            exit();
        }
    }
}
header("Location: login.php");
exit();