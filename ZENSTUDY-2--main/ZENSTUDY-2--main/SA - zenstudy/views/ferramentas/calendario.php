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

<form action="/controller/AgendaController.php" method="post" class="form-agenda">

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

        eventClick: function(info){
            
            let evento = info.event;
            let opcao = confirm(
                "Evento: " + evento.title +
                "\n\nOK = Editar\nCancelar = Excluir"
            );
            
            if(opcao){
                
                window.location ="/views/ferramentas/editar_evento.php?id=" + evento.id;
            
            }else{
                
                if(confirm("Deseja realmente excluir este evento?")){
                    
                    window.location ="/views/ferramentas/excluir_evento.php?id=" + evento.id;
                }
            }
        }
    });

    calendar.render();
});
</script>

<?php 
include __DIR__ . '/../includes/footer.php'; 
?>