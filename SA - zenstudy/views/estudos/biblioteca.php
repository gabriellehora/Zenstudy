<?php 
include __DIR__ . '/../includes/header.php'; 

if (!isset($_SESSION['logado'])) {
    redirecionar('/views/login.php');
}
?>

<div class="conteudo-scroll">

    <h1>Biblioteca - Assuntos</h1>

    <div class="secao-titulo">Ensino Fundamental</div>
    <div class="cards-container">
        <?php 
        $fundamental = [
            1 => "1º Ano Fundamental", 2 => "2º Ano Fundamental", 3 => "3º Ano Fundamental",
            4 => "4º Ano Fundamental", 5 => "5º Ano Fundamental", 6 => "6º Ano Fundamental",
            7 => "7º Ano Fundamental", 8 => "8º Ano Fundamental", 9 => "9º Ano Fundamental"
        ];
        foreach ($fundamental as $id => $ano): 
        ?>
        <div class="card">
            <a href="/views/estudos/materiais.php?ano_id=<?php echo $id; ?>">
                <?php echo $ano; ?>
            </a>
        </div>
        <?php endforeach; ?>
    </div>

    <div class="secao-titulo">Ensino Médio</div>
    <div class="cards-container">
        <?php 
        $medio = [10 => "1º Ano Ensino Médio", 11 => "2º Ano Ensino Médio", 12 => "3º Ano Ensino Médio"];
        foreach ($medio as $id => $ano): 
        ?>
        <div class="card">
            <a href="/views/estudos/materiais.php?ano_id=<?php echo $id; ?>">
                <?php echo $ano; ?>
            </a>
        </div>
        <?php endforeach; ?>
    </div>

    <div class="secao-titulo">ENEM - Áreas do Conhecimento</div>
    <div class="cards-container">
        <?php 
        $enem = [13 => "Matemática", 14 => "Linguagens e Códigos", 15 => "Ciências Humanas", 16 => "Ciências da Natureza", 17 => "Redação"];
        foreach ($enem as $id => $tema): 
        ?>
        <div class="card">
            <a href="/views/estudos/materiais.php?ano_id=<?php echo $id; ?>">
                <?php echo $tema; ?>
            </a>
        </div>
        <?php endforeach; ?>
    </div>

</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>