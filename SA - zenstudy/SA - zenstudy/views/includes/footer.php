</main>

    <footer>
        <p>Desenvolvido por Zenstudy</p> 
    </footer>

<script>
    const toggleButton = document.getElementById('theme-toggle');
    const body = document.body;

    // 1. Verifica se o usuário já tem uma preferência salva ao carregar a página
    const currentTheme = localStorage.getItem('theme');
    if (currentTheme === 'dark') {
        body.classList.add('dark-mode');
        toggleButton.textContent = '☀️'; // Muda ícone para sol
    }

    // 2. Ação do clique no botão
    toggleButton.addEventListener('click', () => {
        body.classList.toggle('dark-mode');
        
        let theme = 'light';
        
        // Se a classe dark-mode foi adicionada, muda para tema escuro
        if (body.classList.contains('dark-mode')) {
            theme = 'dark';
            toggleButton.textContent = '☀️';
        } else {
            toggleButton.textContent = '🌙';
        }
        
        // 3. Salva a preferência no navegador para as outras páginas
        localStorage.setItem('theme', theme);

        // EXTRA: Avisa o PHP via formulário ou requisição se você quiser salvar no banco depois,
        // mas o localStorage já segura o visual perfeitamente entre as páginas!
    });
</script>
</body>
</html>