<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$tema = isset($_SESSION['tema']) ? $_SESSION['tema'] : 'light';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Zenstudy</title>
    <link rel="stylesheet" href="static/style.css">
</head>

<body class="<?php echo ($tema === 'dark') ? 'dark-mode' : ''; ?>">

    <header>
        <nav class="navbar">
            <a href="php/index.php" class="logo">Zenstudy</a> 
            <div class="navbar-links">
                <a href="php/menu.php">Painel</a>
                <a href="php/agenda.php">Agenda</a>
                <a href="php/pesquisa.php">Pesquisa</a>
                <a href="php/biblioteca.php">Biblioteca</a>
                <a href="php/configuracoes.php">Configurações</a>
                <button id="theme-toggle" class="theme-toggle" title="Alternar Tema">🌙</button>
                <a href="php/logout.php" class="btn-sair">Sair</a>
            </div>
        </nav>
    </header>

    <main class="container">