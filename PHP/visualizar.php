<?php
// Inclui a configuração do banco de dados
require_once 'config.php';

// Verifica se o ID foi passado via GET
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        // Conexão ao banco de dados usando PDO
        $pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

        // Prepara e executa a consulta SQL para obter o arquivo
        $sql = "SELECT nome_arquivo, conteudo FROM arquivos WHERE trabalhoID = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            // Obtém o nome do arquivo e o conteúdo
            $nome_arquivo = htmlspecialchars($row['nome_arquivo']);
            $conteudo = stream_get_contents($row['conteudo']);
            $arquivo_data = pg_unescape_bytea($conteudo); // Desescapa o bytea

            // Verifica a extensão do arquivo
            $extensao = strtolower(pathinfo($nome_arquivo, PATHINFO_EXTENSION));

            if ($extensao === 'txt') {
                // Processa como TXT
                $linhas = explode("\n", trim($arquivo_data));
                echo "<div class='tabela'><h2>Visualização da Tabela (TXT)</h2><table border='1'>";
                foreach ($linhas as $i => $linha) {
                    $colunas = explode("\t", trim($linha));
                    if (!empty(array_filter($colunas))) {
                        echo "<tr>";
                        foreach ($colunas as $coluna) {
                            echo $i == 0 ? "<th>" . htmlspecialchars($coluna) . "</th>" : "<td>" . htmlspecialchars($coluna) . "</td>";
                        }
                        echo "</tr>";
                    }
                }
                echo "</table></div>";
            } elseif ($extensao === 'csv') {
                // Processa como CSV
                $arquivo_data = str_replace(";", ",", $arquivo_data); // Ajusta separadores
                $linhas = explode("\n", trim($arquivo_data));
                echo "<div class='tabela'><h2>Visualização da Tabela (CSV)</h2><table border='1'>";
                foreach ($linhas as $i => $linha) {
                    $colunas = str_getcsv(trim($linha), ",");
                    if (!empty(array_filter($colunas))) {
                        echo "<tr>";
                        foreach ($colunas as $coluna) {
                            echo $i == 0 ? "<th>" . htmlspecialchars($coluna) . "</th>" : "<td>" . htmlspecialchars($coluna) . "</td>";
                        }
                        echo "</tr>";
                    }
                }
                echo "</table></div>";
            } else {
                echo "<p style='color: red; font-weight: bold;'>Formato de arquivo inválido</p>";
            }
        } else {
            echo "<p>Arquivo não encontrado.</p>";
        }
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
} else {
    echo "<p>Erro no ID do trabalho.</p>";
}
?>
