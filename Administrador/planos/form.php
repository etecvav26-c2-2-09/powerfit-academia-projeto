<?php
require_once __DIR__ . '/../includes/functions.php';

$plano = ['id' => '', 'nome' => 'Mensal', 'descricao' => '', 'preco' => '', 'ativo' => 1];
if (isset($_GET['id'])) {
    $st = db()->prepare('SELECT * FROM planos WHERE id = ?');
    $st->execute([(int)$_GET['id']]);
    $achado = $st->fetch(PDO::FETCH_ASSOC);
    if (!$achado) {
        flash('Plano não encontrado.', 'erro');
        redirect('index.php');
    }
    $plano = $achado;
}

$tituloPagina = ($plano['id'] ? 'Editar' : 'Novo') . ' plano - PowerFit Academia';
require_once __DIR__ . '/../includes/header.php';
?>
<h1><?= $plano['id'] ? 'Editar plano' : 'Novo plano' ?></h1>

<form method="post" action="salvar.php">
    <input type="hidden" name="id" value="<?= e($plano['id']) ?>">

    <p>
        <label>Pacote<br>
            <select name="nome" required>
                <?php foreach (['Mensal', 'Semestral', 'Anual'] as $n): ?>
                    <option <?= $plano['nome'] === $n ? 'selected' : '' ?>><?= $n ?></option>
                <?php endforeach; ?>
            </select>
        </label>
    </p>
    <p>
        <label>Descrição<br>
            <input type="text" name="descricao" maxlength="255" value="<?= e($plano['descricao']) ?>">
        </label>
    </p>
    <p>
        <label>Preço (R$)<br>
            <input type="number" name="preco" step="0.01" min="0" required value="<?= e($plano['preco']) ?>">
        </label>
    </p>
    <p>
        <label><input type="checkbox" name="ativo" value="1" <?= $plano['ativo'] ? 'checked' : '' ?>> Ativo</label>
    </p>

    <button type="submit" class="btn">Salvar</button>
    <a href="index.php">Cancelar</a>
</form>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
