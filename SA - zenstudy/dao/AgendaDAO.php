<?php
require_once __DIR__ . '/../config/conexao.php';

class AgendaDAO {
    private $pdo;

    public function __construct() {
        global $pdo;
        $this->pdo = $pdo;
    }

    // Salva o evento na tabela tb_agenda
    public function salvarEvento($id_cadastro, $titulo, $data, $horario, $descricao) {
        $sql = "INSERT INTO tb_agenda (id_cadastro, nm_titulo, dt_data, hr_horario, ds_descricao) 
                VALUES (:id_cadastro, :titulo, :dt_data, :horario, :descricao)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id_cadastro', $id_cadastro);
        $stmt->bindValue(':titulo', $titulo);
        $stmt->bindValue(':dt_data', $data);
        $stmt->bindValue(':horario', $horario);
        $stmt->bindValue(':descricao', $descricao);
        return $stmt->execute();
    }

    // Busca os eventos do usuário logado
    public function buscarEventosPorUsuario($id_cadastro) {
        $sql = "SELECT id, nm_titulo as title, dt_data as start, ds_descricao as descricao, hr_horario as horario 
                FROM tb_agenda WHERE id_cadastro = :id_cadastro";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id_cadastro', $id_cadastro);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>