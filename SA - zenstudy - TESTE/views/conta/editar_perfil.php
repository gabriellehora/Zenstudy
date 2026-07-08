<?php 
include __DIR__ . '/../includes/header.php'; 
require_once __DIR__ . '/../../dao/UsuarioDAO.php';

if (!isset($_SESSION['logado'])) {
    redirecionar('/views/login.php');
}

$usuarioDAO = new UsuarioDAO();
$usuario = $usuarioDAO->buscarPorId($_SESSION['id_cadastro']);

$flash = flash();
?>

<section class="form-section">
    <h2>Editar Perfil</h2>

    <form method="POST" action="/controller/ContaController.php">
        <input type="hidden" name="acao_perfil" value="1">

        <label>Nome:</label><br>
        <input type="text" name="nome" value="<?php echo htmlspecialchars($usuario['nm_usuario'] ?? $_SESSION['nome_usuario']); ?>" required><br><br>
    
        <label>Email:</label><br>
        <input type="email" name="email" value="<?php echo htmlspecialchars($usuario['ds_email'] ?? $_SESSION['email']); ?>" required><br><br>
    
        <button type="submit">Salvar</button>
    </form>
    
    <?php if ($flash): ?>
        <p class="<?php echo $flash['tipo']; ?>" style="font-weight: bold; color: <?php echo $flash['tipo'] == 'sucesso' ? 'green' : 'red'; ?>;">
            <?php echo $flash['mensagem']; ?>
        </p>
    <?php endif; ?>

</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>