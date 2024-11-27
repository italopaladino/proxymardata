<?php
require_once 'config.php';

try {
    $pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

    // Seleciona o tipo de trabalho e conta quantos registros existem para cada tipo
    $sql = "SELECT 
    tipo, 
    COUNT(*) AS quantidade
FROM (
    -- Parte para pegar os registros da tabela areaP
    SELECT 
        areaP.ID_amstAREA AS tipo
    FROM 
        areaP
    WHERE 
        areaP.ID_amstAREA IS NOT NULL

    UNION ALL

    -- Parte para pegar os registros da tabela pontos_coleta
    SELECT 
        pontos_coleta.id_amst AS tipo
    FROM 
        pontos_coleta
    WHERE 
        pontos_coleta.id_amst IS NOT NULL
) AS combined
GROUP BY 
    tipo;

";
    $stm = $pdo->query($sql);
    $tipostrabalho = $stm->fetchAll(PDO::FETCH_ASSOC);

    // Monta a lista HTML para os tipos de trabalho
    $filtroHTMLTIPO = "<ul class='filtro-tipo-amostra'>";
    foreach ($tipostrabalho as $tipoAmostra) { // Corrigido para $tipostrabalho
        $tipo = htmlspecialchars($tipoAmostra['tipo']);
        $quantidade = htmlspecialchars($tipoAmostra['quantidade']);
        
        if (!empty($tipo)) { // Verifica se $tipo não está vazio
            $filtroHTMLTIPO .= "<li><a title='filtrar pelo Projeto' class='top-filtro' href='#' onclick='showAlert(); return false;' data-tipo-trabalho='" . $tipo . "'>" . $tipo . " (" . $quantidade . ")</a></li>";
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