<?php
// Inclui o arquivo de configuração do banco de dados
require_once 'config.php';

// Verifica se o ID foi passado como parâmetro via GET
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        // Conexão ao banco de dados usando PDO
        $pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

        // Prepara e executa a consulta SQL com o ID fornecido
        $sql = "SELECT nome_arquivo, conteudo FROM arquivos WHERE trabalhoID = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $nome_arquivo = htmlspecialchars($row['nome_arquivo']);
            $conteudo = stream_get_contents($row['conteudo']); // Converte o recurso em string

            // Definir os cabeçalhos para download do arquivo
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="' . $nome_arquivo . '"');
            header('Pragma: no-cache');
            header('Expires: 0');

            // Exibir o conteúdo do CSV
            echo pg_unescape_bytea($conteudo); // Desescapa o conteúdo do bytea
            exit;
        } else {
            echo "<script> alert (' Não tem arquivo disponível'); </script>";
        }
    } catch (PDOException $e) {
        echo "Erro ao conectar ao banco de dados: " . $e->getMessage();
    }
} else {
    echo "<script> alert ('erro no ID');</script>";
}

echo "<script>";
echo "setTimeout(function() {";
echo "    history.go(-1);";
echo "}, 20);"; // 3000 milissegundos = 3 segundos
echo "</script>";

exit;
?>

