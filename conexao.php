<?php
// Se o arquivo .env existir, lê as linhas e guarda no array $_ENV
if (file_exists(__DIR__ . '/.env')) {
    $linhas = file(__DIR__ . '/.env');
    foreach ($linhas as $linha) {
        list($chave, $valor) = explode('=', $linha, 2);
        $_ENV[trim($chave)] = trim($valor);
    }
}

// Configurações do banco de dados (obtidas do arquivo .env)
$host   = $_ENV['DB_HOST'] ?? '';
$dbname = $_ENV['DB_NAME'] ?? '';
$user   = $_ENV['DB_USER'] ?? '';
$pass   = $_ENV['DB_PASS'] ?? '';

// Tenta conectar ao banco de dados usando o PDO
try {
    // Cria a conexão e guarda diretamente na variável $cmd
    $cmd = new PDO(
        "mysql:host={$host};dbname={$dbname};charset=utf8mb4",
        $user,
        $pass,
        [
            // 1. Configura o PDO para disparar exceções (erros) caso ocorra alguma falha em consultas futuras
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            
            // 2. Define que o retorno das consultas do banco será um Array Associativo (coluna => valor)
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            
            // 3. Desativa a emulação de statements preparados, garantindo proteção real e nativa contra SQL Injection
            PDO::ATTR_EMULATE_PREPARES => false,
        ]
    );
} catch (PDOException $e) {
    // Se a conexão falhar, o bloco catch captura o objeto de exceção na variável $e
    // $e->getMessage() extrai o texto do erro ocorrido (como 'Access denied' ou 'Unknown database')
    // A função die() exibe a mensagem na tela e interrompe na hora a execução do PHP
    die('Erro de conexão: ' . $e->getMessage());
}
?>
