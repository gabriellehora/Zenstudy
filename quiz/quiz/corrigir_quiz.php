<?php


function normalizar($texto) {
    return trim(str_replace(' ', '', mb_strtolower($texto)));
}

$acertos = 0;
$total = 0;

echo "<h1>Resultado do Quiz</h1>";

foreach ($_POST as $questao => $respostaAluno) {

    if (strpos($questao, "gabarito_") === 0) {
        continue;
    }

    if (strpos($questao, "resposta_esperada_") === 0) {
        continue;
    }

    if (strpos($questao, "pergunta_") === 0) {
        continue;
    }


    $numero = str_replace("q", "", $questao);

    $gabarito = $_POST["gabarito_$numero"] ?? "";
    
    $respostaEsperada = $_POST["resposta_esperada_$numero"] ?? "";

    $pergunta = $_POST["pergunta_$numero"] ?? "";
    
    $total++;

    echo "<hr>";
    echo "<h3>Questão " . ($numero + 1) . "</h3>";
    echo "<p><strong>Sua resposta:</strong> $respostaAluno</p>";
    echo "<p><strong>Resposta correta:</strong> $gabarito</p>";

    if ($gabarito != "") {

        if (
            strtoupper(substr(trim($respostaAluno), 0, 1))
            ==
            strtoupper(trim($gabarito))
        ) {
            echo "<p style='color:green;'>✅ Correta</p>";
            $acertos++;
        } else {
            echo "<p style='color:red;'>❌ Incorreta</p>";
        }
    
    } else {
    
        echo "<p style='color:blue;'>📝 Questão discursiva</p>";
        echo "<p><strong>Resposta esperada:</strong> $respostaEsperada</p>";
        
        $apiKey = "AQ.Ab8RN6LS7yxLQmCkGGaQpmQcmcpsPflBLkn-QgW3SYphRc6wEg"; // coloque a mesma chave do gerar_quiz.php
        
        $prompt = "
        Você é um professor corrigindo uma prova.
        
        Pergunta:
        $pergunta
        
        Resposta esperada:
        $respostaEsperada
        
        Resposta do aluno:
        $respostaAluno
        
        Analise o significado da resposta.
        
        Se o aluno demonstrou o conceito correto, mesmo usando palavras diferentes, responda apenas:
        
        CORRETA
        
        Se houver erro conceitual, responda apenas:
        
        INCORRETA
        
        Não explique.
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
        
        $avaliacao = strtoupper(trim(
            $resultado['candidates'][0]['content']['parts'][0]['text'] ?? ""
        ));
        
        
        if ($avaliacao === "CORRETA") {
            echo "<p style='color:green;'>✅ Correta</p>";
            $acertos++;
        } elseif ($avaliacao === "INCORRETA") {
            echo "<p style='color:red;'>❌ Incorreta</p>";
        } else {
            echo "<p style='color:orange;'>⚠️ A IA retornou uma resposta inesperada.</p>";
        }
    
    }

}

echo "<hr>";
echo "<h2>Acertos: $acertos / $total</h2>";