<?php
require_once __DIR__ . '/../config/conexao.php';
require_once __DIR__ . '/../dao/EstudosDAO.php';

// Garante que só quem está logado pode usar o controlador
if (!isset($_SESSION['logado'])) {
    redirecionar('/views/login.php');
}

$estudosDAO = new EstudosDAO();

// Lógica para a página de Materiais
function obterDadosMateriais($ano_id) {
    global $estudosDAO;
    $dadosAno = $estudosDAO->buscarAnoPorId($ano_id);
    $materias = $estudosDAO->buscarMateriasPorAno($ano_id);

    return [
        'nivel' => $dadosAno['nm_nivel'] ?? 'Estudos',
        'ano' => $dadosAno['nm_ano'] ?? 'Conteúdos',
        'materias' => $materias
    ];
}

// Lógica para a lista de Assuntos
function obterDadosEstudos($ano_id, $materia_id) {
    global $estudosDAO;
    $assuntos = $estudosDAO->buscarAssuntos($ano_id, $materia_id);
    return $assuntos;
}

// Lógica para a página de Conteúdo Final
function obterTextoConteudo($assunto_id) {
    global $estudosDAO;
    return $estudosDAO->buscarConteudoAssunto($assunto_id);
}
?>