<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>ProxyMar Data Base</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="icon" type="image/x-icon" href="../assets/mac.ico" />
   

    <link href="../css/stylesG.css" rel="stylesheet" />
    
    <link href="../css/resultado.css" rel="stylesheet" />



    <script src="../js/add-script.js"></script>

    <script src= "../js/scripts.js"></script>

</head>

   <!-- Navigation -->
   <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
        <div class="container px-4">
            <div class="search1">
                <input style="left: 0%;" id="search1" type="text" name="search" placeholder="Search..">
                <button style="left: 0%;"><i class="bi bi-search"></i></button>
            </div>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation" id="navbarToggleBtn">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="../index.html" onclick=closeNavbar()>Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="../index.html#last-issues" onclick=closeNavbar()>Últimos Artigos</a></li>
                    <li class="nav-item"><a class="nav-link" href="../index.html#contact" onclick=closeNavbar()>Contatos</a></li>
                    <li class="nav-item"><a class="nav-link" href="consulta.php" onclick=closeNavbar()>Consulta</a></li>
                    <li class="nav-item"><a class="nav-link" href="submit.html">Submissão de dados</a></li>
                   <!-- <li class="nav-item"><a class="nav-link" href="#" onclick="openLoginDialog(); closeNavbar()">Login</a></li>
                    <li class="nav-item"><a class="nav-link" href="novo-user.html" onclick=closeNavbar()>Sing in</a></li> -->
                </ul>
            </div>
        </div>
    </nav>

    <head>

    </head>
    <!-- LOGIN POR CAIXA DE DIALOGO -->
    <div id="loginDialogOverlay">
        <div id="loginDialog">
            <img src="../assets/avatar.jpeg" alt="Avatar" class="avatar">
            <br><br>
            <h2>Login</h2><br>
            <form action="../PHP/login.php" method="post">
                <label for="username">Nome:</label><br>
                <input type="text" id="nome" name="nome" required autofocus><br>
                <label for="password">Senha:</label><br>
                <input type="password" id="senha" name="senha" required><br>
                <button class="lgbttn" type="submit">Login</button><br>
            </form>
            <button class="lgbttn" onclick="closeLoginDialog()">Fechar</button>
        </div>
        </div>
 




    <!-- Pagina de consulta dos dados -->
  <?php
    // Verifica se o parâmetro 'id' foi passado via GET
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        // Inclui o arquivo de configuração do banco de dados
        require_once '../PHP/config.php';

       
        require_once '../PHP/config.php';

        try {
            // Conexão ao banco de dados usando PDO
            $pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    
           // Prepara e executa a consulta SQL com o ID fornecido
           $sql = "SELECT 
    infogeral.correspondente,
    infogeral.email,
    infogeral.tituloPrinc,
    infogeral.tituloDado,
    infogeral.tipoTrabalho,
    infogeral.tituloTrabalho,
    infogeral.referencia,
    infogeral.armazenamento,
    infogeral.termo,
    infogeral.funding,
    caractDado.red_dado,
    arquivos.nome_arquivo,
    arquivos.uploaded_at,
    ferramentas.tipoamst,
    ferramentas.assos,
    ferramentas.batmet,
    ferramentas.bioOrg,
    ferramentas.cocolit,
    ferramentas.estrat,
    ferramentas.foramplan,
    ferramentas.forambent,
    ferramentas.granl,
    ferramentas.hidrod,
    ferramentas.hidrog,
    ferramentas.matorg,
    ferramentas.metais,
    ferramentas.microps,
    ferramentas.ageMod,
    ferramentas.proFisi,
    ferramentas.radioist,
    ferramentas.razIsot,
    ferramentas.smodNum,
    ferramentas.teorAg,
    ferramentas.outroFerr,
    equipcoleta.piston,
    equipcoleta.gravcorer,
    equipcoleta.drilli,
    equipcoleta.gboxcorer,
    equipcoleta.boxcorer,
    equipcoleta.ADCP,
    equipcoleta.corrt,
    equipcoleta.CTD,
    equipcoleta.modNum,
    equipcoleta.multcor,
    equipcoleta.multB,
    equipcoleta.stl,
    equipcoleta.senscbio,
    equipcoleta.sidSc,
    equipcoleta.vanv,
    equipcoleta.outroequi,
    tipoPonto.descricao AS tipo_ponto_descricao,

    -- Subconsulta para agregar autores
    (SELECT STRING_AGG(CONCAT(autores.autor, ' (', filiacao.filiacao, ')'), ', ' ORDER BY trabalhos_autores_filiacao.ordem)
     FROM trabalhos_autores_filiacao
     LEFT JOIN autores ON trabalhos_autores_filiacao.autorID = autores.autID
     LEFT JOIN filiacao ON trabalhos_autores_filiacao.filiacaoID = filiacao.filiacaoID
     WHERE trabalhos_autores_filiacao.trabalhoID = infogeral.geralID) AS autores,

    -- Subconsulta para pontos de coleta
    (SELECT STRING_AGG(CONCAT_WS(', ',
            'ID: ' || pontos_coleta.ID_amst,
            'Latitude: ' || pontos_coleta.latitude,
            'Longitude: ' || pontos_coleta.longitude,
            'Data de coleta: ' || pontos_coleta.data2), ' | ')
     FROM pontos_coleta
     WHERE pontos_coleta.trabalhoID = infogeral.geralID) AS pontos_coleta,

    -- Subconsulta para área de coleta
    (SELECT STRING_AGG(CONCAT_WS(', ',
            'ID: ' || areap.ID_amstAREA,
            'Latitude: ' || areap.latitudeAREA,
            'Longitude: ' || areap.longitudeAREA,
            'Data de coleta: ' || areap.dataAREA), ' | ')
     FROM areap
     WHERE areap.trabalhoID = infogeral.geralID) AS area_coleta

FROM infogeral
LEFT JOIN caractDado ON infogeral.geralID = caractDado.trabalhoId
LEFT JOIN arquivos ON infogeral.geralID = arquivos.trabalhoID
LEFT JOIN ferramentas ON infogeral.geralID = ferramentas.trabalhoID
LEFT JOIN equipcoleta ON infogeral.geralID = equipcoleta.trabalhoID
LEFT JOIN tipoPonto ON infogeral.geralID = tipoPonto.trabalhoID

WHERE infogeral.geralID = :id
GROUP BY infogeral.geralID,
         infogeral.correspondente,
         infogeral.email,
         infogeral.tipoTrabalho,
         infogeral.armazenamento,
         infogeral.termo,
         infogeral.tituloPrinc,
         infogeral.tituloDado,
         infogeral.referencia,
         infogeral.funding,
         caractDado.red_dado,
         arquivos.nome_arquivo,
         arquivos.uploaded_at,
         ferramentas.tipoamst,
         ferramentas.assos,
         ferramentas.batmet,
         ferramentas.bioOrg,
         ferramentas.cocolit,
         ferramentas.estrat,
         ferramentas.foramplan,
         ferramentas.forambent,
         ferramentas.granl,
         ferramentas.hidrod,
         ferramentas.hidrog,
         ferramentas.matorg,
         ferramentas.metais,
         ferramentas.microps,
         ferramentas.ageMod,
         ferramentas.proFisi,
         ferramentas.radioist,
         ferramentas.razIsot,
         ferramentas.smodNum,
         ferramentas.teorAg,
         ferramentas.outroFerr,
         equipcoleta.piston,
         equipcoleta.gravcorer,
         equipcoleta.drilli,
         equipcoleta.gboxcorer,
         equipcoleta.boxcorer,
         equipcoleta.ADCP,
         equipcoleta.corrt,
         equipcoleta.CTD,
         equipcoleta.modNum,
         equipcoleta.multcor,
         equipcoleta.multB,
         equipcoleta.stl,
         equipcoleta.senscbio,
         equipcoleta.sidSc,
         equipcoleta.vanv,
         equipcoleta.outroequi,
         tipoPonto.descricao;";

        

        
        
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $infogeral = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        if (!empty($infogeral)) {
            foreach ($infogeral as $row) {
                // Exibe os detalhes na página resultados.html
                echo "<div id='principal1' class='bg-primary'>
                    <span id='principal1'> RESULTADO </span>
                </div>"; // DIV PRINCIPAL
        
                echo "<div class='principal2'>"; // DIV SECUNDÁRIA
                echo "<a href='consulta.php' id='voltar' class='voltar'> &laquo; Voltar</a></br>";
        
                echo "<div class='linha' id='coluna-esq-dir'>"; // div corr
                echo "<div class='coluna' id='colun-esq'><span class='colun-esq'>Correspondente:</span></div>";
                echo "<div class='coluna' id='colun-med'>" . htmlspecialchars($row['correspondente']) . "&nbsp;&nbsp; <i>(" . htmlspecialchars($row['email']) . ")</i></div>";
                echo "</div>"; // div corr
        
                
                    echo "<div class='linha' id='coluna-esq-dir'>"; // div tit
                    echo "<div class='coluna' id='colun-esq'><span class='colun-esq'>Título do projeto principal:</span></div>";
                    echo "<div class='coluna' id='colun-med'>" . htmlspecialchars($row['tituloprinc']) . "</div>";
                    echo "</div>";
                 // div tit

                echo "<div class='linha' id='coluna-esq-dir'>"; // div tit
                echo "<div class='coluna' id='colun-esq'><span class='colun-esq'>Título atribuido para os Dados:</span></div>";
                echo "<div class='coluna' id='colun-med'>" . htmlspecialchars($row['titulodado']) . "</div>";
                echo "</div>";
        
                echo "<div class='linha' id='coluna-esq-dir'>"; // autores
                echo "<div class='coluna' id='colun-esq'><span class='colun-esq'>Autores:</span></div>";
                echo "<div class='coluna' id='colun-med'>" . htmlspecialchars($row['autores']) . "</div>";
                echo "</div>"; // autores

                echo "<div class='linha' id='coluna-esq-dir'>"; // funding
                echo "<div class='coluna' id='colun-esq'><span class='colun-esq'>Financiamento:</span></div>";
                echo "<div class='coluna' id='colun-med'>" . htmlspecialchars($row['funding']) . "</div>";
                echo "</div>"; // funding
        
                echo "<div class='linha' id='coluna-esq-dir'>"; // tipo
                echo "<div class='coluna' id='colun-esq'><span class='colun-esq'>Tipo de Armazenamento:</span></div>";
                echo "<div class='coluna' id='colun-med'>" . htmlspecialchars($row['tipotrabalho']) . "&nbsp;&nbsp; (" . htmlspecialchars($row['armazenamento']) . ")</div>";
                echo "</div>"; // tipo
        
                                   
        
                    
                echo "<div class='linha' id='coluna-esq-dir'>"; // caracteristicas
                echo "<div class='coluna' id='colun-esq'><span class='colun-esq'>Resumo para os dados:</span></div>";
                echo "<div class='coluna' id='colun-dir'>" . htmlspecialchars($row['red_dado']) . "</div>";
                echo "</div>"; // caracteristicas

                echo "<div class='linha' id='coluna-esq-dir'>"; // Tipo de amostra
                echo "<div class='coluna' id='colun-esq'><span class='colun-esq'>Tipo de amostra:</span></div>";
                echo "<div class='coluna' id='colun-dir'>" . htmlspecialchars($row['tipoamst']) . "</div>";
                echo "</div>"; // tipo e amostra

               
                     
                $ferramentas = [];
                if ($row['assos']) $proxys[] = "Associação";
                if ($row['batmet']) $proxys[] = "Batimetria";
                if ($row['bioorg']) $proxys[] = "Biomarcadores Orgânicos";
                if ($row['cocolit']) $proxys[] = "Cocolitoforídeos";
                if ($row['estrat']) $proxys[] = "Estraigrafia";
                if ($row['foramplan']) $proxys[] = "Foraminífero Planctônico";
                if ($row['forambent']) $proxys[] = "Foraminífero Bentônico";
                if ($row['granl']) $proxys[] = "Granulometria";
                if ($row['hidrod']) $proxys[] = "Hidrodinâmica";
                if ($row['hidrog']) $proxys[] = "Hidrografia";
                if ($row['matorg']) $proxys[] = "Matéria Orgânica";
                if ($row['metais']) $proxys[] = "Metais";
                if ($row['microps']) $proxys[] = "Microplásticos";
                if ($row['agemod']) $proxys[] = "Modelos de Idade";
                if ($row['profisi']) $proxys[] = "Propriedades Físicas";
                if ($row['radioist']) $proxys[] = "Radioisótopos";
                if ($row['razisot']) $proxys[] = "Razões Isotópicas";
                if ($row['smodnum']) $proxys[] = "Saída de modelo numérico";
                if ($row['teorag']) $proxys[] = "Teor e água";
                if ($row['outroferr']) $proxys[] = htmlspecialchars($row['outroferr']);
        
                echo "<div class='linha' id='coluna-esq-dir'>"; // prox
                echo "<div class='coluna' id='colun-esq'><span class='colun-esq'>Ferrmenta(s) Utilizada(s): </span></div>";
                echo "<div class='coluna' id='colun-dir'>" . implode(", ", $proxys) . "</div>"; // Exibe os proxies em uma linha
                echo "</div>"; // prox
        
                $equipcoleta = [];
                
                if ($row['piston']) $equipcoleta[] = "Piston";
                if ($row['gravcorer']) $equipcoleta[] = "Gravity corer";
                if ($row['drilli']) $equipcoleta[] = "Drilling devide";
                if ($row['gboxcorer']) $equipcoleta[] = "Giant box corer";
                if ($row['boxcorer']) $equipcoleta[] = "Box corer";
                if ($row['adcp']) $equipcoleta[] = "ADCP";
                if ($row['corrt']) $equipcoleta[] = "Correntômetro";
                if ($row['modnum']) $equipcoleta[] = "Modelo númerico";
                if ($row['multcor']) $equipcoleta[] = "Multiple corer";
                if ($row['multb']) $equipcoleta[] = "Multibean";
                if ($row['stl']) $equipcoleta[] = "Satélite";
                if ($row['senscbio']) $equipcoleta[] = "Sensores bio-ópticos";
                if ($row['sidsc']) $equipcoleta[] = "Side-scan sonar";
                if ($row['outroequi']) $equipcoleta[] = htmlspecialchars($row['outroequi']);
        
                echo "<div class='linha' id='coluna-esq-dir'>"; // equi
                echo "<div class='coluna' id='colun-esq'><span class='colun-esq'> Equipamento(s) utilizado(s): </span></div>";
                echo "<div class='coluna' id='colun-dir'>" . implode(", ", $equipcoleta) . "</div>"; // Exibe os proxies em uma linha
                echo "</div>"; // equi
        

                
        
            $pontos_coleta = explode(' | ', $row['pontos_coleta']);
            $html_coleta = ''; // Inicializa uma string para armazenar todo o HTML de pontos de coleta

foreach ($pontos_coleta as $ponto) {
    // Separar os detalhes do ponto de coleta
    $detalhes = explode(', ', $ponto);

    // Inicializar uma string para armazenar o HTML formatado de um único ponto
    $html_ponto = '';

    // Iterar sobre os detalhes e aplicar os estilos conforme necessário
    foreach ($detalhes as $detalhe) {
        if (strpos($detalhe, 'ID: ') !== false) {
            $valor = str_replace('ID: ', '', $detalhe);
            if (!empty($valor)) {
                $html_ponto .= "<span class='label'>ID: </span><span class='id-value'>" . htmlspecialchars($valor) . "</span>, ";
            }
        } elseif (strpos($detalhe, 'Latitude: ') !== false) {
            $valor = str_replace('Latitude: ', '', $detalhe);
            if (!empty($valor)) {
                $html_ponto .= "<span class='label'>Latitude: </span><span class='latitude-value'>" . htmlspecialchars($valor) . "</span>, ";
            }
        } elseif (strpos($detalhe, 'Longitude: ') !== false) {
            $valor = str_replace('Longitude: ', '', $detalhe);
            if (!empty($valor)) {
                $html_ponto .= "<span class='label'>Longitude: </span><span class='longitude-value'>" . htmlspecialchars($valor) . "</span>, ";
            }
        } elseif (strpos($detalhe, 'Data de coleta: ') !== false) {
            $data_original = str_replace('Data de coleta: ', '', $detalhe);
            if (!empty($data_original)) {
                $data_formatada = date('d/m/Y', strtotime($data_original));
                $html_ponto .= "<span class='label'>Data de coleta: </span><span class='data-value'>" . htmlspecialchars($data_formatada) . "</span>, ";
            }
        }
    }
    
    
    // Remover a vírgula extra no final, se necessário
    $html_ponto = rtrim($html_ponto, ', ');

    // Adicionar o HTML do ponto ao HTML total, apenas se não estiver vazio
    if (!empty($html_ponto)) {
        $html_coleta .= "<div class='ponto-coleta'>{$html_ponto}</div><br>";
    }
}

// Só exibir a estrutura "Pontos de Coleta" se houver conteúdo
if (!empty($html_coleta)) {
    echo "<div class='linha' id='coluna-esq-dir'>"; // pontos
    echo "<div class='coluna' id='colun-esq'><span class='colun-esq'> Ponto(s) de coleta:</span></div>";
    echo "<div class='coluna' id='colun-dir'>";
    echo $html_coleta; // Exibe todos os pontos de coleta formatados
    echo "</div>"; // fecha coluna
    echo "</div>"; // fecha linha
}


$area_coleta = explode(' | ', $row['area_coleta']);
$area_html = ''; // Inicializa uma string para armazenar todo o HTML formatado
$areas_processadas = []; // Array para armazenar as áreas já processadas

foreach ($area_coleta as $area) {
    if (in_array($area, $areas_processadas)) {
        continue; // Pule áreas duplicadas
    }

    $areas_processadas[] = $area; // Marque esta área como processada

    $detal = explode(', ', $area);

    $html_area = ''; // Resetar o HTML da área para cada iteração

    foreach ($detal as $detals) {
        if (strpos($detals, 'ID: ') !== false) {
            $valor = str_replace('ID: ', '', $detals);
            if (!empty($valor)) {
                $html_area .= "<span class='label'>ID: </span><span class='id-value'>" . htmlspecialchars($valor) . "</span>, ";
            }
        } elseif (strpos($detals, 'Latitude: ') !== false) {
            $valor = str_replace('Latitude: ', '', $detals);
            if (!empty($valor)) {
                $html_area .= "<span class='label'>Latitude: </span><span class='latitude-value'>" . htmlspecialchars($valor) . "</span>, ";
            }
        } elseif (strpos($detals, 'Longitude: ') !== false) {
            $valor = str_replace('Longitude: ', '', $detals);
            if (!empty($valor)) {
                $html_area .= "<span class='label'>Longitude: </span><span class='longitude-value'>" . htmlspecialchars($valor) . "</span>, ";
            }
        } elseif (strpos($detals, 'Data de coleta: ') !== false) {
            $data_original = str_replace('Data de coleta: ', '', $detals);
            if (!empty($data_original) && strtotime($data_original) !== false) {
                $data_formatada = date('d/m/Y', strtotime($data_original));
                $html_area .= "<span class='label'>Data de coleta: </span><span class='data-value'>" . htmlspecialchars($data_formatada) . "</span>, ";
            }
        }
    }

    $html_area = rtrim($html_area, ', '); // Remove a vírgula extra no final

    if (!empty($html_area)) {
        $area_html .= "<div class='ponto-coleta'>{$html_area}</div><br>";
    }
}


if (!empty($area_html)) {
    echo "<div class='linha' id='coluna-esq-dir'>"; // Linha principal
    echo "<div class='coluna' id='colun-esq'><span class='colun-esq'>Área de coleta:</span></div>";
    echo "<div class='coluna' id='colun-dir'>";
    echo $area_html; // Todas as áreas em uma única div
    echo "</div>";
    echo " </div>";
}

                
                echo "<div class='linha' id='coluna-esq-dir'>"; // arquivo
                echo "<div class='coluna' id='colun-esq'><span class='colun-esq'> Tabela: </span></div>";
        
                // Ensure $row['nome_arquivo'] is a string before using htmlspecialchars
                $nome_arquivo = is_string($row['nome_arquivo']) ? htmlspecialchars($row['nome_arquivo']) : '';
        
                echo "<div class='coluna' id='colun-dir'>" . $nome_arquivo . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a id='btn'  class='fa fa-download' id='download' href='../PHP/download.php?id=". htmlspecialchars($id) . "'> Download </a>
                
                <a id='btn-visu' class='fa fa-eye' href='#' onclick='n(); return false;'>EM BREVE:</br> Visualizador</a></div>"; 
                echo "</div>"; // arquivo 
        
                
                echo "<a href='consulta.php' id='voltar' class='voltar'> &laquo; Voltar</a> ";

               

                echo "</div>"; // DIV SECUNDÁRIA
            }
    

            } else {
                echo "<p>Nenhum registro encontrado para o ID: $id</p>";
            }
        } catch (PDOException $e) {
            echo "Erro: " . $e->getMessage();
        
        } finally {
            // Fecha a conexão com o banco de dados
            if ($pdo) {
                $pdo = null;
            }
        }
    } else {
        echo "<p>ID não especificado.</p>";
    }
    ?>
                           
            
 


    <!-- Footer -->
    <footer id="contact" class="py-5 bg-dark" style="position: relative;">
    <div class="footer-container">
        <div class="column1">
            <p style="text-align: justify;" class="text-white">Este banco de dados é produto do projeto “Um banco de dados de registros proxy do Atlântico Sudoeste nos últimos 2 mil anos para projeções climáticas mais robustas no passado e futuro (2023 - atual)” CNPq processo n° - Chamada CNPq/MCTI/FNDCT Nº 59/2022 (Linha 5).</p>
        </div>

        <div class="column2">
            <p class="text-white">Copyright &copy; ProxyMar 2024</p>
            <a href="https://www.instagram.com/proxymar_iousp/" target="_blank" class="bi bi-instagram"></a>
            <a href="https://sites.usp.br/proxymar/sobre/" target="_blank" class="bi bi-globe2"></a>
            <a href="mailto:proxymar@usp.br" target="_blank" class="bi bi-envelope"></a>
        </div>
        
        <div class="column3">
            <div>
                <p> Execução:</p>
                <a href="https://www5.usp.br"><img style="background-color: white;" src="https://imagens.usp.br/wp-content/uploads/usp-logo-transp-600x253.png" width="120"></a>
                <a href="https://www.io.usp.br"><img  src="https://www.io.usp.br/templates/base/img/logo.png" width="120"></a>
                <a href="https://sites.usp.br/proxymar/"><img style="background-color: white;" src="../assets/ProxyMar-logo.png" width="120"></a>
            </div>
            <div>
                <p> Financiamento:</p>
                <a href="https://www.gov.br/cnpq/pt-br"><img src="../assets/CNPq-logo.png" width="120"></a>
                <a href="https://www.gov.br/mcti/pt-br"><img src="../assets/MCTI.png" width="120"></a>
                <a href="https://www.gov.br/mcti/pt-br/acompanhe-o-mcti/fndct"><img src="../assets/fndct.png" width="120"></a>

            </div>
        </div>
    </footer>
    

    <!-- Bootstrap core JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

</body>
</html>