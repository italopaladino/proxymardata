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
    <link rel="icon" type="image/x-icon" href="../assets/mac.ico" />
    <link href="../css/submit.css" rel="stylesheet"/>
    <link href="../css/styles.css" rel="stylesheet" />
    <link href="../css/consulta.css" rel="stylesheet" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    
    <script src="../js/add-script.js"></script>
    <script src="../js/scripts.js"></script>

    <style>
    /* Estilo do preloader */
    #preloader {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background:white;
      z-index: 9999;
      display: flex;
      align-items: center;
      justify-content: center;
      overflow: hidden;
    }

    .logo {
      width: 300px; /* Ajuste o tamanho da logo conforme necessário */
      animation: fadeInOut 3s ease-in-out infinite;
    }

    @keyframes fadeInOut {
      0%, 100% {
        opacity: 0;
      }
      50% {
        opacity: 1;
      }
    }

    /* Conteúdo da página */
    #content {
      display: none; /* Esconde o conteúdo até que o carregamento seja concluído */
    }
    
  </style>


</head>
<body id="page1">
    
<!-- Preloader com a logo -->
<div id="preloader">
    <img src="../assets/avatar.jpeg" alt="Logo" class="logo"> <!-- Substitua 'logo.png' pelo caminho da sua logo -->
  </div>

   <!-- Navigation -->
   <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
        <div class="container px-4">
            <div class="search1">
                <input style="left: 0%;" id="search1" type="text" name="search" placeholder="Search.." onclick="n()">
                <button style="left: 0%;"><i class="bi bi-search" onclick="n()"></i></button>
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
                    <!--<li class="nav-item"><a class="nav-link" href="#" onclick="openLoginDialog(); closeNavbar()">Login</a></li>
                    <li class="nav-item"><a class="nav-link" href="novo-user.html" onclick=closeNavbar()>Sing in</a></li>-->
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

    <div class="flex-wrapper" style="border:none;">


     <div id="primeiraPart" class="filter-forms" >   

    <div class="filter-top-forms bordaPag bg-primary" >
                <h4><span id="filter-forms-label">Busca Avançada:</span></h4>
                <div class="search3">
    <input id="filtro-geral" class="search3"placeholder="Filtragem (em construção...)" readonly>
</div>
</div>  


            
            <!--<form class="form-filter">
            <div id="filtroAtv>
            <h1 class="form-tip">Filtros ativo:</h1>

            <div id="filtro-ativo">

            </div>
</div>        -->

      <div id="segundaPart" class="bordaPag" style="background-color:ghostwhite;">

        <div id="todos os filtros" class="bordaDentro">
                <h2 class="form-tip">Tipo de trabalho:</h2>
                <div class="top-tipo" id="top-tipo">
                    <!-- deixar fixado -->
                </div>

                <!-- Lista de anos de publicação será carregada aqui -->
                <h2 class="form-tip">Ano de Coleta:</h2>
                <!-- linkar com os anos que tem no banco deixar últimos 5 -->
                <div id="top-ano-coleta">    
                </div>

                <!--<h2 class="form-tip">Autores:</h2>
                <div class="top-autores" id="top-autores">
                </div>-->

                <h2 class="form-tip">Tipo de amostra:</h2>
                <div class="top-tipAmost" id="top-tipAmost">
                </div>

                <h2 class="form-tip">Ferramenta(s) utilizada(s):</h2>
                <div class="top-ferra" id="top-ferra">
                </div>

                <h2 class="form-tip">Equipamento(s) utilizado(s):</h2>
                <div id="top-equi" class="top-equi">
                </div>

                <h2 class="form-tip">Armazenamento:</h1>
                <div id="top-armaz" class="top-armaz">
                </div>

                <h2 class="form-tip">Projeto:</h1>
                <div id="projeto" class="projeto">
                </div>

                <h2 class="form-tip">IDs:</h1>
                <div id="ID_amst" class="ID_amst">
                </div>

            </div>
      


    <!-- Links de Resultados -->
    <div class="resultados">
        <!-- Os links serão preenchidos aqui -->
    </div>
    </div>
     </div> 
     
     

        <div class="results-consult" >
            <div class="filter-top-forms bordaPag bg-primary">
                <h4><span id="result-fomrs">Disponíveis no banco de dados:</span></h4>
            </div>
            <div class="bordaPag" style="background-color:ghostwhite;">
                <div>
                    <div class="col">
                        <div id="ultimosartigos" class="table-responsive bordaDentro">
                            <!-- Os resultados da consulta serão exibidos aqui -->
                        </div>
                                               
                    </div>
                </div>
            </div>
        </div>
    </div>

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
    <script>
$(document).ready(function() {
    console.log("jQuery está funcionando.");

    // Função para carregar todos os artigos
    function carregarTodosArtigos() {
        $.ajax({
            url: "../PHP/consulta-art-geral.php",
            type: "GET",
            success: function(response) {
                $("#ultimosartigos").html(response);
            },
            error: function(xhr, status, error) {
                console.error("Erro ao consultar artigos:", status, error);
            }
        });
    }

    // Função para carregar filtros
    function carregarFiltros() {
        $.ajax({
            url: "../PHP/top-tipo.php",
            type: "GET",
            success: function(response) {
                $("#top-tipo").html(response);
            

            //adicionar evento ao de clique no botão tipo
            $(".tipo-button").click(function(){
                var tipo =$(this).tipo("tipo");
                console.log("tipo selecionado:", tipo);
                carregarTipoTrabalho(tipo);

            });
        },
            error: function(xhr, status, error) {
                console.error("Erro ao consultar tipos:", status, error);
            }
                
        });


         $.ajax({
            url: "../PHP/top-ano-coleta.php",
            type: "GET",
            success: function(response) {
                $("#top-ano-coleta").html(response);
            },
            error: function(xhr, status, error) {
                console.error("Erro ao consultar ano de coleta:", status, error);
            }
        });

        
        $.ajax({
            url: "../PHP/projeto.php",
            type: "GET",
            success: function(response) {
                $("#projeto").html(response);
            },
            error: function(xhr, status, error) {
                console.error("Erro ao consultar ano de coleta:", status, error);
            }
        });


        $.ajax({
            url: "../PHP/ID_amst.php",
            type: "GET",
            success: function(response) {
                $("#ID_amst").html(response);
            },
            error: function(xhr, status, error) {
                console.error("Erro ao consultar ano de coleta:", status, error);
            }
        });


        $.ajax({
            url: "../PHP/top-ferra.php",
            type: "GET",
            success: function(response) {
                $("#top-ferra").html(response);
            },
            error: function(xhr, status, error) {
                console.error("Erro ao consultar proxies:", status, error);
            }
        });


        $.ajax({
            url: "../PHP/top-tipAmost.php",
            type: "GET",
            success: function(response) {
                $("#top-tipAmost").html(response);
            },
            error: function(xhr, status, error) {
                console.error("Erro ao consultar proxies:", status, error);
            }
        });



        $.ajax({
            url: "../PHP/top-equi.php",
            type: "GET",
            success: function(response) {
                $("#top-equi").html(response);
            },
            error: function(xhr, status, error) {
                console.error("Erro ao consultar equipamentos:", status, error);
            }
        });
    }

 $.ajax({
            url: "../PHP/top-armaz.php",
            type: "GET",
            success: function(response) {
                $("#top-armaz").html(response);
            },
            error: function(xhr, status, error) {
                console.error("Erro ao consultar proxies:", status, error);
            }
        });

        

// Filtro para ano de publicação
function carregarResultadosano(ano) {
    $.ajax({
        url: "../PHP/filtros-ano-pub.php",
        type: "GET",
        data: { ano: ano },
        success: function(response) {
            $("#ultimosartigos").html(response);  // Atualiza a div com o id 'ultimosartigos'
            $("#filtro-ativo").html('<ul><li><u><span>' + ano + '</span></u> <button style="background-color: transparent; color: red; border: none;" id="remove-filtro">X</button></li></ul>');
            localStorage.setItem('anoSelecionado', ano);  // Armazena o ano selecionado
        },
        error: function(xhr, status, error) {
            console.error("Erro ao consultar artigos:", status, error);
        }
    });
}

// filtro para Tipo de Trabalho
function carregarTipoTrabalho(tipo) {
    $.ajax({
        url: "../PHP/filtro-tipo-trabalho.php",
        type: "GET",
        data: { tipo: tipo },
        success: function(response) {
            $("#ultimosartigos").html(response);  // Atualiza a div com o id 'ultimosartigos'
            $("#filtro-ativo").html('<ul><li><u><span>' + tipo + '</span></u> <button style="background-color: transparent; color: red; border: none;" id="remove-filtro">X</button></li></ul>');
            localStorage.setItem('tipoTrabalho', tipo);  // Armazena o tipo de trabalho selecionado
        },
        error: function(xhr, status, error) {
            console.error("Erro ao consultar artigos:", status, error);
        }
    });
}

// Evento de clique para remover o filtro
$(document).on('click', '#remove-filtro', function() {
    localStorage.removeItem('anoSelecionado');  // Remove o filtro de ano armazenado
    localStorage.removeItem('tipoTrabalho');  // Remove o filtro de tipo de trabalho armazenado
    $("#filtro-ativo").html('');  // Limpa o conteúdo do filtro ativo
    $("#ultimosartigos").html('');  // Opcional: Limpa os resultados exibidos
    carregarTodosArtigos();  // Recarrega todos os artigos
});

// Adiciona um listener de clique para cada link de ano
$(document).on('click', '.filtro-ano-pub a', function(event) {
    event.preventDefault();  // Evita o comportamento padrão do link
    var ano = $(this).data('ano');  // Obtém o valor do ano
    carregarResultadosano(ano);  // Carrega os resultados via AJAX
});

// Adiciona um listener de clique para cada link de tipo de trabalho
$(document).on('click', '.filtro-tipo-trabalho a', function(event) {
    event.preventDefault();  // Evita o comportamento padrão do link
    var tipo = $(this).data('tipo-trabalho');  // Obtém o valor do tipo de trabalho
    carregarTipoTrabalho(tipo);  // Carrega os resultados via AJAX
});

// Carregar filtros e artigos ao iniciar a página
carregarFiltros();

// Carregar todos os artigos inicialmente, pode ser removido se não for necessário
carregarTodosArtigos();

// Verifica se há um filtro armazenado e carrega os resultados filtrados
var ano = localStorage.getItem('anoSelecionado');
if (ano) {
    carregarResultadosano(ano);  // Carrega os resultados do ano armazenado
}

var tipo = localStorage.getItem('tipoTrabalho');
if (tipo) {
    carregarTipoTrabalho(tipo);  // Carrega os resultados do tipo de trabalho armazenado
}

});

    // Tempo fixo para o preloader
    const PRELOADER_TIMEOUT = 2500; // 3000ms = 3 segundos

    // Remove o preloader e exibe o conteúdo após o tempo fixo
    window.addEventListener('load', () => {
      setTimeout(() => {
        document.getElementById('preloader').style.display = 'none';
        document.getElementById('page1').style.display = 'block';
      }, PRELOADER_TIMEOUT);
    });

    </script>   
</body>
</html>
