<?php 
// Inclui o topo da página (Equivalente ao extends e abertura do block content)
include 'base_header.php'; 
?>

<div class="conteudo-scroll">

    <h1>Biblioteca - Assuntos</h1>

    <div class="secao-titulo">Ensino Fundamental</div>

    <div class="cards-container">
        <?php
        $fundamental = [
            "1º Ano Fundamental", "2º Ano Fundamental", "3º Ano Fundamental",
            "4º Ano Fundamental", "5º Ano Fundamental", "6º Ano Fundamental",
            "7º Ano Fundamental", "8º Ano Fundamental", "9º Ano Fundamental"
        ];
        
        // Em Jinja2, loop.index começa em 1. Criamos um contador para simular isso.
        $index_fundamental = 1; 
        foreach ($fundamental as $ano): 
        ?>
            <div class="card">
                <a href="/materiais/fundamental/<?php echo $index_fundamental; ?>">
                    <?php echo htmlspecialchars($ano); ?>
                </a>
            </div>
        <?php 
            $index_fundamental++;
        endforeach; 
        ?>
    </div>

    <div class="secao-titulo">Ensino Médio</div>

    <div class="cards-container">
        <?php 
        $anos_medio_ids = [10, 11, 12];
        $medio_nomes = [
            "1º Ano Ensino Médio", "2º Ano Ensino Médio", "3º Ano Ensino Médio"
        ];
        
        // Usamos a chave ($key) do foreach que começa em 0, equivalente ao loop.index0
        foreach ($medio_nomes as $key => $ano): 
            $id_medio = $anos_medio_ids[$key];
        ?>
            <div class="card">
                <a href="/materiais/medio/<?php echo $id_medio; ?>">
                    <?php echo htmlspecialchars($ano); ?>
                </a>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="secao-titulo">ENEM - Áreas do Conhecimento</div>

    <div class="cards-container">
        <?php 
        $enem_ids = [13, 14, 15, 16, 17];
        $enem_temas = [
            "Matemática",
            "Linguagens e Códigos",
            "Ciências Humanas",
            "Ciências da Natureza",
            "Redação"
        ];
        
        // Usamos a chave ($key) para mapear o ID correto de forma idêntica ao Jinja2
        foreach ($enem_temas as $key => $tema): 
            $id_enem = $enem_ids[$key];
        ?>
            <div class="card">
                <a href="/materiais/enem/<?php echo $id_enem; ?>">
                    <?php echo htmlspecialchars($tema); ?>
                </a>
            </div>
        <?php endforeach; ?>
    </div>

</div>

<?php 
// Inclui o rodapé da página (Equivalente ao endblock)
include 'base_footer.php'; 
?>