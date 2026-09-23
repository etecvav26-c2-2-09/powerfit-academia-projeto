<?php
/**
 * ============================================================
 * config.php - PowerFit Academia
 * Arquivo de conexão com o banco de dados (MySQL) usando PDO.
 *
 * Este arquivo deve ser incluído no topo de cada página de
 * CRUD (Alunos, Planos, Modalidades) com:
 *
 *      require_once 'config.php';
 *
 * Depois disso, a variável $pdo já estará pronta para uso,
 * por exemplo:
 *
 *      $stmt = $pdo->query('SELECT * FROM alunos');
 * ============================================================
 */

// ------------------------------------------------------------
// 1) Dados de acesso ao banco - edite aqui conforme o ambiente
//    de cada um (XAMPP, WAMP, servidor da faculdade, etc.)
// ------------------------------------------------------------
$host   = 'localhost';          // endereço do servidor MySQL
$dbname = 'powerfit_academia';  // nome do banco de dados
$user   = 'root';               // usuário do MySQL
$pass   = '';                   // senha do MySQL (em muitos setups locais fica vazia)

// ------------------------------------------------------------
// 2) DSN (Data Source Name)
//    É a "string de endereço" que informa ao PDO qual driver
//    usar (mysql), em qual host, qual banco e qual charset.
//    charset=utf8mb4 evita problemas com acentos e emojis.
// ------------------------------------------------------------
$dsn = "mysql:host={$host};dbname={$dbname};charset=utf8mb4";

// ------------------------------------------------------------
// 3) Opções do PDO
//    ERRMODE_EXCEPTION faz o PDO "lançar" uma exceção sempre
//    que um comando SQL der erro, em vez de falhar em silêncio.
//    Isso é o que permite usar o try/catch abaixo.
// ------------------------------------------------------------
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // resultados como array associativo
    PDO::ATTR_EMULATE_PREPARES   => false,            // usa prepared statements reais do MySQL
];

// ------------------------------------------------------------
// 4) Criação da conexão
//    Tudo fica dentro de um try/catch: se a conexão falhar
//    (senha errada, banco não existe, MySQL desligado, etc.),
//    o script para aqui e mostra uma mensagem de erro clara,
//    em vez de quebrar de forma confusa mais adiante no código.
// ------------------------------------------------------------
try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    // Em produção, o ideal é registrar o erro em log e mostrar
    // uma mensagem genérica ao usuário. Para fins de estudo/
    // desenvolvimento, mostramos o erro real para facilitar o debug.
    die('Erro na conexão com o banco de dados: ' . $e->getMessage());
}

// A partir daqui, $pdo está disponível para quem incluir este arquivo.
