<?php 
// Inclui o topo da página
include 'base_header.php'; 
?>

    <h2>Bem-vindo(a) ao seu Painel</h2>

    <div class="dashboard-grid">

        <div class="menu-card">
            <a href="agenda.php" class="agenda">Agenda e Rotina</a>
            <p>Organize tarefas, eventos e estudos.</p>
        </div>

        <div class="menu-card">
            <a href="biblioteca.php" class="biblioteca">Biblioteca</a>
            <p>Gerencie seus materiais de estudo.</p>
        </div>

        <div class="menu-card">
            <a href="pesquisa.php" class="pesquisa">Pesquisa</a>
            <p>Encontre conteúdos rapidamente.</p>
        </div>


        <div class="menu-card">
            <a href="quiz.php" class="quiz">📚 Quiz</a>
            <p>Gere e responda quizzes personalizados.</p>
        </div>
        

        <div class="menu-card">
            <a href="configuracoes.php" class="config">Configurações</a>
            <p>Ajuste suas preferências.</p>
        </div>

        <div class="menu-card">
            <a href="sobre.php" class="sobre">Sobre</a>
            <p>Conheça o Zenstudy.</p>
        </div>

    </div>

<?php 
// Inclui o rodapé da página
include 'base_footer.php'; 
?>