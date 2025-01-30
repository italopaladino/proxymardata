<?php
require_once 'config.php';

try {
    $pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

    // Seleciona o tipo de trabalho e conta quantos registros existem para cada tipo
    $sql = "SELECT tipoAmst AS tipoa, COUNT(*) AS quantidade FROM ferramentas GROUP BY tipoa";
    $stm = $pdo->query($sql);
    $tipostrabalho = $stm->fetchAll(PDO::FETCH_ASSOC);

    // Monta a lista HTML para os tipos de trabalho
    $filtroHTMLTIPO = "<ul class='filtro-tipo-amostra'>";
    foreach ($tipostrabalho as $tipoAmostra) { // Corrigido para $tipostrabalho
        $tipoAmst = htmlspecialchars($tipoAmostra['tipoa']);
        $quantidade = htmlspecialchars($tipoAmostra['quantidade']);
        
        if (!empty($tipoAmst)) { // Verifica se $tipo não está vazio
            $filtroHTMLTIPO .= "<li><a title='filtrar para o tipo de amostra' class='top-filtro' href='#' onclick='mostrarLoader()' data-tipo-amostra='" . $tipoAmst . "'>" . $tipoAmst . " (" . $quantidade . ")</a></li>";
        }
    }
    $filtroHTMLTIPO .= "</ul>";

    // Retorna a lista HTML
    echo $filtroHTMLTIPO;

} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
} finally {
    if (isset($pdo)) {
        $pdo = null;
    }
}
?>
