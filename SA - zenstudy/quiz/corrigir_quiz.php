<?php

require_once __DIR__ . "/../config/ia.php";
include __DIR__ . "/../views/includes/header.php";

function normalizar($texto)
{
    return trim(
        str_replace(
            ' ',
            '',
            mb_strtolower($texto)
        )
    );
}

$acertos = 0;
$total = 0;

$resultados = [];

foreach ($_POST as $questao => $respostaAluno) {

    if (
        strpos($questao,"gabarito_")===0 ||
        strpos($questao,"pergunta_")===0 ||
        strpos($questao,"resposta_esperada_")===0
    ){
        continue;
    }

    $numero = str_replace("q","",$questao);

    $gabarito = $_POST["gabarito_$numero"] ?? "";

    $respostaEsperada = $_POST["resposta_esperada_$numero"] ?? "";

    $pergunta = $_POST["pergunta_$numero"] ?? "";

    $total++;

    $correta = false;

    if($gabarito!=""){

        if(

            strtoupper(substr(trim($respostaAluno),0,1))

            ==

            strtoupper(trim($gabarito))

        ){

            $correta=true;

            $acertos++;

        }

    }else{

        $prompt="

Você é um professor.

Pergunta:

$pergunta

Resposta esperada:

$respostaEsperada

Resposta do aluno:

$respostaAluno

Analise o significado.

Se estiver correta responda apenas:

CORRETA

Se estiver errada responda apenas:

INCORRETA

";

        $dados=[

            "model"=>"llama-3.3-70b-versatile",

            "messages"=>[
                [
                    "role"=>"user",
                    "content"=>$prompt
                ]
            ],

            "temperature"=>0

        ];

        $ch=curl_init("https://api.groq.com/openai/v1/chat/completions");

        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

        curl_setopt($ch,CURLOPT_POST,true);

        curl_setopt($ch,CURLOPT_HTTPHEADER,[

            "Content-Type: application/json",

            "Authorization: Bearer ".$apiKey

        ]);

        curl_setopt($ch,CURLOPT_POSTFIELDS,json_encode($dados));

        $resposta=curl_exec($ch);

        curl_close($ch);

        $resultado=json_decode($resposta,true);

        $avaliacao=strtoupper(trim(

            $resultado['choices'][0]['message']['content'] ?? ""

        ));

        if($avaliacao=="CORRETA"){

            $correta=true;

            $acertos++;

        }

    }

    $resultados[]=[

        "numero"=>$numero+1,

        "pergunta"=>$pergunta,

        "resposta"=>$respostaAluno,

        "gabarito"=>$gabarito,

        "esperada"=>$respostaEsperada,

        "correta"=>$correta,

        "discursiva"=>$gabarito==""

    ];

}

$porcentagem=0;

if($total>0){

    $porcentagem=round(($acertos/$total)*100);

}

if($porcentagem>=90){

    $mensagem="🏆 Excelente desempenho!";

}elseif($porcentagem>=70){

    $mensagem="🎉 Muito bom! Continue assim.";

}elseif($porcentagem>=50){

    $mensagem="📚 Bom resultado. Você está evoluindo.";

}else{

    $mensagem="💪 Continue estudando. Você consegue melhorar!";

}

?>

<div class="page-container">

<div class="page-header">

<h1>🏆 Resultado do Quiz</h1>

<p>Confira seu desempenho.</p>

</div>

<div class="page-card resultado-geral">

<div class="porcentagem">

<?= $porcentagem ?>%

</div>

<h2>

<?= $acertos ?> de <?= $total ?>

questões corretas

</h2>

<p>

<?= $mensagem ?>

</p>

<div class="barra-resultado">

<div
class="barra-preenchida"

style="width:<?= $porcentagem ?>%">

</div>

</div>

</div>

<?php foreach($resultados as $item): ?>

<div class="page-card resultado-card <?= $item['correta'] ? 'resultado-correto' : 'resultado-incorreto' ?>">

    <div class="resultado-topo">

        <h3>

            <?= $item['correta'] ? '✅' : '❌' ?>

            Questão <?= $item['numero'] ?>

        </h3>

        <span class="resultado-badge">

            <?= $item['discursiva'] ? 'Discursiva' : 'Objetiva' ?>

        </span>

    </div>

    <?php if(!empty($item['pergunta'])): ?>

        <div class="resultado-bloco">

            <strong>Pergunta</strong>

            <p>

                <?= htmlspecialchars($item['pergunta']) ?>

            </p>

        </div>

    <?php endif; ?>

    <div class="resultado-bloco">

        <strong>Sua resposta</strong>

        <p>

            <?= nl2br(htmlspecialchars($item['resposta'])) ?>

        </p>

    </div>

    <?php if($item['discursiva']): ?>

        <div class="resultado-bloco">

            <strong>Resposta esperada</strong>

            <p>

                <?= htmlspecialchars($item['esperada']) ?>

            </p>

        </div>

    <?php else: ?>

        <div class="resultado-bloco">

            <strong>Resposta correta</strong>

            <p>

                <?= htmlspecialchars($item['gabarito']) ?>

            </p>

        </div>

    <?php endif; ?>

</div>

<?php endforeach; ?>

<div class="page-card resultado-final">

    <h2>🎯 Resumo do Desempenho</h2>

    <p>
        Você concluiu o quiz com
        <strong><?= $acertos ?></strong>
        acertos em
        <strong><?= $total ?></strong>
        questões.
    </p>

    <div class="acoes-resultado">

        <a
            href="quiz.php"
            class="btn-premium-action">

            🔄 Refazer Quiz

        </a>

        <a
            href="../index.php"
            class="btn-premium-action">

            🏠 Voltar ao Início

        </a>

    </div>

</div>

</div>

<?php
include __DIR__ . '/../views/includes/footer.php';
?>