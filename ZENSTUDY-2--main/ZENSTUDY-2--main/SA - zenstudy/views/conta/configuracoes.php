<?php 
include __DIR__ . '/../includes/header.php'; 

if (!isset($_SESSION['logado'])) {
    redirecionar('/views/login.php');
}
?>

<div class="menu-container">
    <h1>Configurações</h1>

    <a href="/views/conta/alterar_senha.php" class="item-config">
        Alterar Senha
    </a>

    <a href="/views/conta/editar_perfil.php" class="item-config">
        Editar Perfil
    </a>

    <a href="/views/conta/sobre.php" class="item-config">
        Sobre o App
    </a>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>