<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <?php include 'view/assets/include/head.html'?>   
    <title>Ao vivo - GIRO TV News</title>
</head>
<body>
    <header id="cabeca"></header>
    <main>
        <section class="sombra">
            <menu></menu>                
        </section>
        <section id="ultimas-noticias" class="sombra">
            <div class="flex center">
                <div><i class="fa-solid fa-newspaper"></i></div>
                <h1 style="text-transform: uppercase; margin-left: 5px;">últimas notícias</h1>                
                <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Iure, ducimus eius beatae ipsa deleniti maxime, eaque non doloremque atque quaerat accusantium nesciunt vitae? Eum illum sapiente, repellendus laboriosam corporis ullam!</p>
                <i class="fa-solid fa-backward-step" id="prev" onclick=""></i>
                <i class="fa-solid fa-forward-step" id="next" onclick=""></i>
            </div>                        
        </section>
        <section>
            <div class="flex center" style="margin: auto;">
                <div>
                    <iframe src="https://gerador.livecenter.host/player.html?data=U2FsdGVkX1%2BG7b93h8I%2B4976MuZOfCgb01IS6z5TkO9bkjQcVKU5sQlQ0iLPrs1DV2CpjF2vCl0YGzV5uwOGFHr5K%2F8m1Yhvj57YXiD%2FWtY%3D" frameborder="0" id="tv-online" autoplay></iframe>
                </div>
            </div>
        </section>
        <section>
            <div id="publicidade-top">
                <div class="flex center" style="margin: auto;">
                    <h1 style="text-transform: uppercase; font-size: 10px; margin-bottom: 10px; color: var(--cor-cinza-escuro);">publicidade</h1>
                </div>
                <div class="flex center" style="margin: auto;">
                    <img src="view/assets/img/publicidade/foto.jpg" alt="publicidade">
                </div>
            </div>
        </section>
    </main>
    <footer id="rodape"></footer>
    <script src="controller/js/controle.js"></script>
</body>
</html>