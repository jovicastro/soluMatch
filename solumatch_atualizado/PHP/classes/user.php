<?php
// solumatch_atualizado/PHP/classes/User.php

// Inclua a classe Database, pois User.php vai utilizá-la para a conexão mysqli.
require_once __DIR__ . '/database.php';

class User {
    private $dbConnection; // Agora usaremos a conexão mysqli

    public function __construct(mysqli $dbConnection) {
        $this->dbConnection = $dbConnection;
    }

    /**
     * Encontra um usuário pelo e-mail ou número de telefone.
     * @param string $login O e-mail ou número de telefone do usuário.
     * @return array|null Retorna os dados do usuário ou null se não encontrado.
     */
    public function findUserByLogin($login) {
        // Verifica se é e-mail ou número de telefone para selecionar o campo correto
        $campo = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'numero';
        
        $stmt = $this->dbConnection->prepare("SELECT id, email, senha_hash, reset_token, reset_token_expiry FROM usuarios WHERE $campo = ?");
        if ($stmt === false) {
            error_log("Erro na preparação da consulta de usuário: " . $this->dbConnection->error);
            return null;
        }
        $stmt->bind_param("s", $login);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();
        return $user;
    }

    /**
     * Gera e salva um token de recuperação de senha para um usuário.
     * @param int $userId O ID do usuário.
     * @return string O token gerado.
     */
    public function generateResetToken($userId) {
        $token = bin2hex(random_bytes(32)); // Gerar um token único e aleatório (64 caracteres hexadecimais)
        $expiry = date('Y-m-d H:i:s', strtotime('+1 hour')); // Token expira em 1 hora

        $stmt = $this->dbConnection->prepare("UPDATE usuarios SET reset_token = ?, reset_token_expiry = ? WHERE id = ?");
        if ($stmt === false) {
            error_log("Erro na preparação da atualização do token: " . $this->dbConnection->error);
            return false;
        }
        $stmt->bind_param("ssi", $token, $expiry, $userId);
        $success = $stmt->execute();
        $stmt->close();

        return $success ? $token : false;
    }

    /**
     * Valida um token de recuperação de senha.
     * @param string $token O token a ser validado.
     * @return array|null Retorna os dados do usuário se o token for válido e não expirado, ou null.
     */
    public function validateResetToken($token) {
        $currentTime = date('Y-m-d H:i:s');
        $stmt = $this->dbConnection->prepare("SELECT id, email FROM usuarios WHERE reset_token = ? AND reset_token_expiry > ?");
        if ($stmt === false) {
            error_log("Erro na preparação da validação do token: " . $this->dbConnection->error);
            return null;
        }
        $stmt->bind_param("ss", $token, $currentTime);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();
        return $user;
    }

    /**
     * Redefine a senha de um usuário e invalida o token de recuperação.
     * @param int $userId O ID do usuário.
     * @param string $newPassword A nova senha (será hashed).
     * @return bool True em caso de sucesso, false caso contrário.
     */
    public function resetPassword($userId, $newPassword) {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        // Invalida o token definindo-o como NULL e a expiração no passado
        $stmt = $this->dbConnection->prepare("UPDATE usuarios SET senha_hash = ?, reset_token = NULL, reset_token_expiry = NULL WHERE id = ?");
        if ($stmt === false) {
            error_log("Erro na preparação da redefinição de senha: " . $this->dbConnection->error);
            return false;
        }
        $stmt->bind_param("si", $hashedPassword, $userId);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    // O método registerUser não é estritamente necessário aqui se você já tiver
    // um fluxo de registro usando PDO no cadastro.php.
    // Mantenho-o apenas como exemplo caso precise de registro via mysqli.
    /*
    public function registerUser($nome, $email, $numero, $endereco, $cep, $CPF, $CNPJ, $senha) {
        $hashedPassword = password_hash($senha, PASSWORD_DEFAULT);
        $stmt = $this->dbConnection->prepare("INSERT INTO usuarios (nome, email, numero, endereco, cep, CPF, CNPJ, senha_hash) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        if ($stmt === false) {
            error_log("Erro na preparação do registro de usuário: " . $this->dbConnection->error);
            return false;
        }
        $stmt->bind_param("ssssssss", $nome, $email, $numero, $endereco, $cep, $CPF, $CNPJ, $hashedPassword);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }
    */
}