<?php
require_once __DIR__ . '/../config/conexao.php';
require_once __DIR__ . '/../dao/UsuarioDAO.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $senha = $_POST['senha'];

    if ($nome && $email && $senha) {
        $usuarioDAO = new UsuarioDAO();
        
        // Executa o insert no banco
        $usuarioDAO->salvar($nome, $email, $senha);

        // Define as mesmas variáveis de sessão do seu app.py original
        $_SESSION['logado'] = true;
        $_SESSION['usuario_logado'] = $email; 
        $_SESSION['nome_usuario'] = $nome;

        flash('Cadastro realizado com sucesso! Bem-vindo.', 'sucesso');
        redirecionar('/zenstudy/views/menu.php');
    } else {
        flash('Preencha todos os campos corretamente.', 'erro');
        redirecionar('/zenstudy/views/cadastro.php');
    }
} else {
    redirecionar('/zenstudy/views/cadastro.php');
}
?>