<?php 
// Inicia a sessão para capturar possíveis mensagens flash
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Inicializa as variáveis para não dar erro de "Undefined variable"
$nome = isset($nome) ? $nome : '';
$email = isset($email) ? $email : '';

// Inclui o topo da página
include 'base_header.php'; 
?>

<section class="form-section">
    <h2>Editar Perfil</h2>

    <form method="POST">
        <label>Nome:</label><br>
        <input type="text" name="nome" value="<?php echo htmlspecialchars($nome); ?>" required><br><br>
    
        <label>Email:</label><br>
        <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required><br><br>
    
        <button type="submit">Salvar</button>
    </form>
    
    <?php if (isset($_SESSION['flash_messages'])): ?>
        <?php 
        foreach ($_SESSION['flash_messages'] as $msg): 
            $categoria = htmlspecialchars($msg['categoria']);
            $mensagem = htmlspecialchars($msg['texto']);
        ?>
            <p class="<?php echo $categoria; ?>"><?php echo $mensagem; ?></p>
        <?php endforeach; ?>
        
        <?php 
        // Limpa as mensagens após a exibição
        unset($_SESSION['flash_messages']); 
        ?>
    <?php endif; ?>

</section>

<?php 
// Inclui o rodapé da página
include 'base_footer.php'; 
?>