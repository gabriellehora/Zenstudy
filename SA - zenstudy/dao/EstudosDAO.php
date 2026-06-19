<?php
require_once __DIR__ . '/../config/conexao.php';

class EstudosDAO {
    private $pdo;

    public function __construct() {
        global $pdo;
        $this->pdo = $pdo;
    }

    // Busca os detalhes do ano/nível selecionado (ex: "Ensino Fundamental", "1º Ano")
    public function buscarAnoPorId($ano_id) {
        $sql = "SELECT * FROM tb_anos WHERE id = :ano_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':ano_id', $ano_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Busca as matérias vinculadas ao ano ID
    public function buscarMateriasPorAno($ano_id) {
        $sql = "SELECT id, nm_materia AS nome FROM tb_materias WHERE id_ano = :ano_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':ano_id', $ano_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Busca os assuntos cadastrados para uma determinada matéria de um determinado ano
    public function buscarAssuntos($ano_id, $materia_id) {
        $sql = "SELECT id, nm_assunto AS titulo FROM tb_assuntos WHERE id_ano = :ano_id AND id_materia = :materia_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':ano_id', $ano_id, PDO::PARAM_INT);
        $stmt->bindValue(':materia_id', $materia_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Busca o texto final/descrição de um assunto específico
    public function buscarConteudoAssunto($assunto_id) {
        $sql = "SELECT nm_assunto AS titulo, ds_conteudo AS descricao FROM tb_assuntos WHERE id = :assunto_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':assunto_id', $assunto_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>