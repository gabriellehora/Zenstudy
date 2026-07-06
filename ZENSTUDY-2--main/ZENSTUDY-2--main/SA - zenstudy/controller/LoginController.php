<?php
require_once __DIR__ . '/../config/conexao.php';
require_once __DIR__ . '/../dao/UsuarioDAO.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $senha = $_POST['senha'];

    $usuarioDAO = new UsuarioDAO();
    $user = $usuarioDAO->login($email, $senha);
    $user = $usuarioDAO->login($email, $senha);

    if ($user) {
        $_SESSION['logado'] = true;
        $_SESSION['usuario_logado'] = $user['ds_email'];
        $_SESSION['nome_usuario'] = $user['nm_usuario'];
        $_SESSION['id_cadastro'] = $user['id'];
        redirecionar('/views/menu.php');

    } else {

        flash("Usuário ou senha incorretos.", "erro");
        redirecionar('/views/login.php');

    }

} else {

    redirecionar('/views/login.php');

}
?>