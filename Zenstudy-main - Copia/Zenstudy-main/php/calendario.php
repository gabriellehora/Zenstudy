<?php 
// Inclui o topo da página
include 'base_header.php'; 
?>

<h2>Minha Agenda</h2>

<form action="adicionar_eventos.php" method="post">
    <input type="text" name="titulo" placeholder="Título" required>

    <input type="date" name="dt_data" required>

    <input type="time" name="horario" required>

    <textarea name="descricao" placeholder="Descrição"></textarea>

    <button type="submit">Salvar</button>
</form>

<hr>

<div id="calendar"></div>

<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'pt-br',
        // Alterado de '/eventos' para apontar para o arquivo PHP que retorna o JSON dos eventos
        events: 'eventos_json.php', 

        eventClick: function(info) {
            let titulo = info.event.title;
            let descricao = info.event.extendedProps.descricao || "Sem descrição";

            alert("Evento: " + titulo + "\n\nDescrição: " + descricao);
        }
    });

    calendar.render();
});
</script>

<?php 
// Inclui o rodapé da página
include 'base_footer.php'; 
?>