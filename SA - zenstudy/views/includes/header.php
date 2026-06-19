<?php
require_once __DIR__ . '/../../config/conexao.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Zenstudy</title>
    <link rel="stylesheet" href="/static/css/style.css">
</head>

<body>
    <header>
        <nav class="navbar">
            <a href="/views/index.php" class="logo">Zenstudy</a> 
            <div class="navbar-links">
                <a href="/views/menu.php">Painel</a>
                <a href="/views/ferramentas/agenda.php">Agenda</a>
                <a href="/views/estudos/pesquisa.php">Pesquisa</a>
                <a href="/views/estudos/biblioteca.php">Biblioteca</a>
                <a href="/views/conta/configuracoes.php">Configurações</a>
                <button id="theme-toggle" class="theme-toggle" title="Alternar Tema">🌙</button>
                <a href="/views/logout.php" class="btn-sair">Sair</a>
            </div>
        </nav>
    </header>

    <main class="container">