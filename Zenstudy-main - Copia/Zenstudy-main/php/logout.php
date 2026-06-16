<?php
// logout.php
require_once 'conexao.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Limpa todas as variáveis de sessão
session_unset();
session_destroy();

// Inicia uma nova sessão apenas para levar a mensagem flash de saída
session_start();
flash('Você saiu do sistema.', 'info');

header("Location: login.php");
exit();