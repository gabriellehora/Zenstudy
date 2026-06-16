<?php 
// Suposição de estrutura para evitar erros caso a variável não venha do backend
$assunto_titulo = isset($assunto->titulo) ? $assunto->titulo : (isset($assunto['titulo']) ? $assunto['titulo'] : 'Assunto sem título');
$assunto_descricao = isset($assunto->descricao) ? $assunto->descricao : (isset($assunto['descricao']) ? $assunto['descricao'] : 'Conteúdo em breve');

// Inclui o topo da página
include 'base_header.php'; 
?>

<div style="max-width: 800px; margin: auto; margin-top: 30px;">

    <h1><?php echo htmlspecialchars($assunto_titulo); ?></h1>
    
    <p style="margin-top: 20px; font-size: 18px;">
        <?php echo htmlspecialchars($assunto_descricao); ?>
    </p>

    <a href="javascript:history.back()" class="botao-voltar">Voltar</a>

</div>

<?php 
// Inclui o rodapé da página
include 'base_footer.php'; 
?>