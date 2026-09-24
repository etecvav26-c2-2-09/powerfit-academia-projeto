<?php
/**
 * PowerFit Academia - Página pública (index.php)
 *
 * Conecta com as outras partes do projeto:
 *   - Configuração/config.php  -> conexão PDO ($pdo)          (Pedro)
 *   - CSS/style.css            -> identidade visual           (Rian)
 *   - Banco powerfit_academia  -> tabelas planos e modalidades
 *   - Administrador/           -> painel de CRUDs             (Luan e equipe)
 *
 * Colunas usadas (conforme powerfit SQL/powerfit_academia.sql):
 *   modalidades (id, nome, descricao)
 *   planos      (id, nome, preco, descricao)
 */

// -----------------------------------------------------------
// 1) Conexão com o banco (mesmo caminho usado no painel admin)
// -----------------------------------------------------------
require_once __DIR__ . '/Configuração/config.php';

// -----------------------------------------------------------
// 2) Dados de contato (fictícios, conforme o README do projeto)
// -----------------------------------------------------------
$whatsappNumero  = '5511999998888';               // formato internacional, só números
$whatsappExibido = '(11) 99999-8888';
$email           = 'contato@powerfit.com.br';
$endereco        = 'Av. do Movimento, 500 - Centro';
$instagram       = '@powerfit_oficial';

// -----------------------------------------------------------
// 3) Busca modalidades e planos no banco
//    Se algo falhar, a página continua abrindo com lista vazia
//    e o erro real vai para o log do PHP (não aparece ao visitante).
// -----------------------------------------------------------
$modalidades = [];
$planos      = [];

try {
    $modalidades = $pdo->query('SELECT id, nome, descricao FROM modalidades ORDER BY nome')->fetchAll();
} catch (PDOException $e) {
    error_log('index.php - erro ao buscar modalidades: ' . $e->getMessage());
}

try {
    // Do mais caro ao mais barato: Mensal, Semestral, Anual
    $planos = $pdo->query('SELECT id, nome, preco, descricao FROM planos ORDER BY preco DESC')->fetchAll();
} catch (PDOException $e) {
    error_log('index.php - erro ao buscar planos: ' . $e->getMessage());
}

// Monta o link do WhatsApp já com o nome do plano na mensagem
function linkWhatsapp(string $numero, string $mensagem): string
{
    return 'https://wa.me/' . $numero . '?text=' . rawurlencode($mensagem);
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>PowerFit Academia</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;600;700&family=Roboto:wght@400;500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="CSS/style.css">
<style>
    /* Só o que a seção de contato precisa e ainda não existe no style.css */
    .contato-lista { list-style: none; max-width: 500px; margin: 0 auto 2rem; text-align: left; }
    .contato-lista li { padding: 0.5rem 0; border-bottom: 1px solid #e5e5e5; }
    .contato-lista strong { color: var(--cor-primaria); }
    .footer-admin { display: block; margin-top: 0.5rem; font-size: 0.8rem; color: #888888; }
    .footer-admin:hover { color: var(--cor-primaria); }
</style>
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
                        <p class="preco">R$ <?= number_format((float) $plano['preco'], 2, ',', '.') ?><small>/mês</small></p>
                        <p><?= htmlspecialchars($plano['descricao'] ?? '') ?></p>
                        <a class="btn-plano"
                           href="<?= htmlspecialchars(linkWhatsapp($whatsappNumero, 'Olá! Tenho interesse no plano ' . $plano['nome'] . ' da PowerFit Academia.')) ?>"
                           target="_blank" rel="noopener">Quero esse plano</a>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </section>

    <section id="contato" class="section">
        <h2>Fale Conosco</h2>
        <p style="margin-bottom:1.5rem;">Venha nos visitar e comece hoje mesmo sua transformação!</p>
        <ul class="contato-lista">
            <li><strong>WhatsApp:</strong> <?= htmlspecialchars($whatsappExibido) ?></li>
            <li><strong>E-mail:</strong> <?= htmlspecialchars($email) ?></li>
            <li><strong>Endereço:</strong> <?= htmlspecialchars($endereco) ?></li>
            <li><strong>Instagram:</strong> <?= htmlspecialchars($instagram) ?></li>
        </ul>
        <a class="btn-cta"
           href="<?= htmlspecialchars(linkWhatsapp($whatsappNumero, 'Olá! Gostaria de saber mais sobre a PowerFit Academia.')) ?>"
           target="_blank" rel="noopener">Chamar no WhatsApp</a>
    </section>
</main>

<footer>
    <p>&copy; <?= date('Y') ?> PowerFit Academia. Todos os direitos reservados.</p>
    <a class="footer-admin" href="Administrador/alunos/listar.php">Área administrativa</a>
</footer>

</body>
</html>
