<?php
require_once __DIR__ . '/../config/conexao.php';

if (!isset($_SESSION['logado'])) {
    redirecionar('/views/login.php');
}

// Lógica de alteração de Idioma
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idioma'])) {
    $novo_idioma = filter_input(INPUT_POST, 'idioma', FILTER_SANITIZE_SPECIAL_CHARS);
    
    if (in_array($novo_idioma, ['pt-br', 'en-us', 'es'])) {
        $_SESSION['idioma'] = $novo_idioma;
        flash('Idioma alterado com sucesso!', 'sucesso');
    } else {
        flash('Idioma inválido.', 'erro');
    }
    redirecionar('/views/conta/idioma.php');
}

// Lógica de alteração de Tema
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['modo'])) {
    $novo_tema = filter_input(INPUT_POST, 'modo', FILTER_SANITIZE_SPECIAL_CHARS);
    
    if (in_array($novo_tema, ['claro', 'escuro'])) {
        $_SESSION['tema'] = $novo_tema;
        flash('Tema alterado com sucesso!', 'sucesso');
    } else {
        flash('Tema inválido.', 'erro');
    }
    redirecionar('/views/conta/tema.php');
}
?>