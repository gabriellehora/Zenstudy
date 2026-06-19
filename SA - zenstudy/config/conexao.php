<?php
// Configurações do banco de dados transferidas do seu app.py
$host = 'tini.click';
$port = '3306';
$db   = 'zenstudy';
$user = 'zenstudy';
$pass = '5564b6c2da8a08044d696ea0a4e82e29';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;port=$port;dbname=$db;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
     $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
     die("Erro na conexão com o banco de dados: " . $e->getMessage());
}

// Inicia as sessões globais (Substitui o app.secret_key do Flask)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Sistema equivalente à função flash() do Flask
function flash($mensagem = '', $tipo = '') {
    if (!empty($mensagem)) {
        $_SESSION['flash_mensagem'] = $mensagem;
        $_SESSION['flash_tipo'] = $tipo;
    } elseif (isset($_SESSION['flash_mensagem'])) {
        $msg = [
            'mensagem' => $_SESSION['flash_mensagem'],
            'tipo' => $_SESSION['flash_tipo']
        ];
        unset($_SESSION['flash_mensagem']);
        unset($_SESSION['flash_tipo']);
        return $msg;
    }
    return null;
}

// Redirecionador auxiliar rápido
function redirecionar($url) {
    header("Location: " . $url);
    exit();
}
?>