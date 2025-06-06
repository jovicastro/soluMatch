<?php
// solumatch_atualizado/templates/reset_password.php

// Inclui as classes necessárias
require_once __DIR__ . '/../classes/database.php'; // Caminho para sua classe Database
require_once __DIR__ . '/../classes/user.php';     // Caminho para a nova classe User

$message = '';
$message_type = ''; // 'success' ou 'error'
$token = $_GET['token'] ?? ''; // **CORRIGIDO: Removido FILTER_SANITIZE_STRING**
$validToken = false;
$userId = null;

// Configurações do banco de dados (ajuste se for diferente)
$dbHost = 'localhost';
$dbUser = 'root';
$dbPass = '';
$dbName = 'solu_match';

try {
    // Instancia a classe Database e obtém a conexão mysqli
    $database = new Database($dbHost, $dbUser, $dbPass, $dbName);
    $dbConnection = $database->getConnection();
    $user = new User($dbConnection); // Passa a conexão mysqli para a classe User
} catch (Exception $e) {
    $message = "Erro no sistema de recuperação de senha. Por favor, tente mais tarde.";
    $message_type = 'error';
    error_log("Erro na conexão para redefinição de senha: " . $e->getMessage());
    exit();
}


// --- Validar o token primeiro ---
if (!empty($token)) {
    $userData = $user->validateResetToken($token);
    if ($userData) {
        $validToken = true;
        $userId = $userData['id'];
    } else {
        $message = 'Link de redefinição de senha inválido ou expirado. Por favor, solicite um novo.';
        $message_type = 'error';
    }
} else {
    $message = 'Token de redefinição de senha não fornecido.';
    $message_type = 'error';
}

// --- Processar a redefinição de senha se o formulário for enviado ---
if ($validToken && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $newPassword = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    if (empty($newPassword) || empty($confirmPassword)) {
        $message = 'Por favor, preencha todos os campos.';
        $message_type = 'error';
    } elseif ($newPassword !== $confirmPassword) {
        $message = 'As senhas não coincidem.';
        $message_type = 'error';
    } elseif (strlen($newPassword) < 8) { // Requisito de senha: mínimo de 8 caracteres
        $message = 'A senha deve ter pelo menos 8 caracteres.';
        $message_type = 'error';
    } else {
        if ($user->resetPassword($userId, $newPassword)) {
            $message = 'Sua senha foi redefinida com sucesso! Você já pode fazer login com sua nova senha.';
            $message_type = 'success';
            $validToken = false; // Invalida o formulário para evitar reuso e mostra o link de login
        } else {
            $message = 'Ocorreu um erro ao redefinir sua senha. Por favor, tente novamente.';
            $message_type = 'error';
        }
    }
}
// Garante que a conexão com o banco de dados seja fechada
if (isset($database)) {
    $database->closeConnection();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redefinir Senha - Solumatch</title>
    <link rel="stylesheet" href="../../CSS/resetar_senha.css">
</head>
<body>
    <div class="container">
        <h2>Redefinir Senha</h2>
        <?php if ($message): ?>
            <div class="message <?php echo $message_type; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <?php if ($validToken): ?>
            <form action="resetar_senha.php?token=<?php echo htmlspecialchars($token); ?>" method="POST">
                <div class="form-group">
                    <label for="password">Nova Senha:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="form-group">
                    <label for="confirm_password">Confirmar Senha:</label>
                    <input type="password" id="confirm_password" name="confirm_password" required>
                </div>
                <button type="submit">Redefinir Senha</button>
            </form>
        <?php elseif ($message_type === 'success'): ?>
             <p><a href="../../templates/login.php">Ir para a página de Login</a></p>
        <?php else: ?>
            <p>Se você precisa de um novo link de redefinição, por favor, <a href="../Public/esqueci_senha.php">clique aqui</a>.</p>
        <?php endif; ?>
    </div>
</body>
</html>