<?php
require_once 'config.php';

try {
    $pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

    // Seleciona o ID e conta quantos registros existem para cada ID
    $sql = "SELECT 
                ID, 
                COUNT(*) AS quantidade
            FROM (
                -- Parte para pegar os registros da tabela areaP
                SELECT 
                    areaP.ID_amstAREA AS ID
                FROM 
                    areaP
                WHERE 
                    areaP.ID_amstAREA IS NOT NULL

                UNION ALL

                -- Parte para pegar os registros da tabela pontos_coleta
                SELECT 
                    pontos_coleta.id_amst AS ID
                FROM 
                    pontos_coleta
                WHERE 
                    pontos_coleta.id_amst IS NOT NULL
            ) AS combined
            GROUP BY 
                ID;";

    $stm = $pdo->query($sql);
    $tipostrabalho = $stm->fetchAll(PDO::FETCH_ASSOC);

    // Monta a lista HTML para os IDs
    $filtroHTMLTIPO = "<ul class='filtro-ID'>";
    foreach ($tipostrabalho as $tipoAmostra) {
        $ID = htmlspecialchars($tipoAmostra['id']);
        $quantidade = htmlspecialchars($tipoAmostra['quantidade']);
        
        if (!empty($ID)) { // Verifica se $ID não está vazio
            $filtroHTMLTIPO .= "<li><a title='filtrar pelo ID da amostra' class='top-filtro' href='#' onclick='mostrarLoader()' data-id='" . $ID . "'>" . $ID . " (" . $quantidade . ")</a></li>";
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