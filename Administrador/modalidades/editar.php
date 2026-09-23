<?php
/**
 * ===========================================================
 * modalidades/editar.php - PowerFit Academia
 * ===========================================================
 * Autor: Luan Alves Padovani
 *
 * Carrega os dados de uma modalidade existente (pelo ID vindo
 * pela URL), mostra no formulário e atualiza no banco quando
 * o formulário é enviado.
 * ===========================================================
 */

$tituloPagina = 'Editar Modalidade - Painel Admin';
require_once __DIR__ . '/../includes/header.php';

// -----------------------------------------------------------
// 1) Pega o ID da modalidade pela URL (?id=...) e valida
// -----------------------------------------------------------
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id) {
    // ID inválido ou ausente: volta para a listagem com erro
    header('Location: index.php?msg=erro');
    exit;
}

$erro = '';

// -----------------------------------------------------------
// 2) Se o formulário foi enviado (POST), valida e atualiza
// -----------------------------------------------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nome      = trim($_POST['nome'] ?? '');
    $descricao = trim($_POST['descricao'] ?? '');

    if ($nome === '') {
        $erro = 'O campo "Nome" é obrigatório.';
    } elseif (mb_strlen($nome) > 100) {
        $erro = 'O nome da modalidade pode ter no máximo 100 caracteres.';
    }

    if ($erro === '') {
        try {
            $stmt = $pdo->prepare(
                'UPDATE modalidades
                    SET nome = :nome, descricao = :descricao
                  WHERE id = :id'
            );
            $stmt->execute([
                ':nome'      => $nome,
                ':descricao' => $descricao,
                ':id'        => $id,
            ]);

            header('Location: index.php?msg=editado');
            exit;

        } catch (PDOException $e) {
            $erro = 'Erro ao atualizar no banco de dados: ' . $e->getMessage();
        }
    }

} else {
    // -----------------------------------------------------------
    // 3) Primeira vez na página (GET): busca os dados atuais
    //    da modalidade para preencher o formulário
    // -----------------------------------------------------------
    try {
        $stmt = $pdo->prepare('SELECT id, nome, descricao FROM modalidades WHERE id = :id');
        $stmt->execute([':id' => $id]);
        $modalidade = $stmt->fetch();

        if (!$modalidade) {
            // Não existe modalidade com esse ID
            header('Location: index.php?msg=erro');
            exit;
        }

        $nome      = $modalidade['nome'];
        $descricao = $modalidade['descricao'];

    } catch (PDOException $e) {
        die('Erro ao buscar modalidade: ' . $e->getMessage());
    }
}
?>

<div class="pagina-topo">
    <h1>Editar Modalidade</h1>
    <a href="index.php" class="btn btn-secundario">&larr; Voltar</a>
</div>

<?php if ($erro !== ''): ?>
    <div class="alerta alerta-erro"><?php echo htmlspecialchars($erro); ?></div>
<?php endif; ?>

<form class="form-padrao" method="POST" action="editar.php?id=<?php echo $id; ?>">

    <label for="nome">Nome da modalidade *</label>
    <input type="text" id="nome" name="nome" maxlength="100"
           value="<?php echo htmlspecialchars($nome); ?>" required>

    <label for="descricao">Descrição</label>
    <textarea id="descricao" name="descricao"><?php echo htmlspecialchars($descricao); ?></textarea>

    <button type="submit" class="btn btn-primario">Atualizar Modalidade</button>
</form>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
