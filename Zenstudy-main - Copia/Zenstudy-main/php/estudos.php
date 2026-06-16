<?php 
// Inicialização de segurança para evitar erros de variáveis indefinidas
$materia_title = isset($materia_title) ? $materia_title : 'Matéria';
$ano_nome = isset($ano_nome) ? $ano_nome : 'Ano não especificado';
$assuntos = isset($assuntos) ? $assuntos : [];

// Inclui o topo da página
include 'base_header.php'; 
?>

<div style="max-width: 900px; margin: auto; margin-top: 30px;">

    <h1><?php echo htmlspecialchars($materia_title); ?></h1>
    <h3><?php echo htmlspecialchars($ano_nome); ?></h3>

    <hr>

    <?php if (!empty($assuntos)): ?>
        <?php foreach ($assuntos as $a): 
            // Aceita tanto objeto ($a->id) quanto array ($a['id'])
            $id = isset($a->id) ? $a->id : (isset($a['id']) ? $a['id'] : '');
            $titulo = isset($a->titulo) ? $a->titulo : (isset($a['titulo']) ? $a['titulo'] : 'Sem título');
        ?>
            <div class="card">
                <a href="conteudo.php?id=<?php echo $id; ?>" style="text-decoration:none; color:inherit;">
                    <h3 style="cursor: pointer;"><?php echo htmlspecialchars($titulo); ?></h3>
                </a>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Nenhum conteúdo cadastrado para esta matéria.</p>
    <?php endif; ?>

</div>

<?php 
// Inclui o rodapé da página
include 'base_footer.php'; 
?>