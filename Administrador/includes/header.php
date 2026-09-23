<?php
/**
 * ===========================================================
 * includes/header.php - PowerFit Academia
 * ===========================================================
 * Autor: Luan Alves Padovani
 *
 * Este arquivo é o topo comum de todas as páginas do painel
 * administrativo (Alunos, Planos e Modalidades).
 *
 * Ele:
 *   - inclui a conexão com o banco (config.php);
 *   - abre a estrutura HTML;
 *   - carrega o CSS comum do painel.
 *
 * Como usar:
 *   No topo de cada página do CRUD, incluir:
 *       require_once __DIR__ . '/../includes/header.php';
 *   e no final da página, incluir footer.php.
 *
 * Estrutura de pastas considerada (repositório GitHub):
 *   powerfit-academia-projeto/
 *   ├── Administrador/
 *   │   ├── includes/   (este arquivo)
 *   │   ├── alunos/
 *   │   ├── planos/
 *   │   └── modalidades/
 *   ├── CSS/
 *   └── Configuração/
 *       └── config.php  (feito por Pedro)
 * ===========================================================
 */

// -----------------------------------------------------------
// 1) Conexão com o banco (feita por Pedro, pasta "Configuração")
// -----------------------------------------------------------
require_once __DIR__ . '/../../Configuração/config.php';

// -----------------------------------------------------------
// 2) Título da página (cada página pode definir $tituloPagina
//    ANTES de incluir este header. Se não definir, usa padrão)
// -----------------------------------------------------------
if (!isset($tituloPagina)) {
    $tituloPagina = 'Painel Administrativo - PowerFit Academia';
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($tituloPagina); ?></title>
    <link rel="stylesheet" href="../../CSS/admin.css">
</head>
<body>

<div class="admin-wrapper">
    <?php require_once __DIR__ . '/sidebar.php'; ?>

    <main class="admin-conteudo">
