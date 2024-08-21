<?php
require_once 'config.php';

try {
    $pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

    // Seleciona as colunas booleanas e conta quantos registros existem para cada coluna onde o valor é TRUE
    $sql = "
     SELECT 'multcorer' AS coluna, COUNT(*) AS quantidade FROM equipcoleta WHERE multcorer = TRUE
UNION ALL
SELECT 'piston' AS coluna, COUNT(*) AS quantidade FROM equipcoleta WHERE piston = TRUE
UNION ALL
SELECT 'gravcorer' AS coluna, COUNT(*) AS quantidade FROM equipcoleta WHERE gravcorer = TRUE
UNION ALL
SELECT 'drilli' AS coluna, COUNT(*) AS quantidade FROM equipcoleta WHERE drilli = TRUE
UNION ALL
SELECT 'gboxcorer' AS coluna, COUNT(*) AS quantidade FROM equipcoleta WHERE gboxcorer = TRUE
UNION ALL
SELECT 'compcorer' AS coluna, COUNT(*) AS quantidade FROM equipcoleta WHERE compcorer = TRUE
UNION ALL
SELECT 'boxcorer' AS coluna, COUNT(*) AS quantidade FROM equipcoleta WHERE boxcorer = TRUE
UNION ALL
SELECT 'corer' AS coluna, COUNT(*) AS quantidade FROM equipcoleta WHERE corer = TRUE
UNION ALL

SELECT outroequi AS coluna, COUNT(*) AS quantidade FROM equipcoleta WHERE outroequi IS NOT NULL AND outroequi <> '' GROUP BY outroequi
";



    $stm = $pdo->query($sql);
    $resultados = $stm->fetchAll(PDO::FETCH_ASSOC);

    // Mapeia os nomes das colunas para os nomes desejados
    $nomesColunas = [
        'multcorer' => 'MultiCorer',
        'piston' => 'Piston',
        'gravcorer' => 'Gravity Corer',
        'drilli' => 'Drilling',
        'gboxcorer' => 'Giant box corer',
        'compcorer' => 'Composite Corer',
        'boxcorer' => 'Box Corer',
        
        ];

    // Monta a lista
    $filtroHTML = "<ul>";
    foreach ($resultados as $resultado) {
        $coluna = htmlspecialchars($resultado['coluna']);
        $quantidade = htmlspecialchars($resultado['quantidade']);
        if ($quantidade > 0) {
            $nome = isset($nomesColunas[$coluna]) ? htmlspecialchars($nomesColunas[$coluna]) : htmlspecialchars($coluna);
            $filtroHTML .= "<li><a href='detalhe.php?prox=" .$nome. "'>" . $nome . "($quantidade)</a></li>";
        }
    }
    $filtroHTML .= "</ul>";

    // Retorna a lista HTML
    echo $filtroHTML;

} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
} finally {
    if ($pdo) {
        $pdo = null;
    }
}
?>