<?php
// solumatch_atualizado/templates/forgot_password.php

// Inclui as classes necessárias
require_once __DIR__ . '/../classes/database.php'; // Caminho para sua classe Database
require_once __DIR__ . '/../classes/user.php';     // Caminho para a nova classe User

$message = '';
$message_type = ''; // 'success' ou 'error'

// Configurações do banco de dados (ajuste se for diferente do seu config.php, mas para mysqli)
// Estes devem ser os mesmos que a sua classe Database.php usa internamente ou que você passa para ela
$dbHost = 'localhost';
$dbUser = 'root';     // <<<< ATUALIZE SEU USUÁRIO DO BANCO DE DADOS AQUI >>>>
$dbPass = '';         // <<<< ATUALIZE SUA SENHA DO BANCO DE DADOS AQUI >>>>
$dbName = 'solu_match'; // <<<< ATUALIZE O NOME DO SEU BANCO DE DADOS AQUI >>>>

try {
    // Instancia a classe Database e obtém a conexão mysqli
    $database = new Database($dbHost, $dbUser, $dbPass, $dbName);
    $dbConnection = $database->getConnection();
    $user = new User($dbConnection); // Passa a conexão mysqli para a classe User
} catch (Exception $e) {
    // Se a conexão falhar, exibe um erro genérico
    $message = "Erro no sistema de recuperação de senha. Por favor, tente mais tarde.";
    $message_type = 'error';
    error_log("Erro na conexão para recuperação de senha: " . $e->getMessage());
    // Termina a execução se não houver conexão
    exit();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login_input = trim($_POST['login'] ?? ''); // Pode ser e-mail ou número

    if (empty($login_input)) {
        $message = 'Por favor, insira seu e-mail ou número de telefone.';
        $message_type = 'error';
    } else {
        $userData = $user->findUserByLogin($login_input); // Usa o novo método findUserByLogin

        if ($userData) {
            $token = $user->generateResetToken($userData['id']);

            if ($token) {
                // Montar o link de redefinição de senha
                // ATENÇÃO: ajuste o 'http://localhost/solumatch_atualizado' para a URL base do seu projeto!
                $resetLink = "http://localhost/solumatch_atualizado/PHP/public/resetar_senha.php?token=" . $token;

                // --- INÍCIO: SIMULAÇÃO DE ENVIO DE E-MAIL ---
                // EM UM AMBIENTE REAL, VOCÊ USARIA UMA BIBLIOTECA COMO PHPMailer
                // OU UM SERVIÇO DE ENVIO DE E-MAIL (SendGrid, Mailgun, etc.)

                $subject = "Redefinição de Senha para Solumatch";
                $emailBody = "Olá,\n\n";
                $emailBody .= "Você solicitou uma redefinição de senha para sua conta Solumatch.\n";
                $emailBody .= "Por favor, clique no link a seguir para redefinir sua senha:\n\n";
                $emailBody .= $resetLink . "\n\n";
                $emailBody .= "Este link expirará em 1 hora.\n";
                $emailBody .= "Se você não solicitou esta redefinição, por favor, ignore este e-mail.\n\n";
                $emailBody .= "Atenciosamente,\nSua Equipe Solumatch";

                // Para fins de demonstração/teste, vamos exibir o link na tela
                // EM AMBIENTE DE PRODUÇÃO, ISSO NUNCA DEVE SER EXIBIDO AO USUÁRIO
                $message = "Um link para redefinição de senha foi enviado para o seu e-mail (se cadastrado). Por favor, verifique sua caixa de entrada e também a pasta de spam. (Link para teste: <a href=\"{$resetLink}\" target=\"_blank\">{$resetLink}</a>)";
                $message_type = 'success';

            } else {
                $message = "Ocorreu um erro ao gerar o link de recuperação. Por favor, tente novamente.";
                $message_type = 'error';
                error_log("Falha ao gerar token para o usuário ID: " . $userData['id']);
            }
        } else {
            // É uma boa prática não informar se o e-mail/número existe ou não por segurança.
            // A mensagem é a mesma tanto para dados existentes quanto inexistentes.
            $message = "Um link para redefinição de senha foi enviado para o seu e-mail (se cadastrado). Por favor, verifique sua caixa de entrada e também a pasta de spam.";
            $message_type = 'success';
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
    <title>Recuperar Senha - Solumatch</title>
    <link rel="stylesheet" href="../../CSS/esqueci_senha.css">
<body>
    <div class="container">
        <h2>Recuperar Senha</h2>
        <?php if ($message): ?>
            <div class="message <?php echo $message_type; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
        <form action="esqueci_senha.php" method="POST">
            <div class="form-group">
                <label for="login">E-mail ou Celular Cadastrado:</label>
                <input type="text" id="login" name="login" required placeholder="Digite seu e-mail ou celular">
            </div>
            <button type="submit">Enviar Link de Recuperação</button>
        </form>
        <p style="margin-top: 20px;"><a href="login.php">Voltar para o Login</a></p>
    </div>
</body>
</html>