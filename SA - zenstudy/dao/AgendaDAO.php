<?php
require_once __DIR__ . '/../config/conexao.php';

class AgendaDAO {

    private $pdo;

    public function __construct() {
        global $pdo;
        $this->pdo = $pdo;
    }

    // Salva um novo evento
    public function salvarEvento($id_cadastro, $titulo, $data, $horario, $descricao, $cor) {

        $sql = "INSERT INTO tb_agenda
                (id_cadastro, titulo, descricao, horario, dt_data, cor)
                VALUES
                (:id_cadastro, :titulo, :descricao, :horario, :dt_data, :cor)";

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(':id_cadastro', $id_cadastro, PDO::PARAM_INT);
        $stmt->bindValue(':titulo', $titulo);
        $stmt->bindValue(':descricao', $descricao);
        $stmt->bindValue(':horario', $horario);
        $stmt->bindValue(':dt_data', $data);
        $stmt->bindValue(':cor', $cor);

        return $stmt->execute();
    }

    // Busca apenas os eventos do usuário logado
    public function buscarEventosPorUsuario($id_cadastro) {

        $sql = "SELECT
                    id,
                    titulo AS title,
                    dt_data AS start,
                    descricao,
                    horario,
                    cor
                FROM tb_agenda
                WHERE id_cadastro = :id_cadastro
                ORDER BY dt_data, horario";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id_cadastro', $id_cadastro, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Atualiza um evento somente se ele pertencer ao usuário
    public function atualizarEvento(
        $id,
        $id_cadastro,
        $titulo,
        $data,
        $horario,
        $descricao,
        $cor
    ){

        $sql = "UPDATE tb_agenda
                SET
                    titulo = :titulo,
                    descricao = :descricao,
                    horario = :horario,
                    dt_data = :dt_data,
                    cor = :cor
                WHERE id = :id
                AND id_cadastro = :id_cadastro";

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(':titulo', $titulo);
        $stmt->bindValue(':descricao', $descricao);
        $stmt->bindValue(':horario', $horario);
        $stmt->bindValue(':dt_data', $data);
        $stmt->bindValue(':cor', $cor);

        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':id_cadastro', $id_cadastro, PDO::PARAM_INT);

        return $stmt->execute();
    }

    // Exclui um evento somente se ele pertencer ao usuário
    public function excluirEvento($id, $id_cadastro){

        $sql = "DELETE FROM tb_agenda
                WHERE id = :id
                AND id_cadastro = :id_cadastro";

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':id_cadastro', $id_cadastro, PDO::PARAM_INT);

        return $stmt->execute();
    }

}
?>