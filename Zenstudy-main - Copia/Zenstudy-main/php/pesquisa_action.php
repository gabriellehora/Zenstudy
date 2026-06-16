<?php
// Este bloco deve ser inserido no início do seu arquivo 'pesquisa.php'
require_once 'conexao.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$resultado_local = [];
$resultado_wikipedia = [];
$mensagem = null;
$termo_pesquisa = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $termo_pesquisa = $_POST['termo'] ?? '';

    if (!empty($termo_pesquisa)) {
        $conexao = conectar();

        // 1. Pesquisa na base de dados local
        $busca = "%" . $termo_pesquisa . "%";
        $stmt = $conexao->prepare("SELECT * FROM tb_biblioteca WHERE titulo LIKE ? OR descricao LIKE ? OR materia LIKE ?");
        $stmt->bind_param("sss", $busca, $busca, $busca);
        $stmt->execute();
        $resultado = $stmt->get_result();

        while ($linha = $resultado->fetch_assoc()) {
            $resultado_local[] = $linha;
        }
        $stmt->close();
        $conexao->close();

        // 2. Se não houver resultados locais, pesquisa na Wikipedia via cURL (API externa)
        if (empty($resultado_local)) {
            $url = "https://pt.wikipedia.org/w/api.php?" . http_build_query([
                "action" => "query",
                "format" => "json",
                "list" => "search",
                "srsearch" => $termo_pesquisa,
                "srlimit" => 5,
                "srprop" => "snippet|titlesnippet"
            ]);

            // Configurando a requisição cURL com o User-Agent necessário
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_USERAGENT, 'ZenStudy-App (Projeto-Estudos-Usuario; contato@exemplo.com)');
            
            $resposta = curl_exec($ch);
            curl_close($ch);

            if ($resposta) {
                $data = json_decode($resposta, true);
                if (isset($data['query']['search'])) {
                    foreach ($data['query']['search'] as $item) {
                        // Remove as tags HTML de destaque trazidas pela API da Wikipedia
                        $snippet_limpo = strip_tags($item['snippet']);
                        
                        $resultado_wikipedia[] = [
                            'titulo' => $item['title'],
                            'descricao' => $snippet_limpo . " [Fonte: Wikipedia]",
                            'materia' => $termo_pesquisa
                        ];
                    }
                }
            }

            if (!empty($resultado_wikipedia)) {
                $mensagem = "Nenhum resultado local encontrado. Resultados externos (Wikipedia) encontrados.";
            } else {
                $mensagem = "Nenhum resultado encontrado, nem na base de dados local, nem na Wikipedia.";
            }
        } else {
            $mensagem = count($resultado_local) . " resultados locais encontrados.";
        }
    }
}