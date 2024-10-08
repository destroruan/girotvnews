<?php
require_once '../model/db.php';

class DB {
    // Função para obter a conexão com o banco de dados
    private static function getConnection() {
        return getConnection(); // Supondo que você tenha uma função getConnection em db.php
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
            'nome' => 'VARCHAR(255) NOT NULL',
            'usuario' => 'VARCHAR(255) NOT NULL',
            'email' => 'VARCHAR(255) UNIQUE NOT NULL',
            'senha' => 'VARCHAR(255) NOT NULL',
            'nivel_acesso' => 'VARCHAR(50) NOT NULL',
            'programa' => 'VARCHAR(255) NOT NULL',
            'created_at' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP'
        ];

        return self::criarTabela('users', $colunas);
    }

    public static function criarTabelasPadrao() {
        $colunas = [
            'id' => 'INT AUTO_INCREMENT PRIMARY KEY',
            'nome' => 'VARCHAR(255) NOT NULL'
        ];
        self::criarTabela('categorias', $colunas);
        $colunas = [
            'id' => 'INT AUTO_INCREMENT PRIMARY KEY',
            'nome' => 'VARCHAR(255) NOT NULL'
        ];
        self::criarTabela('cidades', $colunas);
    }

    // Função para criar um novo usuário
    public static function criarUsuario($nome, $usuario, $email, $senha, $nivelAcesso, $programa) {
        try {
            $pdo = self::getConnection();
            $senhaCriptografada = password_hash($senha, PASSWORD_DEFAULT);

            $sql = "INSERT INTO users (nome, usuario, email, senha, nivel_acesso, programa) 
                    VALUES (:nome, :usuario, :email, :senha, :nivel_acesso, :programa)";
            
            $stmt = $pdo->prepare($sql);
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
        $pdo = self::getConnection();
        $sql = "SELECT * FROM users WHERE email = :usuario OR usuario = :usuario LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['usuario' => $usuario]);
        
        // Verifica se o usuário foi encontrado
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && self::verificarSenha($senha, $user['senha'])) {
            return $user;
        }
        return false; // Retorna false caso o login falhe
    }

    // Função para verificar a senha
    public static function verificarSenha($senhaInformada, $senhaCriptografada) {
        return password_verify($senhaInformada, $senhaCriptografada);
    }

    // Função para inserir um artigo
    public static function inserirArtigo($titulo, $autor, $data, $categoria, $cidade, $resumo, $conteudo, $palavras_chave, $imagens, $referencias) {
        $pdo = self::getConnection();
        $sql = "INSERT INTO artigos (titulo, autor, data, categoria_id, cidade_id, resumo, conteudo, palavras_chave, imagens, referencias) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$titulo, $autor, $data, $categoria, $cidade, $resumo, $conteudo, $palavras_chave, $imagens, $referencias]);
    }

    public static function trazerOptions($condicao) {
        $pdo = self::getConnection(); 
        $sql = "SELECT " . $condicao;
        $result = $pdo->query($sql);
    
        if ($result) {
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                echo "<option value='" . htmlspecialchars($row['id']) . "'>" . htmlspecialchars($row['nome']) . "</option>";
            }
        } else {
            echo "<option value=''>Nenhum resultado encontrado</option>";
        }
    }
}
?>