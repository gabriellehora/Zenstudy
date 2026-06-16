<link rel="stylesheet" href="/static/style.css">
<?php
// Garante o acesso às configurações e sessões globais
require_once __DIR__ . '/../../config/conexao.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Zenstudy</title>
    <link rel="stylesheet" href="/zenstudy/static/style.css">
</head>

<body class="<?php echo (isset($_SESSION['tema']) && $_SESSION['tema'] === 'dark') ? 'dark' : ''; ?>">

    <header>
        <nav class="navbar">
            <a href="/zenstudy/views/index.php" class="logo">Zenstudy</a> 
            <div class="navbar-links">
                <a href="/zenstudy/views/menu.php">Painel</a>
                <a href="/zenstudy/views/ferramentas/agenda.php">Agenda</a>
                <a href="/zenstudy/views/estudos/pesquisa.php">Pesquisa</a>
                <a href="/zenstudy/views/estudos/biblioteca.php">Biblioteca</a>
                <a href="/zenstudy/views/conta/configuracoes.php">Configurações</a>
                <button id="theme-toggle" class="theme-toggle" title="Alternar Tema">🌙</button>
                <a href="/zenstudy/views/auth/logout.php">Sair</a>
            </div>
        </nav>
    </header>

    <main class="container">