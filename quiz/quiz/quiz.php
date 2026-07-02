<?php
include __DIR__ . '/../views/includes/header.php';
?>

<h1>📚 Quiz ZenStudy</h1>

<form action="gerar_quiz.php" method="POST">

    <label>Matéria:</label><br>

    <select name="materia">
        <option>Matemática</option>
        <option>Português</option>
        <option>Literatura</option>
        <option>Inglês</option>
        <option>Biologia</option>
        <option>Espanhol</option>
        <option>Biologia</option>
        <option>Física</option>
        <option>Química</option>
        <option>História</option>
        <option>Geografia</option>
        <option>Filosofia</option>
        <option>Sociologia</option>

    </select>

    <br><br>

    <label>Nível:</label><br>

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

    <br><br>

    <label>Assunto:</label><br>

    <input
        type="text"
        name="assunto"
        placeholder="Ex: Revolução Francesa"
        required
    >

    <br><br>

    <button type="submit">
        Gerar Quiz
    </button>

</form>

<?php
include __DIR__ . '/../views/includes/footer.php';
?>