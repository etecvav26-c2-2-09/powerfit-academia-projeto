<?php
/**
 * ===========================================================
 * modalidades/index.php - PowerFit Academia
 * ===========================================================
 * Autor: Luan Alves Padovani
 *
 * Lista todas as modalidades cadastradas (Musculação, Funcional,
 * Ritmos, Lutas, etc.), com links para editar e excluir.
 * ===========================================================
 */

$tituloPagina = 'Modalidades - Painel Admin';
require_once __DIR__ . '/../includes/header.php';

// -----------------------------------------------------------
// 1) Busca todas as modalidades no banco, já ordenadas por nome
// -----------------------------------------------------------
try {
    $stmt = $pdo->query('SELECT id, nome, descricao FROM modalidades ORDER BY nome ASC');
    $modalidades = $stmt->fetchAll();
} catch (PDOException $e) {
    // Em produção, o ideal é registrar o erro em log e mostrar
    // uma mensagem genérica ao usuário. Para fins de estudo/
    // desenvolvimento, mostramos o erro real para facilitar o debug.
    die('Erro ao buscar modalidades: ' . $e->getMessage());
}
?>

<div class="pagina-topo">
    <h1>Modalidades</h1>
    <a href="cadastrar.php" class="btn btn-primario">+ Nova Modalidade</a>
</div>

<?php
// -----------------------------------------------------------
// 2) Mensagens de sucesso/erro vindas de outras páginas
//    (cadastrar.php, editar.php, excluir.php) via ?msg=...
// -----------------------------------------------------------
if (isset($_GET['msg'])) {
    if ($_GET['msg'] === 'cadastrado') {
        echo '<div class="alerta alerta-sucesso">Modalidade cadastrada com sucesso!</div>';
    } elseif ($_GET['msg'] === 'editado') {
        echo '<div class="alerta alerta-sucesso">Modalidade atualizada com sucesso!</div>';
    } elseif ($_GET['msg'] === 'excluido') {
        echo '<div class="alerta alerta-sucesso">Modalidade excluída com sucesso!</div>';
    } elseif ($_GET['msg'] === 'erro') {
        echo '<div class="alerta alerta-erro">Ocorreu um erro ao processar a solicitação.</div>';
    }
}
?>

<table class="tabela-padrao">
    <thead>
        <tr>
            <th>#</th>
            <th>Nome</th>
            <th>Descrição</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php if (count($modalidades) === 0): ?>
            <tr>
                <td colspan="4">Nenhuma modalidade cadastrada ainda.</td>
            </tr>
        <?php else: ?>
            <?php foreach ($modalidades as $modalidade): ?>
                <tr>
                    <td><?php echo $modalidade['id']; ?></td>
                    <td><?php echo htmlspecialchars($modalidade['nome']); ?></td>
                    <td><?php echo htmlspecialchars($modalidade['descricao']); ?></td>
                    <td class="acoes-tabela">
                        <a class="link-editar" href="editar.php?id=<?php echo $modalidade['id']; ?>">Editar</a>
                        <a class="link-excluir"
                           href="excluir.php?id=<?php echo $modalidade['id']; ?>"
                           onclick="return confirm('Tem certeza que deseja excluir esta modalidade?');">
                           Excluir
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
