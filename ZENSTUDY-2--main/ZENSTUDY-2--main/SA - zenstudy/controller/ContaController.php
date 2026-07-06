<?php
require_once __DIR__ . '/../config/conexao.php';
require_once __DIR__ . '/../dao/UsuarioDAO.php';

if (!isset($_SESSION['logado'])) {
    redirecionar('/views/login.php');
}

$usuarioDAO = new UsuarioDAO();
$id_usuario = $_SESSION['id_cadastro'];

// AÇÃO 1: Editar Perfil
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['acao_perfil'])) {
    $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

    if ($nome && $email) {
        $usuarioDAO->atualizarPerfil($id_usuario, $nome, $email);
        
        // Atualiza os dados da sessão atual
        $_SESSION['nome_usuario'] = $nome;
        $_SESSION['email'] = $email;

        flash('Perfil atualizado com sucesso!', 'sucesso');
    } else {
        flash('Preencha os campos corretamente.', 'erro');
    }
    redirecionar('/views/conta/editar_perfil.php');
}

// AÇÃO 2: Alterar Senha
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['acao_senha'])) {
    $senha_atual = $_POST['senha_atual'];
    $nova_senha = $_POST['nova_senha'];
    $confirmar_senha = $_POST['confirmar_senha'];

    // Pega os dados atuais do banco para validar a senha antiga
    $usuario = $usuarioDAO->buscarPorId($id_usuario);

    if ($usuario['ds_senha'] !== $senha_atual) {
        flash('A senha atual digitada está incorreta.', 'erro');
    } elseif ($nova_senha !== $confirmar_senha) {
        flash('A nova senha e a confirmação não coincidem.', 'erro');
    } else {
        $usuarioDAO->atualizarSenha($id_usuario, $nova_senha);
        flash('Senha alterada com sucesso!', 'sucesso');
    }
    redirecionar('/views/conta/alterar_senha.php');
}
?>