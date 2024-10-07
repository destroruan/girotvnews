<?php
session_start();
require 'DB.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = $_POST['usuario'];
    $senha = $_POST['senha'];
   
    $user = DB::verificarLogin($usuario, $senha);

    if ($user) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['nome'];
        $_SESSION['user_nivel'] = $user['nivel_acesso'];
        
        header("Location: ../portal.php");
        exit();
    } else {
        // Usuário ou senha incorretos, redireciona de volta com um erro
        $_SESSION['login_error'] = "Usuário ou senha incorretos!";
        header("Location: ../../view/assets/include/forms/login.html");  // Utilize PHP para poder mostrar o erro
        exit();  // Certifique-se de parar a execução após o redirecionamento
    }
}
?>