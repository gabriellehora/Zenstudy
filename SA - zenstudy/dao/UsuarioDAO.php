<?php
require_once __DIR__ . '/../config/conexao.php';

class UsuarioDAO {
    private $pdo;

    public function __construct() {
        global $pdo;
        $this->pdo = $pdo;
    }

    // ==========================================
    // MÓDULO DE AUTENTICAÇÃO (LOGIN E CADASTRO)
    // ==========================================

    // Realiza a verificação de login do usuário
    public function login($email, $senha) {
        $sql = "SELECT * FROM tb_cadastro WHERE ds_email = :email AND ds_senha = :senha";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':senha', $senha); // Se futuramente usar password_hash, ajustamos aqui
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Verifica se um e-mail já existe no banco antes de cadastrar
    public function emailExiste($email) {
        $sql = "SELECT id FROM tb_cadastro WHERE ds_email = :email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':email', $email);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }

    // Insere um novo usuário na tabela tb_cadastro
    public function cadastrar($nome, $email, $senha) {
        $sql = "INSERT INTO tb_cadastro (nm_usuario, ds_email, ds_senha) VALUES (:nome, :email, :senha)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':nome', $nome);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':senha', $senha);

        return $stmt->execute();
    }

    // ==========================================
    // MÓDULO DE CONTA (PERFIL E CONFIGURAÇÕES)
    // ==========================================

    // Busca os dados completos do usuário pelo ID (para preencher formulários)
    public function buscarPorId($id) {
        $sql = "SELECT * FROM tb_cadastro WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Atualiza o nome e o e-mail do perfil do usuário
    public function atualizarPerfil($id, $nome, $email) {
        $sql = "UPDATE tb_cadastro SET nm_usuario = :nome, ds_email = :email WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':nome', $nome);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    // Atualiza a senha do usuário
    public function atualizarSenha($id, $nova_senha) {
        $sql = "UPDATE tb_cadastro SET ds_senha = :senha WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':senha', $nova_senha);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }
}
?>