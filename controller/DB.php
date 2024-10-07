<?php
require '../../model/db.php';

class DB {
    private static function getConnection() {
        return getConnection(); // Utiliza a função de conexão definida em db.php
    }

    // Função para criar um novo usuário
    public static function criarUsuario($nome, $email, $senha) {
        $pdo = self::getConnection();
        $senhaCriptografada = password_hash($senha, PASSWORD_DEFAULT); // Criptografa a senha
        $sql = "INSERT INTO users (name, email, password) VALUES (:nome, :email, :senha)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['nome' => $nome, 'email' => $email, 'senha' => $senhaCriptografada]);
        return $pdo->lastInsertId();
    }

    // Função para atualizar um usuário
    public static function atualizarUsuario($id, $nome, $email, $senha = null) {
        $pdo = self::getConnection();
        $sql = "UPDATE users SET name = :nome, email = :email" . ($senha ? ", password = :senha" : "") . " WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        
        $params = ['id' => $id, 'nome' => $nome, 'email' => $email];
        if ($senha) {
            $params['senha'] = password_hash($senha, PASSWORD_DEFAULT); // Criptografa a nova senha
        }
        
        $stmt->execute($params);
        return $stmt->rowCount();
    }

    // Função para deletar um usuário
    public static function deletarUsuario($id) {
        $pdo = self::getConnection();
        $sql = "DELETE FROM users WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->rowCount();
    }

    // Função para obter um usuário pelo ID
    public static function obterUsuarioPorId($id) {
        $pdo = self::getConnection();
        $sql = "SELECT * FROM users WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Função para obter todos os usuários
    public static function obterTodosOsUsuarios() {
        $pdo = self::getConnection();
        $sql = "SELECT * FROM users";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Função para verificar a senha
    public static function verificarSenha($senhaInformada, $senhaCriptografada) {
        return password_verify($senhaInformada, $senhaCriptografada);
    }
}
?>