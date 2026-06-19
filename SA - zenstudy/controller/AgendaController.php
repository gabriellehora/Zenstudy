<?php
require_once __DIR__ . '/../config/conexao.php';
require_once __DIR__ . '/../dao/AgendaDAO.php';

$agendaDAO = new AgendaDAO();

// AÇÃO 1: Se o formulário foi enviado via POST, salva o evento
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Garante que o usuário tá logado
    if (!isset($_SESSION['id_cadastro'])) {
        redirecionar('/views/login.php');
    }

    $id_cadastro = $_SESSION['id_cadastro'];
    $titulo = filter_input(INPUT_POST, 'titulo', FILTER_SANITIZE_SPECIAL_CHARS);
    $data = $_POST['dt_data'];
    $horario = $_POST['horario'];
    $descricao = filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_SPECIAL_CHARS);

    if ($titulo && $data && $horario) {
        $agendaDAO->salvarEvento($id_cadastro, $titulo, $data, $horario, $descricao);
        flash('Evento adicionado com sucesso!', 'sucesso');
    } else {
        flash('Preencha os campos obrigatórios.', 'erro');
    }
    redirecionar('/views/ferramentas/calendario.php');
}

// AÇÃO 2: Se o FullCalendar pedir os dados (via GET), joga o JSON na tela
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['api'])) {
    header('Content-Type: application/json');
    
    if (!isset($_SESSION['id_cadastro'])) {
        echo json_encode([]);
        exit;
    }

    $eventos = $agendaDAO->buscarEventosPorUsuario($_SESSION['id_cadastro']);
    echo json_encode($eventos);
    exit;
}
?>