<?php
// conexao.php

function conectar() {
    $host = "tini.click";
    $port = 3306;
    $user = "zenstudy";
    $password = "5564b6c2da8a08044d696ea0a4e82e29";
    $database = "zenstudy";

    // Criando a conexão utilizando o driver mysqli nativo do PHP
    $conexao = new mysqli($host, $user, $password, $database, $port);

    // Valida se houve erro na conexão
    if ($conexao->connect_error) {
        die("Falha na conexão com o banco de dados: " . $conexao->connect_error);
    }

    // Define o charset para evitar problemas com acentuação
    $conexao->set_charset("utf8mb4");

    return $conexao;
}

// Helper para gerenciar mensagens Flash no PHP
function flash($mensagem, $categoria) {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $_SESSION['flash_messages'][] = [
        'texto' => $mensagem,
        'categoria' => $categoria
    ];
}