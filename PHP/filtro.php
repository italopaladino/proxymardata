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

    if (isset($_GET['ano_valor']) || isset($_GET['tipot']) || isset($_GET['tipoa']) || isset($_GET['equip_coleta'])) {

        if (isset($_GET['ano_valor'])) {
            $ano = $_GET['ano_valor'];
            $filtro = 'ano';
            $parametro = $ano;

        } elseif (isset($_GET['tipot'])) {
            $tipot = $_GET['tipot'];
            $filtro = 'tipot';
            $parametro = $tipot;

        } elseif (isset($_GET['tipoa'])) {
            $tipoa = $_GET['tipoa'];
            $filtro = 'tipoa';
            $parametro = $tipoa;

        } elseif (isset($_GET['equip_coleta'])) {
            $equip_coleta = $_GET['equip_coleta'];
            $filtro = 'equip_coleta';
            $parametro = $equip_coleta;

            // Lista de colunas permitidas para o filtro equip_coleta
            $colunasPermitidas = ['piston', 'gravcorer', 'drilli', 'gboxcorer', 'boxcorer', 'ADCP', 'corrt', 'CTD', 'modNum', 'multcor', 'multB', 'stl', 'senscbio', 'sidSc', 'vanv', 'outroequi'];

            // Verifica se o parâmetro é uma coluna válida
            if (!in_array($parametro, $colunasPermitidas)) {
                echo "<p>Parâmetro inválido.</p>";
                exit;
            }
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

        } elseif ($filtro == 'tipot') {
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

        } elseif ($filtro == 'tipoa') {
            $sql = "SELECT 
                infogeral.geralid,
                infogeral.correspondente,
                infogeral.email,
                infogeral.tituloPrinc,
                infogeral.tituloDado,
                infogeral.tipoTrabalho,
                infogeral.tituloTrabalho,
                infogeral.armazenamento,
                ferramentas.tipoAmst,
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
            LEFT JOIN ferramentas ON infogeral.geralid = ferramentas.trabalhoID
            WHERE ferramentas.tipoAmst = :parametro
            GROUP BY 
                infogeral.geralid,
                infogeral.correspondente,
                infogeral.email,
                infogeral.armazenamento,
                infogeral.tituloPrinc,
                infogeral.tituloDado,
                arquivos.uploaded_at,
                ferramentas.tipoAmst";

        } elseif ($filtro == 'equip_coleta') {
            if ($parametro == 'outroequi') {
                // Filtro para a coluna 'outroequi' (valores variáveis)
                $sql = "
                    SELECT 
                        infogeral.geralid,
                        infogeral.correspondente,
                        infogeral.email,
                        infogeral.tituloPrinc,
                        infogeral.tituloDado,
                        infogeral.tipoTrabalho,
                        infogeral.tituloTrabalho,
                        infogeral.armazenamento,
                        ferramentas.tipoAmst,
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
                    LEFT JOIN ferramentas ON infogeral.geralid = ferramentas.trabalhoID
                    LEFT JOIN equipcoleta ON infogeral.geralid = equipcoleta.trabalhoID
                    WHERE equipcoleta.outroequi = :parametro
                    GROUP BY 
                        infogeral.geralid,
                        infogeral.correspondente,
                        infogeral.email,
                        infogeral.armazenamento,
                        infogeral.tituloPrinc,
                        infogeral.tituloDado,
                        arquivos.uploaded_at,
                        ferramentas.tipoAmst";
            } else {
                // Filtro para colunas booleanas (piston, gravcorer, etc.)
                $sql = "
                    SELECT 
                        infogeral.geralid,
                        infogeral.correspondente,
                        infogeral.email,
                        infogeral.tituloPrinc,
                        infogeral.tituloDado,
                        infogeral.tipoTrabalho,
                        infogeral.tituloTrabalho,
                        infogeral.armazenamento,
                        ferramentas.tipoAmst,
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
                    LEFT JOIN ferramentas ON infogeral.geralid = ferramentas.trabalhoID
                    LEFT JOIN equipcoleta ON infogeral.geralid = equipcoleta.trabalhoID
                    WHERE equipcoleta.$parametro = TRUE
                    GROUP BY 
                        infogeral.geralid,
                        infogeral.correspondente,
                        infogeral.email,
                        infogeral.armazenamento,
                        infogeral.tituloPrinc,
                        infogeral.tituloDado,
                        arquivos.uploaded_at,
                        ferramentas.tipoAmst";
            }
        }

        // Executa a query
        $stm = $pdo->prepare($sql);

        // Apenas bindParam se o parâmetro for usado na query
        if ($filtro == 'ano' || $filtro == 'tipot' || $filtro == 'tipoa' || $parametro == 'outroequi') {
            $stm->bindParam(':parametro', $parametro, PDO::PARAM_STR);
        }

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