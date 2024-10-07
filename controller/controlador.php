<?php 
require 'DB.php';
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
            header("Location: ../portal.php");
        } else {
            echo "Todos os campos são obrigatórios!";
        }
    }
}
?>