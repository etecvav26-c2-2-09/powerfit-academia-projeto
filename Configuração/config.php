<?php

// 
// 1) Dados de acesso ao banco - (XAMPP, WAMP, servidor da faculdade, etc.)
// 
$host   = 'localhost';          // endereço do servidor MySQL
$dbname = 'powerfit_academia';  // nome do banco de dados
$user   = 'root';               // usuário do MySQL
$pass   = '';                   // senha do MySQL 

// 
// 2) DSN (Data Source Name)
//    É a "string de endereço" que informa ao PDO qual driver
//    usar (mysql), em qual host, qual banco e qual charset.
// 
$dsn = "mysql:host={$host};dbname={$dbname};charset=utf8mb4";

// 
// 3) Opções do PDO
//    ERRMODE_EXCEPTION faz o PDO "lançar" uma exceção sempre
//    que um comando SQL der erro
// 
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,          
];

// 
// 4) Criação da conexão
//    Tudo fica dentro de um try/catch: se a conexão falhar
//    (senha errada, banco não existe, MySQL desligado, etc.),
// 
try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    die('Erro na conexão com o banco de dados: ' . $e->getMessage());
}
