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
    <div style="text-align: center; margin-bottom: 15px; color: green; font-weight: bold;">
        <?php echo $flash['mensagem']; ?>
    </div>
<?php endif; ?>

<form action="/controller/AgendaController.php" method="post">
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
        // Aponta para a nossa API criada no Controller passando o parâmetro ?api=1
        events: '/controller/AgendaController.php?api=1',

        eventClick: function(info) {
            let titulo = info.event.title;
            let descricao = info.event.extendedProps.descricao || "Sem descrição";
            let horario = info.event.extendedProps.horario || "";

            alert("Evento: " + titulo + "\nHora: " + horario + "\n\nDescrição: " + descricao);
        }
    });

    calendar.render();
});
</script>

<?php 
include __DIR__ . '/../includes/footer.php'; 
?>