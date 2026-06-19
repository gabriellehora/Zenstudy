<?php

$acertos = 0;
$total = 0;

echo "<h1>Resultado do Quiz</h1>";

foreach ($_POST as $questao => $respostaAluno) {

    if (strpos($questao, "gabarito_") === 0) {
        continue;
    }

    $numero = str_replace("q", "", $questao);

    $gabarito = $_POST["gabarito_$numero"] ?? "";

    $total++;

    echo "<hr>";
    echo "<h3>Questão " . ($numero + 1) . "</h3>";

    echo "<p><strong>Sua resposta:</strong> $respostaAluno</p>";
    echo "<p><strong>Resposta correta:</strong> $gabarito</p>";

    if (trim($respostaAluno) == trim($gabarito)) {
        echo "<p style='color:green;'>✅ Correta</p>";
        $acertos++;
    } else {
        echo "<p style='color:red;'>❌ Incorreta</p>";
    }
}

echo "<hr>";
echo "<h2>Acertos: $acertos / $total</h2>";