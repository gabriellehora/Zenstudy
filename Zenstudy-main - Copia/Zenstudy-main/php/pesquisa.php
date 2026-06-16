<?php 
// Inicia a sessão para capturar possíveis mensagens flash de aviso/erro
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Inicialização segura das variáveis para evitar erros de variáveis indefinidas
$termo_pesquisa = isset($termo_pesquisa) ? $termo_pesquisa : '';
$mensagem = isset($mensagem) ? $mensagem : null;
$resultado_local = isset($resultado_local) ? $resultado_local : [];
$resultado_wikipedia = isset($resultado_wikipedia) ? $resultado_wikipedia : [];

// Inclui o topo da página
include 'base_header.php'; 
?>

<section class="form-section full-width-content">
    <h2>Pesquisar material</h2>

    <form action="pesquisa.php" method="POST" class="form-card search-form">
        <input type="text" name="termo" placeholder="Digite sua pesquisa..." required value="<?php echo htmlspecialchars($termo_pesquisa); ?>">
        <button type="submit">Pesquisar</button>
    </form>

    <?php if (isset($_SESSION['flash_messages'])): ?>
        <div class="flash-messages">
            <?php 
            foreach ($_SESSION['flash_messages'] as $msg): 
                $categoria = htmlspecialchars($msg['categoria']);
                $texto_msg = htmlspecialchars($msg['texto']);
            ?>
                <div class="alert alert-<?php echo $categoria; ?>"><?php echo $texto_msg; ?></div>
            <?php endforeach; ?>
            <?php unset($_SESSION['flash_messages']); ?>
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
                            <td><?php echo htmlspecialchars($item['titulo'] ?? $item->titulo); ?></td>
                            <td><?php echo htmlspecialchars($item['descricao'] ?? $item->descricao); ?></td>
                            <td><?php echo htmlspecialchars($item['dt_criacao'] ?? $item->dt_criacao); ?></td>
                            <td><?php echo htmlspecialchars($item['materia'] ?? $item->materia); ?></td>
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
                            <td class="font-bold"><?php echo htmlspecialchars($item['titulo'] ?? $item->titulo); ?></td>
                            <td><?php echo htmlspecialchars($item['descricao'] ?? $item->descricao); ?></td>
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

.local-results { margin-top: 3rem; }
.wikipedia-results { margin-top: 4rem; }
.wiki-table td:last-child { width: 100px; }
</style>

<?php 
// Inclui o rodapé da página
include 'base_footer.php'; 
?>