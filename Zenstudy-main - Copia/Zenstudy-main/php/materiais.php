<?php 
// Inicialização de segurança para evitar erros de variáveis indefinidas
$nivel = isset($nivel) ? $nivel : 'Nível de Ensino';
$ano = isset($ano) ? $ano : 'Ano/Série';
$ano_id = isset($ano_id) ? $ano_id : 0;
$materias = isset($materias) ? $materias : [];

// Inclui o topo da página
include 'base_header.php'; 
?>

<div class="conteudo">

    <div class="titulo" style="margin-bottom: 10px;"><?php echo htmlspecialchars($nivel); ?></div>
    <div class="subtitulo" style="color: var(--color-text-light); margin-bottom: 30px;">
        <?php echo htmlspecialchars($ano); ?>
    </div>

    <div class="botoes-container">
        
        <?php foreach ($materias as $materia): 
            // Aceita formato de objeto ($materia->id) ou array associativo ($materia['id'])
            $materia_id = isset($materia->id) ? $materia->id : (isset($materia['id']) ? $materia['id'] : '');
            $materia_nome = isset($materia->nome) ? $materia->nome : (isset($materia['nome']) ? $materia['nome'] : 'Matéria Sem Nome');
        ?>
            <div class="menu-card">
                <a href="estudos.php?ano_id=<?php echo $ano_id; ?>&materia_id=<?php echo $materia_id; ?>" class="icone-livro">
                    <?php echo htmlspecialchars($materia_nome); ?>
                </a>
                
                <p>Conteúdos e aulas.</p> 
            </div>
        <?php endforeach; ?>

    </div>

</div>

<?php 
// Inclui o rodapé da página
include 'base_footer.php'; 
?>