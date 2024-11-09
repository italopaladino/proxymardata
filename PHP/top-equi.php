<?php
require_once 'config.php';

try {
    $pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

    // Seleciona as colunas booleanas e conta quantos registros existem para cada coluna onde o valor é TRUE
    $sql = "
SELECT 'piston' AS coluna, COUNT(*) AS quantidade FROM equipcoleta WHERE piston = TRUE
UNION ALL
SELECT 'gravcorer' AS coluna, COUNT(*) AS quantidade FROM equipcoleta WHERE gravcorer = TRUE
UNION ALL
SELECT 'drilli' AS coluna, COUNT(*) AS quantidade FROM equipcoleta WHERE drilli = TRUE
UNION ALL
SELECT 'gboxcorer' AS coluna, COUNT(*) AS quantidade FROM equipcoleta WHERE gboxcorer = TRUE
UNION ALL
SELECT 'boxcorer' AS coluna, COUNT(*) AS quantidade FROM equipcoleta WHERE boxcorer = TRUE
UNION ALL
SELECT 'ADCP' AS coluna, COUNT(*) AS quantidade FROM equipcoleta WHERE ADCP = TRUE
UNION ALL
SELECT 'corrt' AS coluna, COUNT(*) AS quantidade FROM equipcoleta WHERE corrt = TRUE
UNION ALL
SELECT 'CTD' AS coluna, COUNT(*) AS quantidade FROM equipcoleta WHERE CTD = TRUE
UNION ALL
SELECT 'modNum' AS coluna, COUNT(*) AS quantidade FROM equipcoleta WHERE modNum = TRUE
UNION ALL
SELECT 'multcor' AS coluna, COUNT(*) AS quantidade FROM equipcoleta WHERE multcor = TRUE
UNION ALL
SELECT 'multB' AS coluna, COUNT(*) AS quantidade FROM equipcoleta WHERE multB = TRUE
UNION ALL

SELECT 'stl' AS coluna, COUNT(*) AS quantidade FROM equipcoleta WHERE stl = TRUE
UNION ALL
SELECT 'senscbio' AS coluna, COUNT(*) AS quantidade FROM equipcoleta WHERE senscbio = TRUE
UNION ALL
SELECT 'sidSc' AS coluna, COUNT(*) AS quantidade FROM equipcoleta WHERE sidSc = TRUE
UNION ALL
SELECT 'vanv' AS coluna, COUNT(*) AS quantidade FROM equipcoleta WHERE vanv = TRUE
UNION ALL

SELECT outroequi AS coluna, COUNT(*) AS quantidade FROM equipcoleta WHERE outroequi IS NOT NULL AND outroequi <> '' GROUP BY outroequi
";



    $stm = $pdo->query($sql);
    $resultados = $stm->fetchAll(PDO::FETCH_ASSOC);

    // Mapeia os nomes das colunas para os nomes desejados
    $nomesColunas = [
        'piston' => 'Piston',
        'gravcorer' => 'Gravity Corer',
        'drilli' => 'Drilling device',
        'gboxcorer' => 'Giant box corer',
        'boxcorer' => 'Box corer',
        'ADCP' => 'ADCP',
        'corrt' => 'Correntômetro',
        'modNum' => 'Modelo numérico',
        'multcor' => 'Multipre Corer',
        'multB' => 'Multibean',
        'stl' => 'Satélite',
        'senscbio' => 'Sensores bio-óptcos',
        'sidSc' => 'Side-scan Sonar',
        'vanv' => 'Van-Veen'

        
        ];

    // Monta a lista
    $filtroHTML = "<ul>";
    foreach ($resultados as $resultado) {
        $coluna = htmlspecialchars($resultado['coluna']);
        $quantidade = htmlspecialchars($resultado['quantidade']);
        if ($quantidade > 0) {
            $nome = isset($nomesColunas[$coluna]) ? htmlspecialchars($nomesColunas[$coluna]) : htmlspecialchars($coluna);
            $filtroHTML .= "<li><a title='Filtrar pelo tipo de equipamento utilizado para coleta' class='top-filtro' href='#' onclick='showAlert(); return false;'>" . $nome . "($quantidade)</a></li>";
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