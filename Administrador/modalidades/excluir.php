<?php
/**
 * ===========================================================
 * modalidades/excluir.php - PowerFit Academia
 * ===========================================================
 * Autor: Luan Alves Padovani
 *
 * Exclui uma modalidade do banco a partir do ID recebido pela
 * URL. Não tem tela própria: processa e volta para index.php.
 *
 * OBS: a confirmação ("Tem certeza?") já é feita em JavaScript
 * na listagem (index.php), antes do link ser seguido.
 * ===========================================================
 */

require_once __DIR__ . '/../../Configuração/config.php';

// -----------------------------------------------------------
// 1) Pega e valida o ID vindo da URL
// -----------------------------------------------------------
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id) {
    header('Location: index.php?msg=erro');
    exit;
}

// -----------------------------------------------------------
// 2) Tenta excluir a modalidade
//
//    Observação: se a modalidade estiver vinculada a algum
//    aluno (chave estrangeira), o banco pode recusar a exclusão
//    para não deixar dados "órfãos". Nesse caso, capturamos o
//    erro e avisamos o usuário de forma clara, em vez de deixar
//    o sistema quebrar.
// -----------------------------------------------------------
try {
    $stmt = $pdo->prepare('DELETE FROM modalidades WHERE id = :id');
    $stmt->execute([':id' => $id]);

    header('Location: index.php?msg=excluido');
    exit;

} catch (PDOException $e) {
    // Provável erro de chave estrangeira (modalidade em uso por
    // algum aluno) ou outro problema no banco.
    header('Location: index.php?msg=erro');
    exit;
}
