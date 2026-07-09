<?php
include __DIR__ . '/../includes/header.php';

// Tranca de segurança
if (!isset($_SESSION['logado'])) {
    redirecionar('/views/login.php');
}

$flash = flash();
?>

<h2>Minha Agenda</h2>

<?php if ($flash): ?>
    <div class="mensagem-agenda">
        <?php echo $flash['mensagem']; ?>
    </div>
<?php endif; ?>

<form action="/controller/AgendaController.php" method="POST" class="form-agenda">

    <h3>Novo Evento</h3>

    <input
        type="text"
        name="titulo"
        placeholder="Título do evento"
        required>

    <div class="linha-agenda">

        <input
            type="date"
            name="dt_data"
            required>

        <input
            type="time"
            name="horario"
            required>

    </div>

    <textarea
        name="descricao"
        placeholder="Descrição do evento"></textarea>

    <div class="cor-evento">

        <label for="cor">Cor do evento</label>

        <input
            type="color"
            id="cor"
            name="cor"
            value="#3788d8">

    </div>

    <button
        type="submit"
        class="btn-agenda">

        Salvar Evento

    </button>

</form>

<hr>

<div id="calendar"></div>

<!-- Modal -->

<div id="modalEvento" class="modal">

    <div class="modal-content">

        <span class="fechar-modal" onclick="fecharModal()">&times;</span>

        <h2>Editar Evento</h2>

        <form action="/controller/AgendaController.php" method="POST">

            <input
                type="hidden"
                id="evento_id"
                name="id">

            <label>Título</label>

            <input
                type="text"
                id="titulo"
                name="titulo"
                required>

            <label>Data</label>

            <input
                type="date"
                id="dt_data"
                name="dt_data"
                required>

            <label>Horário</label>

            <input
                type="time"
                id="horario"
                name="horario"
                required>

            <label>Descrição</label>

            <textarea
                id="descricao"
                name="descricao"></textarea>

            <label>Cor</label>

            <input
                type="color"
                id="cor_modal"
                name="cor">

            <div class="botoes-modal">

                <button
                    type="submit"
                    name="editar"
                    class="btn-salvar">

                    Salvar

                </button>

                <button
                    type="button"
                    class="btn-excluir"
                    onclick="excluirEvento()">

                    Excluir

                </button>

            </div>

        </form>

    </div>

</div>

<link
href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css"
rel="stylesheet">

<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>

<script>

function fecharModal(){

    document.getElementById("modalEvento").style.display = "none";

}

function excluirEvento(){

    if(confirm("Deseja realmente excluir este evento?")){

        let form = document.createElement("form");

        form.method = "POST";

        form.action = "/controller/AgendaController.php";

        form.innerHTML = `
            <input type="hidden" name="id" value="${document.getElementById('evento_id').value}">
            <input type="hidden" name="excluir" value="1">
        `;

        document.body.appendChild(form);

        form.submit();

    }

}

document.addEventListener('DOMContentLoaded', function () {

    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {

        initialView: 'dayGridMonth',

        locale: 'pt-br',

        events: '/controller/AgendaController.php?api=1',

        eventClick: function(info){

            let evento = info.event;

            document.getElementById("evento_id").value = evento.id;

            document.getElementById("titulo").value = evento.title;

            document.getElementById("dt_data").value = evento.startStr;

            document.getElementById("horario").value = evento.extendedProps.horario;

            document.getElementById("descricao").value = evento.extendedProps.descricao;

            document.getElementById("cor_modal").value = evento.backgroundColor;

            document.getElementById("modalEvento").style.display = "flex";

        }

    });

    calendar.render();

});
</script>

<?php
include __DIR__ . '/../includes/footer.php';
?>