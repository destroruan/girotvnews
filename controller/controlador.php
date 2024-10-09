<?php 
require 'functions.php';
$acao = isset($_GET['acao']) ? $_GET['acao'] : null;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($acao === 'cadastrar') {
        // Chama a função para criar a tabela 'users', caso não exista
        DB::criarTabelaUsuarios();

        // Verifica se todos os campos necessários estão presentes
        if (isset($_POST['nome'], $_POST['usuario'], $_POST['senha'], $_POST['email'], $_POST['nivel-acesso'], $_POST['programa'])) {
            // Filtra os dados e atribui a variáveis
            $nome = htmlspecialchars($_POST['nome']);
            $usuario = htmlspecialchars($_POST['usuario']);  // Agora estamos pegando o valor de 'usuario'
            $senha = $_POST['senha'];
            $email = htmlspecialchars($_POST['email']);
            $nivel_acesso = htmlspecialchars($_POST['nivel-acesso']);
            $programa = htmlspecialchars($_POST['programa']);

            DB::criarUsuario($nome, $usuario, $email, $senha, $nivel_acesso, $programa);
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['nome'];
            $_SESSION['user_nivel'] = $user['nivel_acesso'];
            $_SESSION['user_prog'] = $user['programa'];
            header("Location: ../portal.php");
        } else {
            echo "Todos os campos são obrigatórios!";
        }
    }
    if ($acao === 'criarPost') {

        $titulo = $_POST['titulo'];
        $autor = $_POST['autor'];
        $data = $_POST['data'];
        $categoria = $_POST['categoria'];
        $cidade = $_POST['cidade'];
        $resumo = $_POST['resumo'];
        $conteudo = $_POST['conteudo'];
        $palavras_chave = $_POST['palavras-chave'];
        $imagens = $_POST['imagens'];
        $referencias = $_POST['referencias'];

        $resultado = DB::inserirArtigo($conn, $titulo, $autor, $data, $categoria, $cidade, $resumo, $conteudo, $palavras_chave, $imagens, $referencias);

        if ($resultado) {
            echo "Artigo criado com sucesso!";
        } else {
            echo "Erro ao criar o artigo.";
        }

        $conn->close();
    }
}
?>