<?php
require_once 'config.php';

try {
    $pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

    $resultadosHTML = "";
    if (isset($_GET['ano'])) {
        $ano = $_GET['ano'];
        
        // Verifica se o valor de ano é válido
        if (!is_numeric($ano)) {
            echo "<p>Parâmetro 'ano' inválido.</p>";
            exit;
        }

        // Prepara e executa a consulta SQL com o ano fornecido
        $sql = "SELECT * FROM infogeral WHERE EXTRACT(YEAR FROM data1) = :ano";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':ano', $ano, PDO::PARAM_INT);
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
            $resultadosHTML = "<p>Não foram encontrados registros para o ano: $ano</p>";
        }
    } else {
        $resultadosHTML = "<p>Parâmetro 'ano' não especificado.</p>";
    }

    echo $resultadosHTML;

} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
} finally {
    if ($pdo) {
        $pdo = null;
    }
}
?>
