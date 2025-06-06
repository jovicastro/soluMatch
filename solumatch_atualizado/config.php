<?php
// Configurações de conexão com o banco de dados
$host = 'localhost';      // Servidor do banco de dados
$dbname = 'solu_match';   // Nome do banco de dados
$usuario = 'root';        // Usuário do banco (altere conforme necessário)
$senha = '';              // Senha do banco (altere conforme necessário)

try {
    // Cria a conexão PDO com o MySQL
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $usuario, $senha);
    
    // Configura o PDO para lançar exceções em caso de erros
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Configura o modo padrão de fetch para array associativo
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    
} catch (PDOException $e) {
    // Em caso de erro na conexão, registra no log e exibe mensagem genérica
    error_log("Erro na conexão: " . $e->getMessage());
    die("Erro no sistema. Por favor, tente mais tarde.");
}
?>