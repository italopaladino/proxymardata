<?php
require_once 'config.php';

try {
    $pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

    // Seleciona as colunas booleanas e conta quantos registros existem para cada coluna onde o valor é TRUE
    $sql = "
        SELECT 'assos' AS coluna, COUNT(*) AS quantidade FROM ferramentas WHERE assos = TRUE
        UNION ALL
        SELECT 'batmet' AS coluna, COUNT(*) AS quantidade FROM ferramentas WHERE batmet = TRUE
        UNION ALL
        SELECT 'bioOrg' AS coluna, COUNT(*) AS quantidade FROM ferramentas WHERE bioOrg = TRUE
        UNION ALL
        SELECT 'cocolit' AS coluna, COUNT(*) AS quantidade FROM ferramentas WHERE cocolit = TRUE
        UNION ALL
        SELECT 'estrat' AS coluna, COUNT(*) AS quantidade FROM ferramentas WHERE estrat = TRUE
        UNION ALL
        SELECT 'foramplan' AS coluna, COUNT(*) AS quantidade FROM ferramentas WHERE foramplan = TRUE
        UNION ALL
        SELECT 'forambent' AS coluna, COUNT(*) AS quantidade FROM ferramentas WHERE forambent = TRUE
        UNION ALL
        SELECT 'granl' AS coluna, COUNT(*) AS quantidade FROM ferramentas WHERE granl = TRUE
        UNION ALL
        SELECT 'hidrod' AS coluna, COUNT(*) AS quantidade FROM ferramentas WHERE hidrod = TRUE
        UNION ALL
        SELECT 'hidrog' AS coluna, COUNT(*) AS quantidade FROM ferramentas WHERE hidrog = TRUE
        UNION ALL
        SELECT 'matorg' AS coluna, COUNT(*) AS quantidade FROM ferramentas WHERE matorg = TRUE
        UNION ALL
        SELECT 'metais' AS coluna, COUNT(*) AS quantidade FROM ferramentas WHERE metais = TRUE
        UNION ALL
        SELECT 'microps' AS coluna, COUNT(*) AS quantidade FROM ferramentas WHERE microps = TRUE
        UNION ALL
        SELECT 'ageMod' AS coluna, COUNT(*) AS quantidade FROM ferramentas WHERE ageMod = TRUE
        UNION ALL
        SELECT 'proFisi' AS coluna, COUNT(*) AS quantidade FROM ferramentas WHERE proFisi = TRUE
        UNION ALL
        SELECT 'radioist' AS coluna, COUNT(*) AS quantidade FROM ferramentas WHERE radioist = TRUE
        UNION ALL
        SELECT 'razIsot' AS coluna, COUNT(*) AS quantidade FROM ferramentas WHERE razIsot = TRUE
        UNION ALL
        SELECT 'smodNum' AS coluna, COUNT(*) AS quantidade FROM ferramentas WHERE smodNUm = TRUE
        UNION ALL
        SELECT 'teorAg' AS coluna, COUNT(*) AS quantidade FROM ferramentas WHERE teorAg = TRUE
        UNION ALL
       SELECT outroFerr AS coluna, COUNT(*) AS quantidade FROM ferramentas WHERE outroFerr IS NOT NULL AND outroFerr <> '' GROUP BY outroFerr
    ";
    $stm = $pdo->query($sql);
    $resultados = $stm->fetchAll(PDO::FETCH_ASSOC);

    // Mapeia os nomes das colunas para os nomes desejados
    $nomesColunas = [
        'assos' => 'Associação',
        'batmet' => 'Batimetria',
        'bioOrg' => 'Biomarcadores Orgânicos',
        'cocolit' => 'Cocolitoforídeos',
        'estrat' => 'Estratigrafia',
        'foramplan' => 'Foraminífero Planctônico',
        'forambent' => 'Foraminífero Bentônico',
        'granl' => 'Granulometria',
        'hidrod' => 'Hidrodinâmica',
        'hidrog' => 'Hidrografia',
        'matorg' => 'Matéria Orgânica',
        'metais' => 'metais',
        'microps'=> 'Microplásticos',
        'ageMod' => 'Modelos de Idade',
        'proFisi' => 'Propriedades Físicas',
        'radioist' => 'Radioisótopos',
        'razIsot' => 'Razões Isotópicas',
        'smodNum' => 'Saída de modelo numérico',
        'teorAg' => 'Teor de Água'
        
    ];

    // Monta a lista
    $filtroHTML = "<ul class='filtro-ferra'>";
    foreach ($resultados as $resultado) {
        $coluna = htmlspecialchars($resultado['coluna']);
        $quantidade = htmlspecialchars($resultado['quantidade']);
        if ($quantidade > 0) {
            $nome = isset($nomesColunas[$coluna]) ? htmlspecialchars($nomesColunas[$coluna]) : htmlspecialchars($coluna);
            $filtroHTML .= "<li><a title='filtrar pela ferramenta escolhido' class='top-filtro' href='#' onclick='mostrarLoader()' data-ferram ='". $coluna ."' >" . $nome . "($quantidade)</a></li>";
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
