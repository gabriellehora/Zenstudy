<?php 
include __DIR__ . '/../includes/header.php'; 
require_once __DIR__ . '/../../controller/EstudosController.php';

$ano_id = isset($_GET['ano_id']) ? intval($_GET['ano_id']) : 0;
$dados = obterDadosMateriais($ano_id);
?>

<div class="conteudo">

    <div class="titulo" style="margin-bottom: 10px; font-size: 2rem; font-weight: bold;">
        <?php echo $dados['nivel']; ?>
    </div>
    <div class="subtitulo" style="color: var(--color-text-light); margin-bottom: 30px;">
        <?php echo $dados['ano']; ?>
    </div>

    <div class="botoes-container">
        <?php if (!empty($dados['materias'])): ?>
            <?php foreach ($dados['materias'] as $materia): ?>
                <div class="menu-card">
                    <a href="/views/estudos/estudos.php?ano_id=<?php echo $ano_id; ?>&materia_id=<?php echo $materia['id']; ?>" class="icone-livro">
                        <?php echo $materia['name'] ?? $materia['nome']; ?>
                    </a>
                    <p>Conteúdos e aulas.</p> 
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p style="grid-column: 1/-1; text-align: center; color: var(--color-text-light);">Nenhuma matéria cadastrada para este ano ainda.</p>
        <?php endif; ?>
    </div>

</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>