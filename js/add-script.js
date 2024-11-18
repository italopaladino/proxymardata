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
    document.addEventListener("DOMContentLoaded", () => {
        const div = document.getElementById("info-adicional");
        const radioSim = document.getElementById("trab-sim");
    
        // Exibe a div caso "Sim" esteja selecionado
        if (radioSim.checked) {
            div.style.maxHeight = "500px";
        }
    });
    
    function mostrarDivInfo() {
        const div = document.getElementById("info-adicional");
        div.style.maxHeight = "500px"; // Define a altura máxima para exibir a <div>
    }
    
    function ocultarDivInfo() {
        const div = document.getElementById("info-adicional");
        div.style.maxHeight = "0"; // Oculta a <div>
    }


    /// campos ponto ou area
    function mostrarDiv1() {
        document.getElementById("area").style.maxHeight = "0";
        const div = document.getElementById("divEBotoes");
        div.style.maxHeight = "500px"; // Define a altura máxima para exibir a <div> com transição
    }
    
    function mostrarDiv2(){
        document.getElementById("divEBotoes").style.maxHeight = "0";
        const div = document.getElementById("area");
        div.style.maxHeight = "500px"; // Define a altura máxima para exibir a <div> com transição
    } 
    
    
    /*{
        document.getElementById("divEBotoes").style.maxHeight = "0";
         // Oculta a <div> com transição
    }*/



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
let currentSection = 1; // Variável para controlar a seção atual

function proximaPagina() {
    if (currentSection === 1) {
        // Verificações específicas para a primeira seção
        const correspondente = document.getElementById('correspondente').value;
        const email = document.getElementById('email').value;
        const tituloPrc = document.getElementById('tituloPrinc').value;
        const titDad = document.getElementById('tituloDado').value;
        const trabAssSim = document.getElementById('trab-sim').checked;
        const trabAssNao = document.getElementById('trab-nao').checked;
        const autor0 = document.getElementById('autor0').value;
        

        if (correspondente === '') {
            window.alert('Indique o nome do correspondente!');
            document.getElementById('correspondente').scrollIntoView({ behavior: 'smooth', block: 'center' });
        } else if (email === '') {
            window.alert('Indique o email do correspondente');
            document.getElementById('email').scrollIntoView({ behavior: 'smooth', block: 'center' });
        } else if (tituloPrc === '') {
            window.alert('Indique o Título do Projeto Principal');
            document.getElementById('tituloPrinc').scrollIntoView({ behavior: 'smooth', block: 'center' });
        } else if (titDad === '') {
            window.alert('Indique um Título para os dados inseridos');
            document.getElementById('tituloDado').scrollIntoView({ behavior: 'smooth', block: 'center' });
        } else if (!trabAssSim && !trabAssNao) {
            window.alert('Indique se existe algum trabalho associado ao conjunto de dados ou Não.');
        } else if (autor0 === '') {
            window.alert('Indique ao menos um Autor');
            document.getElementById('autor0').scrollIntoView({ behavior: 'smooth', block: 'center' });
        }  else {
            // Passa para a próxima "seção"
            document.getElementById('section1').style.display = 'none';
            document.getElementById('section2').style.display = 'block';
            currentSection = 2; // Atualiza para a próxima seção
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    } else if (currentSection === 2) {
        // Verificações específicas para a segunda seção
        const resumoD = document.getElementById('resDado').value; // Exemplo de campo específico para a Section2
        const termo = document.getElementById('termo').checked;

        if (resumoD === '') {
            window.alert('Adicione um resumo para os dados.');
            document.getElementById('resDado').scrollIntoView({ behavior: 'smooth', block: 'center' });

        }else if (!termo) {
            window.alert('Aceite os termos antes de Submeter os dados.');
            document.getElementById('termo').scrollIntoView({ behavior: 'smooth', block: 'center' }); 

        }else {
            document.getElementById('section2').style.display = 'none';
            document.getElementById('section3').style.display = 'block';
            currentSection = 3; // Atualiza para a próxima seção
            window.alert('Obs: Certifique que todos os dados estejam corretos - Não é possível mudar a planilha de dados, se houver modificações é necessário fazer uma nova sumissão');
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    }
}

            function paginaAnterior() {
              // Validação ou lógica adicional pode ser adicionada aqui
        if(currentSection >1){
              // Oculta a seção atual
              document.getElementById(`section${currentSection}`).style.display='none';
        
              // Atualiza a página atual
              currentSection--;
              window.scrollTo({ top: 0, behavior: 'smooth' });
        
              // Exibe a seção anterior
              document.getElementById(`section${currentSection}`).style.display='block';
            }
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
              "<textarea readonly rows='4' style='width:98.4%;'>"+ refef+"</textarea>"
              +"</div>";

 
resumo += "</div>";
resumo +="</form>"; 

summary1.innerHTML = resumo;

}



function exibirDADOS() {
    var summary2 = document.getElementById("summary-2");
    var resumo = "";
    var resDad = document.getElementById("resDado").value;

    resumo += "<form id='formsRes' style='position: relative; margin-bottom:20px'>"
        + "</br>"  
        + "<div>"
        + "<h4><a style='color:red;'>*</a> Resumo dos dados</h4>"
        + "<textarea readonly style='width:98.4%; height: auto;' rows='4'>" + resDad + "</textarea>"
        + "</div>";

    for (var i = 0; i < coordenadas; i++) {
        var ID_amst = document.getElementById("ID_amst" + i).value;
        var latitude = document.getElementById("latitude" + i).value;
        var longitude = document.getElementById("longitude" + i).value;
        var data2 = document.getElementById("data2" + i).value;
    
        resumo += "</br>"
            + "<div class='coordenadas-campo' style='display:flex; flex-wrap:wrap; width:100%; gap:4.8px;'>"
            + "<p><strong>Ponto " + (i + 1) + ":</strong></p>"
            + "<input type='text' style='width:20%;' readonly value='" + ID_amst + "'> "
            + "<input type='text' style='width:25%;' readonly value='" + latitude + "'> "
            + "<input type='text' style='width:25%;' readonly value='" + longitude + "'> "
            + "<input type='date' style='width:20%;' readonly value='" + data2 + "'>"
            + "</div>";
    }
    var idArea1 = document.getElementById("ID_amstAREA1").value;
    var latArea1 = document.getElementById("latitudeAREA1").value;
    var longArea1 = document.getElementById("longitudeAREA1").value;
    var dat31 = document.getElementById("dataAREA1").value;
    var idArea2 = document.getElementById("ID_amstAREA2").value;
    var latArea2 = document.getElementById("latitudeAREA2").value;
    var longArea2 = document.getElementById("longitudeAREA2").value;
    var dat32 = document.getElementById("dataAREA2").value;
    var idArea3 = document.getElementById("ID_amstAREA3").value;
    var latArea3 = document.getElementById("latitudeAREA3").value;
    var longArea3 = document.getElementById("longitudeAREA3").value;
    var dat33 = document.getElementById("dataAREA3").value;
    var idArea4 = document.getElementById("ID_amstAREA4").value;
    var latArea4 = document.getElementById("latitudeAREA4").value;
    var longArea4 = document.getElementById("longitudeAREA4").value;
    var dat34 = document.getElementById("dataAREA4").value;
if (
    idArea1 && latArea1 && longArea1 && dat31 &&
    idArea2 && latArea2 && longArea2 && dat32 &&
    idArea3 && latArea3 && longArea3 && dat33 &&
    idArea4 && latArea4 && longArea4 && dat34
){
    resumo+="<br>"
    +"<div style='display:flex; flex-wrap; width: 100%; gap: 4.8px;'>"
    +"<input readonly type='text' style='width:20%' value='" + idArea1 + "'>"
    +"<input readonly type='text' style='width:25%' value='" + latArea1 + "'>"
    +"<input readonly type='text' style='width:25%' value='" + longArea1 + "'>"
    +"<input readonly type='date' style='width:20%' value='" + dat31 + "'>"
    +"</div>"
    +"</br>"
    +"<div style='display:flex; flex-wrap; width: 100%; gap: 4.8px;'>"
    +"<input readonly type='text' style='width:20%' value='" + idArea2 + "'>"
    +"<input readonly type='text' style='width:25%' value='" + latArea2 + "'>"
    +"<input readonly type='text' style='width:25%' value='" + longArea2 + "'>"
    +"<input readonly type='date' style='width:20%' value='" + dat32 + "'>"
    +"</div>"
    +"</br>"
    +"<div style='display:flex; flex-wrap; width: 100%; gap: 4.8px;'>"
    +"<input readonly type='text' style='width:20%' value='" + idArea3 + "'>"
    +"<input readonly type='text' style='width:25%' value='" + latArea3 + "'>"
    +"<input readonly type='text' style='width:25%' value='" + longArea3 + "'>"
    +"<input readonly type='date' style='width:20%' value='" + dat33 + "'>"
    +"</div>"
    +"</br>"
    +"<div style='display:flex; flex-wrap; width: 100%; gap: 4.8px;'>"
    +"<input readonly type='text' style='width:20%' value='" + idArea4 + "'>"
    +"<input readonly type='text' style='width:25%' value='" + latArea4 + "'>"
    +"<input readonly type='text' style='width:25%' value='" + longArea4 + "'>"
    +"<input readonly type='date' style='width:20%' value='" + dat34 + "'>"
    +"</div>"
    +"</br>"
}else{

}

    var tipoAmostra = document.getElementById("tipAmst").value;

    resumo += "<br>"
        + "<div id='tipFerr'>"
        + "<div id='amostras' class='coluna'>"
        + "<h4>Tipo de Amostra</h4>"
        + "<select style='height: 30px; width: 50%;'>"
        + "<option readonly selected value='" + tipoAmostra + "'>" + tipoAmostra + "</option>"
        + "</select>"
        + "</div>"  // Fechamento do div "amostras"

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
            }if(ferramentasUt==''){
                ferramentasUt+=' Nennhuma ferramenta selecionada.';
            }


           // Remove a vírgula extra no final, se houver
           if (ferramentasUt.slice(-2) === ', ') {
               ferramentasUt = ferramentasUt.slice(0, -2);
           }
           if (ferramentasUt) {
            resumo += "<div class='Coluna'>"
                +"<p style='display: inline-block;'>"
                + "<h4 style='display: inline;'>Ferramentas Selecionado(s):</h4> "
                + "<span style='display: inline; font-size: 20px; margin-left: 5px; text-decoration: underline red;'>"+ ferramentasUt + "</span>"
                + "</p>"
                + "</div>";
        }


           // Adiciona outra ferramenta inserida
           var outroFe = document.getElementById("outroFerr").value;
           if (outroFe) {
               resumo += "<div>"
                +"<p style='display: inline-block;'>"
                + "<h4 style='display: inline;'> Outra ferramenta:</h4>"
                + "<span style='display:inline; font-size:20px; margin-left: 5px; text-decoration: underline red;'>" + outroFe +"</span>"
                +"</p>"
                + "</div>";
           }
          
              // Equipamentos de coleta
    resumo += "</br>"
    + "<div id='equipamentos-container'>";

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

                  } if (equipCole==''){
                    equipCole +="Nenhum equipamento selecionado.";
                  }


                 // Remove vírgula extra se houver
    if (equipCole.slice(-2) === ', ') {
        equipCole = equipCole.slice(0, -2);
    }
    if (equipCole) {
        resumo += "<div>"
            + "</br>"
            + "<p style='display: inline-block;'>"
            + "<h4 style='display: inline;'>Equipamento(s) de coleta:</h4>"
            + "<span style='display: inline; font-size: 20px; margin-left: 5px; text-decoration: underline red;'>" + equipCole + "</span>"
            + "</p>"
            + "</div>";
    }
    

    var outroFeEquip = document.getElementById("outroEqui").value;
    if (outroFeEquip) {
        resumo += "<div>"
                +"<p style='display: inline-block;'>"
                + "<h4 style='display: inline;'> Outro Equipamento:</h4>"
                + "<span style='display:inline; font-size:20px; margin-left: 5px; text-decoration: underline red;'>" + outroFeEquip +"</span>"
                +"</p>"
                + "</div>";
    }

    var refef1 = document.getElementById("refef").value;
    var armze = document.getElementById("armazenamentoSelecao").value;

    resumo += "<div>"
     + "</br>"
      + "</br>"
      +"<p style='display: inline-block;'>"
        + "<h4 style='display:inline;'>Arquivo inserido:</h4>"
        + "<span style='display: inline; font-size: 20px; margin-left: 5px; text-decoration: underline red;'>" + refef1 + "</span>"
        + "</p>"
        + "</div>";

    resumo += "<div>"
     + "</br>"
        + "<h4>Como os dados serão armazenados:</h4>"
        + "<select style='height: 30px; width: 30%;'>"
        + "<option readonly selected value='" + armze + "'>" + armze + "</option>"
        + "</select>"
        + "</div>"
        +"</br>"
        +"</br>"

        +"<div class='termo'>"
+"<input type='checkbox' id='termo' name='termo'checked disabled>"
+"<label><h5 for='termo'> Li e concordo com os termos sobre o uso dos dados <a href='javascript:abrirTermo()'> Clique aqui para ler</a></h5></label>"
+"</div>";


    resumo += "</form>";
    summary2.innerHTML = resumo;
}

   



