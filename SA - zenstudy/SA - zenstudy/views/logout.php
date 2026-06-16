<?php
require_once __DIR__ . '/../config/conexao.php';
session_clear(); // Limpa as sessões
session_destroy();

session_start(); // Reinicia para conseguir mandar o flash
flash('Você saiu do sistema.', 'info');
redirecionar('/zenstudy/views/login.php');
?>