<?php

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode([
        'error' => 'Método não permitido.'
    ]);
    exit;
}

$apiKey = getenv('GROQ_API_KEY');

if (!$apiKey) {
    http_response_code(500);
    echo json_encode([
        'error' => 'GROQ_API_KEY não configurada no servidor.'
    ]);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);

$materia = $input['materia'] ?? '';
$nivel = $input['nivel'] ?? '';
$assunto = $input['assunto'] ?? '';

if (!$materia || !$nivel || !$assunto) {
    http_response_code(400);
    echo json_encode([
        'error' => 'Matéria, nível e assunto são obrigatórios.'
    ]);
    exit;
}

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
    "model" => "openai/gpt-oss-20b",
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

if ($resposta === false) {
    http_response_code(500);
    echo json_encode([
        'error' => 'Erro ao conectar com a API da Groq: ' . curl_error($ch)
    ]);

    curl_close($ch);
    exit;
}

$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

curl_close($ch);

http_response_code($status);

echo $resposta;