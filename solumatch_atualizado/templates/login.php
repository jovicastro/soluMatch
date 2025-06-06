<?php
session_start();
require_once('../config.php');

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login']);
    $senha = trim($_POST['senha']);

    try {
        // Verifica se é email ou telefone
        $campo = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'numero';
        
        $stmt = $pdo->prepare("SELECT id, senha_hash FROM usuarios WHERE $campo = ?");
        $stmt->execute([$login]);
        $usuario = $stmt->fetch();

        if ($usuario && password_verify($senha, $usuario['senha_hash'])) {
            $_SESSION['usuario_id'] = $usuario['id'];
            header('Location: ../templates/trabalhos.php');
            exit();
        } else {
            $erro = 'Credenciais inválidas ⚠️';
        }
    } catch (PDOException $e) {
        error_log('Erro no login: ' . $e->getMessage());
        $erro = 'Erro no sistema. Tente novamente.';
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | SoluMatch</title>
    <link rel="stylesheet" href="../CSS/login.css">

</head>
<body>
    <div class="container">
        <div class="login-box">
            <img src="../misc/logo.png" class="logo">
            <h2>Entrar no SoluMatch</h2>
            
            <?php if (!empty($erro)): ?>
                <div class="erro-login"><?= htmlspecialchars($erro) ?></div>
            <?php endif; ?>
            
            <form method="POST" action="login.php">
                <input type="text" name="login" placeholder="Celular ou e-mail" required 
                       value="<?= isset($_POST['login']) ? htmlspecialchars($_POST['login']) : '' ?>">
                
                <input type="password" name="senha" placeholder="Senha" required>
                
                <button type="submit" src="../templates/trabalhos.html">Entrar</button>
            </form>
            
            <div class="links">
                <a href="../PHP/Public/esqueci_senha.php">Esqueceu a senha?</a>
                <br>
                <a href="../templates/trabalhos.php">Cadastre-se</a>
            </div>
        </div>
    </div>
</body>
</html>