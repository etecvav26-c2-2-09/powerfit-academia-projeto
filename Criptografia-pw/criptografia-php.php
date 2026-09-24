<?php
/**
 * Atividade - Criptografia no PHP
 * Turma: 2C | Disciplina: PW2 - Programação Web II
 * Integrantes: Pedro Menezes, Rian Andrade, Luan Padovani, Gabriel Oliveira
 *
 * Objetivo: demonstrar os principais tipos de "criptografia" disponíveis
 * nativamente no PHP: hashing, hashing de senhas e cifragem simétrica.
 */

// ------------------------------------------------------------------
// 1) HASHING (função hash())
// Hash é uma via de mão única: transforma qualquer dado em uma
// sequência de tamanho fixo. Não existe "descriptografar" um hash.
// Serve para checar integridade de arquivos, gerar identificadores, etc.
// ------------------------------------------------------------------
$texto = "PW2 - Programação Web II";

$algoritmos_hash = ['md5', 'sha1', 'sha256', 'sha3-256', 'crc32b'];
$resultados_hash = [];
foreach ($algoritmos_hash as $algo) {
    $resultados_hash[$algo] = hash($algo, $texto);
}

// ------------------------------------------------------------------
// 2) HASHING DE SENHAS (password_hash / password_verify)
// É um tipo especial de hash, feito para senhas: é lento de propósito
// (dificulta ataques de força bruta) e usa "salt" automático, então
// o mesmo texto gera hashes diferentes a cada execução.
// ------------------------------------------------------------------
$senha = "SenhaSuperSecreta123";

$hash_bcrypt = password_hash($senha, PASSWORD_BCRYPT);
$hash_padrao = password_hash($senha, PASSWORD_DEFAULT);

$senha_confere = password_verify($senha, $hash_bcrypt);
$senha_errada_confere = password_verify("senha_errada", $hash_bcrypt);

// ------------------------------------------------------------------
// 3) CIFRAGEM SIMÉTRICA (openssl_encrypt / openssl_decrypt)
// Diferente do hash, a cifragem é reversível: quem tem a chave certa
// consegue "descriptografar" e recuperar o texto original.
// Usamos AES-256-CBC, um dos algoritmos simétricos mais usados hoje.
// ------------------------------------------------------------------
$mensagem_original = "Mensagem confidencial do grupo de PW2";
$metodo_cifra = "AES-256-CBC";
$chave = "chave-secreta-do-grupo-2c-pw2!!"; // em produção, nunca deixar fixa no código
$tamanho_iv = openssl_cipher_iv_length($metodo_cifra);
$iv = openssl_random_pseudo_bytes($tamanho_iv);

$texto_cifrado = openssl_encrypt($mensagem_original, $metodo_cifra, $chave, 0, $iv);
$texto_decifrado = openssl_decrypt($texto_cifrado, $metodo_cifra, $chave, 0, $iv);

// ------------------------------------------------------------------
// 4) O QUE ESTÁ DISPONÍVEL NO PHP (listas do próprio interpretador)
// ------------------------------------------------------------------
$todos_algoritmos_hash = hash_algos();
$todos_metodos_cifra = openssl_get_cipher_methods();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Criptografia no PHP</title>
<style>
    body {
        font-family: Segoe UI, Arial, sans-serif;
        background: #0f1115;
        color: #e8e8e8;
        max-width: 900px;
        margin: 40px auto;
        padding: 0 20px;
        line-height: 1.5;
    }
    h1 { color: #7dd3fc; }
    h2 {
        color: #a78bfa;
        border-bottom: 1px solid #333;
        padding-bottom: 6px;
        margin-top: 40px;
    }
    .card {
        background: #1a1d24;
        border: 1px solid #2a2d35;
        border-radius: 8px;
        padding: 16px 20px;
        margin: 12px 0;
    }
    code, .mono {
        font-family: Consolas, monospace;
        word-break: break-all;
        color: #86efac;
    }
    table { width: 100%; border-collapse: collapse; margin-top: 10px; }
    td, th { text-align: left; padding: 6px 8px; border-bottom: 1px solid #2a2d35; }
    .ok { color: #4ade80; font-weight: bold; }
    .erro { color: #f87171; font-weight: bold; }
    .tag {
        display: inline-block;
        background: #2a2d35;
        padding: 2px 8px;
        border-radius: 4px;
        font-size: 0.8em;
        color: #7dd3fc;
    }
    .lista-pequena {
        max-height: 160px;
        overflow-y: auto;
        font-size: 0.85em;
        color: #9ca3af;
    }
</style>
</head>
<body>

<h1>🔐 Tipos de Criptografia Disponíveis no PHP</h1>
<p>Turma 2C — PW2 - Programação Web II · Grupo: Pedro Menezes, Rian Andrade, Luan Padovani e Gabriel Oliveira</p>

<h2>1. Hashing <span class="tag">função hash()</span></h2>
<div class="card">
    <p>Texto original: <code><?= htmlspecialchars($texto) ?></code></p>
    <table>
        <tr><th>Algoritmo</th><th>Hash gerado</th></tr>
        <?php foreach ($resultados_hash as $algo => $valor): ?>
        <tr>
            <td><?= strtoupper($algo) ?></td>
            <td class="mono"><?= $valor ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <p><small>O hash é irreversível: não é possível voltar do hash para o texto original.</small></p>
</div>

<h2>2. Hashing de Senhas <span class="tag">password_hash() / password_verify()</span></h2>
<div class="card">
    <p>Senha original: <code><?= htmlspecialchars($senha) ?></code></p>
    <p>Hash (BCRYPT): <span class="mono"><?= $hash_bcrypt ?></span></p>
    <p>Hash (algoritmo padrão do PHP): <span class="mono"><?= $hash_padrao ?></span></p>
    <p>Verificação com a senha certa:
        <span class="<?= $senha_confere ? 'ok' : 'erro' ?>"><?= $senha_confere ? 'válida ✔' : 'inválida ✘' ?></span>
    </p>
    <p>Verificação com senha errada:
        <span class="<?= $senha_errada_confere ? 'ok' : 'erro' ?>"><?= $senha_errada_confere ? 'válida ✔' : 'inválida ✘' ?></span>
    </p>
</div>

<h2>3. Cifragem Simétrica (reversível) <span class="tag">openssl_encrypt() / openssl_decrypt()</span></h2>
<div class="card">
    <p>Método: <code><?= $metodo_cifra ?></code></p>
    <p>Mensagem original: <code><?= htmlspecialchars($mensagem_original) ?></code></p>
    <p>Mensagem cifrada: <span class="mono"><?= $texto_cifrado ?></span></p>
    <p>Mensagem decifrada: <code><?= htmlspecialchars($texto_decifrado) ?></code></p>
    <p>Round-trip correto:
        <span class="<?= $texto_decifrado === $mensagem_original ? 'ok' : 'erro' ?>">
            <?= $texto_decifrado === $mensagem_original ? 'sim ✔' : 'não ✘' ?>
        </span>
    </p>
</div>

<h2>4. O que o PHP oferece nativamente</h2>
<div class="card">
    <p><strong><?= count($todos_algoritmos_hash) ?> algoritmos de hash</strong> disponíveis (via <code>hash_algos()</code>):</p>
    <div class="lista-pequena"><?= implode(', ', $todos_algoritmos_hash) ?></div>

    <p style="margin-top:16px;"><strong><?= count($todos_metodos_cifra) ?> métodos de cifragem</strong> disponíveis (via <code>openssl_get_cipher_methods()</code>):</p>
    <div class="lista-pequena"><?= implode(', ', $todos_metodos_cifra) ?></div>
</div>

<h2>Resumo</h2>
<div class="card">
    <ul>
        <li><strong>Hash</strong> (<code>hash()</code>): via de mão única, usado para integridade e identificação de dados.</li>
        <li><strong>Hash de senha</strong> (<code>password_hash()</code>): hash lento e com salt, próprio para armazenar senhas com segurança.</li>
        <li><strong>Cifragem simétrica</strong> (<code>openssl_encrypt()</code>): reversível, usa a mesma chave para cifrar e decifrar dados.</li>
    </ul>
</div>

</body>
</html>
