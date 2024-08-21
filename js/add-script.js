function abrirPDF() {
    var url = "../assets/termo.pdf";
    window.open(url, "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=100,left=100,width=600,height=600");
}

        
document.addEventListener('keydown',handleKeyPress);

function handleKeyPress(event1, dialogAberto) {
    // Verificar se a tecla pressionada é a tecla "Esc" (código 27)
    if (dialogAberto){

    }
    if (event1.keyCode === 27) {
        closeLoginDialog();
    }
}


document.addEventListener('keydown', keysub);
    // Verificar se estamos na página "submit.html"
    function keysub(event){
    var paginaSubmit = verifPag();
    if (paginaSubmit) {
        // Verificar as teclas de avanço específicas para "submit.html"
        if (event.keyCode === 36) { //home
            proximaPagina();  
        } else if (event.keyCode === 35) { //end
            paginaAnterior();
        } else if (event.keyCode === 192) { // '
            exibirResumo();
            exibirDADOS();
        }
    }
}

// Função para verificar se a página atual é "submit.html"
function verifPag() {
    var paginaAtual = window.location.href;
    return paginaAtual.includes("submit.html");
}

//fechar barra de navegação 
function closeNavbar() {
        // Fecha o menu de navegação se estiver aberto
        var navbarResponsive = document.getElementById('navbarResponsive');
        if (navbarResponsive.classList.contains('show')) {
            var navbarToggleBtn = document.getElementById('navbarToggleBtn');
            navbarToggleBtn.click(); // Simula o clique para fechar o menu
        }
    }






//GET THE MODAL (W3-SCHOOL)

var modal = document.getElementById('lg3');

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}





// alerta para não funcionar 
function n(){
    window.alert('nao mexe aqui')
}







// SCRIPT PARA PAGINA DE INDEX - LOGIN - TECLA ESC
function openLoginDialog() {
    document.getElementById('loginDialogOverlay').style.display = 'flex';
    document.body.classList.add('dialog-open');
    dialogAberto = true;
    document.addEventListener('keydown', handleKeyPress);
    }

function closeLoginDialog() {
    document.getElementById('loginDialogOverlay').style.display = 'none';
    document.body.classList.remove('dialog-open');
    dialogAberto=false;
}

function performLogin() {
    var username = document.getElementById('username').value;
    var password = document.getElementById('password').value;

    // Adicione aqui a lógica de verificação de login em JavaScript
    // Exemplo simples: usuário "admin" e senha "password"
    
    if ($user && password_verify($senha, $user ['senha_hash'])) {
        alert('Login bem-sucedido!');
        closeLoginDialog();
    } else {
        alert('Login falhou! Verifique suas credenciais.');
    }

    return false; // Impede o envio do formulário tradicional
}


                  
var contadorAutores = 0;
function adicionarAutor() {
    // Container onde os campos de autor serão adicionados
    var container = document.getElementById("autoresContainer");
    
    // Criar um novo contêiner para o autor
    var novoAutorContainer = document.createElement("div");
    novoAutorContainer.className = "autor-campo";
    novoAutorContainer.id = "autorContainer" + contadorAutores;
    
    // Criar coluna para o nome completo
    var colunaNome = document.createElement("div");
    colunaNome.className = "colunaaut";
    
    // Criar novo campo de input para o nome
    var novoCampoNome = document.createElement("input");
    novoCampoNome.type = "text";
    novoCampoNome.className = "autor";
    novoCampoNome.name = "autor[]";
    novoCampoNome.id = "autor" + contadorAutores; // Use um array para coletar vários valores
    novoCampoNome.placeholder = "Nome Completo";
   novoCampoNome.style.width = "100%";    
   novoCampoNome.autocomplete="off";
    novoCampoNome.addEventListener("input", function() {
        autocomplete(this, "../PHP/busca_autor.php");
    });
    
    // Adicionar campo de nome à coluna de nome
    colunaNome.appendChild(novoCampoNome);
    
    // Criar coluna para a filiação
    var colunaFiliacao = document.createElement("div");
    colunaFiliacao.className = "colunafili";
    
    // Criar novo campo de input para a filiação
    var novoCampoFiliacao = document.createElement("input");
    novoCampoFiliacao.type = "text";
    novoCampoFiliacao.className = "filiacao";
    novoCampoFiliacao.name = "filiacao[]";
    novoCampoFiliacao.id = "filiacao" + contadorAutores;
    novoCampoFiliacao.placeholder = "Filiação";
    novoCampoFiliacao.style.width="100%"
    novoCampoFiliacao.autocomplete="off";
   
    
    novoCampoFiliacao.addEventListener("input", function() {
        autocomplete(this, "../PHP/busca_fili.php");
    });
    
    // Adicionar campo de filiação à coluna de filiação
    colunaFiliacao.appendChild(novoCampoFiliacao);
    
    // Adicionar as colunas ao contêiner do autor na ordem correta
    novoAutorContainer.appendChild(colunaNome);
    novoAutorContainer.appendChild(colunaFiliacao);
    
    // Adicionar o contêiner do autor ao contêiner principal
    container.appendChild(novoAutorContainer);

    // Adicionar quebra de linha entre autores (opcional)
     container.appendChild(document.createElement("br"));
    
    // Incrementar o contador de autores
    contadorAutores++;
}

               
                    
                    function deletarAutor() {
                        var container = document.getElementById("autoresContainer");
                        
                        // Verifica se há mais de três campos de autor para excluir e pelo menos um autor deve permanecer
                        if (container.children.length > 0) {
                            // Remove os três últimos filhos do container
                            for (var i = 0; i < 2; i++) {
                                var ultimoAutor = container.lastChild;

                                container.removeChild(ultimoAutor);
                            }
                    
                            // Decrementa o contador de autores
                            contadorAutores--;
                            
                        } else {
                            // Se houver menos de três campos de autor, exiba um alerta informando que pelo menos um autor deve ser mantido
                            window.alert(" Não existe mais campos para serem removidos ");
                        }
                    }


                    function removerTODOSAutores() {
                        var container = document.getElementById("autoresContainer");
                        while (container.lastChild) {
                            container.removeChild(container.lastChild);                          
                        }
                        contadorAutores=0; // Resetar o contador

                        setTimeout(function() { //timeout, é o tempo pra executar alguma coisa antes que o alert apreça
        window.alert("Todas as linhas removidas!!");
    }, 0);
}
                    

// Initialize the coordenadas variable
var coordenadas = 0;

function adicionarCoordenadas() {
    // Container where the coordinate fields will be added
    var container = document.getElementById("coordenadas");

    var novoCoordenadas = document.createElement("div");
    novoCoordenadas.className = "coordenadas-campo";
    novoCoordenadas.id = "coordenadas" + coordenadas;
    novoCoordenadas.style.display = "flex";
    novoCoordenadas.style.flexWrap = "wrap"; // To ensure the elements wrap if there's not enough space
    novoCoordenadas.style.width = "100%";
    novoCoordenadas.style.gap = "4.8px"; // Consistent gap between elements

    // Create new input elements
    var novoID = document.createElement("input");
    novoID.type = "text";
    novoID.className = "ID_amst";
    novoID.id = "ID_amst" + coordenadas;
    novoID.name = "ID_amst[]"; // Use an array to collect multiple values
    novoID.placeholder = "ID";
    novoID.style.width ="10%";
    novoID.style.autocomplete ="off";   
    
    novoID.maxLength = 10;

    var novolatitude = document.createElement("input");
    novolatitude.type = "text";
    novolatitude.className = "latitude";
    novolatitude.id = "latitude" + coordenadas;
    novolatitude.name = "latitude[]";
    novolatitude.placeholder = "Latitude: -XX.XXXXX";
    novolatitude.style.width="20%"   
    novolatitude.maxLength = 10;
    novolatitude.style.autocomplete="off";

    var novolongitude = document.createElement("input");
    novolongitude.type = "text";
    novolongitude.className = "longitude";
    novolongitude.id = "longitude" + coordenadas;
    novolongitude.name = "longitude[]";
    novolongitude.placeholder = "Longitude: -YY.YYYYY";
    novolongitude.style.width="20%";
    novolongitude.maxLength = 10;
    novolongitude.style.autocomplete ="off";

    var novoProf = document.createElement("input");
    novoProf.type = "text";
    novoProf.className = "prof";
    novoProf.id = "prof" + coordenadas;
    novoProf.name = "prof[]"; // Use an array to collect multiple values
    novoProf.placeholder = "Profundidade";
    novoProf.style.width ="8%"  
    novoProf.maxLength = 10;
    novoProf.style.autocomplete="off";

    var novoRecSed = document.createElement("input");
    novoRecSed.type = "number";
    novoRecSed.className = "recuperacao";
    novoRecSed.id = "recuperacao" + coordenadas;
    novoRecSed.name = "recuperacao[]"; // Use an array to collect multiple values
    novoRecSed.placeholder = "Recuperação sedimentar (metros)";
    novoRecSed.style.width ="20%"
    novoRecSed.maxLength = 10;
    novoRecSed.style.autocomplete="off";

    var novoAnoCol = document.createElement("input");
    novoAnoCol.type = "date";
    novoAnoCol.className = "data2";
    novoAnoCol.id = "data2" + coordenadas;
    novoAnoCol.name = "data[]"; // Use an array to collect multiple values
    novoAnoCol.placeholder = "Data da coleta";
    novoAnoCol.style.width="10%";
    novoAnoCol.maxLength = 10;
    
     
    // Add the new fields to the container
    novoCoordenadas.appendChild(novoID);
    novoCoordenadas.appendChild(novolatitude);
    novoCoordenadas.appendChild(novolongitude);
    novoCoordenadas.appendChild(novoProf);
    novoCoordenadas.appendChild(novoRecSed);
    novoCoordenadas.appendChild(novoAnoCol);
   
    container.appendChild(novoCoordenadas);

    container.appendChild(document.createElement("br"));

    coordenadas++;
}

                    
function deletarCoordenadas() {
    var container = document.getElementById("coordenadas");

    if (coordenadas > 0) {
        var ultimaCoord = document.getElementById("coordenadas" + (coordenadas - 1));
        if (ultimaCoord) {
            container.removeChild(ultimaCoord);
        }

        // Remove o <br> correspondente
        var br = container.lastChild;
        if (br && br.nodeName === "BR") {
            container.removeChild(br);
        }
        
        coordenadas--;
    } else {
        window.alert("Não há coordenadas para remover!");
    }
}


function removerTODAScoordenadas() {
    var container = document.getElementById("coordenadas");

    // Remove todos os conjuntos de coordenadas e os <br> correspondentes
    while (coordenadas > 0) {
        var ultimaCoord = document.getElementById("coordenadas" + (coordenadas - 1));
        if (ultimaCoord) {
            container.removeChild(ultimaCoord);
        }
        
        var br = container.lastChild;
        if (br && br.nodeName === "BR") {
            container.removeChild(br);
        }

        coordenadas--;
    }

    setTimeout(function() {
        window.alert("Todas as linhas removidas!!");
    }, 0);
}




// SCRIPT PARA PASSAR AS PAFINAS DO FORMULÁRIO SUBMIT.HTML
 let currentPage = 1;

            function proximaPagina() {
              // Validação ou lógica adicional pode ser adicionada aqui
        
              // Oculta a seção atual
              document.getElementById(`section${currentPage}`).classList.remove('active');
        
              // Atualiza a página atual
              currentPage++;
        
              // Exibe a próxima seção
              document.getElementById(`section${currentPage}`).classList.add('active');
            }
        
            function paginaAnterior() {
              // Validação ou lógica adicional pode ser adicionada aqui
        
              // Oculta a seção atual
              document.getElementById(`section${currentPage}`).classList.remove('active');
        
              // Atualiza a página atual
              currentPage--;
        
              // Exibe a seção anterior
              document.getElementById(`section${currentPage}`).classList.add('active');
            }
        
 
            



 // pagina de LOGIN ---  funções do botões
                    function registro() {
                        window.location.href='novo-user.html'
                    }
                    function inicio(){
                        window.location.href='index.html'
                    }





// resumo da pagina no final SUBMIT--


function exibirResumo() {
    var summary1 = document.getElementById("summary-1");
    var resumo = "";

    // Recuperar os valores dos campos do formulário
    var autorCorrValue = document.getElementById("correspondente").value;
    resumo += "<p" + (autorCorrValue ? '' : ' class="texto-vermelho"') + "><strong>Correspondente:</strong> " + autorCorrValue + "</p>";

    var emailCorr = document.getElementById("email").value;
    resumo += "<p" + (emailCorr ? '' : ' class="texto-vermelho"') + "><strong>E-mail:</strong> " + emailCorr + "</p>";

    var tipoTrabalho = document.getElementById("tipoTrabalhoSelecao").value;
    resumo += "<p" + (tipoTrabalho ? '' : ' class="texto-vermelho"') + "><strong>Tipo de trabalho escolhido:</strong> " + tipoTrabalho + "</p>";

    var armazenamentoSel = document.getElementById("armazenamentoSelecao").value;
    resumo += "<p" + (armazenamentoSel ? '' : ' class="texto-vermelho"') + "><strong>Como deseja armazenar os dados? </strong>" + armazenamentoSel + "</p>";

    var titulo = document.getElementById("titulo").value;
    resumo += "<p" + (titulo ? '' : ' class="texto-vermelho"') + "><strong>Título:</strong> " + titulo + "</p>";

    // Adicionar mais coordenadas
    for (var i = 0; i < contadorAutores; i++) {
        var AutorNome = document.getElementsByClassName("autor")[i].value;
        var AutorFiliacao = document.getElementsByClassName("filiacao")[i].value;
        resumo += "<p><strong>"+ (i + 1) + "º Autor:</strong> " + AutorNome + " (" + AutorFiliacao + ")</p>";
    }

    var periodico = document.getElementById("periodico").value;
    resumo += "<p" + (periodico ? '' : ' class="texto-vermelho"') + "><strong>Nome do Periódico:</strong> " + periodico + "</p>";

    var linkart = document.getElementById("linkart").value;
    resumo += "<p" + (linkart ? '' : ' class="texto-vermelho"') + "><strong>Link para o Artigo:</strong> " + linkart + "</p>";

    var doi1 = document.getElementById("doi").value;
    resumo += "<p" + (doi1 ? '' : ' class="texto-vermelho"') + "><strong>DOI:</strong> " + doi1 + "</p>";

    var datap = document.getElementById("data1").value;
    resumo += "<p" + (datap ? '' : ' class="texto-vermelho"') + "><strong>Data da publicação:</strong> " + datap + "</p>";

    var keywords1 = document.getElementById("keywords").value;
    resumo += "<p" + (keywords1 ? '' : ' class="texto-vermelho"') + "><strong>Palavras-Chave:</strong> " + keywords1 + "</p>";

    var referencia = document.getElementById("referencia").value;
    resumo += "<p" + (referencia ? '' : ' class="texto-vermelho"') + "><strong>Referência <i>(ABNT)<i>:</strong> " + referencia + "</p>";

    // Exibir o resumo no elemento summary1
    summary1.innerHTML = resumo;
}



function exibirDADOS() {
    var summary2 = document.getElementById("summary-2");
    var resumo = "";
    
        var coordenadasCampos = document.getElementsByClassName("coordenadas-campo");
        for (var i = 0; i < coordenadasCampos.length; i++) {
                var ID_amst = document.getElementById("ID_amst" + i).value;
                var latitude = document.getElementById("latitude" + i).value;
                var longitude = document.getElementById("longitude" + i).value;
                var prof = document.getElementById("prof" + i).value;
                var recuperacao = document.getElementById("recuperacao" + i).value;
                var data2 = document.getElementById("data2" + i).value;
        
                resumo += "<p><strong> Ponto " + (i + 1) + ":</strong> ID: " + ID_amst + "| Latitude: " + latitude + "| Longitude: " + longitude + "| Profundidade: " + prof + "| Recuperação: " + recuperacao + "| Data da Coleta: " + data2 + "</p>";
            }

    // Adiciona as características inseridas
    var caract = document.getElementById("caract").value;
    resumo += "<p" + (caract ? '' : ' class="texto-vermelho"') + "><strong>Características inseridas:</strong> " + caract + "</p>";

    // Adiciona os métodos utilizados
    var mett1 = document.getElementById("metut").value;
    resumo += "<p" + (mett1 ? '' : ' class="texto-vermelho"') + "><strong>Métodos Utilizados:</strong> " + mett1 + "</p>";

    // Verifica proxies selecionados e adiciona ao resumo
    var proxySummary = "";
    if (document.getElementById("TSM").checked) {
        proxySummary += "TSM (Temperatura da Superfície do Mar), ";
    }
    if (document.getElementById("PP").checked) {
        proxySummary += "Produtividade Primária, ";
    }
    if (document.getElementById("circulacao").checked) {
        proxySummary += "Circulação Oceânica, ";
    }
    if (document.getElementById("org").checked) {
        proxySummary += "Marcadores Orgânicos, ";
    }
    if (document.getElementById("inorg").checked) {
        proxySummary += "Marcadores Inorgânicos, ";
    }
    if (document.getElementById("foramplan").checked) {
        proxySummary += "Foraminíferos Planctônicos, ";
    }
    if (document.getElementById("forambent").checked) {
        proxySummary += "Foraminíferos Bentônicos, ";
    }
    if (document.getElementById("sealev").checked) {
        proxySummary += "Nível do Mar, ";
    }
    if (document.getElementById("co2atm").checked) {
        proxySummary += "CO<sub>2</sub> Atmosférico, ";
    }
    if (document.getElementById("cobveg").checked) {
        proxySummary += "Cobertura Vegetal, ";
    }
    if (document.getElementById("rainfall").checked) {
        proxySummary += "Precipitação, ";
    }
    if (document.getElementById("stratg").checked) {
        proxySummary += "Estratigrafia, ";
    }
    
    // Remove a vírgula extra no final, se houver
    if (proxySummary.slice(-2) === ', ') {
        proxySummary = proxySummary.slice(0, -2);
    }

    resumo += "<p" + (proxySummary ? '' : ' class="texto-vermelho"') + "><strong>Proxie(s) Selecionado(s):</strong> " + proxySummary + "</p>";

    // Adiciona outro proxy inserido
    var outroprox = document.getElementById("outroProx").value;
    resumo += "<p" + (outroprox ? '' : ' class="texto-vermelho"') + "><strong> Outro proxy:</strong> " + outroprox + "</p>";

    // Adiciona equipamentos selecionados
    var coleta = "";
    if (document.getElementById("multcorer").checked) {
        coleta += "MultiCorer, ";
    }
    if (document.getElementById("piston").checked) {
        coleta += "Piston Corer, ";
    }
    if (document.getElementById("gravcorer").checked) {
        coleta += "Gravity Corer, ";
    }
    if (document.getElementById("drilli").checked) {
        coleta += "Drilling, ";
    }
    if (document.getElementById("gboxcorer").checked) {
        coleta += "Giant box corer, ";
    }
    if (document.getElementById("compcorer").checked) {
        coleta += "Composite Corer, ";
    }
    if (document.getElementById("boxcorer").checked) {
        coleta += "Box Corer, ";
    }
    if (document.getElementById("corer").checked) {
        coleta += "Corer, ";
    }
    
    // Remove a vírgula extra no final, se houver
    if (coleta.slice(-2) === ', ') {
        coleta = coleta.slice(0, -2);
    }

    resumo += "<p" + (coleta ? '' : ' class="texto-vermelho"') + "><strong>Equipamento(s) Selecionado(s):</strong> " + coleta + "</p>";

    // Adiciona outro equipamento inserido
    var outroequip = document.getElementById("outroEqui").value;
    resumo += "<p" + (outroequip ? '' : ' class="texto-vermelho"') + "><strong> Outro equipamento:</strong> " + outroequip + "</p>";

    // Adiciona arquivo de referência inserido
    var refef1 = document.getElementById("refef").value;
    resumo += "<p" + (refef1 ? '' : ' class="texto-vermelho"') + "><strong>Arquivo:</strong> " + refef1 + "</p>";

    // Exibe o resumo no elemento summary2
    summary2.innerHTML = resumo;
}
