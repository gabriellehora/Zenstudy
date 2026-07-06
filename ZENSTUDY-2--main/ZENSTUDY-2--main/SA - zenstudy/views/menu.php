<?php 
// Inclui o header, que já carrega o config/conexao.php e inicia a sessão
include __DIR__ . '/includes/header.php'; 

// Proteção de rota: Se não estiver logado, redireciona para o login (igual ao Python!)
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    redirecionar('/views/login.php');
}
?>
<div class="dashboard-container"> <h2>Bem-vindo(a) ao seu Painel</h2>

    <div class="dashboard-grid">

        <div class="menu-card">
            <a href="/views/ferramentas/calendario.php">Agenda e Rotina</a>
            <p>Organize tarefas, eventos e estudos.</p>
        </div>

        <div class="menu-card">
            <a href="/views/estudos/biblioteca.php" class="biblioteca">Biblioteca</a>
            <p>Gerencie seus materiais de estudo.</p>
        </div>

        <div class="menu-card">
            <a href="/views/estudos/pesquisa.php" class="pesquisa">Pesquisa</a>
            <p>Encontre conteúdos rapidamente.</p>
        </div>

        <div class="menu-card">
            <a href="/quiz/quiz.php" class="quiz">Quiz</a>
            <p>Teste seus conhecimentos com quizzes.</p>
        </div>

        <div class="menu-card">
            <a href="/views/conta/configuracoes.php" class="config">Configurações</a>
            <p>Ajuste suas preferências.</p>
        </div>

        <div class="menu-card">
            <a href="/views/conta/sobre.php" class="sobre">Sobre</a>
            <p>Conheça o Zenstudy.</p>
        </div>

    </div>
</div>

<?php 
include __DIR__ . '/includes/footer.php'; 
?>