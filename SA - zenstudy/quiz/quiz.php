<?php
include __DIR__ . '/../views/includes/header.php';
?>

<div class="page-container">

    <div class="page-header">
        <h1>Quiz ZenStudy</h1>

        <p>
            Gere um quiz personalizado para testar seus conhecimentos.
        </p>
    </div>


    <div class="page-card">

        <form action="gerar_quiz.php" method="POST" class="form-agenda">


            <label>Matéria</label>

            <select name="materia">

                <option>Matemática</option>
                <option>Português</option>
                <option>Literatura</option>
                <option>Inglês</option>
                <option>Biologia</option>
                <option>Espanhol</option>
                <option>Física</option>
                <option>Química</option>
                <option>História</option>
                <option>Geografia</option>
                <option>Filosofia</option>
                <option>Sociologia</option>

            </select>


            <label>Nível</label>

            <select name="nivel">

                <option>6º Ano</option>
                <option>7º Ano</option>
                <option>8º Ano</option>
                <option>9º Ano</option>
                <option>1º Ano Ensino Médio</option>
                <option>2º Ano Ensino Médio</option>
                <option>3º Ano Ensino Médio</option>
                <option>ENEM</option>

            </select>


            <label>Assunto</label>

            <input
                type="text"
                name="assunto"
                placeholder="Ex: Revolução Francesa"
                required
            >


            <button
                type="submit"
                class="btn-premium-action">

                Gerar Quiz

            </button>


        </form>

    </div>

</div>


<?php
include __DIR__ . '/../views/includes/footer.php';
?>