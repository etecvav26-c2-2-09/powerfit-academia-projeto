<?php
/**
 * ===========================================================
 * Administrador/index.php - PowerFit Academia
 * ===========================================================
 * Painel inicial do administrador (só abre depois do login).
 * Mostra os totais e a ligação entre as tabelas:
 *   quantos alunos existem em cada modalidade e em cada plano.
 * Daqui o menu leva para os CRUDs de Alunos e Modalidades.
 * ===========================================================
 */

$tituloPagina = 'Painel - PowerFit Academia';
$prefixoAdmin = '';   // esta página fica direto em Administrador/
require_once __DIR__ . '/includes/header.php';

try {
    $totalAlunos      = (int) $pdo->query('SELECT COUNT(*) FROM alunos')->fetchColumn();
    $totalModalidades = (int) $pdo->query('SELECT COUNT(*) FROM modalidades')->fetchColumn();
    $totalPlanos      = (int) $pdo->query('SELECT COUNT(*) FROM planos')->fetchColumn();

    // LEFT JOIN: modalidades sem nenhum aluno também aparecem (com 0)
    $porModalidade = $pdo->query(
        'SELECT m.nome, COUNT(a.id) AS total
           FROM modalidades m
           LEFT JOIN alunos a ON a.modalidade_id = m.id
          GROUP BY m.id, m.nome
          ORDER BY total DESC, m.nome'
    )->fetchAll();

    $porPlano = $pdo->query(
        'SELECT p.nome, COUNT(a.id) AS total
           FROM planos p
           LEFT JOIN alunos a ON a.plano_id = p.id
          GROUP BY p.id, p.nome
          ORDER BY total DESC, p.nome'
    )->fetchAll();
} catch (PDOException $e) {
    die('Erro ao carregar o painel: ' . $e->getMessage());
}

// Se ainda não existe o CRUD de planos, o card leva para a seção de planos do site
$temPlanos  = file_exists(__DIR__ . '/planos/index.php');
$urlPlanos  = $temPlanos ? 'planos/index.php' : '../index.php#planos';
$rotuloPlan = $temPlanos ? 'Planos' : 'Planos (ver no site)';
?>

<div class="pagina-topo">
    <h1>Painel</h1>
</div>
<p class="subtitulo">Bem-vindo à administração da PowerFit Academia.</p>

<div class="cards-resumo">
    <a class="card-resumo" href="alunos/listar.php">
        <span class="numero"><?php echo $totalAlunos; ?></span>
        <span class="rotulo">Alunos</span>
    </a>
    <a class="card-resumo" href="modalidades/index.php">
        <span class="numero"><?php echo $totalModalidades; ?></span>
        <span class="rotulo">Modalidades</span>
    </a>
    <a class="card-resumo" href="<?php echo $urlPlanos; ?>">
        <span class="numero"><?php echo $totalPlanos; ?></span>
        <span class="rotulo"><?php echo $rotuloPlan; ?></span>
    </a>
</div>

<div class="atalhos">
    <a class="btn btn-primario" href="alunos/criar.php">+ Novo aluno</a>
    <a class="btn btn-secundario" href="modalidades/cadastrar.php">+ Nova modalidade</a>
</div>

<div class="painel-grid">
    <section>
        <h2>Alunos por modalidade</h2>
        <div class="tabela-wrap">
            <table class="tabela-padrao">
                <thead>
                    <tr><th>Modalidade</th><th>Alunos</th></tr>
                </thead>
                <tbody>
                    <?php if (count($porModalidade) === 0): ?>
                        <tr><td colspan="2">Nenhuma modalidade cadastrada.</td></tr>
                    <?php else: ?>
                        <?php foreach ($porModalidade as $linha): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($linha['nome']); ?></td>
                                <td><span class="badge <?php echo $linha['total'] == 0 ? 'badge-zero' : ''; ?>"><?php echo (int) $linha['total']; ?></span></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>

    <section>
        <h2>Alunos por plano</h2>
        <div class="tabela-wrap">
            <table class="tabela-padrao">
                <thead>
                    <tr><th>Plano</th><th>Alunos</th></tr>
                </thead>
                <tbody>
                    <?php if (count($porPlano) === 0): ?>
                        <tr><td colspan="2">Nenhum plano cadastrado.</td></tr>
                    <?php else: ?>
                        <?php foreach ($porPlano as $linha): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($linha['nome']); ?></td>
                                <td><span class="badge <?php echo $linha['total'] == 0 ? 'badge-zero' : ''; ?>"><?php echo (int) $linha['total']; ?></span></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
