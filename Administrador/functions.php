<?php
require_once __DIR__ . '/../../Configuração/config.php';

if (session_status() === PHP_SESSION_NONE) session_start();

function db(): PDO {
    foreach (['pdo', 'conn', 'conexao', 'con', 'db'] as $nome) {
        if (isset($GLOBALS[$nome]) && $GLOBALS[$nome] instanceof PDO) {
            return $GLOBALS[$nome];
        }
    }
    die('Conexão PDO não encontrada. Verifique Configuração/config.php.');
}

function e($v): string {
    return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8');
}

function brl($v): string {
    return 'R$ ' . number_format((float)$v, 2, ',', '.');
}

function redirect(string $url): void {
    header('Location: ' . $url);
    exit;
}

function flash(string $msg, string $tipo = 'ok'): void {
    $_SESSION['flash'] = ['msg' => $msg, 'tipo' => $tipo];
}

function pegar_flash(): ?array {
    $f = $_SESSION['flash'] ?? null;
    unset($_SESSION['flash']);
    return $f;
}
