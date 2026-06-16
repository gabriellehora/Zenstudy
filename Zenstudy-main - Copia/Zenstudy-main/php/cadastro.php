<?php 
// Inicia a sessão para capturar possíveis mensagens flash do PHP
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Inclui o topo da página
include 'base_header.php'; 
?>

<section class="form-section">
    <h2>Cadastro de Usuários</h2>

    <?php if (isset($_SESSION['flash_messages'])): ?>
        <div class="mensagens">
            <?php 
            foreach ($_SESSION['flash_messages'] as $msg): 
                // Exemplo: $msg deve ser um array contendo ['categoria' => 'sucesso', 'texto' => '...']
                $categoria = htmlspecialchars($msg['categoria']);
                $mensagem = htmlspecialchars($msg['texto']);
            ?>
                <p class="<?php echo $categoria; ?>"><?php echo $mensagem; ?></p>
            <?php endforeach; ?>
            
            <?php 
            // Limpa as mensagens da sessão após exibir para não repetir na próxima página
            unset($_SESSION['flash_messages']); 
            ?>
        </div>
    <?php endif; ?>

    <form method="POST" class="form-card">
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
// Inclui o rodapé da página
include 'base_footer.php'; 
?>