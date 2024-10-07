<?php 
    session_start();
    $id = $_SESSION['user_id'];
    $nome = $_SESSION['user_name'];
    $nivel = $_SESSION['user_nivel'];
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <?php include 'view/assets/include/head.html'?>   
    <title>Portal - GIRO TV News</title>
</head>
<body>
    <div id="desktop" class="flex center">
        <div id="aba-left"><a href="portal.php"><img src="view/assets/img/logotipo.png" alt="logotipo"></a></div>
        <div id="aba-right">
            <div id="nomeusuario" class="flex right">
                <p><?php echo $nivel . " | " . $nome?></p>
                <a href="" title="Sair"><i class="fa-solid fa-right-from-bracket"></i></a>
            </div>
        </div>
    </div>    
</body>
</html>