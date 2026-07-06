<?php
require_once __DIR__ . '/../config/conexao.php';
require_once __DIR__ . '/../dao/UsuarioDAO.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $senha = $_POST['senha'];

    if ($nome && $email && $senha) {

        $usuarioDAO = new UsuarioDAO();

        // Verifica se o e-mail já está cadastrado
        if ($usuarioDAO->emailExiste($email)) {
            flash('Este e-mail já está cadastrado.', 'erro');
            redirecionar('/views/cadastro.php');
        }

        // Cadastra o usuário
        $usuarioDAO->cadastrar($nome, $email, $senha);

        // Cria a sessão do usuário
        $_SESSION['logado'] = true;
        $_SESSION['usuario_logado'] = $email;
        $_SESSION['nome_usuario'] = $nome;

        flash('Cadastro realizado com sucesso! Bem-vindo.', 'sucesso');
        redirecionar('/views/menu.php');

    } else {

        flash('Preencha todos os campos corretamente.', 'erro');
        redirecionar('/views/cadastro.php');

    }

} else {

    redirecionar('/views/cadastro.php');
}
?>