<?php
require_once '../model/db.php';

class DB {
    private static function getConnection() {
        return getConnection(); // Utiliza a função de conexão definida em db.php
    }

    // Função para criar uma tabela com base nos parâmetros fornecidos
    public static function criarTabela($nomeTabela, $colunas) {
        $pdo = self::getConnection();

        // Inicia a construção do SQL
        $sql = "CREATE TABLE IF NOT EXISTS {$nomeTabela} (";

        // Itera sobre o array de colunas e cria a definição de cada uma
        $colunasDefinidas = [];
        foreach ($colunas as $coluna => $tipo) {
            $colunasDefinidas[] = "{$coluna} {$tipo}";
        }

        // Junta as colunas e adiciona ao SQL
        $sql .= implode(', ', $colunasDefinidas) . ");";

        // Executa a query
        $stmt = $pdo->prepare($sql);
        return $stmt->execute();
    }

    // Função para criar a tabela 'users' se ela não existir
    public static function criarTabelaUsuarios() {
        $colunas = [
            'id' => 'INT AUTO_INCREMENT PRIMARY KEY',
            'nome' => 'VARCHAR(255) NOT NULL',        // Nome do usuário
            'usuario' => 'VARCHAR(255) NOT NULL',        // Nome do usuário
            'email' => 'VARCHAR(255) UNIQUE NOT NULL', // E-mail único
            'senha' => 'VARCHAR(255) NOT NULL',    // Senha criptografada
            'nivel_acesso' => 'VARCHAR(50) NOT NULL',  // Nível de acesso (exemplo: 'redator', 'editor', 'administrador')
            'programa' => 'VARCHAR(255) NOT NULL',    // Programa do usuário
            'created_at' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP' // Data de criação
        ];

        return self::criarTabela('users', $colunas);
    }

    // Função para criar um novo usuário
    public static function criarUsuario($nome, $usuario, $email, $senha, $nivelAcesso, $programa) {
        try {
            $pdo = self::getConnection();
            $senhaCriptografada = password_hash($senha, PASSWORD_DEFAULT); // Criptografa a senha
            
            $sql = "INSERT INTO users (nome, usuario, email, senha, nivel_acesso, programa) 
                    VALUES (:nome, :usuario, :email, :senha, :nivel_acesso, :programa)";
            
            $stmt = $pdo->prepare($sql);
            
            // Passando os valores para os placeholders (sem 'created_at')
            $stmt->execute([
                'nome' => $nome, 
                'usuario' => $usuario,
                'email' => $email, 
                'senha' => $senhaCriptografada,
                'nivel_acesso' => $nivelAcesso,
                'programa' => $programa
            ]);
            
            return $pdo->lastInsertId(); // Retorna o ID do último inserido
        } catch (PDOException $e) {
            // Se ocorrer um erro, redireciona para a página de cadastro
            header("Location: ../view/assets/include/forms/caduser.html");
            exit(); // Evita que o código continue após o redirecionamento
        }
    }

    // Função para verificar o login
    public static function verificarLogin($usuario, $senha) {
        // Busca o usuário por nome ou e-mail
        $pdo = self::getConnection();
        $sql = "SELECT * FROM users WHERE email = :usuario OR usuario = :usuario LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['usuario' => $usuario]);
        
        // Verifica se o usuário foi encontrado
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && self::verificarSenha($senha, $user['senha'])) {
            return $user;
        }
        // Retorna false caso o login falhe
        return false;
    }

    // Função para verificar a senha
    public static function verificarSenha($senhaInformada, $senhaCriptografada) {
        return password_verify($senhaInformada, $senhaCriptografada);
    }
}
?>