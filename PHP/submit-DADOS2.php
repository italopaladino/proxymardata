<?php

use function PHPSTORM_META\type;

require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtendo os dados do formulário
    $secaoAtual1 = $_POST['secaoAtual1'] ?? null;

    $secaoAtual2 = $_POST['secaoAtual2'] ?? null;

    // Conexão com o banco de dados PostgreSQL
    $conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$pass");

    if (!$conn) {
        error_log("Connectino failed:". pg_last_error(),3,"../errorlog/errorlog.txt");
        die("Connection failed: " . pg_last_error());
    }

    try {
        // Inicia a transação
        pg_query($conn, 'BEGIN');

        // Verifica se devemos inserir na tabela infogeral
        if ($secaoAtual1) {
            // Obtém os dados do formulário
            $corr = $_POST['correspondente'];
            $email = $_POST['email'];
            $tituloPrinc = $_POST['tituloPrinc'];
            $tituloDado = $_POST['tituloDado'];
            $trabAssoc = $_POST['trab_associado'];
            $tipotrabalho = $_POST['tipoTrabalho'];
            $tituloTrabalho = $_POST['titTrab'];
            $referencia = trim($_POST['referencia']);
           
           
            $armazenamento = $_POST['armazenamento'];

            $termo = isset($_POST['termo']) ? 'TRUE' : 'FALSE';
            
            
           

            // Preparando e executando a consulta SQL para inserir na tabela infogeral
            $sql1 = "INSERT INTO infogeral (correspondente, email, tituloPrinc, tituloDado, trabAssoc, tipoTrabalho, tituloTrabalho, referencia, armazenamento, termo) 
                     VALUES ($1, $2, $3, $4, $5, $6, $7, $8, $9, $10)
                     RETURNING geralID";
            
            $result1 = pg_query_params($conn, $sql1, [$corr, $email, $tituloPrinc, $tituloDado, $trabAssoc ,$tipotrabalho,$tipotrabalho,$referencia,$armazenamento,$termo]);

            // Verifica se a consulta foi bem-sucedida e obtém o ID do trabalho inserido
            if ($result1) {
                $row = pg_fetch_assoc($result1);
                $trabalhoID = $row['geralid'];

            } else {
                echo "<script> window.alert('Erro ao inserir a primeira Página do Formulário'); </script>";
                error_log("Erro ao inserir na tabela infogeral". pg_last_error($conn), 3, "../errorlog/errorlog.txt");
                throw new Exception("Erro ao inserir na tabela infogeral: " . pg_last_error($conn));
            }
        } else {
            echo "<script> window.alert('erro: secaoAtual1 não definido'); </script>";
            error_log("erro: secaoAtual1 não definido", 3, "../errorlog/errorlog.txt");
            throw new Exception("Erro: secaoAtual1 não definido.");
        }

        // Loop através dos dados de autores e filiações enviados
        foreach ($_POST['autor'] as $key => $autor) {
            $autor = trim($autor);
            $filiacao = trim($_POST['filiacao'][$key]);
            
            $autor_upper = strtoupper($autor);
            $filiacao_upper = strtoupper($_POST['filiacao'][$key]);

            // Inserir o autor na tabela autores se ainda não existir
            $sql_autor = "INSERT INTO autores (autor) VALUES ($1) ON CONFLICT (autor) DO NOTHING RETURNING autID";
            $result_autor = pg_query_params($conn, $sql_autor, [$autor_upper]);

            // Obter o autorID (seja novo ou existente)
            if ($result_autor && pg_num_rows($result_autor) > 0) {
                $row_autor = pg_fetch_assoc($result_autor);
                $autorID = $row_autor['autid'];
            } else {
                $sql_get_autorid = "SELECT autid FROM autores WHERE autor = $1";
                $result_get_autorid = pg_query_params($conn, $sql_get_autorid, [$autor_upper]);
                $row_autor = pg_fetch_assoc($result_get_autorid);
                $autorID = $row_autor['autid'];
            }

            // Inserir a filiação na tabela filiacao se ainda não existir
            $sql_filiacao = "INSERT INTO filiacao (filiacao) VALUES ($1) ON CONFLICT (filiacao) DO NOTHING RETURNING filiacaoid";
            $result_filiacao = pg_query_params($conn, $sql_filiacao, [$filiacao_upper]);

            // Obter o filiacaoID (seja novo ou existente)
            if ($result_filiacao && pg_num_rows($result_filiacao) > 0) {
                $row_filiacao = pg_fetch_assoc($result_filiacao);
                $filiacaoID = $row_filiacao['filiacaoid'];
            } else {
                $sql_get_filiacaoid = "SELECT filiacaoid FROM filiacao WHERE filiacao = $1";
                $result_get_filiacaoid = pg_query_params($conn, $sql_get_filiacaoid, [$filiacao_upper]);
                $row_filiacao = pg_fetch_assoc($result_get_filiacaoid);
                $filiacaoID = $row_filiacao['filiacaoid'];
            }
                       
            // Inserir associação na tabela trabalhos_autores_filiacao
            $sql_trabalhos_autores = "INSERT INTO trabalhos_autores_filiacao (trabalhoid, autorid, filiacaoid, ordem) VALUES ($1, $2, $3, $4)";
            $result_trabalhos_autores = pg_query_params($conn, $sql_trabalhos_autores, [$trabalhoID, $autorID, $filiacaoID, $key]);

            // Verifica se as inserções foram bem-sucedidas
            if (!$result_trabalhos_autores) {
                echo "<script> window.alert('Erro ao inserir associação na tabela trabalho_autores_filiacao $key'); </script>";
                error_log("Erro ao inserir associação na tabela trabalho_autores_filiacao",3, "../errorlog/errorlog.txt");
                throw new Exception("Erro ao inserir associação na tabela trabalhos_autores_filiacao.");
            }
     }

// Verifica se os campos de ID_amst existem antes de proceder
if ($secaoAtual2 && isset($_POST['ID_amst'])) {
    foreach ($_POST['ID_amst'] as $key => $ID_amst) {
        // Limpa e atribui os valores, ou define como null se não existirem
        $ID_amst = isset($_POST['ID_amst'][$key]) ? trim($_POST['ID_amst'][$key]) : null;
        $latitude = isset($_POST['latitude'][$key]) ? trim(str_replace(",", ".", $_POST['latitude'][$key])) : null;
        $longitude = isset($_POST['longitude'][$key]) ? trim(str_replace(",", ".", $_POST['longitude'][$key])) : null;
        $anoColeta = isset($_POST['data'][$key]) ? trim($_POST['data'][$key]) : null;

        // Insere apenas se pelo menos um campo tiver valor
        if ($ID_amst || $latitude || $longitude || $anoColeta) {
            $sql_pontos = "INSERT INTO pontos_coleta (ID_amst, latitude, longitude, data2, trabalhoid) VALUES ($1, $2, $3, $4, $5)";
            $result_ponto = pg_query_params($conn, $sql_pontos, [$ID_amst, $latitude, $longitude, $anoColeta, $trabalhoID]);

            if (!$result_ponto) {
                $pg_error = pg_last_error($conn);
                echo "<script> window.alert('Erro ao inserir na tabela de pontos $key: $pg_error'); </script>";
                error_log("Erro ao inserir na tabela de pontos $key: $pg_error", 3, "../errorlog/errorlog.txt");
                throw new Exception("Erro ao inserir na tabela de pontos: $pg_error");
            }
        }
    }
}

// Arrays contendo os valores das áreas, verificando se cada índice existe antes de criar os arrays
// Definindo os valores das áreas apenas se os campos existirem
$ID_amstAREA = [
    $_POST['ID_amstAREA1'] ?? null, 
    $_POST['ID_amstAREA2'] ?? null, 
    $_POST['ID_amstAREA3'] ?? null, 
    $_POST['ID_amstAREA4'] ?? null
];
$latitudeAREA = [
    $_POST['latitudeAREA1'] ?? null, 
    $_POST['latitudeAREA2'] ?? null, 
    $_POST['latitudeAREA3'] ?? null, 
    $_POST['latitudeAREA4'] ?? null
];
$longitudeAREA = [
    $_POST['longitudeAREA1'] ?? null, 
    $_POST['longitudeAREA2'] ?? null, 
    $_POST['longitudeAREA3'] ?? null, 
    $_POST['longitudeAREA4'] ?? null
];
$dataAREA = [
    $_POST['dataAREA1'] ?? null, 
    $_POST['dataAREA2'] ?? null, 
    $_POST['dataAREA3'] ?? null, 
    $_POST['dataAREA4'] ?? null
];

$sql_areaP = "INSERT INTO areaP (ID_amstAREA, latitudeAREA, longitudeAREA, dataAREA, trabalhoID) VALUES ($1, $2, $3, $4, $5)";

// Insere cada conjunto de valores na tabela areaP, apenas se algum valor estiver preenchido
for ($i = 1; $i <= count($ID_amstAREA); $i++) {
    if ($ID_amstAREA[$i - 1] || $latitudeAREA[$i - 1] || $longitudeAREA[$i - 1] || $dataAREA[$i - 1]) {
        $params = [
            $ID_amstAREA[$i - 1],
            $latitudeAREA[$i - 1],
            $longitudeAREA[$i - 1],
            $dataAREA[$i - 1],
            $trabalhoID
        ];

        // Depuração: exibir os dados que estão sendo passados
        error_log("Tentativa de inserir na tabela areaP com valores: " . print_r($params, true), 3, "../errorlog/errorlog.txt");

        $result_prox = pg_query_params($conn, $sql_areaP, $params);

        if (!$result_prox) {
            // Exibir erro específico do PostgreSQL
            $pg_error = pg_last_error($conn);
            echo "<script> window.alert('Erro ao inserir na tabela areaP: $pg_error'); </script>";
            error_log("Erro ao inserir na tabela areaP: $pg_error", 3, "../errorlog/errorlog.txt");
            throw new Exception("Erro ao inserir na tabela areaP: $pg_error");
        }
    }




    $tipAmst = $_POST['tipAmst'];
    $associ = isset($_POST['associ']) ? 1 : 0;
    $batmet = isset($_POST['batmet']) ? 1 : 0;
    $bioOrg = isset($_POST['bioOrg']) ? 1 : 0;
    $cocolit = isset($_POST['cocolit']) ? 1 : 0;
    $strat = isset($_POST['estrat']) ? 1 : 0;
    $foramplan = isset($_POST['foramplan']) ? 1 : 0;
    $forambent = isset($_POST['forambent']) ? 1 : 0;
    $granl = isset($_POST['granl']) ? 1 : 0;
    $hidrod = isset($_POST['hidrod']) ? 1 : 0;
    $hidrog = isset($_POST['hidrog']) ? 1 : 0;
    $matorg = isset($_POST['matorg']) ? 1 : 0;
    $metais = isset($_POST['metais']) ? 1 : 0;
    $microps = isset($_POST['microps']) ? 1 : 0;
    $ageMod = isset($_POST['ageMod']) ? 1 : 0;
    $proFisi = isset($_POST['proFisi']) ? 1 : 0;
    $radioist = isset($_POST['radioist']) ? 1 : 0;
    $razIsot = isset($_POST['razIsot']) ? 1 : 0;
    $smodnum = isset($_POST['SmodNum']) ? 1 : 0;
    $teorAg = isset($_POST['teorAg']) ? 1 : 0;

    $outroFerr = trim($_POST['outroFerr']);

    $sql_ferram = "INSERT INTO ferramentas (tipoAmst, assos, batmet, bioOrg, cocolit, estrat, foramplan,forambent, granl, hidrod, hidrog, matorg, metais, microps, ageMod, proFisi, radioist, razIsot,smodNum, teorAg, outroFerr, trabalhoid)
    VALUES ($1, $2, $3, $4, $5, $6, $7, $8, $9, $10, $11,$12,$13,$14,$15,$16,$17,$18,$19,$20,NULLIF($21, ''), $22)";
    $result_prox = pg_query_params($conn, $sql_ferram,[$tipAmst,$associ,$batmet,$bioOrg,$cocolit,$strat,$foramplan,$forambent,$granl,$hidrod,$hidrog,$matorg,$metais,$microps,$ageMod,$proFisi,$radioist,$razIsot,$smodnum,$teorAg,$outroFerr,$trabalhoID]);

    if (!$result_prox){
        $pg_error =pg_last_error($conn);
        echo "<script> window.alert(' Erro ao inserir na tabela ferramentas : $pg_error''); </script>";
        error_log("erro ao inserir na tabela ferramenta: $pg_error ", 3, "../errorlog/errorlog.txt");
        throw new Exception("Erro ao inserir na tabela ferramenta");
    }

    
    $piston = isset($_POST['pstCor']) ? 1 : 0;
    $gravcorer = isset($_POST['gravt']) ? 1 : 0;
    $drilli = isset($_POST['drill']) ? 1 : 0;
    $gboxcorer = isset($_POST['gbox']) ? 1 : 0;
    $boxcr = isset($_POST['boxcr']) ? 1 : 0;
    $ADCP = isset($_POST['ADCP']) ? 1 : 0;
    $corrt = isset($_POST['corrt']) ? 1 : 0;
    $CTD = isset($_POST['CTD']) ? 1 : 0;
    $modNum = isset($_POST['modNum']) ? 1 : 0;
    $multb = isset($_POST['multb']) ? 1 : 0;
    $multCorr = isset($_POST['multCorr']) ? 1 : 0;
    $satl = isset($_POST['satl']) ? 1 : 0;
    $sensBio = isset($_POST['sensBio']) ? 1 : 0;
    $sidSc = isset($_POST['sidSc']) ? 1 : 0;
    $vanv = isset($_POST['vanv']) ? 1 : 0;
    $outroEqui = trim($_POST['outroEqui']);

    $sql_equipamentos = "INSERT INTO equipcoleta (piston,gravcorer,drilli,gboxcorer,boxcorer,ADCP,corrt,CTD, modNum, multb, multcor,stl,senscbio,sidSc,vanv, outroEQui, trabalhoid)
    VALUES ($1, $2, $3, $4, $5, $6, $7, $8,$9,$10,$11,$12,$13,$14,$15,NULLIF($16, ''), $17)";

    $result_equi = pg_query_params($conn, $sql_equipamentos,[$piston,$gravcorer,$drilli,$gboxcorer,$boxcr,$ADCP,$corrt,$CTD,$modNum,$multb,$multCorr,$satl,$sensBio,$sidSc,$vanv,$outroEqui,$trabalhoID]);


    if (!$result_equi) {
        $pg_error = pg_last_error($conn);
        echo "<script> window.alert('Erro ao inserir na tabela equipamentos: $pg_error'); </script>";
        error_log("Erro ao inserir na tabela equipamentos: $pg_error", 3, "../errorlog/errorlog.txt");
        throw new Exception("Erro ao inserir na tabela equipamentos: $pg_error");
    }


$resDad = $_POST['res_dado'];

$sql_caract = "INSERT INTO caractDado (red_dado, trabalhoid) VALUES ($1, $2)";
$result_caract = pg_query_params($conn, $sql_caract,[$resDad, $trabalhoID]);





// Verifica se o arquivo foi enviado sem erros
if (isset($_FILES['tabelaDado']) && $_FILES['tabelaDado']['error'] === UPLOAD_ERR_OK) {
    // Nome do arquivo temporário
    $csvFile = $_FILES['tabelaDado']['tmp_name'];

    // Conteúdo do arquivo CSV
    $conteudo = file_get_contents($csvFile);

    // Nome original do arquivo
    $nomeArquivo = $_FILES['tabelaDado']['name'];

    // Prepara a consulta SQL para inserir na tabela arquivos
    $sql_insert = "INSERT INTO arquivos (nome_arquivo, conteudo, trabalhoid) VALUES ($1, $2, $3)";
    $result = pg_query_params($conn, $sql_insert, [$nomeArquivo, pg_escape_bytea($conteudo), $trabalhoID]);

    if ($result) {
        error_log("Arquivo CSV carregado e inserido na tabela arquivos com sucesso.", 3, "../errorlog/errorlog.txt");
    } else {
        echo "<script> window.alert('erro no arquivo'); </script>";
        error_log("Erro ao inserir arquivo na tabela arquivos: " . pg_last_error($conn), 3, "../errorlog/errorlog.txt");
    }
} else {
    echo "<script> window.alert('erro no arquivo'); </script>";
    error_log("Erro no envio do arquivo CSV.", 3, "../errorlog/errorlog.txt");
}

     }

        // Commit da transação
        pg_query($conn, 'COMMIT');
    
        // Redireciona para a página de sucesso
        echo "<script>window.location.href = '../HTML/dados_inseridos.html';</script>";
    
    } catch (Exception $e) {
        // Rollback da transação em caso de erro
        pg_query($conn, 'ROLLBACK');

        error_log('alguma coisa não deu certo aqui ');
        
        // Redireciona para a página de erro
        echo "<script>window.location.href = '../HTML/dados_invalidos.html?msg=" . urlencode($e->getMessage()) . "';</script>";
    }
}
    // Fechar a conexão
    pg_close($conn);
    ?>

