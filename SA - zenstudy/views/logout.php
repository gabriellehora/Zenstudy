<?php
require_once __DIR__ . '/../config/conexao.php';

session_unset();
session_destroy();
session_start();

flash('Você saiu do sistema.', 'info');
redirecionar('/views/login.php');
?>