<?php
require_once __DIR__ . '/../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['id'])) {
    try {
        $st = db()->prepare('DELETE FROM planos WHERE id = ?');
        $st->execute([(int)$_POST['id']]);
        flash('Plano excluído.');
    } catch (PDOException $ex) {
        flash('Não foi possível excluir: existem alunos vinculados a este plano.', 'erro');
    }
}
redirect('index.php');
