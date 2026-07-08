document.addEventListener("DOMContentLoaded", function () {

    const botao = document.getElementById("theme-toggle");

    if (!botao) return;

    // Carrega o tema salvo
    const temaSalvo = localStorage.getItem("theme");

    if (temaSalvo === "dark") {
        document.body.classList.add("dark");
        botao.textContent = "☀️";
    } else {
        botao.textContent = "🌙";
    }

    // Alterna o tema
    botao.addEventListener("click", function () {

        document.body.classList.toggle("dark");

        if (document.body.classList.contains("dark")) {
            localStorage.setItem("theme", "dark");
            botao.textContent = "☀️";
        } else {
            localStorage.setItem("theme", "light");
            botao.textContent = "🌙";
        }

    });

});