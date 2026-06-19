<?php 
include __DIR__ . '/../includes/header.php'; 

// Tranca de segurança
if (!isset($_SESSION['logado'])) {
    redirecionar('/views/login.php');
}
?>

<div class="login-container">
    <h1>Agenda</h1>
    
    <ul>
        <li><a href="/views/ferramentas/calendario.php">Ir para o Calendário</a></li>
    </ul>
</div>

<?php 
include __DIR__ . '/../includes/footer.php'; 
?>