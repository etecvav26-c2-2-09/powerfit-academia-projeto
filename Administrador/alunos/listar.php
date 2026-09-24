<?php
// lista de alunos - CRUD Alunos (READ)
// aqui a gente já traz o nome do plano e da modalidade junto,
// em vez de mostrar só o ID, usando JOIN

require_once __DIR__ . '/../../Configuração/config.php';

$sql = "SELECT
            alunos.id,
            alunos.nome,
            alunos.cpf,
            alunos.email,
            alunos.telefone,
            alunos.data_matricula,
            planos.nome AS plano_nome,
            modalidades.nome AS modalidade_nome
        FROM alunos
        INNER JOIN planos ON alunos.plano_id = planos.id
        INNER JOIN modalidades ON alunos.modalidade_id = modalidades.id
        ORDER BY alunos.nome";

$stmt = $pdo->query($sql);
$alunos = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>PowerFit Academia - Alunos</title>
    <style>
        body { background:#121212; color:#F5F5F5; font-family: Arial, sans-serif; padding: 20px; }
        h1 { color:#FF4500; }
        table { width:100%; border-collapse: collapse; margin-top: 15px; }
        th, td { padding: 8px 10px; border-bottom: 1px solid #333; text-align: left; }
        th { color:#FF4500; }
        a.btn { display:inline-block; padding:6px 12px; border-radius:4px; text-decoration:none; margin-right:5px; }
        a.novo { background:#FF4500; color:#121212; font-weight:bold; }
        a.editar { background:#333; color:#F5F5F5; }
        a.excluir { background:#8B0000; color:#F5F5F5; }
    </style>
</head>
<body>
    <h1>Alunos - PowerFit Academia</h1>
    <a class="btn novo" href="criar.php">+ Novo aluno</a>

    <table>
        <tr>
            <th>Nome</th><th>CPF</th><th>Email</th><th>Telefone</th>
            <th>Matrícula</th><th>Plano</th><th>Modalidade</th><th>Ações</th>
        </tr>

        <?php foreach ($alunos as $aluno): ?>
        <tr>
            <!-- htmlspecialchars pra não deixar o HTML quebrar se tiver algum caractere estranho no banco -->
            <td><?= htmlspecialchars($aluno['nome']) ?></td>
            <td><?= htmlspecialchars($aluno['cpf']) ?></td>
            <td><?= htmlspecialchars($aluno['email']) ?></td>
            <td><?= htmlspecialchars($aluno['telefone']) ?></td>
            <td><?= htmlspecialchars($aluno['data_matricula']) ?></td>
            <td><?= htmlspecialchars($aluno['plano_nome']) ?></td>
            <td><?= htmlspecialchars($aluno['modalidade_nome']) ?></td>
            <td>
                <a class="btn editar" href="editar.php?id=<?= $aluno['id'] ?>">Editar</a>
                <a class="btn excluir" href="excluir.php?id=<?= $aluno['id'] ?>"
                   onclick="return confirm('Tem certeza que deseja excluir este aluno?');">Excluir</a>
            </td>
        </tr>
        <?php endforeach; ?>

        <?php if (count($alunos) === 0): ?>
        <tr><td colspan="8">Nenhum aluno cadastrado ainda.</td></tr>
        <?php endif; ?>
    </table>
</body>
</html>
