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

    if (isset($_GET['ano_valor'])) {
        $ano = $_GET['ano_valor'];

        if (empty($ano)) {
            echo "<p>Parâmetro 'ano' não especificado.</p>";
            exit;
        }

        // Prepara a consulta com segurança usando parâmetros
        $sql = "SELECT 
                    infogeral.geralid,
                    infogeral.correspondente,
                    infogeral.email,
                    infogeral.tituloPrinc,
                    infogeral.tituloDado,
                    infogeral.tipoTrabalho,
                    infogeral.tituloTrabalho,
                    infogeral.armazenamento,
                    COALESCE(pontos_coleta.data2, areap.dataarea) AS data_referencia,
                    -- Subconsulta para agregar autores
                    (SELECT STRING_AGG(autores.autor, ', ' ORDER BY trabalhos_autores_filiacao.ordem)
                     FROM trabalhos_autores_filiacao
                     LEFT JOIN autores ON trabalhos_autores_filiacao.autorID = autores.autID
                     WHERE trabalhos_autores_filiacao.trabalhoID = infogeral.geralID) AS autores
                FROM infogeral
                LEFT JOIN caractDado ON infogeral.geralid = caractDado.trabalhoId
                LEFT JOIN pontos_coleta ON infogeral.geralid = pontos_coleta.trabalhoid
                LEFT JOIN areap ON infogeral.geralid = areap.trabalhoid
                WHERE 
                    EXTRACT(YEAR FROM pontos_coleta.data2) = :ano OR
                    EXTRACT(YEAR FROM areap.dataarea) = :ano
                GROUP BY 
                    infogeral.geralid,
                    infogeral.correspondente,
                    infogeral.email,
                    infogeral.armazenamento,
                    infogeral.tituloPrinc,
                    infogeral.tituloDado,
                    pontos_coleta.data2,
                    areap.dataarea";

        $stm = $pdo->prepare($sql);
        $stm->bindParam(':ano', $ano, PDO::PARAM_INT);
        $stm->execute();

        $infogeral = $stm->fetchAll(PDO::FETCH_ASSOC);

        if ($infogeral) {
            // Exibe a tabela HTML
            echo "<table>";
            echo "<tbody>";

            foreach ($infogeral as $infogera) {
                // Formatar autores
                $autoresArray = explode(',', $infogera['autores'] ?? '');
                $autoresFormatados = array_map('formatarNome', $autoresArray);
                $autoresString = implode(', ', array_map('htmlspecialchars', $autoresFormatados));

                // Formatar data
                $dataFormatada = formatarData($infogera['data_referencia']);

                // Exibir resultado
                echo "<tr>";
                echo "<td>
                        <div class='citation'>
                            <a class='link-pesq' href='../HTML/resultados.php?id=" 
                    . htmlspecialchars($infogera['geralid']) ."'>". htmlspecialchars($autoresString) ."." 
                     ."<br>" . htmlspecialchars($infogera['correspondente']) . "&nbsp;(" . htmlspecialchars($infogera['email']) . ").&nbsp;"
                     . htmlspecialchars($infogera['titulodado']) . "&nbsp;(" . htmlspecialchars($dataFormatada) . ")." . "</a>
                        </div></br></br>
                      </td>";
                echo "</tr>";
            }

            echo "</tbody>";
            echo "</table>";
        } else {
            echo "<p>Nenhum resultado encontrado para o ano especificado.</p>";
        }
    } else {
        echo "<p>Parâmetro 'ano' não especificado.</p>";
    }
} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
} finally {
    if (isset($pdo)) {
        $pdo = null;
    }
}
?>