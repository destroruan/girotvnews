<?php 
    session_start();
    $id = $_SESSION['user_id'];
    $nome = $_SESSION['user_name'];
    $nivel = $_SESSION['user_nivel'];
    $programa = $_SESSION['user_prog'];
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <?php include 'view/assets/include/head.html'?>   
    <title>Portal - GIRO TV News</title>
</head>
<body id="painel">
    <div id="desktop" class="flextotal">
        <div id="aba-left">
            <a href="portal.php"><img src="view/assets/img/logotipo.png" alt="logotipo"></a>
            <a onclick="mostrarnopainel()" class="button"><i class="fa-solid fa-clipboard-list"></i> Publicar</a>
            <a onclick="mostrarnopainel()" class="button"><i class="fa-solid fa-clipboard-list"></i> Programação</a>
        </div>
        <div id="aba-right">
            <div id="nomeusuario" class="flextotal right">
                <p><?php echo $programa . " | " . $nivel . " | " . $nome?></p>
                <a href="" title="Sair"><i class="fa-solid fa-right-from-bracket"></i></a>
            </div>
            <section id="painel-do-usuario">
                <div id="postnoticias">
                    <h1>postagem de notícias - <?php echo $programa;?></h1>                    
                </div>
            </section>
        </div>
    </div>    
</body>
</html>