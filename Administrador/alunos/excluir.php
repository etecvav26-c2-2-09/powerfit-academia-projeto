<?php
// excluir aluno - CRUD Alunos (DELETE)
// GET  -> mostra uma tela de confirmação (pra não excluir sem querer)
// POST -> confirma e apaga de vez

require_once __DIR__ . '/../../Configuração/config.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id === 0) {
    die('Aluno não informado.');
}

$erro = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $stmt = $pdo->prepare("DELETE FROM alunos WHERE id = ?");
        $stmt->execute([$id]);

        header('Location: listar.php');
        exit;

    } catch (PDOException $e) {
        // aluno não tem nenhuma tabela filha apontando pra ele, então dificilmente
        // vai dar erro aqui, mas deixo o try/catch por garantia
        $erro = "Não foi possível excluir o aluno. (" . $e->getMessage() . ")";
    }
}

$stmt = $pdo->prepare("SELECT * FROM alunos WHERE id = ?");
$stmt->execute([$id]);
$aluno = $stmt->fetch();

if (!$aluno) {
    die('Aluno não encontrado.');
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>PowerFit Academia - Excluir Aluno</title>
    <style>
        body { background:#121212; color:#F5F5F5; font-family: Arial, sans-serif; padding: 20px; }
        h1 { color:#FF4500; }
        .erro { background:#8B0000; padding:10px; border-radius:4px; margin-bottom:10px; }
        button { padding:10px 16px; background:#8B0000; color:#F5F5F5; font-weight:bold; border:none; border-radius:4px; cursor:pointer; margin-right:8px; }
        a.cancelar { color:#F5F5F5; background:#333; padding:10px 16px; border-radius:4px; text-decoration:none; }
    </style>
</head>
<body>
    <h1>Excluir Aluno</h1>

    <?php if ($erro): ?>
        <div class="erro"><?= htmlspecialchars($erro) ?></div>
    <?php endif; ?>

    <p>Tem certeza que deseja excluir o aluno <strong><?= htmlspecialchars($aluno['nome']) ?></strong>? Essa ação não pode ser desfeita.</p>

    <form method="post" action="excluir.php?id=<?= $id ?>">
        <button type="submit">Sim, excluir</button>
        <a class="cancelar" href="listar.php">Cancelar</a>
    </form>
</body>
</html>
