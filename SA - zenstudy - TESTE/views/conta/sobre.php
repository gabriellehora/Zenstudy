<?php

include __DIR__ . '/../includes/header.php';

if (!isset($_SESSION['logado'])) {
    redirecionar('/views/login.php');
}

?>


<div class="sobre-page">


    <div class="sobre-top">

        <h1>Sobre o ZenStudy</h1>

        <p>
            Uma plataforma criada para transformar organização,
            disciplina e conhecimento em resultados reais.
        </p>

    </div>



    <div class="sobre-content">


        <div class="sobre-texto">

            <h2>O propósito do ZenStudy</h2>


            <p>
                O ZenStudy nasceu com uma ideia simples:
                tornar o estudo mais organizado, eficiente e acessível.
            </p>


            <p>
                Nossa missão é ajudar estudantes a criarem uma rotina
                de aprendizado mais inteligente, reunindo ferramentas
                de organização, biblioteca de conteúdos, pesquisas e
                desafios para melhorar o desempenho acadêmico.
            </p>


            <p>
                Mais do que entregar respostas, o ZenStudy busca incentivar
                autonomia, concentração e evolução constante.
            </p>


        </div>



        <div class="sobre-box">

            <h3>Nossa visão</h3>

            <p>
                Criar um ambiente onde qualquer estudante possa estudar
                melhor, acompanhar sua evolução e desenvolver todo seu potencial.
            </p>

        </div>


    </div>



    <h2 class="sobre-subtitulo">
        Recursos da plataforma
    </h2>



    <div class="sobre-cards">


        <div class="sobre-card">

            <h3>Organização</h3>

            <p>
                Planeje seus estudos e mantenha suas tarefas organizadas.
            </p>

        </div>



        <div class="sobre-card">

            <h3>Biblioteca</h3>

            <p>
                Acesse materiais separados por matérias e níveis de ensino.
            </p>

        </div>



        <div class="sobre-card">

            <h3>Aprendizado</h3>

            <p>
                Desenvolva conhecimento através de prática e revisão.
            </p>

        </div>


    </div>



    <div class="sobre-final">

        <h2>
            Estudar melhor começa com organização.
        </h2>

        <p>
            O ZenStudy acompanha você nessa jornada.
        </p>

    </div>


</div>



<?php include __DIR__ . '/../includes/footer.php'; ?>