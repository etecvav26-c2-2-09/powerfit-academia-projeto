<?php
/**
 * ===========================================================
 * includes/sidebar.php - PowerFit Academia
 * ===========================================================
 * Autor: Luan Alves Padovani
 *
 * Menu lateral do painel administrativo, com os links para os
 * três CRUDs do sistema (Alunos, Planos, Modalidades).
 *
 * Este arquivo é incluído automaticamente pelo header.php,
 * não precisa ser chamado manualmente em cada página.
 * ===========================================================
 */

// -----------------------------------------------------------
// Descobre em qual página estamos, para destacar o item
// correspondente no menu (classe "ativo")
// -----------------------------------------------------------
$paginaAtual = basename($_SERVER['PHP_SELF']);
$pastaAtual  = basename(dirname($_SERVER['PHP_SELF']));
?>
<aside class="admin-sidebar">
    <div class="sidebar-logo">
        <span class="sidebar-logo-power">Power</span><span class="sidebar-logo-fit">Fit</span>
        <small>Academia</small>
    </div>

    <nav class="sidebar-menu">
        <ul>
            <li class="<?php echo ($pastaAtual === 'alunos') ? 'ativo' : ''; ?>">
                <a href="../alunos/index.php">
                    <span class="icone">👤</span> Alunos
                </a>
            </li>
            <li class="<?php echo ($pastaAtual === 'planos') ? 'ativo' : ''; ?>">
                <a href="../planos/index.php">
                    <span class="icone">💳</span> Planos
                </a>
            </li>
            <li class="<?php echo ($pastaAtual === 'modalidades') ? 'ativo' : ''; ?>">
                <a href="../modalidades/index.php">
                    <span class="icone">🏋️</span> Modalidades
                </a>
            </li>
        </ul>
    </nav>

    <div class="sidebar-rodape">
        <small>Painel Admin &copy; <?php echo date('Y'); ?></small>
    </div>
</aside>
