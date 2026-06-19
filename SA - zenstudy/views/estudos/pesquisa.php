<?php 
include __DIR__ . '/../includes/header.php'; 
require_once __DIR__ . '/../../controller/PesquisaController.php';

if (!isset($_SESSION['logado'])) {
    redirecionar('/views/login.php');
}

$flash = flash();
$termo_pesquisa = $_SESSION['ultimo_termo'] ?? '';
$resultado_local = $_SESSION['res_local'] ?? null;
$resultado_wikipedia = $_SESSION['res_wiki'] ?? null;
$mensagem = $_SESSION['msg_pesquisa'] ?? null;

// Limpa os resultados da sessão para não ficarem travados na próxima vez que entrar na página
unset($_SESSION['ultimo_termo'], $_SESSION['res_local'], $_SESSION['res_wiki'], $_SESSION['msg_pesquisa']);
?>

<section class="form-section full-width-content">
<h2>Pesquisar material</h2>

<form action="/controller/PesquisaController.php" method="POST" class="form-card search-form">
<input type="text" name="termo" placeholder="Digite sua pesquisa..." required value="<?php echo htmlspecialchars($termo_pesquisa); ?>">
<button type="submit">Pesquisar</button>
</form>

<?php if ($flash): ?>
<div class="flash-messages">
<div class="alert alert-<?php echo $flash['tipo'] == 'erro' ? 'erro' : 'sucesso'; ?>"><?php echo $flash['mensagem']; ?></div>
</div>
<?php endif; ?>

<?php if ($mensagem): ?>
<p class="message-status"><?php echo htmlspecialchars($mensagem); ?></p>
<?php endif; ?>

<?php if (!empty($resultado_local)): ?>
<div class="results-container local-results">
<h3 class="mt-8">Resultados da Sua Biblioteca Local</h3>
<table class="data-table">
<thead>
<tr>
<th>Título</th>
<th>Descrição</th>
<th>Data Criação</th>
<th>Matéria</th>
<th>Status</th>
</tr>
</thead>
<tbody>
<?php foreach ($resultado_local as $item): ?>
<tr>
<td><?php echo htmlspecialchars($item['titulo']); ?></td>
<td><?php echo htmlspecialchars($item['descricao']); ?></td>
<td><?php echo htmlspecialchars($item['dt_criacao'] ?? '-'); ?></td>
<td><?php echo htmlspecialchars($item['materia'] ?? '-'); ?></td>
<td>
<span class="status-saved">Salvo</span>
</td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</div>
<?php endif; ?>

<?php if (!empty($resultado_wikipedia)): ?>
<div class="results-container wikipedia-results">
<h3 class="mt-8">Resultados da Wikipedia (Fonte Externa)</h3>
<table class="data-table wiki-table">
<thead>
<tr>
<th>Título do Artigo</th>
<th>Trecho / Snippet</th>
<th>Origem</th>
</tr>
</thead>
<tbody>
<?php foreach ($resultado_wikipedia as $item): ?>
<tr>
<td class="font-bold"><?php echo htmlspecialchars($item['titulo']); ?></td>
<td><?php echo $item['descricao']; // Mantido sem scaped pois traz marcações em HTML da wiki ?></td>
<td>Wikipedia</td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
<p class="mt-4 text-sm text-gray-600">
<i class="fas fa-info-circle"></i> O conteúdo da Wikipedia é licensed sob CC BY-SA 4.0.
</p>
</div>
<?php endif; ?>

</section>

<style>
.mt-8 { margin-top: 2rem; }
.mt-12 { margin-top: 3rem; }
.message-status { margin-bottom: 1rem; font-weight: bold; }
.flash-messages { margin-bottom: 1rem; padding: 10px; border-radius: 5px; }
.alert-sucesso { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
.alert-erro { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6fb; }
.status-saved { background-color: #d4edda; color: #155724; padding: 4px 8px; border-radius: 4px; font-size: 0.9rem; }

.form-section.full-width-content {
width: 100%;
max-width: none;
padding: 20px;
box-sizing: border-box;
}

.data-table {
width: 100%;
border-collapse: separate;
border-spacing: 0 10px;
}

.data-table th, .data-table td {
padding: 12px 15px;
text-align: left;
border-bottom: 1px solid #eee;
background-color: #fff;
}

.data-table th {
background-color: #f0f0f0;
font-weight: 600;
border-bottom: 2px solid #ccc;
}

.data-table tbody tr:hover {
background-color: #f5f5f5;
}

.results-container {
margin-top: 4rem;
padding: 0;
border: none;
border-radius: 0;
background-color: transparent;
}

.search-form {
display: flex;
gap: 10px;
padding: 20px;
background-color: #fff;
border-radius: 8px;
box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
margin-bottom: 2rem;
}

.search-form input[type="text"] {
flex-grow: 1;
padding: 10px;
border: 1px solid #ccc;
border-radius: 4px;
}

.local-results {
margin-top: 3rem;
}

.wikipedia-results {
margin-top: 4rem;
}

.wiki-table td:last-child {
width: 100px;
}
</style>

<?php include __DIR__ . '/../includes/footer.php'; ?>