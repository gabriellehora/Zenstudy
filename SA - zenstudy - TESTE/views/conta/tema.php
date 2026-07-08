<?php 
include __DIR__ . '/../includes/header.php'; 

if (!isset($_SESSION['logado'])) {
    redirecionar('/views/login.php');
}

// Define o tema padrão se não tiver nenhum salvo
$tema_atual = $_SESSION['tema'] ?? 'claro';
$flash = flash();
?>

<section class="form-section">

    <h2>Tema</h2>

    <p>Tema atual: <b><?php echo ucfirst($tema_atual); ?></b></p>

    <form method="POST" action="/controller/PreferenciaController.php">
        <button type="submit" name="modo" value="claro">Tema Claro</button>
        <button type="submit" name="modo" value="escuro">Tema Escuro</button>
    </form>

    <?php if ($flash): ?>
        <p class="<?php echo $flash['tipo']; ?>" style="font-weight: bold; margin-top: 15px; color: <?php echo $flash['tipo'] == 'sucesso' ? 'green' : 'red'; ?>;">
            <?php echo $flash['mensagem']; ?>
        </p>
    <?php endif; ?>

</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>