<?php
// solumatch_atualizado/templates/forgot_password.php

// Inclui o arquivo de configuração, que já estabelece a conexão $pdo
require_once __DIR__ . '/../../config.php'; // Caminho para o seu config.php
require_once __DIR__ . '/../classes/user.php';     // Caminho para a nova classe User

$message = '';
$message_type = ''; // 'success' ou 'error'

// A conexão $pdo já está disponível globalmente do config.php
// Não precisamos mais das variáveis $dbHost, $dbUser, $dbPass, $dbName aqui.
$user = new User($pdo); // Passa a instância PDO para a classe User

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login_input = trim($_POST['login'] ?? ''); // Pode ser e-mail ou número

    if (empty($login_input)) {
        $message = 'Por favor, insira seu e-mail cadastrado.';
        $message_type = 'error';
    } else {
        $userData = $user->findUserByLogin($login_input);

        if ($userData) {
            $token = $user->generateResetToken($userData['id']);

            // --- LINHAS DE DEPURACÃO (Pode remover após testar) ---
            error_log("Token gerado por generateResetToken: " . ($token ?: "FALHA ou VAZIO"));
            // --- FIM LINHAS DE DEPURACÃO ---

            if ($token) {
                // Montar o link de redefinição de senha
                // ATENÇÃO: ajuste o 'http://localhost/solumatch_atualizado' para a URL base do seu projeto!
                $resetLink = "http://localhost/solumatch_atualizado/PHP/public/resetar_senha.php?token=" . $token;

                // --- APENAS PARA TESTE LOCAL: Exibe o link na tela ---
                // EM AMBIENTE DE PRODUÇÃO, ISSO NUNCA DEVE SER EXIBIDO AO USUÁRIO
                $message = "Um link para redefinição de senha foi enviado para o seu e-mail (se cadastrado). Por favor, verifique sua caixa de entrada e também a pasta de spam. (Link para teste: <a href=\"{$resetLink}\" target=\"_blank\">{$resetLink}</a>)";
                $message_type = 'success';
                // --- FIM DO TESTE LOCAL ---

            } else {
                $message = "Ocorreu um erro ao gerar o link de recuperação. Por favor, tente novamente.";
                $message_type = 'error';
                error_log("Falha ao gerar token para o usuário ID: " . $userData['id']);
            }
        } else {
            // Mensagem genérica para segurança, mesmo que o e-mail/número não exista.
            $message = "Não foram encontrados usuários com esse e-mail ou número de telefone. Se você tiver certeza de que está cadastrado, por favor, verifique se digitou corretamente.";
            $message_type = 'success';
        }
    }
}
// Não é necessário fechar a conexão $pdo aqui, pois ela é gerenciada pelo config.php e será fechada no final da execução do script.
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="../../CSS/esqueci_senha.css">
</head>
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
                <label for="login">E-mail Cadastrado:</label>
                <input type="text" id="login" name="login" required placeholder="Digite seu e-mail">
            </div>
            <button type="submit">Enviar Link de Recuperação</button>
        </form>
        <p style="margin-top: 20px;"><a href="login.php">Voltar para o Login</a></p>
    </div>
</body>
</html>