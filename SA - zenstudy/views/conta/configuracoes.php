<?php

include __DIR__ . '/../includes/header.php';

if (!isset($_SESSION['logado'])) {
    redirecionar('/views/login.php');
}

?>

<div class="page-container">

    <div class="page-header">

        <h1>Configurações</h1>

        <p>
            Gerencie sua conta, segurança e informações do aplicativo.
        </p>

    </div>


    <div class="page-card">

        <div class="config-grid">

            <a href="/views/conta/alterar_senha.php" class="config-card">

                <div class="config-icon icon-security"></div>

                <div class="config-content">

                    <h3>Alterar Senha</h3>

                    <p>
                        Atualize sua senha para manter sua conta protegida.
                    </p>

                </div>

                <span class="config-arrow">→</span>

            </a>


            <a href="/views/conta/editar_perfil.php" class="config-card">

                <div class="config-icon icon-profile"></div>

                <div class="config-content">

                    <h3>Editar Perfil</h3>

                    <p>
                        Modifique seus dados pessoais e preferências.
                    </p>

                </div>

                <span class="config-arrow">→</span>

            </a>


            <a href="/views/conta/sobre.php" class="config-card">

                <div class="config-icon icon-info"></div>

                <div class="config-content">

                    <h3>Sobre o Aplicativo</h3>

                    <p>
                        Veja informações sobre o ZenStudy.
                    </p>

                </div>

                <span class="config-arrow">→</span>

            </a>

        </div>

    </div>

</div>


<?php include __DIR__ . '/../includes/footer.php'; ?>