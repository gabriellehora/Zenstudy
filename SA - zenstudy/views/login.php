<?php 
include __DIR__ . '/includes/header.php'; 

if (isset($_SESSION['logado']) && $_SESSION['logado'] === true) {
    redirecionar('/views/menu.php');
}

$flash = flash();
?>

<div class="auth-wrapper">
    <div class="login-container">
        <h2>Entrar no Zenstudy</h2>
        <p class="auth-desc">
            Insira suas credenciais para acessar sua área de estudos.
        </p>

        <?php if ($flash): ?>
            <div class="alert alert-<?php echo ($flash['tipo'] == 'erro') ? 'danger' : 'success'; ?>">
                <i class="fas <?php echo ($flash['tipo'] == 'erro') ? 'fa-exclamation-circle' : 'fa-check-circle'; ?>"></i>
                <span>
                    <?php echo htmlspecialchars($flash['mensagem']); ?>
                </span>
            </div>
        <?php endif; ?>

        <form action="/controller/LoginController.php" method="POST" class="auth-form">

            <div class="input-group">
                <label for="email">E-mail Corporativo ou Estudantil</label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    placeholder="exemplo@zenstudy.com" 
                    required
                >
            </div>

            <div class="input-group">
                <label for="senha">Sua Senha</label>
                <input 
                    type="password" 
                    id="senha" 
                    name="senha" 
                    placeholder="••••••••" 
                    required
                >
            </div>

            <button type="submit" class="btn-premium-action">
                Entrar na Plataforma
            </button>

            <p class="auth-footer-text">
                Ainda não tem uma conta?
                <a href="/views/cadastro.php">
                    Cadastre-se aqui
                </a>
            </p>

        </form>

    </div>
</div>

<?php 
include __DIR__ . '/includes/footer.php'; 
?>