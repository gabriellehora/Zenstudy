<?php 
include __DIR__ . '/../includes/header.php'; 
require_once __DIR__ . '/../../controller/EstudosController.php';

$assunto_id = isset($_GET['assunto_id']) ? intval($_GET['assunto_id']) : 0;
$assunto = obterTextoConteudo($assunto_id);
?>

<div style="max-width: 800px; margin: auto; margin-top: 30px; padding: 0 20px;">

    <h1><?php echo htmlspecialchars($assunto['titulo'] ?? 'Conteúdo'); ?></h1>
    <p style="margin-top: 20px; font-size: 18px; line-height: 1.6;">
        <?php echo nl2br(htmlspecialchars($assunto['descricao'] ?? "Conteúdo em breve")); ?>
    </p>

    <a href="javascript:history.back()" class="botao-voltar" style="display: inline-block; margin-top: 30px; text-decoration: none; font-weight: bold;">Voltar</a>

</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>