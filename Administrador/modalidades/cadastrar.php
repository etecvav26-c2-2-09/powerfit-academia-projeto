<?php
/**
 * ===========================================================
 * modalidades/cadastrar.php - PowerFit Academia
 * ===========================================================
 * Autor: Luan Alves Padovani
 *
 * Formulário de cadastro de uma nova modalidade e o código que
 * grava os dados no banco quando o formulário é enviado.
 * ===========================================================
 */

$tituloPagina = 'Nova Modalidade - Painel Admin';
require_once __DIR__ . '/../includes/header.php';

// -----------------------------------------------------------
// 1) Variáveis de controle: erro de validação e valores digitados
//    (para não perder o que o usuário já preencheu se der erro)
// -----------------------------------------------------------
$erro = '';
$nome = '';
$descricao = '';

// -----------------------------------------------------------
// 2) Se o formulário foi enviado (POST), valida e salva
// -----------------------------------------------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nome      = trim($_POST['nome'] ?? '');
    $descricao = trim($_POST['descricao'] ?? '');

    // ---- validação básica -----------------------------------
    if ($nome === '') {
        $erro = 'O campo "Nome" é obrigatório.';
    } elseif (mb_strlen($nome) > 100) {
        $erro = 'O nome da modalidade pode ter no máximo 100 caracteres.';
    }

    // ---- se passou na validação, tenta inserir no banco ------
    if ($erro === '') {
        try {
            $stmt = $pdo->prepare(
                'INSERT INTO modalidades (nome, descricao) VALUES (:nome, :descricao)'
            );
            $stmt->execute([
                ':nome'      => $nome,
                ':descricao' => $descricao,
            ]);

            // Sucesso: volta para a listagem com mensagem de sucesso
            header('Location: index.php?msg=cadastrado');
            exit;

        } catch (PDOException $e) {
            $erro = 'Erro ao salvar no banco de dados: ' . $e->getMessage();
        }
    }
}
?>

<div class="pagina-topo">
    <h1>Nova Modalidade</h1>
    <a href="index.php" class="btn btn-secundario">&larr; Voltar</a>
</div>

<?php if ($erro !== ''): ?>
    <div class="alerta alerta-erro"><?php echo htmlspecialchars($erro); ?></div>
<?php endif; ?>

<form class="form-padrao" method="POST" action="cadastrar.php">

    <label for="nome">Nome da modalidade *</label>
    <input type="text" id="nome" name="nome" maxlength="100"
           value="<?php echo htmlspecialchars($nome); ?>"
           placeholder="Ex: Musculação, Funcional, Ritmos, Lutas" required>

    <label for="descricao">Descrição</label>
    <textarea id="descricao" name="descricao"
              placeholder="Breve descrição da modalidade (opcional)"><?php echo htmlspecialchars($descricao); ?></textarea>

    <button type="submit" class="btn btn-primario">Salvar Modalidade</button>
</form>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
