<?php 
// Inicia a sessão para capturar as preferências de modo e mensagens flash
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$tema = isset($tema) ? $tema : 'Claro';

// Inclui o topo da página
include 'base_header.php'; 
?>

<section class="form-section">

    <h2>Tema</h2>

    <p>Tema atual: <b><?php echo htmlspecialchars($tema); ?></b></p>

    <form method="POST">
        <button type="submit" name="modo" value="claro">Tema Claro</button>
        <button type="submit" name="modo" value="escuro">Tema Escuro</button>
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