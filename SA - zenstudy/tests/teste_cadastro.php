<?php

require_once __DIR__ . '/../config/conexao.php';
require_once __DIR__ . '/../dao/UsuarioDAO.php';

$dao = new UsuarioDAO();

$nome = "Usuário Teste";
$email = "teste_phpunit@zenstudy.com";
$senha = "123456";

global $pdo;

// Remove caso já exista
$pdo->prepare("DELETE FROM tb_cadastro WHERE ds_email = :email")
    ->execute([
        ':email' => $email
    ]);

$resultado = $dao->cadastrar(
    $nome,
    $email,
    $senha
);

if ($resultado && $dao->emailExiste($email)) {
    echo "TESTE APROVADO";
} else {
    echo "TESTE REPROVADO";
}

// Limpeza
$pdo->prepare("DELETE FROM tb_cadastro WHERE ds_email = :email")
    ->execute([
        ':email' => $email
    ]);