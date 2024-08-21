<?php
require_once 'config.php';

try {
    $pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

    $resultadosHTML = "";
    if (isset($_GET['tipo'])) {
        $tipo = $_GET['tipo'];

        // Verifica se o valor de tipo não está vazio
        if (empty($tipo)) {
            echo "<p>Parâmetro 'tipo' não especificado.</p>";
            exit;
        }

        // Prepara e executa a consulta SQL com o tipo fornecido
        $sql = "SELECT * FROM infogeral WHERE tipotrabalho = :tipo";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':tipo', $tipo, PDO::PARAM_STR);
        $stmt->execute();
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Verifica se há resultados
        if ($resultados) {
            $resultadosHTML = "<div class='resultados'>";
            foreach ($resultados as $resultado) {
                $resultadosHTML .= "<a class='link-pesq' href='../HTML/resultados.php?id=" . htmlspecialchars($resultado['geralid']) . "'>" . htmlspecialchars($resultado['referencia']) . "</a><br><br>";
            }
            $resultadosHTML .= "</div>";
        } else {
            $resultadosHTML = "<p>Não foram encontrados registros para o tipo de trabalho: " . htmlspecialchars($tipo) . "</p>";
        }
    } else {
        $resultadosHTML = "<p>Parâmetro 'tipo' não especificado.</p>";
    }

    echo $resultadosHTML;

} catch (PDOException $e) {
    echo "<p>Erro: " . htmlspecialchars($e->getMessage()) . "</p>";
} finally {
    if (isset($pdo)) {
        $pdo = null;
    }
}
?>
