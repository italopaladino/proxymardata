<?php
// Inclua o arquivo de configuração do banco de dados
require_once 'config.php';

// Verifica se o parâmetro 'id' foi passado via GET
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        // Conexão ao banco de dados usando PDO
        $pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

        // Prepara e executa a consulta SQL com o ID fornecido
        $sql = "SELECT * FROM infogeral WHERE geralid = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $infogeral = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verifica se há resultados
        if ($infogeral) {
            // Exibe os detalhes na página resultados.html
            echo "<div class='container'>";
            echo "<h2>Detalhes do Item ID: $id</h2>";
            echo "<p>Correspondente: " . htmlspecialchars($infogeral['correspondente']) . "</p>";
            echo "<p>Título: " . htmlspecialchars($infogeral['titulo']) . "</p>";
            echo "<p>Publicado em: " . htmlspecialchars($infogeral['periodico']) . "</p>";
            // Adicione os outros campos conforme necessário
            echo "</div>";
        } else {
            echo "<p>Não foram encontrados registros com o ID: $id</p>";
        }

    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    } finally {
        // Fecha a conexão com o banco de dados
        if ($pdo) {
            $pdo = null;
        }
    }
} else {
    echo "<p>ID não especificado.</p>";
}
?>
