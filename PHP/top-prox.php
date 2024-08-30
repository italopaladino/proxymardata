<?php
require_once 'config.php';

try {
    $pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

    // Seleciona as colunas booleanas e conta quantos registros existem para cada coluna onde o valor é TRUE
    $sql = "
        SELECT 'TSM' AS coluna, COUNT(*) AS quantidade FROM proxys WHERE isot = TRUE
        UNION ALL
        SELECT 'PP' AS coluna, COUNT(*) AS quantidade FROM proxys WHERE PP = TRUE
        UNION ALL
        SELECT 'circulacao' AS coluna, COUNT(*) AS quantidade FROM proxys WHERE circulacao = TRUE
        UNION ALL
        SELECT 'org' AS coluna, COUNT(*) AS quantidade FROM proxys WHERE org = TRUE
        UNION ALL
        SELECT 'inorg' AS coluna, COUNT(*) AS quantidade FROM proxys WHERE inorg = TRUE
        UNION ALL
        SELECT 'foramplan' AS coluna, COUNT(*) AS quantidade FROM proxys WHERE foramplan = TRUE
        UNION ALL
        SELECT 'forambent' AS coluna, COUNT(*) AS quantidade FROM proxys WHERE forambent = TRUE
        UNION ALL
        SELECT 'seaLev' AS coluna, COUNT(*) AS quantidade FROM proxys WHERE seaLev = TRUE
        UNION ALL
        SELECT 'co2atm' AS coluna, COUNT(*) AS quantidade FROM proxys WHERE co2atm = TRUE
        UNION ALL
        SELECT 'cobveg' AS coluna, COUNT(*) AS quantidade FROM proxys WHERE cobveg = TRUE
        UNION ALL
        SELECT 'rainfall' AS coluna, COUNT(*) AS quantidade FROM proxys WHERE rainfall = TRUE
        UNION ALL
        SELECT 'stratg' AS coluna, COUNT(*) AS quantidade FROM proxys WHERE stratg = TRUE
        UNION ALL
       SELECT outroprox AS coluna, COUNT(*) AS quantidade FROM proxys WHERE outroprox IS NOT NULL AND outroprox <> '' GROUP BY outroprox
    ";
    $stm = $pdo->query($sql);
    $resultados = $stm->fetchAll(PDO::FETCH_ASSOC);

    // Mapeia os nomes das colunas para os nomes desejados
    $nomesColunas = [
        'isot' => 'Isótopos',
        'PP' => 'Produção Primária',
        'circulacao' => 'Circulação',
        'org' => 'Orgânico',
        'inorg' => 'Inorgânico',
        'foramplan' => 'Foraminífero Planctônico',
        'forambent' => 'Foraminífero Bentônico',
        'seaLev' => 'Nível do Mar',
        'co2atm' => 'CO2 Atmosférico',
        'cobveg' => 'Cobertura Vegetal',
        'rainfall' => 'Precipitação',
        'stratg' => 'Estratigrafia'
        
    ];

    // Monta a lista
    $filtroHTML = "<ul>";
    foreach ($resultados as $resultado) {
        $coluna = htmlspecialchars($resultado['coluna']);
        $quantidade = htmlspecialchars($resultado['quantidade']);
        if ($quantidade > 0) {
            $nome = isset($nomesColunas[$coluna]) ? htmlspecialchars($nomesColunas[$coluna]) : htmlspecialchars($coluna);
            $filtroHTML .= "<li><a title='filtrar pelo proxie escolhido' class='top-filtro' href='#' onclick='showAlert(); return false;' >" . $nome . "($quantidade)</a></li>";
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
