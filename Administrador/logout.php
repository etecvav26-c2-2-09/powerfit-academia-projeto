<?php
/**
 * ===========================================================
 * Administrador/logout.php - PowerFit Academia
 * ===========================================================
 * Encerra a sessão do administrador e volta para o login.
 * ===========================================================
 */

require_once __DIR__ . '/includes/auth.php';

sairDoAdmin();

header('Location: login.php?saiu=1');
exit;
