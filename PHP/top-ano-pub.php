<?php
require_once 'config.php';

try {
    $pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    // Seleciona o ano e conta quantos registros existem para cada ano
    $sql = "SELECT EXTRACT(YEAR FROM data1) AS ano, COUNT(*) AS quantidade FROM infogeral GROUP BY ano ORDER BY ano DESC";
    $stm = $pdo->query($sql);
    $anosPublicacao = $stm->fetchAll(PDO::FETCH_ASSOC);

    // Monta a lista de filtros
    $filtroHTML = "<ul class='filtro-ano-pub'>";
    foreach ($anosPublicacao as $anoPublicacao) {
        $ano = htmlspecialchars($anoPublicacao['ano']);
        $quantidade = htmlspecialchars($anoPublicacao['quantidade']);
        $filtroHTML .= "<li><a title='Filtrar pelo ano de Publicação' class='top-filtro' href='#' data-ano='" . $ano . "'>" . $ano . " ($quantidade)</a></li>";
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