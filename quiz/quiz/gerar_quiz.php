<?php

$materia = $_POST['materia'] ?? '';
$nivel = $_POST['nivel'] ?? '';
$assunto = $_POST['assunto'] ?? '';

$apiKey = "AQ.Ab8RN6LS7yxLQmCkGGaQpmQcmcpsPflBLkn-QgW3SYphRc6wEg";

$prompt = "

Crie um quiz em JSON válido.

IMPORTANTE:
- NÃO use ```json
- NÃO use markdown
- NÃO explique nada
- Retorne apenas o JSON puro
- NÃO escreva texto fora do JSON

Matéria: $materia
Nível: $nivel
Assunto: $assunto

Retorne exatamente neste formato:

[
  {
    \"tipo\": \"multipla_escolha\",
    \"pergunta\": \"...\",
    \"alternativas\": {
      \"A\": \"...\",
      \"B\": \"...\",
      \"C\": \"...\",
      \"D\": \"...\"
    },
    \"gabarito\": \"A\"
  },
  {
    \"tipo\": \"discursiva\",
    \"pergunta\": \"...\",
    \"resposta_esperada\": \"...\"
  }
]

Regras:
- Gere exatamente 10 questões.
- 7 questões devem ser de múltipla escolha.
- 3 questões devem ser discursivas.
- Toda questão de múltipla escolha deve obrigatoriamente conter:
  - \"tipo\": \"multipla_escolha\"
  - \"pergunta\"
  - \"alternativas\"
  - \"gabarito\"
- O campo \"alternativas\" deve conter obrigatoriamente:
  - \"A\"
  - \"B\"
  - \"C\"
  - \"D\"
- Nunca deixe o campo \"alternativas\" vazio.
- O campo \"gabarito\" deve conter apenas A, B, C ou D.
- Toda questão discursiva deve obrigatoriamente conter:
  - \"tipo\": \"discursiva\"
  - \"pergunta\"
  - \"resposta_esperada\"
- Nunca deixe o campo \"resposta_esperada\" vazio.
- As questões devem ser diferentes entre si e relacionadas ao assunto informado.
- Não repita perguntas.
- Não retorne nenhum campo diferente dos especificados.
- Retorne apenas um JSON válido contendo exatamente 10 questões.

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

if ($resposta === false) {
    die("Erro na conexão com a API.");
}

curl_close($ch);

$resultado = json_decode($resposta, true);

if (isset($resultado['error'])) {
    die("Erro na API: " . $resultado['error']['message']);
}

$quiz = $resultado['candidates'][0]['content']['parts'][0]['text']
    ?? "Erro ao gerar quiz.";

$quiz = str_replace(["```json", "```"], "", $quiz);
$quiz = trim($quiz);

$questoes = json_decode($quiz, true);


if (!$questoes) {
    echo "<pre>";
    var_dump(json_last_error_msg());
    echo "\n\n";
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
    <?= htmlspecialchars($q['pergunta']) ?>
    </p>

    <?php if($q['tipo'] == 'multipla_escolha'): ?>

<input
    type="hidden"
    name="gabarito_<?= $i ?>"
    value="<?= $q['gabarito'] ?>"
>

<?php foreach($q['alternativas'] as $letra => $texto): ?>

<label>
    <input
        type="radio"
        name="q<?= $i ?>"
        value="<?= $letra ?>"
    >
    <?= $letra ?>) <?= $texto ?>
</label>

<br>

<?php endforeach; ?>

<?php else: ?>

<input
    type="hidden"
    name="pergunta_<?= $i ?>"
    value="<?= htmlspecialchars($q['pergunta']) ?>"
>

<input
    type="hidden"
    name="resposta_esperada_<?= $i ?>"
    value="<?= htmlspecialchars($q['resposta_esperada']) ?>"
>

<textarea
    name="q<?= $i ?>"
    rows="5"
    cols="80"
></textarea>

<?php endif; ?>

<?php endforeach; ?>

<br><br>

<button type="submit">
    Finalizar Quiz
</button>

</form>