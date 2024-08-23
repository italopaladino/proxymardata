<?php
require_once 'config.php';

try {
    $pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

    // Seleciona o ano e conta quantos registros existem para cada ano, considerando apenas um ponto de coleta por trabalhoid
    $sql = "
        SELECT EXTRACT(YEAR FROM data2) AS ano, COUNT(DISTINCT trabalhoid) AS quantidade 
        FROM pontos_coleta 
        GROUP BY ano 
        ORDER BY ano DESC
    ";
    $stm = $pdo->query($sql);
    $anoColetas = $stm->fetchAll(PDO::FETCH_ASSOC);

    // Monta a lista para o filtro
    $filtroHTML = "<ul>";
    foreach ($anoColetas as $anoColeta) {
        $ano = htmlspecialchars($anoColeta['ano']);
        $quantidade = htmlspecialchars($anoColeta['quantidade']);
        $filtroHTML .= "<li><a title='Filtrar pelo ano de Coleta' class='top-filtro' href='#' onclick='showAlert(); return false;'>" . $ano . " ($quantidade)</a></li>";
 // adicionar link para pesquisa dos anos
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
