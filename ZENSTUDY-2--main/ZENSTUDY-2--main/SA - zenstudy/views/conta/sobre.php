<?php
require_once __DIR__ . '/../../config/conexao.php';
// Garante o bloqueio de segurança
if (!isset($_SESSION['logado'])) {
    redirecionar('/views/login.php');
}
?>
<!DOCTYPE html> 
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Sobre o Zenstudy</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --color-primary: #00bcd4;
            --color-secondary: #ff4081;
            --color-danger: #f44336;
            --bg-body: #ffffff;
            --bg-card: #ffffff;
            --bg-intro: #fff0f5;
            --bg-feature: #fafbff;
            --bg-footer: #ecf0f1;
            --color-text-main: #2c3e50;
            --color-text-muted: #7f8c8d;
            --color-heading: #4a3577;
            --shadow-color: rgba(0, 0, 0, 0.08);
            --border-feature: #e0f7fa;
        }

        body.dark-mode {
            --bg-body: #121212;
            --bg-card: #1e1e1e;
            --bg-intro: #2c2033;
            --bg-feature: #252525;
            --bg-footer: #1a1a1a;
            --color-text-main: #e0e0e0;
            --color-text-muted: #a0a0a0;
            --color-heading: #d46ac7;
            --shadow-color: rgba(0, 0, 0, 0.5);
            --border-feature: #333333;
        }

        body {
            margin: 0;
            font-family: 'Montserrat', sans-serif;
            background: var(--bg-body);
            color: var(--color-text-main);
            line-height: 1.6;
            transition: background 0.3s, color 0.3s;
        }

        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100px;
            z-index: 999;
            background: linear-gradient(90deg, var(--color-primary), var(--color-secondary));
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 40px; 
            box-shadow: 0 4px 15px rgba(126, 233, 247, 0.4);
            box-sizing: border-box; 
        }

        body::before {
            content: "";
            display: block;
            height: 130px;
        }

        .logo {
            font-size: 30px;
            font-weight: 800;
            color: white;
            text-decoration: none;
            letter-spacing: -0.5px;
        }

        .navbar-links {
            display: flex;
            align-items: center;
        }

        .navbar-links a {
            color: white;
            text-decoration: none;
            font-size: 18px;
            font-weight: 700;
            margin-left: 20px;
            opacity: 1.0;
            transition: .3s;
            cursor: pointer;
        }

        .navbar-links a:hover {
            opacity: 0.8;
        }

        .btn-sair {
            margin-left: 30px !important; 
        }

        .theme-toggle {
            background: none;
            border: none;
            color: white;
            font-size: 24px;
            cursor: pointer;
            margin-left: 20px;
            padding: 0;
            transition: transform 0.3s;
        }
        .theme-toggle:hover {
            transform: rotate(20deg) scale(1.1);
        }

        .sobre-wrapper {
            display: flex;
            justify-content: center;
            padding: 40px 20px;
        }

        .sobre-card {
            background: var(--bg-card);
            width: 96%;
            max-width: 1200px;
            padding: 70px;
            border-radius: 22px;
            box-shadow: 0 6px 20px var(--shadow-color);
            animation: fadeIn .4s ease-in-out;
            transition: background 0.3s;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .sobre-card h1 {
            text-align: center;
            font-size: 3rem;
            color: var(--color-heading);
            font-weight: 800;
            margin-bottom: 30px;
            padding-bottom: 12px;
        }

        .sobre-card h2 {
            font-size: 2rem;
            margin-top: 45px;
            color: var(--color-heading);
            font-weight: 700;
            border-left: 6px solid var(--color-primary);
            padding-left: 14px;
        }

        .intro-text {
            font-size: 1.25rem;
            background: var(--bg-intro);
            border-left: 5px solid var(--color-secondary);
            padding: 30px;
            border-radius: 14px;
            margin-bottom: 30px;
            line-height: 1.75;
            color: var(--color-text-main);
        }

        .feature-list {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(290px, 1fr));
            gap: 30px;
            margin-top: 30px;
        }

        .feature-item {
            background: var(--bg-feature);
            padding: 30px;
            border-radius: 16px;
            border: 1px solid var(--border-feature);
            transition: .3s;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        }

        .feature-item:hover {
            transform: translateY(-6px);
            box-shadow: 0 10px 22px rgba(0, 188, 212, 0.2);
        }

        .feature-item h3 {
            margin-bottom: 14px;
            color: var(--color-primary);
            font-weight: 700;
        }

        .call-to-action {
            margin-top: 50px;
            background: var(--bg-intro);
            padding: 30px;
            border-left: 6px solid var(--color-secondary);
            border-radius: 14px;
            text-align: center;
            font-weight: 600;
            font-size: 1.3rem;
            color: var(--color-heading);
        }

        footer {
            background: var(--bg-footer);
            text-align: center;
            padding: 25px 15px;
            font-size: 0.9rem;
            color: var(--color-text-muted);
            border-top: 1px solid #bdc3c7;
        }
    </style>
</head>
<body>

<nav class="navbar">
    <a href="/views/menu.php" class="logo">Zenstudy</a>
    
    <div class="navbar-links">
        <a href="/views/menu.php">Painel</a>
        <a href="/views/ferramentas/agenda.php">Agenda</a>
        <a href="/views/estudos/pesquisa.php">Pesquisa</a>
        <a href="/views/estudos/biblioteca.php">Biblioteca</a>
        <a href="/views/conta/configuracoes.php">Configurações</a>
        
        <button id="theme-toggle" class="theme-toggle" title="Alternar Tema">🌙</button>

        <a href="/views/logout.php" class="btn-sair">Sair</a>
    </div>
</nav>

<div class="sobre-wrapper">
    <div class="sobre-card">
        <h1>Sobre o Zenstudy</h1>

        <p class="intro-text">
            🚀 <strong>O Poder do Seu Próprio Estudo</strong><br><br>
            Em um world cheio de respostas instantâneas, acreditamos no 
            <strong>poder insubstituível do seu próprio raciocínio</strong>.
            O ZENSTUDY nasceu para reacender a paixão pelo estudo ativo e autônomo. 
            Não somos um atalho; somos um <strong>guia</strong> para o aprendizado verdadeiro.
        </p>

        <h2>Por que estudar sem IA?</h2>
        <p>A excelência acadêmica nasce da capacidade de pensar, conectar ideias e solucionar problemas:</p>

        <div class="feature-list">
            <div class="feature-item">
                <h3>🌟 Ferramentas, não Respostas</h3>
                <p>Oferecemos métodos, organização e desafios que te ensinam <em>como</em> aprender.</p>
            </div>

            <div class="feature-item">
                <h3>🧠 Raciocínio Crítico</h3>
                <p>Te incentivamos a explorar, questionar e construir conhecimento próprio.</p>
            </div>

            <div class="feature-item">
                <h3>⏳ Disciplina e Autonomia</h3>
                <p>Ajuda você a montar rotinas eficazes e estudar com independência.</p>
            </div>
        </div>

        <p class="call-to-action">
            Se você busca uma preparação sólida e duradoura, junte-se a nós.  
            Sua inteligência é sua ferramenta mais poderosa!
        </p>

    </div>
</div>

<footer>
    Desenvolvido por Zenstudy
</footer>

<script>
    const toggleButton = document.getElementById('theme-toggle');
    const body = document.body;

    const currentTheme = localStorage.getItem('theme');
    if (currentTheme === 'dark') {
        body.classList.add('dark-mode');
        toggleButton.textContent = '☀️';
    }

    toggleButton.addEventListener('click', () => {
        body.classList.toggle('dark-mode');
        
        let theme = 'light';
        if (body.classList.contains('dark-mode')) {
            theme = 'dark';
            toggleButton.textContent = '☀️';
        } else {
            toggleButton.textContent = '🌙';
        }
        
        localStorage.setItem('theme', theme);
    });
</script>

</body>
</html>