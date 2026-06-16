<?php
// eventos.php
require_once 'conexao.php';

// Define que o retorno desta página será um JSON limpo
header('Content-Type: application/json; charset=utf-8');

$conexao = conectar();

$sql = "SELECT id, titulo AS title, CONCAT(dt_data, 'T', horario) AS start, descricao FROM tb_agenda";
$resultado = $conexao->query($sql);

$eventos = [];
if ($resultado) {
    while ($linha = $resultado->fetch_assoc()) {
        $eventos[] = $linha;
    }
}

$conexao->close();

// Retorna o array codificado em JSON (equivalente ao jsonify do Flask)
echo json_encode($eventos, JSON_UNESCAPED_UNICODE);
exit();