<?php 
require __DIR__ . '../../../../model/db.php';

$acao = isset($_GET['acao']) ? $_GET['acao'] : null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($acao === 'cadnoticias') {
        // Verifica se todos os campos necessários estão presentes
        if (isset($_POST['titulo'], $_POST['subtitulo'], $_POST['corpo'], $_FILES['imagem'])) {
            // Filtra os dados e atribui a variáveis
            $titulo = htmlspecialchars($_POST['titulo']);
            $subtitulo = htmlspecialchars($_POST['subtitulo']);
            $corpo = htmlspecialchars($_POST['corpo']);
            $imagem = $_FILES['imagem'];
            $categorias = isset($_POST['categorias']) ? explode(';', $_POST['categorias']) : [];
            $tags = isset($_POST['tags']) ? explode(';', $_POST['tags']) : [];

            // Processamento da imagem
            $targetDir = "uploads/"; // Diretório onde as imagens serão salvas
            $targetFile = $targetDir . basename($imagem["name"]);

            // Move o arquivo para o diretório de upload
            if (!move_uploaded_file($imagem["tmp_name"], $targetFile)) {
                echo "Erro ao carregar a imagem.";
                exit();
            }

            // Inserindo dados da notícia no banco de dados
            try {
                $pdo = DB::getConnection();
                
                // Inserir dados da notícia
                $sql = "INSERT INTO noticias (titulo, subtitulo, corpo, imagem) VALUES (:titulo, :subtitulo, :corpo, :imagem)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    'titulo' => $titulo,
                    'subtitulo' => $subtitulo,
                    'corpo' => $corpo,
                    'imagem' => $targetFile
                ]);

                // Obter o ID da notícia inserida
                $noticiaId = $pdo->lastInsertId();

                // Função para adicionar categorias e tags
                function adicionarCategoriasETags($items, $tipo) {
                    global $pdo, $noticiaId;
                    foreach ($items as $item) {
                        $item = trim($item);
                        if (!empty($item)) {
                            // Verifica se a categoria ou tag já existe
                            $sql = "INSERT IGNORE INTO {$tipo} (nome) VALUES (:nome)";
                            $stmt = $pdo->prepare($sql);
                            $stmt->execute(['nome' => $item]);

                            // Obtém o ID da categoria ou tag
                            $sql = "SELECT id FROM {$tipo} WHERE nome = :nome";
                            $stmt = $pdo->prepare($sql);
                            $stmt->execute(['nome' => $item]);
                            $id = $stmt->fetchColumn();

                            // Insere na tabela de relacionamento
                            $sql = "INSERT INTO noticia_{$tipo} (noticia_id, {$tipo}_id) VALUES (:noticia_id, :tipo_id)";
                            $stmt = $pdo->prepare($sql);
                            $stmt->execute(['noticia_id' => $noticiaId, 'tipo_id' => $id]);
                        }
                    }
                }

                // Adiciona categorias e tags
                adicionarCategoriasETags($categorias, 'categorias');
                adicionarCategoriasETags($tags, 'tags');

                echo "Notícia cadastrada com sucesso!";
            } catch (PDOException $e) {
                echo "Erro ao cadastrar notícia: " . $e->getMessage();
            }
        } else {
            echo "Todos os campos são obrigatórios!";
        }
    }
}
?>
<form action="?acao=cadnoticias" method="post" enctype="multipart/form-data">
    <div>
        <label for="titulo">Título:</label>
        <input type="text" name="titulo" id="titulo" required>
    </div>
    <div>
        <label for="subtitulo">Subtítulo:</label>
        <input type="text" name="subtitulo" id="subtitulo" required>
    </div>
    <div>
        <label for="corpo">Corpo:</label>
        <textarea name="corpo" id="corpo" required></textarea>
    </div>
    <div>
        <label for="categorias">Categorias (separadas por ";"):</label>
        <input type="text" name="categorias" id="categorias">
    </div>
    <div>
        <label for="tags">Tags (separadas por ";"):</label>
        <input type="text" name="tags" id="tags">
    </div>
    <div>
        <label for="imagem">Imagem Principal:</label>
        <input type="file" name="imagem" id="imagem" accept="image/*" required>
    </div>
    <div>
        <button type="submit">Enviar</button>
    </div>
</form>