<?php
// Código PHP que lida com a lógica
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Inclui o arquivo de configuração do banco de dados
    require_once 'config.php';

    try {
        // Conexão ao banco de dados usando PDO
        $pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

        // Prepara e executa a consulta
        $sql = "SELECT nome_arquivo FROM arquivos WHERE trabalhoID = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result && !empty($result['nome_arquivo'])) {
            $nome_arquivo = $result['nome_arquivo'];
            $caminho_arquivo = '../path/to/csv/' . $nome_arquivo;

            if (file_exists($caminho_arquivo)) {
                if (($handle = fopen($caminho_arquivo, "r")) !== FALSE) {
                    $csv_data = [];
                    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                        $csv_data[] = $data;
                    }
                    fclose($handle);
                } else {
                    $csv_data = "Não foi possível abrir o arquivo CSV.";
                }
            } else {
                $csv_data = "Arquivo CSV não encontrado.";
            }
        } else {
            $csv_data = "Nenhum arquivo CSV encontrado para o ID fornecido.";
        }
    } catch (PDOException $e) {
        $csv_data = "Erro ao conectar ao banco de dados: " . htmlspecialchars($e->getMessage());
    } finally {
        $pdo = null;
    }
} else {
    $csv_data = "ID não fornecido.";
}
?>

