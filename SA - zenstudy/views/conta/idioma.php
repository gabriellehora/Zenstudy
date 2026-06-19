<?php 
include __DIR__ . '/../includes/header.php'; 

if (!isset($_SESSION['logado'])) {
    redirecionar('/views/login.php');
}

// Define o idioma padrão se ainda não tiver nenhum salvo
$idioma_atual = $_SESSION['idioma'] ?? 'pt-br';
$flash = flash();
?>

<section class="form-section">

    <h2>Idioma</h2>

    <p>Idioma atual: <b><?php echo strtoupper($idioma_atual); ?></b></p>

    <form method="POST" action="/controller/PreferenciaController.php">
        <button type="submit" name="idioma" value="pt-br">Português</button>
        <button type="submit" name="idioma" value="en-us">Inglês</button>
        <button type="submit" name="idioma" value="es">Espanhol</button>
    </form>

    <?php if ($flash): ?>
        <p class="<?php echo $flash['tipo']; ?>" style="font-weight: bold; margin-top: 15px; color: <?php echo $flash['tipo'] == 'sucesso' ? 'green' : 'red'; ?>;">
            <?php echo $flash['mensagem']; ?>
        </p>
    <?php endif; ?>

</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>