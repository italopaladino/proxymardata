<?php
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
    arquivos.uploaded_at,
    
    -- Subconsulta para agregar autores (sem filiação)
    (SELECT STRING_AGG(autores.autor, ', ' ORDER BY trabalhos_autores_filiacao.ordem)
     FROM trabalhos_autores_filiacao
     LEFT JOIN autores ON trabalhos_autores_filiacao.autorID = autores.autID
     WHERE trabalhos_autores_filiacao.trabalhoID = infogeral.geralID) AS autores

FROM infogeral
LEFT JOIN caractDado ON infogeral.geralid = caractDado.trabalhoId
LEFT JOIN arquivos ON infogeral.geralid = arquivos.trabalhoID

GROUP BY infogeral.geralid,
         infogeral.correspondente,
         infogeral.email,
         infogeral.armazenamento,
         infogeral.tituloPrinc,
         infogeral.tituloDado,
         arquivos.uploaded_at;";

    $stm = $pdo->query($sql);
    $infogeral = $stm->fetchAll(PDO::FETCH_ASSOC);

    // Inicializa o contador
    $contador = 0;
    echo "<div style='display: flex; justify-content: flex-start; margin-left: 30px;'>";
    echo "<table style='display: flex; left:30px'>";
    echo "<tbody>";

    // Itera sobre as linhas, começando do final
    for ($i = count($infogeral) - 1; $i >= 0; $i--) {
        $infogera = $infogeral[$i]; // Obtém a linha atual
        
        // Formata os autores
        $autoresArray = explode(',', $infogera['autores']);
        $autoresFormatados = array_map('formatarNome', $autoresArray);
        $autoresString = implode(', ', $autoresFormatados);
        
        // Formata a data
        $dataFormatada = formatarData($infogera['uploaded_at']);
        
        // Cria a frase com os dados do autor, título sublinhado, DOI e data
        $frase = "<div class='citation'>
                    <a class='link-pesq' href='./HTML/resultados.php?id=" 
                    . htmlspecialchars($infogera['geralid']) ."'>". htmlspecialchars($autoresString) ."." // Usa os autores formatados
                     ."<br>" . htmlspecialchars($infogera['correspondente']) . "&nbsp;(" . htmlspecialchars($infogera['email']) . ").&nbsp;"
                     . htmlspecialchars($infogera['titulodado']) . "&nbsp;(" . htmlspecialchars($dataFormatada) . ")." . "</a>
                  </div></br></br>";
    
        // Exibe a frase dentro de uma célula da tabela
        echo "<tr><td>" . $frase . "</td></tr>";

        // Incrementa o contador
        $contador++;

        // Verifica se o contador atingiu três, se sim, interrompe o loop
        if ($contador >= 5) {
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
