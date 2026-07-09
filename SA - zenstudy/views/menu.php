<?php 
include __DIR__ . '/includes/header.php'; 

if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    redirecionar('/views/login.php');
}
?>

<div class="dashboard-container"> 

    <div class="dashboard-header">
        <h2>Painel de Controle de Estudos</h2>

        <p class="dashboard-welcome">
            Olá, <?php echo htmlspecialchars($_SESSION['nome_usuario'] ?? 'Estudante'); ?>!
            Pronto para o foco ativo de hoje?
        </p>
    </div>


    <div class="dashboard-grid">

        <div class="menu-card card-agenda">
            <div class="card-icon-wrapper">🗓️</div>
            <a href="/views/ferramentas/calendario.php">
                Agenda e Rotina
            </a>
            <p>Monitore seus prazos, eventos e defina cronogramas.</p>
        </div>


        <div class="menu-card card-biblioteca">
            <div class="card-icon-wrapper">📚</div>
            <a href="/views/estudos/biblioteca.php">
                Biblioteca Virtual
            </a>
            <p>Acesse o repositório de matérias segmentadas do Fundamental ao ENEM.</p>
        </div>


        <div class="menu-card card-pesquisa">
            <div class="card-icon-wrapper">🔍</div>
            <a href="/views/estudos/pesquisa.php">
                Mecanismo de Pesquisa
            </a>
            <p>Busque referências cruzadas localmente ou na enciclopédia externa.</p>
        </div>


        <div class="menu-card card-quiz">
            <div class="card-icon-wrapper">🧠</div>
            <a href="/quiz/quiz.php">
                Desafios e Quizzes
            </a>
            <p>Avalie a retenção do seu conhecimento em tempo real.</p>
        </div>


        <div class="menu-card card-config">
            <div class="card-icon-wrapper">⚙️</div>
            <a href="/views/conta/configuracoes.php">
                Configurações
            </a>
            <p>Gerencie sua segurança e ajuste as preferências da conta.</p>
        </div>


        <div class="menu-card card-sobre">
            <div class="card-icon-wrapper">🚀</div>
            <a href="/views/conta/sobre.php">
                Sobre o Zenstudy
            </a>
            <p>Entenda o manifesto por trás do nosso ecossistema sem IA.</p>
        </div>

    </div>
</div>


<?php 
include __DIR__ . '/includes/footer.php'; 
?>