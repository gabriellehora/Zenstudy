<?php 
// Inicia a sessão para checar o idioma e as mensagens flash
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$idioma = isset($idioma) ? $idioma : 'Não definido';

// Inclui o topo da página
include 'base_header.php'; 
?>

<section class="form-section">

    <h2>Idioma</h2>

    <p>Idioma atual: <b><?php echo htmlspecialchars($idioma); ?></b></p>

    <form method="POST">
        <button type="submit" name="idioma" value="pt-br">Português</button>
        <button type="submit" name="idioma" value="en-us">Inglês</button>
        <button type="submit" name="idioma" value="es">Espanhol</button>
    </form>

    <?php if (isset($_SESSION['flash_messages'])): ?>
        <?php 
        foreach ($_SESSION['flash_messages'] as $msg): 
            $categoria = htmlspecialchars($msg['categoria']);
            $mensagem = htmlspecialchars($msg['texto']);
        ?>
            <p class="<?php echo $categoria; ?>"><?php echo $mensagem; ?></p>
        <?php endforeach; ?>
        
        <?php unset($_SESSION['flash_messages']); ?>
    <?php endif; ?>

</section>

<?php 
// Inclui o rodapé da página
include 'base_footer.php'; 
?>