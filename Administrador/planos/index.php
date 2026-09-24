<?php
require_once __DIR__ . '/../includes/functions.php';
$tituloPagina = 'Planos - PowerFit Academia';
require_once __DIR__ . '/../includes/header.php';

$planos = db()->query("SELECT * FROM planos ORDER BY id")->fetchAll(PDO::FETCH_ASSOC);
$flash  = pegar_flash();
?>
<h1>Planos</h1>

<?php if ($flash): ?>
    <div class="alerta <?= e($flash['tipo']) ?>"><?= e($flash['msg']) ?></div>
<?php endif; ?>

<p><a class="btn" href="form.php">+ Novo plano</a></p>

<table class="tabela">
    <thead>
        <tr><th>ID</th><th>Pacote</th><th>Descrição</th><th>Preço</th><th>Status</th><th>Ações</th></tr>
    </thead>
    <tbody>
    <?php foreach ($planos as $p): ?>
        <tr>
            <td><?= $p['id'] ?></td>
            <td><?= e($p['nome']) ?></td>
            <td><?= e($p['descricao']) ?></td>
            <td><?= brl($p['preco']) ?></td>
            <td><?= $p['ativo'] ? 'Ativo' : 'Inativo' ?></td>
            <td>
                <a href="form.php?id=<?= $p['id'] ?>">Editar</a>
                <form method="post" action="excluir.php" style="display:inline"
                      onsubmit="return confirm('Excluir este plano?')">
                    <input type="hidden" name="id" value="<?= $p['id'] ?>">
                    <button type="submit">Excluir</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
    <?php if (!$planos): ?>
        <tr><td colspan="6">Nenhum plano cadastrado.</td></tr>
    <?php endif; ?>
    </tbody>
</table>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
