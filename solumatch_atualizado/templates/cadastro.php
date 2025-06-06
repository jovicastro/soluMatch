<?php
// Inicia a sessão para possíveis mensagens de erro
session_start();

// Inclui o arquivo de configuração do banco
require_once('../config.php');


// Array para armazenar erros de validação
$erros = [
    'email' => '',
    'CPF' => '',
    'CNPJ' => '',
    'geral' => ''
];

// Verifica se o formulário foi submetido
if (isset($_POST['cadastrar'])) {
    try {
        // Validação básica - Senha
        if (empty($_POST['senha'])) {
            throw new Exception("Senha é obrigatória");
        }

        // Valida se as senhas coincidem
        if ($_POST['senha'] !== $_POST['confirmar_senha']) {
            throw new Exception("As senhas não coincidem");
        }

        // Verificação de e-mail
        $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE email = ?");
        $stmt->execute([$_POST['email']]);
        if ($stmt->rowCount() > 0) {
            $erros['email'] = "Este e-mail já está cadastrado";
        }

        // Verificação de CPF
        $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE CPF = ?");
        $stmt->execute([$_POST['CPF']]);
        if ($stmt->rowCount() > 0) {
            $erros['CPF'] = "Este CPF já está cadastrado";
        }

        // Verificação de CNPJ (se fornecido)
        if (!empty($_POST['CNPJ'])) {
            $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE CNPJ = ?");
            $stmt->execute([$_POST['CNPJ']]);
            if ($stmt->rowCount() > 0) {
                $erros['CNPJ'] = "Este CNPJ já está cadastrado";
            }
        }

        // Se existirem erros, lança exceção
        if (!empty(array_filter($erros))) {
            throw new Exception("Uma ou mais informações ja foram cadastradas ⚠️");
        }

        // Prepara os dados para inserção
        $dados = [
            'nome' => $_POST['nome'],
            'email' => $_POST['email'],
            'numero' => $_POST['numero'],
            'endereco' => $_POST['endereco'],
            'cep' => $_POST['cep'],
            'CPF' => $_POST['CPF'],
            'CNPJ' => !empty($_POST['CNPJ']) ? $_POST['CNPJ'] : null,
            'senha_hash' => password_hash($_POST['senha'], PASSWORD_DEFAULT)
        ];

        // Prepara e executa a query de inserção
        $stmt = $pdo->prepare("INSERT INTO usuarios 
                             (nome, email, numero, endereco, cep, CPF, CNPJ, senha_hash) 
                             VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        
        $stmt->execute(array_values($dados));
        
        // Redireciona para página de sucesso
        header("Location: login.php");
        exit();

    } catch (PDOException $e) {
        // Erros específicos do banco de dados
        $erros['geral'] = "Erro no sistema. Por favor, tente novamente.";
        error_log("Erro no cadastro: " . $e->getMessage());
    } catch (Exception $e) {
        // Erros gerais de validação
        $erros['geral'] = $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro | SoluMatch</title>
    <link rel="stylesheet" href="../CSS/cadastro.css">
</head>
<body>
    <section class="formulario">
        <img src="../misc/logo.png" class="logo-form">
        <h1>Cadastre-se na SoluMatch</h1>
        
        <!-- Exibe mensagem geral de erro -->
        <?php if (!empty($erros['geral'])): ?>
            <div class="alert-danger"><?= htmlspecialchars($erros['geral']) ?></div>
        <?php endif; ?>

    <form method="POST" action="cadastro.php">
    <!-- Campo Nome -->
    <div class="campo-wrapper">
        <input name="nome" type="text" placeholder="Nome:" required value="<?= htmlspecialchars($_POST['nome'] ?? '') ?>">
    </div>
    
    <!-- Campo Email -->
    <div class="campo-wrapper">
        <input name="email" type="email" placeholder="Email:" required
            class="<?= !empty($erros['email']) ? 'campo-invalido' : '' ?>"
             value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>">
    </div>
    
    <!-- Campo Telefone -->
    <div class="campo-wrapper">
        <input name="numero" type="tel" placeholder="Telefone:" required
               value="<?= isset($_POST['numero']) ? htmlspecialchars($_POST['numero']) : '' ?>">
    </div>
    
    <!-- Campo Endereço -->
    <div class="campo-wrapper">
        <input name="endereco" type="text" placeholder="Endereço:" required
               value="<?= isset($_POST['endereco']) ? htmlspecialchars($_POST['endereco']) : '' ?>">
    </div>
    
    <!-- Campo CEP -->
    <div class="campo-wrapper">
        <input name="cep" type="text" placeholder="CEP:" required
               value="<?= isset($_POST['cep']) ? htmlspecialchars($_POST['cep']) : '' ?>">
    </div>
    
    <!-- Campo CPF -->
    <div class="campo-wrapper">
        <input name="CPF" type="text" placeholder="CPF:" required
               class="<?= !empty($erros['CPF']) ? 'campo-invalido' : '' ?>"
               value="<?= isset($_POST['CPF']) ? htmlspecialchars($_POST['CPF']) : '' ?>">
    </div> 
    
    <!-- Campo CNPJ -->
    <div class="campo-wrapper">
        <input name="CNPJ" type="text" placeholder="CNPJ (opcional):"
               class="<?= !empty($erros['CNPJ']) ? 'campo-invalido' : '' ?>"
               value="<?= isset($_POST['CNPJ']) ? htmlspecialchars($_POST['CNPJ']) : '' ?>">
    </div>
    
    <!-- Campos Senha -->
    <div class="campo-wrapper">
        <input type="password" name="senha" placeholder="Senha:" required minlength="8">
    </div>
    <div class="campo-wrapper">
        <input type="password" name="confirmar_senha" placeholder="Confirme a senha:" required>
    </div>
    
    <button name="cadastrar" type="submit" src="../templates/login.php" class="btn_cadastrar">Cadastrar</button>
</form>
        
        <p>Já tem uma conta? <a href="login.php">Faça login</a></p>
    </section>

    <!-- Scripts de formatação -->
    <script src="../JavaScript/formatarTelefone.js"></script>
    <script src="../JavaScript/formatarCPF.js"></script>
    <script src="../JavaScript/formatarCNPJ.js"></script>
    <script src="../JavaScript/formatarCEP.js"></script>
    <script src="../JavaScript/cadastro_forms.js"></script>
</body>
</html>