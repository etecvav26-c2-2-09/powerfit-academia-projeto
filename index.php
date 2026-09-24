<?php
/**
 * PowerFit Academia - Página pública
 * Parte: Rian Andrade (etapa 5)
 *
 * Depende do config.php (Pedro Menezes) para a conexão com o banco.
 * Assume conexão via PDO na variável $pdo e as tabelas:
 *   modalidades (id, nome, descricao, imagem)
 *   planos      (id, nome, descricao, preco, duracao)
 * Ajuste os nomes de coluna abaixo se o schema do Pedro for diferente.
 */

require_once __DIR__ . '/config.php';

$modalidades = [];
$planos = [];

try {
    $modalidades = $pdo->query('SELECT * FROM modalidades ORDER BY nome')->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Tabela ainda não populada/criada por algum colega - segue com lista vazia
}

try {
    $planos = $pdo->query('SELECT * FROM planos ORDER BY preco')->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Tabela ainda não populada/criada por algum colega - segue com lista vazia
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>PowerFit Academia</title>
<link rel="stylesheet" href="css/style.css">
</head>
<body>

<header>
    <nav class="navbar">
        <div class="logo">Power<span>Fit</span></div>
        <ul class="nav-links">
            <li><a href="#inicio">Início</a></li>
            <li><a href="#modalidades">Modalidades</a></li>
            <li><a href="#planos">Planos</a></li>
            <li><a href="#contato">Contato</a></li>
        </ul>
    </nav>

    <div class="hero" id="inicio">
        <h1>Supere seus limites</h1>
        <p>Treine com a PowerFit Academia e transforme seu corpo e sua mente.</p>
        <a href="#planos" class="btn-cta">Ver planos</a>
    </div>
</header>

<main>
    <section id="modalidades" class="section">
        <h2>Nossas Modalidades</h2>
        <div class="cards-grid">
            <?php if (empty($modalidades)): ?>
                <p class="empty-msg">Nenhuma modalidade cadastrada ainda.</p>
            <?php else: ?>
                <?php foreach ($modalidades as $mod): ?>
                    <div class="card">
                        <?php if (!empty($mod['imagem'])): ?>
                            <img src="<?= htmlspecialchars($mod['imagem']) ?>" alt="<?= htmlspecialchars($mod['nome']) ?>">
                        <?php endif; ?>
                        <h3><?= htmlspecialchars($mod['nome']) ?></h3>
                        <p><?= htmlspecialchars($mod['descricao'] ?? '') ?></p>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </section>

    <section id="planos" class="section section-alt">
        <h2>Nossos Planos</h2>
        <div class="cards-grid">
            <?php if (empty($planos)): ?>
                <p class="empty-msg">Nenhum plano cadastrado ainda.</p>
            <?php else: ?>
                <?php foreach ($planos as $plano): ?>
                    <div class="card plano-card">
                        <h3><?= htmlspecialchars($plano['nome']) ?></h3>
                        <p class="preco">R$ <?= number_format((float) $plano['preco'], 2, ',', '.') ?></p>
                        <p><?= htmlspecialchars($plano['descricao'] ?? '') ?></p>
                        <?php if (!empty($plano['duracao'])): ?>
                            <span class="duracao"><?= htmlspecialchars($plano['duracao']) ?></span>
                        <?php endif; ?>
                        <a href="#contato" class="btn-plano">Quero esse plano</a>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </section>

    <section id="contato" class="section">
        <h2>Fale Conosco</h2>
        <p>Venha nos visitar e comece hoje mesmo sua transformação!</p>
    </section>
</main>

<footer>
    <p>&copy; <?= date('Y') ?> PowerFit Academia. Todos os direitos reservados.</p>
</footer>

</body>
</html>
