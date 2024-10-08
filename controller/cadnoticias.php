<?php
require 'functions.php';
session_start();
$id = $_SESSION['user_id'];
$nome = $_SESSION['user_name'];
$nivel = $_SESSION['user_nivel'];
$programa = $_SESSION['user_prog'];
DB::criarTabelasPadrao();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário de Criação de Artigo</title>
    <link rel="stylesheet" href="style.css"> <!-- Adicione o link para o seu CSS -->
</head>
<body>
    <h1>Criar Artigo</h1>
    <div class="form-container">
        <form action="processar_artigo.php" method="post">
            <label for="titulo">Título do Artigo:</label>
            <input type="text" id="titulo" name="titulo" required>

            <label for="autor">Autor:</label>
            <input type="text" id="autor" name="autor" value="<?php echo htmlspecialchars($nome); ?>" readonly>

            <label for="data">Data de Publicação:</label>
            <input type="date" id="data" name="data" required>

            <label for="categoria">Categoria:</label>
            <select id="categoria" name="categoria" required>
                <?php
                    $condicao = " * FROM categorias";
                    DB::trazerOptions($condicao);
                ?>
            </select>

            <label for="cidade">Cidade:</label>
            <select id="cidade" name="cidade" required>
                <?php
                    $condicao = " * FROM cidades";
                    DB::trazerOptions($condicao);
                ?>
            </select>

            <label for="resumo">Resumo do Artigo:</label>
            <textarea id="resumo" name="resumo" rows="4" required></textarea>

            <label for="conteudo">Conteúdo do Artigo:</label>
            <textarea id="conteudo" name="conteudo" rows="8" required></textarea>

            <label for="palavras-chave">Palavras-chave:</label>
            <input type="text" id="palavras-chave" name="palavras-chave" required>

            <label for="imagens">Imagens (URLs):</label>
            <input type="text" id="imagens" name="imagens">

            <label for="referencias">Referências:</label>
            <textarea id="referencias" name="referencias" rows="4"></textarea>

            <button type="submit">Criar Artigo</button>
        </form>
    </div>
</body>
</html>