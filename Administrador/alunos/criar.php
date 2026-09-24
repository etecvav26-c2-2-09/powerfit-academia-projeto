<?php
// cadastro de aluno - CRUD Alunos (CREATE)
// GET  -> mostra o formulário vazio
// POST -> recebe os dados e insere no banco

require_once __DIR__ . '/../../Configuração/config.php';

// busca planos e modalidades pra montar os <select> do formulário
$planos = $pdo->query("SELECT id, nome FROM planos ORDER BY nome")->fetchAll();
$modalidades = $pdo->query("SELECT id, nome FROM modalidades ORDER BY nome")->fetchAll();

$erro = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nome             = trim($_POST['nome']);
    $cpf              = trim($_POST['cpf']);
    $email            = trim($_POST['email']);
    $telefone         = trim($_POST['telefone']);
    $data_nascimento  = $_POST['data_nascimento'];
    $plano_id         = $_POST['plano_id'];
    $modalidade_id    = $_POST['modalidade_id'];

    try {
        // os "?" aqui são o que protege contra SQL injection (prepared statement) -
        // o PDO nunca deixa o valor virar parte do comando SQL
        $sql = "INSERT INTO alunos (nome, cpf, email, telefone, data_nascimento, plano_id, modalidade_id)
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        // data_matricula não entra aqui - a tabela já preenche sozinha com a data de hoje (DEFAULT)

        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nome, $cpf, $email, $telefone, $data_nascimento, $plano_id, $modalidade_id]);

        header('Location: listar.php');
        exit;

    } catch (PDOException $e) {
        // geralmente cai aqui quando o CPF ou email já existe (por causa do UNIQUE)
        $erro = "Não foi possível cadastrar o aluno. Verifique se o CPF ou email já existe. (" . $e->getMessage() . ")";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>PowerFit Academia - Novo Aluno</title>
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
    <h1>Novo Aluno</h1>

    <?php if ($erro): ?>
        <div class="erro"><?= htmlspecialchars($erro) ?></div>
    <?php endif; ?>

    <form method="post" action="criar.php">
        <label>Nome</label>
        <input type="text" name="nome" required>

        <label>CPF</label>
        <input type="text" name="cpf" placeholder="000.000.000-00" required>

        <label>Email</label>
        <input type="email" name="email" required>

        <label>Telefone</label>
        <input type="text" name="telefone" placeholder="(11) 90000-0000">

        <label>Data de nascimento</label>
        <input type="date" name="data_nascimento" required>

        <label>Plano</label>
        <select name="plano_id" required>
            <option value="">Selecione...</option>
            <?php foreach ($planos as $plano): ?>
                <option value="<?= $plano['id'] ?>"><?= htmlspecialchars($plano['nome']) ?></option>
            <?php endforeach; ?>
        </select>

        <label>Modalidade</label>
        <select name="modalidade_id" required>
            <option value="">Selecione...</option>
            <?php foreach ($modalidades as $modalidade): ?>
                <option value="<?= $modalidade['id'] ?>"><?= htmlspecialchars($modalidade['nome']) ?></option>
            <?php endforeach; ?>
        </select>

        <button type="submit">Cadastrar aluno</button>
    </form>

    <p><a href="listar.php">&larr; Voltar para a lista</a></p>
</body>
</html>
