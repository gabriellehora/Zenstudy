<?php

$materia = $_POST['materia'];
$nivel = $_POST['nivel'];
$assunto = $_POST['assunto'];

$apiKey = "AQ.Ab8RN6LS7yxLQmCkGGaQpmQcmcpsPflBLkn-QgW3SYphRc6wEg";

$prompt = "

Crie um quiz em JSON válido.

IMPORTANTE:
- NÃO use ```json
- NÃO use markdown
- NÃO explique nada
- Retorne apenas o JSON puro

Matéria: $materia
Nível: $nivel
Assunto: $assunto

Retorne exatamente neste formato:

[
  {
    \"tipo\":\"multipla_escolha\",
    \"pergunta\":\"...\",
    \"alternativas\":[\"A\",\"B\",\"C\",\"D\"],
    \"gabarito\":\"A\"
  },
  {
    \"tipo\":\"discursiva\",
    \"pergunta\":\"...\",
    \"resposta_esperada\":\"...\"
  }
]

Sem explicações.
Somente JSON.
";

$url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key=$apiKey";

$dados = [
    "contents" => [
        [
            "parts" => [
                [
                    "text" => $prompt
                ]
            ]
        ]
    ]
];

$ch = curl_init($url);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: application/json"
]);

curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($dados));

$resposta = curl_exec($ch);

curl_close($ch);

$resultado = json_decode($resposta, true);

$quiz = $resultado['candidates'][0]['content']['parts'][0]['text'] ?? "Erro ao gerar quiz.";

$quiz = str_replace("```json", "", $quiz);
$quiz = str_replace("```", "", $quiz);
$quiz = trim($quiz);

$questoes = json_decode($quiz, true);

if (!$questoes) {
    echo "<pre>";
    echo $quiz;
    echo "</pre>";
    die("Erro ao converter JSON.");
}

?>

<h1>📚 Quiz</h1>

<form action="corrigir_quiz.php" method="POST">

<?php foreach($questoes as $i => $q): ?>

    <hr>

    <h3>
        Questão <?= $i + 1 ?>
    </h3>

    <p>
        <?= $q['pergunta'] ?>
    </p>

    <?php if($q['tipo'] == 'multipla_escolha'): ?>

        <?php foreach($q['alternativas'] as $alt): ?>

            <label>
                <input
                    type="radio"
                    name="q<?= $i ?>"
                    value="<?= $alt ?>"
                >
                <?= $alt ?>
            </label>

            <br>

        <?php endforeach; ?>

    <?php else: ?>

        <textarea
            name="q<?= $i ?>"
            rows="5"
            cols="80">
        </textarea>

    <?php endif; ?>

<?php endforeach; ?>

<br><br>

<button type="submit">
    Finalizar Quiz
</button>

</form>