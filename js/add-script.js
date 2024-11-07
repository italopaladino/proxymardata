function abrirTermo() {
    var url = "../assets/termo-confia.pdf";
    window.open(url, "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=100,left=100,width=600,height=600");
}

function abrirPonto() {
    var url = "../assets/ponto.pdf";
    window.open(url, "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=100,left=100,width=600,height=600");
}
function abrirCSV() {
    var url = "../assets/csv.pdf";
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

    //ABRIR NOVOS CAMPOS e modelar automático o tamanho da caixa de texto

    function mostrarDivInfo() {
        const div = document.getElementById("info-adicional");
        div.style.maxHeight = "500px"; // Define a altura máxima para exibir a <div> com transição
    }
    
    function ocultarDivInfo() {
        document.getElementById("info-adicional").style.maxHeight = "0"; // Oculta a <div> com transição
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
let clickCount = 0;

function n() {
    clickCount++;
    
    if (clickCount === 1) {
        window.alert('Não é pra mexer aqui!');
    } else if (clickCount === 2) {
        window.alert('Eu avisei para não mexer!!');
    } else {
        window.alert('Agora você mexeu demais!!!');
        clickCount = 0; // Reinicia o contador para começar de novo
    }
}


function showAlert() {
    window.alert('Não deu tempo de fazer, desculpaaaa. Mas obrigado por tentar testar, na proxima vai estar funcionando');
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


                  
var contadorAutores = 1;
function adicionarAutor() {
    // Container onde os campos de autor serão adicionados
    var container = document.getElementById("autoresContainer");
    
    // Criar um novo contêiner para o autor
    var novoAutorContainer = document.createElement("div");
    novoAutorContainer.className = "autor-campo";
    novoAutorContainer.id = "autorContainer" + contadorAutores;
    
    // Criar coluna para o nome completo
    var colunaNome = document.createElement("div");
    colunaNome.className = "colunaaut2";
      // Criar novo campo de input para o nome
    var novoCampoNome = document.createElement("input");
    novoCampoNome.type = "text";
    novoCampoNome.className = "autor" + contadorAutores;
    novoCampoNome.name = "autor[]";
    novoCampoNome.id = "autor" + contadorAutores; // Use um array para coletar vários valores
    novoCampoNome.placeholder = "Nome Completo";
   novoCampoNome.style.width = "100%";
   novoCampoNome.style.right= "2px";    
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
    novoID.style.width ="20%";
    novoID.style.autocomplete ="off";   
    
    novoID.maxLength = 10;

    var novolatitude = document.createElement("input");
    novolatitude.type = "text";
    novolatitude.className = "latitude";
    novolatitude.id = "latitude" + coordenadas;
    novolatitude.name = "latitude[]";
    novolatitude.placeholder = "Latitude: -YY.YYYYY";
    novolatitude.style.width="25%"   
    novolatitude.maxLength = 10;
    novolatitude.style.autocomplete="off";

    var novolongitude = document.createElement("input");
    novolongitude.type = "text";
    novolongitude.className = "longitude";
    novolongitude.id = "longitude" + coordenadas;
    novolongitude.name = "longitude[]";
    novolongitude.placeholder = "Longitude: -XX.XXXXX";
    novolongitude.style.width="25%";
    novolongitude.maxLength = 10;
    novolongitude.style.autocomplete ="off";

    var novoAnoCol = document.createElement("input");
    novoAnoCol.type = "date";
    novoAnoCol.className = "data2";
    novoAnoCol.id = "data2" + coordenadas;
    novoAnoCol.name = "data[]"; // Use an array to collect multiple values
    novoAnoCol.placeholder = "Data da coleta";
    novoAnoCol.style.width="20%";
    novoAnoCol.maxLength = 10;
    
     
    // Add the new fields to the container
    novoCoordenadas.appendChild(novoID);
    novoCoordenadas.appendChild(novolatitude);
    novoCoordenadas.appendChild(novolongitude);
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
              /*const correspondente = document.getElementById('correspondente').value;
              const email =document.getElementById('email').value;
              const autor = document.getElementById('autor0').value;
              const data = document.getElementById('data1').value;
              const ref = document.getElementById('referencia').value;
             
              if(correspondente ==''){
                window.alert('Indique o nome do correspondente!');
              } else if(data ==''){
                window.alert('Indique a data!');
              }else if (ref ==''){
                window.alert('Indique a Referência do trabalho!');
              }else if (email ==''){
                window.alert ('Indique o email do correspondente');  
              }else if (autor ==''){
                window.alert('Indique ao menos um Autor e sua filiação');
            }else{*/
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

function proximaPagina2(){

   /* const area = document.getElementById('area_est').value;
    const desc_dados = document.getElementById('caract').value;
    const metut = document.getElementById('metut').value;
    const arquivo = document.getElementById ('refef').value;
if(area ==''){
    window.alert ('Adicione a descrição da área de estudo');
    return false;
}else if (desc_dados ==''){
    window.alert ('Adicione uma descrição ao seus dados');
    return false;
} else if (metut ==''){
    window.alert ('Adicione os métodos utilizados para a aquisição desses dados');
    return false;
}else if (arquivo =='') {
    window.alert(' Adicione a sua tabela de dados. Não esqueça que o formato é .CSV (separado por virgula)');
}else{*/

proximaPagina();
exibirResumo();
}


function exibirResumo() {
    var summary1 = document.getElementById("summary-1");
    var resumo = "";

    // Recuperar os valores dos campos do formulário
    var autorCorrValue = document.getElementById("correspondente").value;
    var emailCorr = document.getElementById("email").value;
    var tituloPrin = document.getElementById("tituloPrinc").value;
    var tituloDad = document.getElementById("tituloDado").value;

    var tipoTrabalhoSelecao = document.getElementById("tipoTrabalhoSelecao").value;
    var tituloTrabalho = document.getElementById("titTrab").value;
    var trabAssociado = document.querySelector('input[name="trab_associado"]:checked').value


    var resumo = "<form id='formsRes' style='position: relative; margin-bottom:20px'>"
    + "<div>"
    + "<h4><label id='autor' for='autor'> <a style='color: red;' title='Elemento obrigatório'>*</a> Identificação do responsável pelo dado:</label></h4>"
    + "<br>" 
    + "<input type='text' value='" + autorCorrValue + "' readonly style='width: 49%; margin-right:4px;'>"
    + "<input type='text' value='" + emailCorr + "' readonly style='width: 49%;'>"
    + "<br><br>"
    + "<div>"
    + "<h4 style='width:auto; margin:0;'><a style='color:red;'>*</a> Título do projeto principal:</h4>"
    + "<input type='text' value='" + tituloPrin + "' readonly style='width:98.4%;'>"
    + "</div>"
    + "<br><br>"
    + "<div>"
    + "<h4 style='width:auto; margin:0'><a style='color:red;'>*</a> Título para os Dados inseridos</h4>"
    + "<input type='text' value='" + tituloDad + "' readonly style='width:98.4%'>"
    + "</div>"
    + "<br><br>"
    + "<div>"
    + "<h4><a style='color:red;'>*</a> Existe algum trabalho associado a esse conjunto de dados</h4>";


if (trabAssociado === 'sim') {
    resumo +="<br>"
            +"<div id='geral'>"
           + "<div class='coluna'>"
          
           + "<label>Tipo de Trabalho:</label>"
           + "<br>"
           + "<select style='height: 30px; width: 50%;'>"
           + "<option selected value='" + tipoTrabalhoSelecao + "'>" + tipoTrabalhoSelecao + "</option>"
           + "</select>"
           + "</div>"
           
           + "<div class='coluna'>"
          
           + "<label>Título do Trabalho:</label>"
           + "<br>"
           + "<textarea style='width: 100%; resize: vertical;' rows='3'>" + tituloTrabalho + "</textarea>"
           + "</div>"
           
           + "</div>"
           + "</div>"
           + "</br>"
           + "</br>"
           + "</br>"
           + "</br>";

} else {
    resumo +="<br>"
           +"<div>"
           + "<input type='radio' value='nao' checked disabled>"
           + "<label>Não</label>"
           + "</div>"
           + "</div>";
}
    
var AutorNome0 = document.getElementById("autor0").value;
var AutorFiliacao0 = document.getElementById("filiacao0").value;

resumo +="</br>"
+"<div>" 
+"<p> 1º Autor:" +
          "<input readonly style='width:45%;' type='text' value='" + AutorNome0 + "'> " +
          "<input readonly style='width:45%; margin-left:4px;' type='text' value='" + AutorFiliacao0 + "'> </p> "
          + "</div>";


   // Adicionar mais autores
    for (var i = 1; i < contadorAutores; i++) {
        var AutorNome = document.getElementById("autor" +i).value;
        var AutorFiliacao = document.getElementById("filiacao" +i).value;

        resumo +="<div>"+
         "<p>" + (i + 1) + "º Autor:" +
          "<input style='width:45%;' readonly type='text' value='" + AutorNome + "'> " +
          "<input readonly style='width:45%; margin-left:4px;' type='text' value='" + AutorFiliacao + "'></p>"
          +"</div>";
    }
    var refef = document.getElementById("referencia").value;
    resumo +="</br>"
    +"</br>"
    +"<div>" +
              "<h4><a style='color:red;'>*</a>Referência</h4>" +
              "<br>" +
              "<textarea readonly rows='4' style='width:98.4%;' value='" + refef + "'></textarea>"
              +"</div>";

 
resumo += "</div>";
resumo +="</form>"; 

summary1.innerHTML = resumo;

}




function exibirDADOS() {

    var summary2 = document.getElementById("summary-2");
    var resumo = "";


var resDad = document.getElementById("res_dado").value;

    resumo += "<form id='formsRes' style='position: relative; margin-bottom:20px'>"
    +"</br>"  
    +"<div>"
    +"<div>"
    +"<h4><a style='color:red;'>*</a> Resumo dos dados</h4>"
    + "<textarea readonly style='width:98.4%; height: auto;' rows='4'>" + resDad + "</textarea>"
    +"</div>";
            
       for (var i = 0; i < coordenadas; i++) {
        var ID_amst = document.getElementById("ID_amst" + i).value;
        var latitude = document.getElementById("latitude" + i).value;
        var longitude = document.getElementById("longitude" + i).value;
        var data2 = document.getElementById("data2" + i).value;
    
        resumo += "</br>"+
        "<div class='coordenadas-campo' style='display:flex; flex-wrap:wrap; width:100%; gap:4.8px;'>" +
                  
        "<p><strong>Ponto " + (i + 1) + ":</strong></p>" +
                  "<input type='text' style='width:20%;' readonly value='" + ID_amst + "'> " +
                  "<input type='text' style='width:25%;' readonly value='" + latitude + "'> " +
                  "<input type='text' style='width:25%;' readonly value='" + longitude + "'> " +
                  "<input type='date' style='width:20%;' readonly value='" + data2 + "'>" +
                  "</div>";
    }


    var tipoAmostra = document.getElementById("tipAmst").value;
   
    resumo +="<br>"
           + "<div id='tipFerr'"
           + "<div id='amostras' class='coluna'>"
           +"<h4>Tipo de Amostra</h4>"         
           + "<br>"
           + "<select style='height: 30px; width: 50%;'>"
           + "<option readonly selected value='" + tipoAmostra + "'>" + tipoAmostra + "</option>"
           + "</select>"
           + "</div>"

           var ferramentasUt = "";
           if (document.getElementById("associ").checked) {
               ferramentasUt += "Associação, ";
           }
           if (document.getElementById("batmet").checked) {
               ferramentasUt += "Batimetria, ";
           }
           if (document.getElementById("bioOrg").checked) {
               ferramentasUt += "Biomarcadores Orgânicos, ";
           }
           if (document.getElementById("cocolit").checked) {
               ferramentasUt += "Cocolitoforídeos, ";
           }
           if (document.getElementById("estrat").checked) {
               ferramentasUt += "Estratigrafia, ";
           }
           if (document.getElementById("foramplan").checked) {
               ferramentasUt += "Foraminíferos Planctônicos, ";
           }
           if (document.getElementById("forambent").checked) {
               ferramentasUt += "Foraminíferos Bentônicos, ";
           }
           if (document.getElementById("granl").checked) {
               ferramentasUt += "Granulometria, ";
           }
           if (document.getElementById("hidrod").checked) {
               ferramentasUt += "Hidrodinâmica, ";
           }
           if (document.getElementById("hidrog").checked) {
               ferramentasUt += "Hidrografia, ";
           }
           if (document.getElementById("matorg").checked) {
               ferramentasUt+= "Matéria Orgânica, ";
           }
           if (document.getElementById("metais").checked) {
               ferramentasUt += "Metais e semi-metais, ";
           }
           if (document.getElementById("microps").checked){
            ferramentasUt +="Microplásticos, ";
           }
           if (document.getElementById("ageMod").checked){
            ferramentasUt += "Modelos de idade, ";
           }
           if (document.getElementById("proFisi").checked){
            ferramentasUt += "Propriedades Físicas: ";
           }
           if (document.getElementById("radioist").checked){
            ferramentasUt += "Radioisótopos, ";
           }
           if (document.getElementById("razIsot").checked){
            ferramentasUt += "Razões Isotópicas";
           }
           if (document.getElementById("SmodNum").checked){
            ferramentasUt += "Saída de modelo numérico";
            }
            if (document.getElementById("teorAg").checked){
                ferramentasUt += "Teor de Água, "
            }


           // Remove a vírgula extra no final, se houver
           if (ferramentasUt.slice(-2) === ', ') {
               ferramentasUt = ferramentasUt.slice(0, -2);
           }
           if (ferramentasUt){
           resumo += "<div class='Coluna' style='display: flex; justify-content:space-between;'>"
           +"<p><h4>Ferramentas Selecionado(s):</h4> " + ferramentasUt + "</p>"
           
           +"</div>"
           +"</div>";
           }
           // Adiciona outro proxy inserido
           var outroFe = document.getElementById("outroFerr").value;
           if(outroFe){
           resumo += "<div>"
           +"<p><strong>Outras ferramentas:</strong> " + outroFe + "</p>"
                     
           +"</div>"
           +"</div>";
           }    

          
           resumo +="</br>"
                  + "<div id=equipamentos-container'"
                        
                  var equipCole = "";
                  if (document.getElementById("pstCor").checked) {
                    equipCole += "Piston Corer, ";
                  }
                  if (document.getElementById("gravt").checked) {
                    equipCole += "Gravity Corer, ";
                  }
                  if (document.getElementById("drill").checked) {
                    equipCole += "Drilling device, ";
                  }
                  if (document.getElementById("gbox").checked) {
                    equipCole += "Giant box corer, ";
                  }
                  if (document.getElementById("boxcr").checked) {
                    equipCole += "Box Corer, ";
                  }
                  if (document.getElementById("ADCP").checked) {
                    equipCole += "ADCP, ";
                  }
                  if (document.getElementById("corrt").checked) {
                    equipCole += "Correntômetro, ";
                  }
                  if (document.getElementById("CTD").checked) {
                    equipCole += "CTD, ";
                  }
                  if (document.getElementById("modNum").checked) {
                    equipCole += "Modelo Numérico, ";
                  }
                  if (document.getElementById("multb").checked) {
                      equipCole += "Multibean, ";
                  }
                  if (document.getElementById("multCor").checked) {
                      equipCole += "Multiple Corer, ";
                  }
                  if (document.getElementById("satl").checked) {
                    equipCole += "Satélite, ";
                  }
                  if (document.getElementById("sensBio").checked){
                   equipCole +="Sensores bio-ópticos, ";
                  }
                  if (document.getElementById("sidSc").checked){
                   equipCole += "Side-scan sonar, ";
                  }
                  if (document.getElementById("vanv").checked){
                   equipCole += "Van-veen, ";

                  }
                                   // Remove a vírgula extra no final, se houver
                  if (equipCole.slice(-2) === ', ') {
                      equipCole = equipCole.slice(0, -2);
                  }
                  if (equipCole){
                  resumo +="</br>" 
                  +"<div>"
                  +"<p><h4>Equipamento(s) de coleta:</h4> " + equipCole + "</p>"
                  
                  
                  +"</div>";
                  }
                  // Adiciona outro proxy inserido
                  var outroFe = document.getElementById("outroEqui").value;
                  if(outroFe){
                  resumo += "<div>"
                  +"<p><strong>Outras ferramentas:</strong> " + equipCole + "</p>"
                            
                  +"</div>";
                  }

    resumo+="</div>"
           +"</br>"
           +"</br>"
            +"</form>";

    summary2.innerHTML = resumo;
}

   /*var summary2 = document.getElementById("summary-2");
    var resumo = "";

    var area_est = document.getElementById("area_est").value;
    resumo += "<p" + (area_est ? '' : ' class="texto-vermelho"') + "><strong>Descrição da Área de estudo:</strong> " + area_est + "</p>";

        
    // Adiciona as características inseridas
    var caract = document.getElementById("caract").value;
    resumo += "<p" + (caract ? '' : ' class="texto-vermelho"') + "><strong>Características inseridas:</strong> " + caract + "</p>";

    // Adiciona os métodos utilizados
    var mett1 = document.getElementById("metut").value;
    resumo += "<p" + (mett1 ? '' : ' class="texto-vermelho"') + "><strong>Métodos Utilizados:</strong> " + mett1 + "</p>";

    // Verifica proxies selecionados e adiciona ao resumo
    var proxySummary = "";
    if (document.getElementById("isot").checked) {
        proxySummary += "Isótopos, ";
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
    if (proxySummary){
    resumo += "<p> <strong>Ferramentas Selecionado(s):</strong> " + proxySummary + "</p>";
    }
    // Adiciona outro proxy inserido
    var outroprox = document.getElementById("outroProx").value;
    if(outroprox){
    resumo += "<p><strong>Outras ferramentas:</strong> " + outroprox + "</p>";
    }
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

    if(coleta){
    resumo += "<p><strong>Equipamento(s) Selecionado(s):</strong> " + coleta + "</p>";
    }
    // Adiciona outro equipamento inserido
    var outroequip = document.getElementById("outroEqui").value;
    if(outroequip){
    resumo += "<p> <strong> Outro equipamento:</strong> " + outroequip + "</p>";
    }
    // Adiciona arquivo de referência inserido
    var refef1 = document.getElementById("refef").value;
    resumo += "<p" + (refef1 ? '' : ' class="texto-vermelho"') + "><strong>Arquivo:</strong> " + refef1 + "</p>";

    // Exibe o resumo no elemento summary2 */


