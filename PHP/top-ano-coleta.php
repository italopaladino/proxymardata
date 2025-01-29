<?php
require_once 'config.php';

try {
    $pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

    // Consulta combinada usando UNION para unir os anos das duas tabelas
    $sql = "
        SELECT ano, SUM(quantidade) AS quantidade_total
        FROM (
            SELECT EXTRACT(YEAR FROM data2) AS ano, COUNT(DISTINCT trabalhoid) AS quantidade
            FROM pontos_coleta
            GROUP BY ano
            UNION ALL
            SELECT EXTRACT(YEAR FROM dataAREA) AS ano, COUNT(DISTINCT trabalhoid) AS quantidade
            FROM areaP
            GROUP BY ano
        ) AS anos_combinados
        GROUP BY ano
        ORDER BY ano DESC
    ";

    $stm = $pdo->query($sql);
    $anos = $stm->fetchAll(PDO::FETCH_ASSOC);

    // Monta a lista para o filtro
    $filtroHTML = "<ul class='filtro-ano-coleta'>";
    foreach ($anos as $ano) {
        $ano_valor = htmlspecialchars($ano['ano']);
        $quantidade = htmlspecialchars($ano['quantidade_total']);
        $filtroHTML .= "<li><a title='Filtrar pelo ano' class='top-filtro' href='?ano_valor=" . urldecode($ano_valor) . "' data-ano='" . $ano_valor . "' onclick='mostrarLoader()'>" . $ano_valor. "(" .($quantidade). ") </a></li>";
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