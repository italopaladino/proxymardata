<?php
    require_once 'config.php';

    try {
        $pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

        // Seleciona o tipo de trabalho e conta quantos registros existem para cada tipo
        $sql = "SELECT tituloprinc AS projeto, COUNT(*) AS quantidade FROM infogeral WHERE tituloprinc IS NOT NULL GROUP BY tituloprinc;";

        $stm = $pdo->query($sql);

        $projetos = $stm->fetchAll(PDO::FETCH_ASSOC);

        // Monta a lista HTML para os tipos de trabalho
        $filtroHTMLTIPO = "<ul class='filtro-projeto'>";
        foreach ($projetos as $projeto) {
            $nomeProjeto = htmlspecialchars($projeto['projeto']);
            $quantidade = htmlspecialchars($projeto['quantidade']);
            if (!empty($nomeProjeto)) {
                $filtroHTMLTIPO .= "<li><p class='lead'><a id='top-tipo' title='Filtrar pelo titulo do projeto' class='top-filtro' href='#' data-projeto='" 
                . $nomeProjeto . "' onclick='mostrarLoader()'>" . $nomeProjeto . " (" . $quantidade . ")</a></p></li>";
            }
        }
        $filtroHTMLTIPO .= "</ul>";
        
        echo $filtroHTMLTIPO;

    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    } finally {
        if (isset($pdo)) {
            $pdo = null;
        }
    }
?>
