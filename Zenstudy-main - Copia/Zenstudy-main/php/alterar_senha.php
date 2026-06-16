<?php

// Código para colocar no topo ou em um arquivo 'alterar_senha_post.php'
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $senha_atual = $_POST['senha_atual'] ?? '';
    $nova_senha = $_POST['nova_senha'] ?? '';
    $confirmar_senha = $_POST['confirmar_senha'] ?? '';

    if ($nova_senha !== $confirmar_senha) {
        flash("As novas senhas não coincidem!", "erro");
        header("Location: alterar_senha.php");
        exit();
    }

    $id = $_SESSION['id_cadastro'];
    $conexao = conectar();

    $stmt = $conexao->prepare("SELECT ds_senha FROM tb_cadastro WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();

    if (!$user || $senha_atual !== $user['ds_senha']) {
        flash("Senha atual incorreta!", "erro");
        $stmt->close();
        $conexao->close();
        header("Location: alterar_senha.php");
        exit();
    }

    $stmt_up = $conexao->prepare("UPDATE tb_cadastro SET ds_senha = ? WHERE id = ?");
    $stmt_up->bind_param("si", $nova_senha, $id);
    $stmt_up->execute();

    flash("Senha alterada com sucesso!", "sucesso");
    $stmt_up->close();
    $stmt->close();
    $conexao->close();
    header("Location: configuracoes.php");
    exit();
}
// Exemplo de lógica para capturar os erros/sucessos enviados pelo seu backend PHP
$erro = isset($erro) ? $erro : null;
$sucesso = isset($sucesso) ? $sucesso : null;

// Inclui o topo da página
include 'base_header.php'; 
?>

<div class="menu-container">
    <h1>Alterar Senha</h1>

    <form method="POST">
        <label>Senha atual:</label><br>
        <input type="password" name="senha_atual" required><br><br>
    
        <label>Nova senha:</label><br>
        <input type="password" name="nova_senha" required><br><br>
    
        <label>Confirmar nova senha:</label><br>
        <input type="password" name="confirmar_senha" required><br><br>
    
        <button type="submit">Alterar senha</button>
    </form>
    
    <?php if ($erro): ?>
        <p style="color:red"><?php echo htmlspecialchars($erro); ?></p>
    <?php endif; ?>
    
    <?php if ($sucesso): ?>
        <p style="color:green"><?php echo htmlspecialchars($sucesso); ?></p>
    <?php endif; ?>

</div>
    
<?php 
// Inclui o rodapé da página
include 'base_footer.php'; 
?>