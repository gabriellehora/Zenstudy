<?php 
include __DIR__ . '/../includes/header.php'; 

if (!isset($_SESSION['logado'])) {
    redirecionar('/zenstudy/views/login.php');
}

$flash = flash();
?>

<div class="menu-container">
    <h1>Alterar Senha</h1>

    <form method="POST" action="/zenstudy/controlleer/ContaController.php">
        <input type="hidden" name="acao_senha" value="1">

        <label>Senha atual:</label><br>
        <input type="password" name="senha_atual" required><br><br>
    
        <label>Nova senha:</label><br>
        <input type="password" name="nova_senha" required><br><br>
    
        <label>Confirmar nova senha:</label><br>
        <input type="password" name="confirmar_senha" required><br><br>
    
        <button type="submit">Alterar senha</button>
    </form>
    
    <?php if ($flash): ?>
        <p style="font-weight: bold; color: <?php echo $flash['tipo'] == 'sucesso' ? 'green' : 'red'; ?>">
            <?php echo $flash['mensagem']; ?>
        </p>
    <?php endif; ?>

</div>
    
<?php include __DIR__ . '/../includes/footer.php'; ?>