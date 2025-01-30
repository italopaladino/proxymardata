
require_once 'config.php';

function formatarNome($nomeCompleto) {
    // Converte o nome para minúsculas e capitaliza as primeiras letras
    return mb_convert_case(mb_strtolower($nomeCompleto, 'UTF-8'), MB_CASE_TITLE, 'UTF-8');
}

function formatarData($data) {
    // Remove os microsegundos, se existirem
    $dataSemMicrosegundos = preg_replace('/\.\d+$/', '', $data);

    // Cria o objeto DateTime com o formato sem microsegundos
    $date = DateTime::createFromFormat('Y-m-d H:i:s', $dataSemMicrosegundos);

    // Retorna a data formatada ou uma mensagem de erro
    return $date ? $date->format('d/m/Y') : 'Data Inválida';
}

try {
    $pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

    if (isset($_GET['tipo'])) {
        $tipo = $_GET['tipo'];

        if (empty($tipo)) {
            echo "<p>Parâmetro 'tipo' não especificado.</p>";
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
                    arquivos.uploaded_at,
                    
                    -- Subconsulta para agregar autores
                    (SELECT STRING_AGG(autores.autor, ', ' ORDER BY trabalhos_autores_filiacao.ordem)
                     FROM trabalhos_autores_filiacao
                     LEFT JOIN autores ON trabalhos_autores_filiacao.autorID = autores.autID
                     WHERE trabalhos_autores_filiacao.trabalhoID = infogeral.geralID) AS autores
                FROM infogeral
                LEFT JOIN caractDado ON infogeral.geralid = caractDado.trabalhoId
                LEFT JOIN arquivos ON infogeral.geralid = arquivos.trabalhoID

                WHERE infogeral.tipoTrabalho = :tipo

                
                GROUP BY infogeral.geralid,
                         infogeral.correspondente,
                         infogeral.email,
                         infogeral.armazenamento,
                         infogeral.tituloPrinc,
                         infogeral.tituloDado,
                         arquivos.uploaded_at";

        $stm = $pdo->prepare($sql);
        $stm->bindParam(':tipo', $tipo, PDO::PARAM_STR);
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

                // Agora usa os autores formatados
                $autoresString = implode(', ', array_map('htmlspecialchars', $autoresFormatados));

                // Formatar data
                $dataFormatada = formatarData($infogera['uploaded_at']);

                // Exibir resultado
                echo "<tr>";
                echo "<td>
                        <div class='citation'>
                            <a class='link-pesq' href='../HTML/resultados.php?id=" 
                    . htmlspecialchars($infogera['geralid']) ."'>". htmlspecialchars($autoresString) ."." // Usa os autores formatados
                     ."<br>" . htmlspecialchars($infogera['correspondente']) . "&nbsp;(" . htmlspecialchars($infogera['email']) . ").&nbsp;"
                     . htmlspecialchars($infogera['titulodado']) . "&nbsp;(" . htmlspecialchars($dataFormatada) . ")." . "</a>
                        </div></br></br>
                      </td>";
                echo "</tr>";
            }

            echo "</tbody>";
            echo "</table>";
        } else {
            echo "<p>Nenhum resultado encontrado para o tipo especificado.</p>";
        }
    } else {
        echo "<p>Parâmetro 'tipo' não especificado.</p>";
    }
} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
} finally {
    if (isset($pdo)) {
        $pdo = null;
    }
}
?>
