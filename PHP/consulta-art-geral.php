<?php
require_once 'config.php';

try {
    // Conexão ao banco de dados
    $pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

    // Consulta SQL para obter todos os registros de infogeral
    $sql = "SELECT * FROM infogeral";
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
    
    // Cria a frase com os dados do autor, título sublinhado, DOI e data
    $frase = "<div class='citation' >
                <a class='link-pesq' href='../HTML/resultados.php?id=" . htmlspecialchars($infogera['geralid']) . "'>". "<b>Correspondente:</b> ".htmlspecialchars($infogera['correspondente'])
                 . "(" . htmlspecialchars($infogera['email']) . ")"
                 . "</br>" ."<b>Título  do projeto principal:</b> " . htmlspecialchars($infogera['tituloprinc']) . 
                "</br>". "<b>Título do dado:</b> " . htmlspecialchars($infogera['titulodado']) . "</a>
              </div></br></br>";

    // Exibe a frase dentro de uma célula da tabela
    echo "<tr><td>" . $frase . "</td></tr>";
}

    // Fecha a tabela
    echo "</tbody></table>";

} catch (PDOException $e) {
    echo "Erro:" . $e->getMessage();
} finally {
    if($pdo){
        $pdo = null;
    }
}
?>
