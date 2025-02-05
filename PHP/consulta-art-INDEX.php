<?php
require_once 'config.php';

function formatarNome($nomeCompleto) {
    // Converte o nome para minúsculas e capitaliza as primeiras letras
    return mb_convert_case(mb_strtolower($nomeCompleto, 'UTF-8'), MB_CASE_TITLE, 'UTF-8');
}

try {
    // Conexão ao banco de dados
    $pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

    // Consulta SQL para obter todos os registros de infogeral
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
    GROUP BY 
        infogeral.geralid,
        infogeral.correspondente,
        infogeral.email,
        infogeral.armazenamento,
        infogeral.tituloPrinc,
        infogeral.tituloDado,
        arquivos.uploaded_at";

    $stm = $pdo->query($sql);
    $infogeral = $stm->fetchAll(PDO::FETCH_ASSOC);

    // Inicializa o contador (caso precise usar depois)
    $contador = 0;

    // Abre a tabela
    echo "<table>";
   
    echo "<tbody>";

    // Itera sobre as linhas, começando do final
    for ($i = count($infogeral) - 1; $i >= 0; $i--) {
        $infogera = $infogeral[$i]; // Obtém a linha atual
        
        // Formata os autores
        $autoresArray = explode(',', $infogera['autores']);
        $autoresFormatados = array_map('formatarNome', $autoresArray);
        $autoresString = implode(', ', $autoresFormatados);
        
        // Formata a data
        
        
        // Cria a frase com os dados do autor, título sublinhado, DOI e data
        $frase = "<div class='citation' style='border-left: 2px solid #0056b3; padding: 1rem;' >
                    <a class='link-pesq' href='../HTML/resultados.php?id=" 
                    . htmlspecialchars($infogera['geralid']) . "'>". htmlspecialchars($autoresString) ."." // Usa os autores formatados
                     ."<br><p class='lead'>" . htmlspecialchars($infogera['correspondente']) . "&nbsp;(" . htmlspecialchars($infogera['email']) . ").&nbsp;"
                     . htmlspecialchars($infogera['titulodado'])
                     ."<br>". 'Ano(s) de coleta(s):' . "&nbsp;" . htmlspecialchars($infogera['anos_coleta'])
             ."<br>". 'Inseridos no banco em:' .  "&nbsp;" . htmlspecialchars($infogera['ano_insercao']) . "."."</p></a>
                  </div></br>";
    
        // Exibe a frase dentro de uma célula da tabela
        echo "<tr><td>" . $frase . "</td></tr>";
    
    // Fecha a tabela
    echo "</tbody></table>";

        // Incrementa o contador
        $contador++;

        // Verifica se o contador atingiu três, se sim, interrompe o loop
        if ($contador >= 4) {
            break;
        }
    }

    echo "</tbody>";
    echo "</table>";
    echo "</div>";
    
} catch (PDOException $e) {
    echo "Erro:" . $e->getMessage();
} finally {
    if($pdo){
        $pdo = null;
    }
}
?>
