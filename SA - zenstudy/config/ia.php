<?php

$apiKey = getenv('GROQ_API_KEY');

if (!$apiKey) {
    die("Chave da API não configurada.");
}