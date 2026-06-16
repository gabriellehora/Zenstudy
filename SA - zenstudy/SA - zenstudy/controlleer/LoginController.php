<?php
require_once __DIR__ . '/../config/conexao.php';
require_once __DIR__ . '/../dao/UsuarioDAO.php';

// Só processa se o formulário foi enviado via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $senha = $_POST['senha'];

    $usuarioDAO = new UsuarioDAO();
    $user = $usuarioDAO->buscarPorEmailESenha($email, $senha);

    if ($user) {
        // Define as mesmas sessões que você usava no Flask
        $_SESSION['logado'] = true;
        $_SESSION['email'] = $user['ds_email'];
        $_SESSION['id_cadastro'] = $user['id'];
        
        // Redireciona para o painel principal (menu)
        redirecionar('/zenstudy/views/menu.php');
    } else {
        // Define a mensagem de erro usando a nossa função flash()
        flash("Usuário ou senha incorretos.", "erro");
        redirecionar('/zenstudy/views/login.php');
    }
} else {
    // Se tentarem acessar o controlador direto pela URL, manda de volta pro login
    redirecionar('/zenstudy/views/login.php');
}
?>