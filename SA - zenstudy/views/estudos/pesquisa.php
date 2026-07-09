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

unset(
    $_SESSION['ultimo_termo'],
    $_SESSION['res_local'],
    $_SESSION['res_wiki'],
    $_SESSION['msg_pesquisa']
);

?>

<div class="page-container">

    <div class="page-header">

        <h1>Pesquisa</h1>

        <p>
            Pesquise materiais na sua biblioteca ou consulte a Wikipedia.
        </p>

    </div>


    <?php if ($flash): ?>

        <div class="alert alert-<?php echo ($flash['tipo'] == 'erro') ? 'danger' : 'success'; ?>">

            <?php echo htmlspecialchars($flash['mensagem']); ?>

        </div>

    <?php endif; ?>


    <?php if ($mensagem): ?>

        <div class="alert alert-success">

            <?php echo htmlspecialchars($mensagem); ?>

        </div>

    <?php endif; ?>


    <div class="page-card">

        <form action="/controller/PesquisaController.php" method="POST" class="search-form">

            <input
                type="text"
                name="termo"
                placeholder="Digite sua pesquisa..."
                required
                value="<?php echo htmlspecialchars($termo_pesquisa); ?>"
            >

            <button type="submit">
                Pesquisar
            </button>

        </form>

    </div>



    <?php if (!empty($resultado_local)): ?>

        <div class="page-card">

            <h3>Biblioteca Local</h3>

            <table class="data-table">

                <thead>

                    <tr>
                        <th>Título</th>
                        <th>Descrição</th>
                        <th>Criação</th>
                        <th>Matéria</th>
                        <th>Status</th>
                    </tr>

                </thead>


                <tbody>

                    <?php foreach ($resultado_local as $item): ?>

                        <tr>

                            <td>
                                <?php echo htmlspecialchars($item['titulo']); ?>
                            </td>

                            <td>
                                <?php echo htmlspecialchars($item['descricao']); ?>
                            </td>

                            <td>
                                <?php echo htmlspecialchars($item['dt_criacao'] ?? '-'); ?>
                            </td>

                            <td>
                                <?php echo htmlspecialchars($item['materia'] ?? '-'); ?>
                            </td>

                            <td>

                                <span class="badge badge-purple">
                                    Salvo
                                </span>

                            </td>

                        </tr>

                    <?php endforeach; ?>

                </tbody>

            </table>

        </div>

    <?php endif; ?>




    <?php if (!empty($resultado_wikipedia)): ?>

        <div class="page-card">

            <h3>Resultados da Wikipedia</h3>


            <table class="data-table">

                <thead>

                    <tr>
                        <th>Título</th>
                        <th>Resumo</th>
                        <th>Origem</th>
                    </tr>

                </thead>


                <tbody>

                    <?php foreach ($resultado_wikipedia as $item): ?>

                        <tr>

                            <td>
                                <strong>
                                    <?php echo htmlspecialchars($item['titulo']); ?>
                                </strong>
                            </td>


                            <td>
                                <?php echo $item['descricao']; ?>
                            </td>


                            <td>

                                <span class="badge badge-orange">
                                    Wikipedia
                                </span>

                            </td>

                        </tr>

                    <?php endforeach; ?>

                </tbody>

            </table>


            <p style="margin-top:20px;color:var(--text-secondary);font-size:14px;">

                Conteúdo obtido da Wikipedia (Licença CC BY-SA 4.0).

            </p>


        </div>

    <?php endif; ?>


</div>


<?php

include __DIR__ . '/../includes/footer.php';

?>