<?php
// editar aluno - CRUD Alunos (UPDATE)
// GET  -> busca o aluno pelo id da URL e mostra o form preenchido
// POST -> recebe os dados alterados e atualiza no banco

require_once __DIR__ . '/../../Configuração/config.php';

// (int) garante que o id seja número, mesmo que alguém mexa na URL
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id === 0) {
    die('Aluno não informado.');
}

$planos = $pdo->query("SELECT id, nome FROM planos ORDER BY nome")->fetchAll();
$modalidades = $pdo->query("SELECT id, nome FROM modalidades ORDER BY nome")->fetchAll();

$erro = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nome             = trim($_POST['nome']);
    $cpf              = trim($_POST['cpf']);
    $email            = trim($_POST['email']);
    $telefone         = trim($_POST['telefone']);
    $data_nascimento  = $_POST['data_nascimento'];
    $data_matricula   = $_POST['data_matricula'];
    $plano_id         = $_POST['plano_id'];
    $modalidade_id    = $_POST['modalidade_id'];

    try {
        $sql = "UPDATE alunos
                SET nome = ?, cpf = ?, email = ?, telefone = ?,
                    data_nascimento = ?, data_matricula = ?,
                    plano_id = ?, modalidade_id = ?
                WHERE id = ?";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            $nome, $cpf, $email, $telefone,
            $data_nascimento, $data_matricula,
            $plano_id, $modalidade_id,
            $id
        ]);

        header('Location: listar.php');
        exit;

    } catch (PDOException $e) {
        $erro = "Não foi possível atualizar o aluno. Verifique CPF/email duplicados. (" . $e->getMessage() . ")";
    }
}

// busca os dados atuais pra preencher o formulário
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
    <title>PowerFit Academia - Editar Aluno</title>
    <style>
        body { background:#121212; color:#F5F5F5; font-family: Arial, sans-serif; padding: 20px; }
        h1 { color:#FF4500; }
        form { max-width: 400px; display:flex; flex-direction:column; gap:10px; }
        label { font-size: 14px; }
        input, select { padding:8px; border-radius:4px; border:1px solid #444; background:#1e1e1e; color:#F5F5F5; }
        button { padding:10px; background:#FF4500; color:#121212; font-weight:bold; border:none; border-radius:4px; cursor:pointer; }
        .erro { background:#8B0000; padding:10px; border-radius:4px; margin-bottom:10px; }
        a { color:#FF4500; }
    </style>
</head>
<body>
    <h1>Editar Aluno</h1>

    <?php if ($erro): ?>
        <div class="erro"><?= htmlspecialchars($erro) ?></div>
    <?php endif; ?>

    <form method="post" action="editar.php?id=<?= $id ?>">
        <label>Nome</label>
        <input type="text" name="nome" value="<?= htmlspecialchars($aluno['nome']) ?>" required>

        <label>CPF</label>
        <input type="text" name="cpf" value="<?= htmlspecialchars($aluno['cpf']) ?>" required>

        <label>Email</label>
        <input type="email" name="email" value="<?= htmlspecialchars($aluno['email']) ?>" required>

        <label>Telefone</label>
        <input type="text" name="telefone" value="<?= htmlspecialchars($aluno['telefone']) ?>">

        <label>Data de nascimento</label>
        <input type="date" name="data_nascimento" value="<?= htmlspecialchars($aluno['data_nascimento']) ?>" required>

        <label>Data de matrícula</label>
        <input type="date" name="data_matricula" value="<?= htmlspecialchars($aluno['data_matricula']) ?>" required>

        <label>Plano</label>
        <select name="plano_id" required>
            <?php foreach ($planos as $plano): ?>
                <option value="<?= $plano['id'] ?>" <?= $plano['id'] == $aluno['plano_id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($plano['nome']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label>Modalidade</label>
        <select name="modalidade_id" required>
            <?php foreach ($modalidades as $modalidade): ?>
                <option value="<?= $modalidade['id'] ?>" <?= $modalidade['id'] == $aluno['modalidade_id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($modalidade['nome']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <button type="submit">Salvar alterações</button>
    </form>

    <p><a href="listar.php">&larr; Voltar para a lista</a></p>
</body>
</html>
