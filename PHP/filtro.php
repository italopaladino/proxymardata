<?php
require_once 'config.php';

function formatarNome($nomeCompleto) {
    return mb_convert_case(mb_strtolower($nomeCompleto, 'UTF-8'), MB_CASE_TITLE, 'UTF-8');
}

function formatarData($data) {
    $dataSemMicrosegundos = preg_replace('/\.\d+$/', '', $data);
    $date = DateTime::createFromFormat('Y-m-d H:i:s', $dataSemMicrosegundos);
    return $date ? $date->format('d/m/Y') : 'Data Inválida';
}

try {
    $pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

    if (isset($_GET['ano_valor']) || isset($_GET['tipo'])) {
        if (isset($_GET['ano_valor'])) {
            $ano = $_GET['ano_valor'];
            $filtro = 'ano';
            $parametro = $ano;
        } elseif (isset($_GET['tipo'])) {
            $tipo = $_GET['tipo'];
            $filtro = 'tipo';
            $parametro = $tipo;
        }

        if (empty($parametro)) {
            echo "<p>Parâmetro não especificado.</p>";
            exit;
        }

        if ($filtro == 'ano') {
            $sql = "SELECT 
                infogeral.geralid,
                infogeral.correspondente,
                infogeral.email,
                infogeral.tituloPrinc,
                infogeral.tituloDado,
                infogeral.tipoTrabalho,
                infogeral.tituloTrabalho,
                infogeral.armazenamento,
                EXTRACT(YEAR FROM arquivos.uploaded_at) AS ano_insercao,
                STRING_AGG(DISTINCT EXTRACT(YEAR FROM COALESCE(pontos_coleta.data2, areap.dataarea))::text, ', ') AS anos_coleta,
                (SELECT STRING_AGG(autores.autor, ', ' ORDER BY trabalhos_autores_filiacao.ordem)
                 FROM trabalhos_autores_filiacao
                 LEFT JOIN autores ON trabalhos_autores_filiacao.autorID = autores.autID
                 WHERE trabalhos_autores_filiacao.trabalhoID = infogeral.geralID) AS autores
            FROM infogeral
            LEFT JOIN caractDado ON infogeral.geralid = caractDado.trabalhoId
            LEFT JOIN pontos_coleta ON infogeral.geralid = pontos_coleta.trabalhoid
            LEFT JOIN areap ON infogeral.geralid = areap.trabalhoid
            LEFT JOIN arquivos ON infogeral.geralid = arquivos.trabalhoID
            WHERE 
                EXTRACT(YEAR FROM pontos_coleta.data2) = :parametro OR
                EXTRACT(YEAR FROM areap.dataarea) = :parametro
            GROUP BY 
                infogeral.geralid,
                infogeral.correspondente,
                infogeral.email,
                infogeral.armazenamento,
                infogeral.tituloPrinc,
                infogeral.tituloDado,
                arquivos.uploaded_at";
        } elseif ($filtro == 'tipo') {
            $sql = "SELECT 
                infogeral.geralid,
                infogeral.correspondente,
                infogeral.email,
                infogeral.tituloPrinc,
                infogeral.tituloDado,
                infogeral.tipoTrabalho,
                infogeral.tituloTrabalho,
                infogeral.armazenamento,
                EXTRACT(YEAR FROM arquivos.uploaded_at) AS ano_insercao,
                STRING_AGG(DISTINCT EXTRACT(YEAR FROM COALESCE(pontos_coleta.data2, areap.dataarea))::text, ', ') AS anos_coleta,
                (SELECT STRING_AGG(autores.autor, ', ' ORDER BY trabalhos_autores_filiacao.ordem)
                 FROM trabalhos_autores_filiacao
                 LEFT JOIN autores ON trabalhos_autores_filiacao.autorID = autores.autID
                 WHERE trabalhos_autores_filiacao.trabalhoID = infogeral.geralID) AS autores
            FROM infogeral
            LEFT JOIN caractDado ON infogeral.geralid = caractDado.trabalhoId
            LEFT JOIN pontos_coleta ON infogeral.geralid = pontos_coleta.trabalhoid
            LEFT JOIN areap ON infogeral.geralid = areap.trabalhoid
            LEFT JOIN arquivos ON infogeral.geralid = arquivos.trabalhoID
            WHERE infogeral.tipoTrabalho = :parametro
            GROUP BY 
                infogeral.geralid,
                infogeral.correspondente,
                infogeral.email,
                infogeral.armazenamento,
                infogeral.tituloPrinc,
                infogeral.tituloDado,
                arquivos.uploaded_at";
        }

        $stm = $pdo->prepare($sql);
        $stm->bindParam(':parametro', $parametro, $filtro == 'ano' ? PDO::PARAM_INT : PDO::PARAM_STR);
        $stm->execute();

        $infogeral = $stm->fetchAll(PDO::FETCH_ASSOC);

        if ($infogeral) {
            echo "<table>";
            echo "<tbody>";

            foreach ($infogeral as $infogera) {
                // Formata os autores
                $autoresArray = explode(',', $infogera['autores']);
                $autoresFormatados = array_map('formatarNome', $autoresArray);
                $autoresString = implode(', ', array_map('htmlspecialchars', $autoresFormatados));

                // Cria a frase com os dados
                $frase = "<div class='citation'>
                            <a class='link-pesq' href='../HTML/resultados.php?id=" 
                            . htmlspecialchars($infogera['geralid']) . "'>" . htmlspecialchars($autoresString) . "."
                            . "<br>" . htmlspecialchars($infogera['correspondente']) . "&nbsp;(" . htmlspecialchars($infogera['email']) . ").&nbsp;"
                            . htmlspecialchars($infogera['titulodado'])
                            . "<br>" . 'Ano(s) de coleta(s):' . "&nbsp;" . htmlspecialchars($infogera['anos_coleta'])
                            . "<br>" . 'Inseridos no banco em:' . "&nbsp;" . htmlspecialchars($infogera['ano_insercao']) . ".</a>
                          </div></br></br>";

                // Exibe a frase dentro de uma célula da tabela
                echo "<tr><td>" . $frase . "</td></tr>";
            }

            echo "</tbody>";
            echo "</table>";
        } else {
            echo "<p>Nenhum resultado encontrado para o filtro especificado.</p>";
        }
    } else {
        echo "<p>Parâmetro de filtro não especificado.</p>";
    }
} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
} finally {
    if (isset($pdo)) {
        $pdo = null;
    }
}
?>