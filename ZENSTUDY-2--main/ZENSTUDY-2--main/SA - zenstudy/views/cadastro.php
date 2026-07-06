<?php 
include __DIR__ . '/includes/header.php'; 

$flash = flash();
?>

<section class="form-section">
    <h2>Cadastro de Usuários</h2>

    <?php if ($flash): ?>
        <div class="mensagens" style="text-align: center; margin-bottom: 15px;">
            <p class="<?php echo $flash['tipo']; ?>" style="font-weight: bold; color: <?php echo ($flash['tipo'] == 'sucesso') ? 'green' : 'red'; ?>;">
                <?php echo $flash['mensagem']; ?>
            </p>
        </div>
    <?php endif; ?>

    <form method="POST" action="../controller/CadastroController.php" class="form-card">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required>

        <label for="email">E-mail:</label>
        <input type="email" id="email" name="email" required>

        <label for="senha">Senha:</label>
        <input type="password" id="senha" name="senha" required>

        <button type="submit" class="btnsalvar">Salvar e Entrar</button>
    </form>
</section>

<?php 
include __DIR__ . '/includes/footer.php'; 
?>