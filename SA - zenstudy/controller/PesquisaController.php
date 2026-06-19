<?php
require_once __DIR__ . '/../config/conexao.php';
require_once __DIR__ . '/../dao/EstudosDAO.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $termo = filter_input(INPUT_POST, 'termo', FILTER_SANITIZE_SPECIAL_CHARS);

    if (!empty($termo)) {
        $_SESSION['ultimo_termo'] = $termo;

        // 1. Busca no Banco Local
        $estudosDAO = new EstudosDAO();
        $resultado_local = $estudosDAO->pesquisarLocal($termo);
        $_SESSION['res_local'] = $resultado_local;

        // 2. Busca na API da Wikipedia (Substituindo o request em Python)
        $url = "https://pt.wikipedia.org/w/api.php?action=query&list=search&srsearch=" . urlencode($termo) . "&format=json";
        
        // Define um user-agent para a Wikipedia aceitar a requisição sem dar erro de segurança
        $opcoes = ["http" => ["header" => "User-Agent: ZenstudyApp/1.0 (contato@zenstudy.com)\r\n"]];
        $contexto = stream_context_create($opcoes);
        $response = @file_get_contents($url, false, $contexto);

        $resultado_wiki = [];
        if ($response) {
            $dados = json_decode($response, true);
            if (isset($dados['query']['search'])) {
                foreach ($dados['query']['search'] as $wikiItem) {
                    $resultado_wiki[] = [
                        'titulo' => $wikiItem['title'],
                        'descricao' => $wikiItem['snippet'] . '...'
                    ];
                }
            }
        }
        $_SESSION['res_wiki'] = $resultado_wiki;

        // Define mensagens caso nada seja encontrado
        if (empty($resultado_local) && empty($resultado_wiki)) {
            $_SESSION['msg_pesquisa'] = "Nenhum resultado encontrado para '" . $termo . "'";
        }
    }

    redirecionar('/views/estudos/pesquisa.php');
}
?>