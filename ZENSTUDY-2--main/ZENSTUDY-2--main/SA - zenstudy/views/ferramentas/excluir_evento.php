<form action="/controller/AgendaController.php" method="post">

    <input
        type="hidden"
        name="id"
        value="<?= $_GET['id'] ?>">

    <button
        type="submit"
        name="excluir">

        Excluir Evento

    </button>

</form>