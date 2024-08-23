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
    <link href="../css/submit.css" rel="stylesheet"/>
    <link href="../css/styles.css" rel="stylesheet" />
    
    <link href="../css/resultado.css" rel="stylesheet" />

    <script src="../js/add-script.js"></script>
    <script src="../js/script.js"></script>

    <style>
    /* Estilos do preloader */
    #preloader {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: white;
      z-index: 9999;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    #preloader.hidden {
      display: none;
    }

    /* Adicione estilos adicionais para o preloader aqui */
  </style>

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
                    <li class="nav-item"><a class="nav-link" href="#" onclick="openLoginDialog(); closeNavbar()">Login</a></li>
                    <li class="nav-item"><a class="nav-link" href="novo-user.html" onclick=closeNavbar()>Sing in</a></li>
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
            $sql = "
           WITH autores_agregados AS (
    SELECT
        infogeral.geralID,
        STRING_AGG(a.autor, ', ' ORDER BY taf.ordem) AS autores
    FROM infogeral
    LEFT JOIN trabalhos_autores_filiacao taf ON infogeral.geralID = taf.trabalhoID
    LEFT JOIN autores a ON taf.autorID = a.autID
    GROUP BY infogeral.geralID
)
SELECT 
    infogeral.correspondente,
    infogeral.email,
    infogeral.tipotrabalho,
    infogeral.armazenamento,
    infogeral.termo,
    infogeral.titulo,
    infogeral.periodico,
    infogeral.linkart,
    infogeral.doi,
    infogeral.data1,
    infogeral.keywords,
    caractDado.caract,
    caractDado.metut,
    arquivos.nome_arquivo,
    arquivos.uploaded_at,
    proxys.TSM,
    proxys.PP,
    proxys.circulacao,
    proxys.org,
    proxys.inorg,
    proxys.foramplan,
    proxys.forambent,
    proxys.seaLev,
    proxys.co2atm,
    proxys.cobveg,
    proxys.rainfall,
    proxys.stratg,
    proxys.outroprox,
    equipcoleta.multcorer,
    equipcoleta.piston,
    equipcoleta.gravcorer,
    equipcoleta.drilli,
    equipcoleta.gboxcorer,
    equipcoleta.compcorer,
    equipcoleta.boxcorer,
    equipcoleta.corer,
    equipcoleta.outroequi,
    autores_agregados.autores,
    STRING_AGG(DISTINCT CONCAT_WS(', ', 
        'ID: ' || pontos_coleta.id_amst, 
        'Latitude: ' || pontos_coleta.latitude, 
        'Longitude: ' || pontos_coleta.longitude, 
        'Profundidade: ' || pontos_coleta.prof, 
        'Recuperação sedimentar: ' || pontos_coleta.recuperacao, 
        'Data de coleta: ' || pontos_coleta.data2), ' | ') AS pontos_coleta
FROM infogeral
LEFT JOIN caractDado ON infogeral.geralID = caractDado.trabalhoId
LEFT JOIN arquivos ON infogeral.geralID = arquivos.trabalhoID
LEFT JOIN proxys ON infogeral.geralID = proxys.trabalhoID
LEFT JOIN equipcoleta ON infogeral.geralID = equipcoleta.trabalhoID
LEFT JOIN pontos_coleta ON infogeral.geralID = pontos_coleta.trabalhoID
LEFT JOIN autores_agregados ON infogeral.geralID = autores_agregados.geralID
WHERE infogeral.geralID = :id
GROUP BY infogeral.geralID, 
         infogeral.correspondente,
         infogeral.email,
         infogeral.tipotrabalho,
         infogeral.armazenamento,
         infogeral.termo,
         infogeral.titulo,
         infogeral.periodico,
         infogeral.linkart,
         infogeral.doi,
         infogeral.data1,
         infogeral.keywords,
         caractDado.caract,
         caractDado.metut,
         arquivos.nome_arquivo,
         arquivos.uploaded_at,
         proxys.TSM,
         proxys.PP,
         proxys.circulacao,
         proxys.org,
         proxys.inorg,
         proxys.foramplan,
         proxys.forambent,
         proxys.seaLev,
         proxys.co2atm,
         proxys.cobveg,
         proxys.rainfall,
         proxys.stratg,
         proxys.outroprox,
         equipcoleta.multcorer,
         equipcoleta.piston,
         equipcoleta.gravcorer,
         equipcoleta.drilli,
         equipcoleta.gboxcorer,
         equipcoleta.compcorer,
         equipcoleta.boxcorer,
         equipcoleta.corer,
         equipcoleta.outroequi,
         autores_agregados.autores
ORDER BY infogeral.geralID";
        
        
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $infogeral = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        if (!empty($infogeral)) {
            foreach ($infogeral as $row) {
                // Exibe os detalhes na página resultados.html
                echo "<div id='principal1'>
                    <span id='principal1'> RESULTADO DA PESQUISA </span>
                </div>"; // DIV PRINCIPAL
        
                echo "<div class='principal2'>"; // DIV SECUNDÁRIA
                echo "<a href='consulta.php' id='voltar' class='voltar'> &laquo; Voltar</a></br>";
        
                echo "<div class='linha' id='coluna-esq-dir'>"; // div corr
                echo "<div class='coluna' id='colun-esq'><span class='colun-esq'> Correspondente:</span></div>";
                echo "<div class='coluna' id='colun-med'>" . htmlspecialchars($row['correspondente']) . "&nbsp;&nbsp; <i>(" . htmlspecialchars($row['email']) . ")</i></div>";
                echo "</div>"; // div corr
        
                echo "<div class='linha' id='coluna-esq-dir'>"; // div tit
                echo "<div class='coluna' id='colun-esq'><span class='colun-esq'> Título:</span></div>";
                echo "<div class='coluna' id='colun-med'>" . htmlspecialchars($row['titulo']) . "</div>";
                echo "</div>"; // div tit
        
                echo "<div class='linha' id='coluna-esq-dir'>"; // autores
                echo "<div class='coluna' id='colun-esq'><span class='colun-esq'> Autores:</span></div>";
                echo "<div class='coluna' id='colun-med'>" . htmlspecialchars($row['autores']) . "</div>";
                echo "</div>"; // autores
        
                echo "<div class='linha' id='coluna-esq-dir'>"; // tipo
                echo "<div class='coluna' id='colun-esq'><span class='colun-esq'> Tipo de trabalho/ Armazenamento:</span></div>";
                echo "<div class='coluna' id='colun-med'>" . htmlspecialchars($row['tipotrabalho']) . "&nbsp;&nbsp; (" . htmlspecialchars($row['armazenamento']) . ")</div>";
                echo "</div>"; // tipo
        
                echo "<div class='linha' id='coluna-esq-dir'>"; // periódico
                echo "<div class='coluna' id='colun-esq'><span class='colun-esq'> Periódico:</span></div>";
                echo "<div class='coluna' id='colun-med'>" . htmlspecialchars($row['periodico']) . "&nbsp;&nbsp; <a href='" . htmlspecialchars($row['linkart']) . "'> Link para o artigo </a></div>";
                echo "</div>"; // periódico
        
                echo "<div class='linha' id='coluna-esq-dir'>"; // doi
                echo "<div class='coluna' id='colun-esq'><span class='colun-esq'> DOI:</span></div>";
                echo "<div class='coluna' id='colun-med'> <a href='https://doi.org/" . htmlspecialchars($row['doi']) . "'>" . htmlspecialchars($row['doi']) . "</a></div>";
                echo "</div>"; // doi
        
                
        
                echo "<div class='linha' id='coluna-esq-dir'>"; // data
                echo "<div class='coluna' id='colun-esq'><span class='colun-esq'> Data da publicação: </span></div>";
                echo "<div class='coluna' id='colun-dir'>" . htmlspecialchars($row['data1']) . "</div>";
                echo "</div>"; // data
        
                echo "<div class='linha' id='coluna-esq-dir'>"; // keywords
                echo "<div class='coluna' id='colun-esq'><span class='colun-esq'> Palavras-chave:</span></div>";
                echo "<div class='coluna' id='colun-dir'>" . htmlspecialchars($row['keywords']) . "</div>";
                echo "</div>"; // keywords
        
                echo "<div class='linha' id='coluna-esq-dir'>"; // caracteristicas
                echo "<div class='coluna' id='colun-esq'><span class='colun-esq'> Característica dos dados inseridos:</span></div>";
                echo "<div class='coluna' id='colun-dir'>" . htmlspecialchars($row['caract']) . "</div>";
                echo "</div>"; // caracteristicas
        
                echo "<div class='linha' id='coluna-esq-dir'>"; // método
                echo "<div class='coluna' id='colun-esq'><span class='colun-esq'> Métodos de análises utilizados:</span></div>";
                echo "<div class='coluna' id='colun-dir'>" . htmlspecialchars($row['metut']) . "</div>";
                echo "</div>"; // método
        
                $proxys = [];
                if ($row['tsm']) $proxys[] = "Temperatura da Superfície do Mar";
                if ($row['pp']) $proxys[] = "Produção Primária";
                if ($row['circulacao']) $proxys[] = "Circulação";
                if ($row['org']) $proxys[] = "Orgânico";
                if ($row['inorg']) $proxys[] = "Inorgânico";
                if ($row['foramplan']) $proxys[] = "Foraminífero Planctônico";
                if ($row['forambent']) $proxys[] = "Foraminífero Bentônico";
                if ($row['sealev']) $proxys[] = "Nível do Mar";
                if ($row['co2atm']) $proxys[] = "CO2 Atmosférico";
                if ($row['cobveg']) $proxys[] = "Cobertura Vegetal";
                if ($row['rainfall']) $proxys[] = "Precipitação";
                if ($row['stratg']) $proxys[] = "Estratigrafia";
                if ($row['outroprox']) $proxys[] = htmlspecialchars($row['outroprox']);
        
                echo "<div class='linha' id='coluna-esq-dir'>"; // prox
                echo "<div class='coluna' id='colun-esq'><span class='colun-esq'> Proxies utilizados: </span></div>";
                echo "<div class='coluna' id='colun-dir'>" . implode(", ", $proxys) . "</div>"; // Exibe os proxies em uma linha
                echo "</div>"; // prox
        
                $equipcoleta = [];
                if ($row['multcorer']) $equipcoleta[] = "Multicorer";
                if ($row['piston']) $equipcoleta[] = "Piston";
                if ($row['gravcorer']) $equipcoleta[] = "Gravity Corer";
                if ($row['drilli']) $equipcoleta[] = "Drilling";
                if ($row['gboxcorer']) $equipcoleta[] = "Giant Boxcorer";
                if ($row['compcorer']) $equipcoleta[] = "Composite Corer";
                if ($row['boxcorer']) $equipcoleta[] = "Boxcorer";
                if ($row['outroequi']) $equipcoleta[] = htmlspecialchars($row['outroequi']);
        
                echo "<div class='linha' id='coluna-esq-dir'>"; // equi
                echo "<div class='coluna' id='colun-esq'><span class='colun-esq'> Equipamento(s) utilizado(s): </span></div>";
                echo "<div class='coluna' id='colun-dir'>" . implode(", ", $equipcoleta) . "</div>"; // Exibe os proxies em uma linha
                echo "</div>"; // equi
        
                echo "<div class='linha' id='coluna-esq-dir'>"; // pontos
                echo "<div class='coluna' id='colun-esq'><span class='colun-esq'> Pontos de Coleta:</span></div>";
                echo "<div class='coluna' id='colun-dir'>";
        
                $pontos_coleta = explode(' | ', $row['pontos_coleta']);
                foreach ($pontos_coleta as $ponto) {
                    // Separar os detalhes do ponto de coleta
                    $detalhes = explode(', ', $ponto);
        
                    // Inicializar uma string para armazenar o HTML formatado
                    $html_ponto = '';
        
                    // Iterar sobre os detalhes e aplicar os estilos conforme necessário
                    foreach ($detalhes as $detalhe) {
                        if (strpos($detalhe, 'ID: ') !== false) {
                            $valor = str_replace('ID: ', '', $detalhe);
                            $html_ponto .= "<span class='label'>ID: </span><span class='id-value'>" . htmlspecialchars($valor) . "</span>, ";
                        } elseif (strpos($detalhe, 'Latitude: ') !== false) {
                            $valor = str_replace('Latitude: ', '', $detalhe);
                            $html_ponto .= "<span class='label'>Latitude: </span><span class='latitude-value'>" . htmlspecialchars($valor) . "</span>, ";
                        } elseif (strpos($detalhe, 'Longitude: ') !== false) {
                            $valor = str_replace('Longitude: ', '', $detalhe);
                            $html_ponto .= "<span class='label'>Longitude: </span><span class='longitude-value'>" . htmlspecialchars($valor) . "</span>, ";
                        } elseif (strpos($detalhe, 'Profundidade: ') !== false) {
                            $valor = str_replace('Profundidade: ', '', $detalhe);
                            $html_ponto .= "<span class='label'>Profundidade(m): </span><span class='profundidade-value'>" . htmlspecialchars($valor) . "</span>, ";
                        } elseif (strpos($detalhe, 'Recuperação sedimentar: ') !== false) {
                            $valor = str_replace('Recuperação sedimentar: ', '', $detalhe);
                            $html_ponto .= "<span class='label'>Recuperação sedimentar(m): </span> <span class='recuperacao-value'>" . htmlspecialchars($valor) . "</span>, ";
                        } elseif (strpos($detalhe, 'Data de coleta: ') !== false) {
                            // Formatar a data
                            $data_original = str_replace('Data de coleta: ', '', $detalhe);
                            $data_formatada = date('d/m/Y', strtotime($data_original));
                            $html_ponto .= "<span class='label'>Data de coleta: </span><span class='data-value'>" . htmlspecialchars($data_formatada) . "</span>, ";
                        }
                    }
        
                    // Remover a última vírgula e espaço
                    $html_ponto = rtrim($html_ponto, ', ');
        
                    // Exibir o ponto de coleta formatado
                    echo "<div>" . $html_ponto . "</div></br>";
                }
        
                echo "</div>"; // pontos
                echo "</div>"; // linha
        
                echo "<div class='linha' id='coluna-esq-dir'>"; // arquivo
                echo "<div class='coluna' id='colun-esq'><span class='colun-esq'> Tabela de dado: </span></div>";
        
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
                           
            
  <script>
    // Remove o preloader após o carregamento da página
    window.addEventListener('load', () => {
      document.getElementById('preloader').classList.add('hidden');
    });
  </script>


    <!-- Footer -->
    <footer id="contact" class="py-5 bg-dark" style="position: relative; margin-top:50px;">
        <div class="social">
            <p class="text-white">Copyright &copy; Italo Paladino 2024</p>
            <br><br>
            <a href="https://www.instagram.com/proxymar_iousp/" target="_blank" class="bi bi-instagram"></a>
            <a href="https://sites.usp.br/proxymar/sobre//" target="_blank" class="bi bi-globe2"></a>
            <a href="mailto:italopaladino22@gmail.com" target="_blank" class="bi bi-envelope"></a>
        </div>
    </footer>
    

    <!-- Bootstrap core JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

</body>
</html>