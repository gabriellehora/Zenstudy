<?php 
// Inclui o topo do site (header.php) que já inicia a sessão e o banco
include __DIR__ . '/includes/header.php'; 

// Verifica se há alguma mensagem de erro do flash (ex: Usuário ou senha incorretos)
$flash = flash();
?>

<div class="login-container">
    <h2>Login</h2>

    <?php if ($flash): ?>
        <div class="alert alert-<?php echo $hex = ($flash['tipo'] == 'erro') ? 'danger' : $flash['tipo']; ?>" style="color: red; text-align: center; margin-bottom: 15px; font-weight: bold;">
            <?php echo $flash['mensagem']; ?>
        </div>
    <?php endif; ?>

    <form action="/controller/LoginController.php" method="POST">
        <label>Email:</label>
        <input type="email" name="email" required>

        <label>Senha:</label>
        <input type="password" name="senha" required>

        <button type="submit" class="btn-blue">Entrar</button>

        <p style="margin-top: 20px; text-align: center; font-size: 0.9rem;">
            Ainda não tem conta? 
            <a href="/views/cadastro.php" style="color: var(--color-secondary); font-weight: bold; text-decoration: none;">
                Cadastre-se
            </a>
        </p>
    </form>
</div>

<?php 
// Inclui o rodapé do site (footer.php)
include __DIR__ . '/includes/footer.php'; 
?>