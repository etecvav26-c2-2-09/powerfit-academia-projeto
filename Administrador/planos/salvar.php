<?php
require_once __DIR__ . '/../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') redirect('index.php');

$id        = (int)($_POST['id'] ?? 0);
$nome      = $_POST['nome'] ?? '';
$descricao = trim($_POST['descricao'] ?? '');
$preco     = (float)str_replace(',', '.', $_POST['preco'] ?? '0');
$ativo     = isset($_POST['ativo']) ? 1 : 0;

if (!in_array($nome, ['Mensal', 'Semestral', 'Anual'], true) || $preco < 0) {
    flash('Dados inválidos.', 'erro');
    redirect('index.php');
}

if ($id) {
    $st = db()->prepare('UPDATE planos SET nome=?, descricao=?, preco=?, ativo=? WHERE id=?');
    $st->execute([$nome, $descricao, $preco, $ativo, $id]);
    flash('Plano atualizado!');
} else {
    $st = db()->prepare('INSERT INTO planos (nome, descricao, preco, ativo) VALUES (?,?,?,?)');
    $st->execute([$nome, $descricao, $preco, $ativo]);
    flash('Plano cadastrado!');
}
redirect('index.php');
