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
    <link rel="icon" type="image/x-icon" href="../assets/ProxyMar-logo.png"  />
   
    <link href="../css/submit.css" rel="stylesheet" />

    

    <link href="../css/stylesG.css" rel="stylesheet" />

    <link href="../css/footer.css" rel="stylesheet" />
    
    <link href="../css/resultado.css" rel="stylesheet" />

    <script src="../js/add-script.js"></script>

    <script src= "../js/scripts.js"></script>

</head>


<body>
   <!-- Navigation -->
   <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
        <div class="container px-4">            
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

function formatarNome($nomeCompleto) {
    // Converte o nome para minúsculas e capitaliza as primeiras letras
    return mb_convert_case(mb_strtolower($nomeCompleto, 'UTF-8'), MB_CASE_TITLE, 'UTF-8');
}

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


        $autoresArray = explode(',', $row['autores']); // Corrigido para $row
        $autoresFormatados = array_map('formatarNome', $autoresArray);
        $autoresString = implode(', ', $autoresFormatados);


                        // DADOS
                echo "<div class='resultados'>

                
                    <h2> Detalhes do Projeto e Dados coletados: </h2>";
                 
        

                echo "<div class='left-section'>";

                echo "<div class='info'>"; 

                echo "<div><strong>Título do projeto principal: </strong>" . htmlspecialchars($row['tituloprinc']) . "</div>";
                
                
                echo "<div><strong>Autores: </strong>". htmlspecialchars($autoresString). "</div>"; // TIRAR DO MAIÚSCULO

                
                echo "<div> <strong>Correspondente: </strong>" . htmlspecialchars($row['correspondente']) . "&nbsp;&nbsp; <i>(" . htmlspecialchars($row['email']) . ")</i></div>";
                

                
               
               
                
                echo "<div><strong>Título atribuido para os Dados: </strong>" . htmlspecialchars($row['titulodado']) . "</div>";
              
                
               

                echo "<div><strong>Financiamento: </strong>" . htmlspecialchars($row['funding']) . "</div>";


                echo "<div><strong>Tipo de Armazenamento: </strong>" . htmlspecialchars($row['tipotrabalho']) . "&nbsp;&nbsp; (" . htmlspecialchars($row['armazenamento']) . ")</div>";
               
            
                echo "</div>"; //fechar info

                echo "</div>"; // left section


                echo "<div class='right-section'>";
                echo "<div class='map-container'>";
                echo "<p> Mapa carregada aqui </p>";
                echo "</div>";
                echo "</div>";
                
                

                    //METODOLOGIA E FERRRAMENTRAS 
                echo "<div class='metodologia'>

                
                    <h2>Metodologia e Ferramentas: </h2>";

                    echo "<div class='left-section'>";

                    echo "<div class='info'>";

                    
                    echo "<div><strong>Resumo para os dados: </strong>" . htmlspecialchars($row['red_dado']) . "</div>";
                    

                   
                    echo "<div><strong>Tipo de amostra: </strong>". htmlspecialchars($row['tipoamst']) . "</div>";
                    
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
        
               
                echo "<div><strong>Ferrmenta(s) Utilizada(s): </strong>" . implode(", ", $proxys) . "</div>"; // Exibe os proxies em uma linha
                

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
        
                
                echo "<div><strong> Equipamento(s) utilizado(s): </strong>" . implode(", ", $equipcoleta) . "</div>"; // Exibe os proxies em uma linha
               
                $pontos_coleta = explode(' | ', $row['pontos_coleta']);
                $html_coleta = ''; // Inicializa a variável que armazenará todas as linhas da tabela
                
                foreach ($pontos_coleta as $ponto) {
                    // Separar os detalhes do ponto de coleta
                    $detalhes = explode(', ', $ponto);
                    $html_ponto = '<tr>'; // Inicializa a linha da tabela
                    $linha_valida = false; // Flag para verificar se há conteúdo real
                
                    foreach ($detalhes as $detalhe) {
                        if (strpos($detalhe, 'ID: ') !== false) {
                            $valor = str_replace('ID: ', '', $detalhe);
                            $html_ponto .= !empty($valor) ? "<td>" . htmlspecialchars($valor) . "</td>" : "<td>-</td>";
                            if (!empty($valor)) $linha_valida = true;
                        } elseif (strpos($detalhe, 'Latitude: ') !== false) {
                            $valor = str_replace('Latitude: ', '', $detalhe);
                            $html_ponto .= !empty($valor) ? "<td>" . htmlspecialchars($valor) . "</td>" : "<td>-</td>";
                            if (!empty($valor)) $linha_valida = true;
                        } elseif (strpos($detalhe, 'Longitude: ') !== false) {
                            $valor = str_replace('Longitude: ', '', $detalhe);
                            $html_ponto .= !empty($valor) ? "<td>" . htmlspecialchars($valor) . "</td>" : "<td>-</td>";
                            if (!empty($valor)) $linha_valida = true;
                        } elseif (strpos($detalhe, 'Data de coleta: ') !== false) {
                            $data_original = str_replace('Data de coleta: ', '', $detalhe);
                            $data_formatada = (!empty($data_original) && strtotime($data_original) !== false) 
                                ? date('d/m/Y', strtotime($data_original)) 
                                : '-';
                            $html_ponto .= "<td>" . htmlspecialchars($data_formatada) . "</td>";
                            if (!empty($data_original)) $linha_valida = true;
                        }
                    }
                
                    $html_ponto .= '</tr>'; // Fecha a linha da tabela
                
                    // Adiciona a linha à tabela apenas se houver dados válidos
                    if ($linha_valida) {
                        $html_coleta .= $html_ponto;
                    }
                }
                
                // Só exibir a estrutura "Pontos de Coleta" se houver conteúdo útil
                if (trim(strip_tags($html_coleta)) !== '') {
                    echo "<div><strong>Ponto(s) de coleta:</strong>";
                    echo "<table border='1' cellspacing='0' cellpadding='5'>";
                    echo "<thead>";
                    echo "<tr>";
                    echo "<th>ID</th>";
                    echo "<th>Latitude</th>";
                    echo "<th>Longitude</th>";
                    echo "<th>Data de coleta</th>";
                    echo "</tr>";
                    echo "</thead>";
                    echo "<tbody>";
                    echo $html_coleta; // Exibe todos os pontos de coleta formatados corretamente
                    echo "</tbody>";
                    echo "</table>";
                    echo "</div>"; // Fecha a div
                }
                
    
    
                $area_coleta = explode(' | ', $row['area_coleta']);
                $area_html = ''; // Inicializa uma string para armazenar todo o HTML formatado
                $areas_processadas = []; // Array para armazenar as áreas já processadas
                
                foreach ($area_coleta as $area) {
                    if (in_array($area, $areas_processadas) || empty(trim($area))) {
                        continue; // Pule áreas duplicadas ou vazias
                    }
                
                    $areas_processadas[] = $area; // Marque esta área como processada
                    $detal = explode(', ', $area);
                    $html_area = '<tr>'; // Resetar o HTML da área para cada iteração
                    $linha_valida = false; // Variável para verificar se a linha tem dados
                
                    foreach ($detal as $detals) {
                        if (strpos($detals, 'ID: ') !== false) {
                            $valor = str_replace('ID: ', '', $detals);
                            $html_area .= !empty($valor) ? "<td>" . htmlspecialchars($valor) . "</td>" : "<td>-</td>";
                            if (!empty($valor)) $linha_valida = true;
                        } elseif (strpos($detals, 'Latitude: ') !== false) {
                            $valor = str_replace('Latitude: ', '', $detals);
                            $html_area .= !empty($valor) ? "<td>" . htmlspecialchars($valor) . "</td>" : "<td>-</td>";
                            if (!empty($valor)) $linha_valida = true;
                        } elseif (strpos($detals, 'Longitude: ') !== false) {
                            $valor = str_replace('Longitude: ', '', $detals);
                            $html_area .= !empty($valor) ? "<td>" . htmlspecialchars($valor) . "</td>" : "<td>-</td>";
                            if (!empty($valor)) $linha_valida = true;
                        } elseif (strpos($detals, 'Data de coleta: ') !== false) {
                            $data_original = str_replace('Data de coleta: ', '', $detals);
                            $data_formatada = (!empty($data_original) && strtotime($data_original) !== false) 
                                ? date('d/m/Y', strtotime($data_original)) 
                                : '-';
                            $html_area .= "<td>" . htmlspecialchars($data_formatada) . "</td>";
                            if (!empty($data_original)) $linha_valida = true;
                        }
                    }
                
                    $html_area .= '</tr>'; // Fecha a linha da tabela
                
                    // Adiciona a linha apenas se houver dados válidos
                    if ($linha_valida) {
                        $area_html .= $html_area;
                    }
                }
                
                // Verifica se há realmente conteúdo na tabela antes de exibir
                if (trim(strip_tags($area_html)) !== '') {
                    echo "<div><strong>Área de coleta:</strong>";
                    echo "<table>";
                    echo "<thead>";
                    echo "<tr>";
                    echo "<th>ID</th>";
                    echo "<th>Latitude</th>";
                    echo "<th>Longitude</th>";
                    echo "<th>Data de coleta</th>";
                    echo "</tr>";
                    echo "</thead>";
                    echo "<tbody>";
                    echo $area_html; // Exibe todas as áreas formatadas corretamente
                    echo "</tbody>";
                    echo "</table>";
                    echo "</div>"; // Fecha a div
                }
                
                echo "</div>"; //fechar info
                echo "</div>"; // left section
                echo "</div>";// METODOLOFIA E FERRAMENTAS
                
               
               
                echo "<div class='tabela'>

                
                <h2>Visualizaçao e Download: </h2>";

                echo "<div class='visualizacao'> ";

                              
                echo "<iframe src='../PHP/visualizar.php?id=" . $id .  "'width='100%' height='500Va'></iframe>";

                echo "</div >"; 

                echo "<div class='download'>"; // Download

                $nome_arquivo = is_string($row['nome_arquivo']) ? htmlspecialchars($row['nome_arquivo']) : '';
        
                echo "<div class='nome_arquivo'>" . $nome_arquivo . "</div></br>";

                echo "<a id='btn'  class='fa fa-download' id='download' href='../PHP/download.php?id=". htmlspecialchars($id) . "'> Download </a>";
                
                echo "</div>"; 
                echo "</div> </br></br>"; // arquivo 
                
                
                echo "<a href='consulta.php' id='voltar' class='voltar'> &laquo; Voltar</a> ";








                    echo "</div>"; //fechar info
                    echo "</div>"; // left section
                    echo "</div>";// Tabela Arquivos




                    echo "</div>";// DADOs
                

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
    <footer  class="py-5 bg-dark" style="position: relative;">
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
                <p class="text-black"> Execução:</p>
                <a href="https://www5.usp.br"><img style="background-color: white;" src="https://imagens.usp.br/wp-content/uploads/usp-logo-transp-600x253.png" width="120"></a>
                <a href="https://www.io.usp.br"><img  src="https://www.io.usp.br/templates/base/img/logo.png" width="120"></a>
                <a href="https://sites.usp.br/proxymar/"><img style="background-color: white;" src="../assets/ProxyMar-logo.png" width="120"></a>
            </div>
            <div>
                <p class="text-black"> Financiamento:</p>
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