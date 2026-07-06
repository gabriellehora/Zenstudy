<?php
require_once __DIR__ . '/../config/conexao.php';
require_once __DIR__ . '/../dao/AgendaDAO.php';

$agendaDAO = new AgendaDAO();

// Salva, edita ou exclui um evento
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!isset($_SESSION['id_cadastro'])) {
        redirecionar('/views/login.php');
        exit;
    }

    // EDITAR EVENTO
    if (isset($_POST['editar'])) {

        $agendaDAO->atualizarEvento(
            $_POST['id'],
            $_POST['titulo'],
            $_POST['dt_data'],
            $_POST['horario'],
            $_POST['descricao'],
            $_POST['cor']
        );

        flash('Evento atualizado com sucesso!', 'sucesso');
        redirecionar('/views/ferramentas/calendario.php');
        exit;
    }

    // EXCLUIR EVENTO
    if (isset($_POST['excluir'])) {

        $agendaDAO->excluirEvento($_POST['id']);

        flash('Evento excluído com sucesso!', 'sucesso');
        redirecionar('/views/ferramentas/calendario.php');
        exit;
    }

    // CADASTRAR EVENTO
    $id_cadastro = $_SESSION['id_cadastro'];
    $titulo = filter_input(INPUT_POST, 'titulo', FILTER_SANITIZE_SPECIAL_CHARS);
    $data = $_POST['dt_data'];
    $horario = $_POST['horario'];
    $descricao = filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_SPECIAL_CHARS);
    $cor = $_POST['cor'];

    if ($titulo && $data && $horario) {

        $agendaDAO->salvarEvento(
            $id_cadastro,
            $titulo,
            $data,
            $horario,
            $descricao,
            $cor
        );

        flash('Evento adicionado com sucesso!', 'sucesso');

    } else {

        flash('Preencha os campos obrigatórios.', 'erro');

    }

    redirecionar('/views/ferramentas/calendario.php');
    exit;
}

// Retorna os eventos em JSON para o FullCalendar
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['api'])) {

    header('Content-Type: application/json');

    if (!isset($_SESSION['id_cadastro'])) {
        echo json_encode([]);
        exit;
    }

    $eventos = $agendaDAO->buscarEventosPorUsuario($_SESSION['id_cadastro']);

    foreach ($eventos as &$evento) {
        $evento['backgroundColor'] = $evento['cor'];
        $evento['borderColor'] = $evento['cor'];
    }

    echo json_encode($eventos);
    exit;
}