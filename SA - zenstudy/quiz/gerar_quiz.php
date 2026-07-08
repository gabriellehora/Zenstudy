<?php

$materia = $_POST['materia'] ?? '';
$nivel = $_POST['nivel'] ?? '';
$assunto = $_POST['assunto'] ?? '';

require_once __DIR__ . "/../config/ia.php";

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
- 7 objetivas.
- 3 discursivas.
- Não explique nada.
- Retorne apenas JSON válido.

";

$url = "https://api.groq.com/openai/v1/chat/completions";

$dados = [
    "model" => "llama-3.3-70b-versatile",
    "messages" => [
        [
            "role" => "user",
            "content" => $prompt
        ]
    ],
    "temperature" => 0.7
];

$ch = curl_init($url);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);

curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: application/json",
    "Authorization: Bearer " . $apiKey
]);

curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($dados));

$resposta = curl_exec($ch);

curl_close($ch);

$resultado = json_decode($resposta, true);

if (isset($resultado['error'])) {
    die("Erro na API: " . $resultado['error']['message']);
}

$quiz = $resultado['choices'][0]['message']['content'] ?? "";

$quiz = str_replace(["```json", "```"], "", $quiz);
$quiz = trim($quiz);

$questoes = json_decode($quiz, true);

if (!$questoes) {

    echo "<pre>";
    var_dump(json_last_error_msg());
    echo $quiz;
    echo "</pre>";
    die();

}

include __DIR__ . '/../views/includes/header.php';

$totalQuestoes = count($questoes);

?>

<div class="page-container">

    <div class="page-header">

        <h1>🧠 Quiz ZenStudy</h1>

        <p>
            Responda todas as questões e teste seus conhecimentos.
        </p>

    </div>

    <div class="page-card quiz-info">

        <div class="quiz-badge">

            <span>📚 <?= htmlspecialchars($materia) ?></span>

            <span>🎯 <?= htmlspecialchars($nivel) ?></span>

            <span>📝 <?= htmlspecialchars($assunto) ?></span>

        </div>

        <div class="quiz-progress">

            <div class="quiz-progress-bar"></div>

        </div>

        <small>
            <?= $totalQuestoes ?> questões
        </small>

    </div>

    <form action="corrigir_quiz.php" method="POST">

    <?php foreach($questoes as $i => $q): ?>

<div class="page-card questao-card">

    <div class="questao-topo">

        <div class="numero-questao">
            Questão <?= $i + 1 ?> de <?= $totalQuestoes ?>
        </div>

        <?php if($q['tipo'] == 'multipla_escolha'): ?>

            <span class="tipo-questao objetiva">
                Objetiva
            </span>

        <?php else: ?>

            <span class="tipo-questao discursiva">
                Discursiva
            </span>

        <?php endif; ?>

    </div>

    <h3 class="titulo-questao">

        <?= htmlspecialchars($q['pergunta']) ?>

    </h3>

<?php if($q['tipo'] == 'multipla_escolha'): ?>

<input
    type="hidden"
    name="gabarito_<?= $i ?>"
    value="<?= $q['gabarito'] ?>"
>

<div class="alternativas">

<?php foreach($q['alternativas'] as $letra => $texto): ?>

<label class="alternativa-card">

    <input
        type="radio"
        name="q<?= $i ?>"
        value="<?= $letra ?>"
        required
    >

    <span class="letra">

        <?= $letra ?>

    </span>

    <span class="texto-alternativa">

        <?= htmlspecialchars($texto) ?>

    </span>

</label>

<?php endforeach; ?>

</div>

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

<div class="resposta-discursiva">

<label>

Sua resposta

</label>

<textarea

    name="q<?= $i ?>"

    rows="6"

    placeholder="Digite sua resposta..."

    required

></textarea>

</div>

<?php endif; ?>

</div>

<?php endforeach; ?>

        <div class="page-card finalizar-card">

            <h3>🏁 Finalizar Quiz</h3>

            <p>
                Revise suas respostas antes de finalizar. Após enviar, seu desempenho será corrigido automaticamente.
            </p>

            <button
                type="submit"
                class="btn-premium-action btn-finalizar">

                ✅ Finalizar Quiz

            </button>

        </div>

    </form>

</div>

<script>

document.querySelectorAll(".alternativa-card").forEach(card=>{

    const radio=card.querySelector("input");

    radio.addEventListener("change",()=>{

        document
        .querySelectorAll(
            'input[name="'+radio.name+'"]'
        )
        .forEach(r=>{

            r.closest(".alternativa-card")
            .classList.remove("selecionada");

        });

        card.classList.add("selecionada");

    });

});

</script>

<?php
include __DIR__ . '/../views/includes/footer.php';
?>