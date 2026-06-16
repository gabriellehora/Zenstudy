<?php 
// Inclui o topo da página
include 'base_header.php'; 
?>

<div class="login-container">
    <h2>Login</h2>

    <form action="login_post.php" method="POST">
        <label>Email:</label>
        <input type="email" name="email" required>

        <label>Senha:</label>
        <input type="password" name="senha" required>

        <button type="submit" class="btn-blue">Entrar</button>

        <p style="margin-top: 20px; text-align: center; font-size: 0.9rem;">
            Ainda não tem conta? 
            <a href="cadastro.php" style="color: var(--color-secondary); font-weight: bold; text-decoration: none;">
                Cadastre-se
            </a>
        </p>
    </form>
</div>

<?php 
// Inclui o rodapé da página
include 'base_footer.php'; 
?>