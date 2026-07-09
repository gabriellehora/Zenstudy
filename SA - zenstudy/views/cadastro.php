<?php 
include __DIR__ . '/includes/header.php'; 

$flash = flash();
?>

<div class="auth-wrapper">
    <section class="form-section login-container">

        <h2>Criar Nova Conta</h2>

        <p class="auth-desc">
            Comece hoje mesmo a transformar sua rotina acadêmica de forma autônoma.
        </p>

        <?php if ($flash): ?>
            <div class="alert alert-<?php echo ($flash['tipo'] == 'sucesso') ? 'success' : 'danger'; ?>">
                <i class="fas <?php echo ($flash['tipo'] == 'sucesso') ? 'fa-check-circle' : 'fa-exclamation-circle'; ?>"></i>

                <span>
                    <?php echo htmlspecialchars($flash['mensagem']); ?>
                </span>
            </div>
        <?php endif; ?>


        <form method="POST" action="/controller/CadastroController.php" class="auth-form">

            <div class="input-group">
                <label for="nome">Nome Completo</label>

                <input 
                    type="text" 
                    id="nome" 
                    name="nome" 
                    placeholder="Seu nome completo" 
                    required
                >
            </div>


            <div class="input-group">
                <label for="email">E-mail</label>

                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    placeholder="seu.email@provedor.com" 
                    required
                >
            </div>


            <div class="input-group">
                <label for="senha">Senha de Acesso</label>

                <input 
                    type="password" 
                    id="senha" 
                    name="senha" 
                    placeholder="Mínimo 6 caracteres" 
                    required
                >
            </div>


            <button type="submit" class="btn-premium-action">
                Salvar e Entrar
            </button>


            <p class="auth-footer-text">
                Já possui registro?
                <a href="/views/login.php">
                    Fazer Login
                </a>
            </p>

        </form>

    </section>
</div>


<?php 
include __DIR__ . '/includes/footer.php'; 
?>