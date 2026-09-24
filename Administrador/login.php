<?php
/**
 * ===========================================================
 * Administrador/login.php - PowerFit Academia
 * ===========================================================
 * Tela de login do painel administrativo.
 * A conferência de usuário/senha fica em includes/auth.php.
 *
 * Fluxo:  site (index.php) -> login.php -> painel (index.php)
 *         -> Alunos / Modalidades
 * ===========================================================
 */

require_once __DIR__ . '/includes/auth.php';

// Já está logado? Vai direto para o painel.
if (adminLogado()) {
    header('Location: index.php');
    exit;
}

$erro    = '';
$usuario = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = trim($_POST['usuario'] ?? '');
    $senha   = $_POST['senha'] ?? '';

    if (tentarLogin($usuario, $senha)) {
        header('Location: index.php');
        exit;
    }

    // Mensagem única de propósito: não revela se errou o usuário ou a senha
    $erro = 'Usuário ou senha incorretos.';
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - PowerFit Academia</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;600;700&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../CSS/admin.css">
</head>
<body class="login-pagina">

<div class="login-caixa">
    <div class="login-logo">Power<span>Fit</span></div>
    <p class="login-subtitulo">Acesso da administração</p>

    <?php if ($erro !== ''): ?>
        <div class="alerta alerta-erro"><?php echo htmlspecialchars($erro); ?></div>
    <?php elseif (isset($_GET['saiu'])): ?>
        <div class="alerta alerta-sucesso">Você saiu do painel.</div>
    <?php endif; ?>

    <form class="form-padrao" method="POST" action="login.php">
        <label for="usuario">Login</label>
        <input type="text" id="usuario" name="usuario"
               value="<?php echo htmlspecialchars($usuario); ?>"
               autocomplete="username" required autofocus>

        <label for="senha">Senha</label>
        <input type="password" id="senha" name="senha"
               autocomplete="current-password" required>

        <button type="submit" class="btn btn-primario">Entrar</button>
    </form>

    <a class="login-voltar" href="../index.php">&larr; Voltar ao site</a>
</div>

</body>
</html>
