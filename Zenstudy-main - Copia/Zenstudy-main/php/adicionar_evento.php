<?php
// adicionar_eventos.php
require_once 'conexao.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Proteção da rota
if (!isset($_SESSION['logado'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'] ?? '';
    $descricao = $_POST['descricao'] ?? '';
    $horario = $_POST['horario'] ?? '';
    $dt_data = $_POST['dt_data'] ?? '';

    if (!empty($titulo) && !empty($descricao) && !empty($horario) && !empty($dt_data)) {
        $conexao = conectar();

        $stmt = $conexao->prepare("INSERT INTO tb_agenda (titulo, descricao, horario, dt_data) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $titulo, $descricao, $horario, $dt_data);
        
        if ($stmt->execute()) {
            flash("Evento salvo com sucesso!", "sucesso");
        } else {
            flash("Erro ao salvar o evento.", "erro");
        }

        $stmt->close();
        $conexao->close();
        header("Location: calendario.php");
        exit();
    }
}

flash("Preencha todos os campos!", "erro");
header("Location: calendario.php");
exit();