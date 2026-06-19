document.addEventListener("DOMContentLoaded", function () {

    const botao = document.getElementById("theme-toggle");

    if (!botao) return;

    // Carrega o tema salvo
    const temaSalvo = localStorage.getItem("theme");

    if (temaSalvo === "dark") {
        document.body.classList.add("dark-mode");
        botao.textContent = "☀️";
    } else {
        botao.textContent = "🌙";
    }

    // Alterna o tema
    botao.addEventListener("click", function () {

        document.body.classList.toggle("dark-mode");

        if (document.body.classList.contains("dark-mode")) {
            localStorage.setItem("theme", "dark");
            botao.textContent = "☀️";
        } else {
            localStorage.setItem("theme", "light");
            botao.textContent = "🌙";
        }

    });

});