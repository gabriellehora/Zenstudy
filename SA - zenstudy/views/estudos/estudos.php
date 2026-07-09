<?php 
include __DIR__ . '/../includes/header.php'; 
require_once __DIR__ . '/../../controller/EstudosController.php';

$ano_id = isset($_GET['ano_id']) ? intval($_GET['ano_id']) : 0;
$materia_id = isset($_GET['materia_id']) ? intval($_GET['materia_id']) : 0;

// Busca os dados através do Controller e DAO
$dadosMaterias = obterDadosMateriais($ano_id);
$assuntos = obterDadosEstudos($ano_id, $materia_id);

$materia_title = "Matéria";
foreach ($dadosMaterias['materias'] as $m) {
    if ($m['id'] == $materia_id) {
        $materia_title = $m['name'] ?? $m['nome'];
        break;
    }
}
$ano_nome = $dadosMaterias['ano'];
?>

<div style="max-width: 900px; margin: auto; margin-top: 30px;">

    <h1><?php echo htmlspecialchars($materia_title); ?></h1>
    <h3><?php echo htmlspecialchars($ano_nome); ?></h3>

    <hr>

    <?php if (!empty($assuntos)): ?>
        <?php foreach ($assuntos as $a): ?>
            <div class="card">
                <a href="/views/estudos/conteudo.php?assunto_id=<?php echo $a['id']; ?>" style="text-decoration:none; color:inherit;">
                    <h3 style="cursor: pointer;"><?php echo htmlspecialchars($a['titulo']); ?></h3>
                </a>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Nenhum conteúdo cadastrado para esta matéria.</p>
    <?php endif; ?>

</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>