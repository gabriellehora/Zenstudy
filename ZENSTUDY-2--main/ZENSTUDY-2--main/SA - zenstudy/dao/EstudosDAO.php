<?php
require_once __DIR__ . '/../config/conexao.php';

class EstudosDAO {
    private $pdo;

    public function __construct() {
        global $pdo;
        $this->pdo = $pdo;
    }

    // Busca termos que combinem com o título ou descrição dos assuntos cadastrados
    public function pesquisarLocal($termo) {
        $sql = "SELECT id, titulo, descricao 
                FROM tb_assuntos 
                WHERE titulo LIKE :termo1 OR descricao LIKE :termo2";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':termo1', '%' . $termo . '%', PDO::PARAM_STR);
        $stmt->bindValue(':termo2', '%' . $termo . '%', PDO::PARAM_STR);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Busca os detalhes do ano/nível selecionado (ex: "Ensino Fundamental", "1º Ano")
    public function buscarAnoPorId($ano_id) {
        $sql = "SELECT * FROM tb_anos WHERE id = :ano_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':ano_id', $ano_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Busca as matérias vinculadas ao nível correto daquele ano ID de forma inteligente
    public function buscarMateriasPorAno($ano_id) {

        $sql = "SELECT m.id, m.nome
                FROM tb_materias m
                INNER JOIN tb_anos a ON m.ano = a.nome
                WHERE a.id = :ano_id";
    
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':ano_id', $ano_id, PDO::PARAM_INT);
        $stmt->execute();
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Busca os assuntos cadastrados para uma determinada matéria de um determinado ano
    public function buscarAssuntos($ano_id, $materia_id) {
        $sql = "SELECT id, titulo FROM tb_assuntos WHERE ano_id = :ano_id AND materia_id = :materia_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':ano_id', $ano_id, PDO::PARAM_INT);
        $stmt->bindValue(':materia_id', $materia_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Busca o texto final/descrição de um assunto específico
    public function buscarConteudoAssunto($assunto_id) {
        $sql = "SELECT titulo, descricao FROM tb_assuntos WHERE id = :assunto_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':assunto_id', $assunto_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>