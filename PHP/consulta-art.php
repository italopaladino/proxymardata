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

    // Itera sobre as linhas, começando do final
    for ($i = count($infogeral) - 1; $i >= 0; $i--) {
        $infogera = $infogeral[$i]; // Obtém a linha atual
    
        // Cria a frase com os dados do autor, título sublinhado, DOI e data
        $frase = "<a class='link-pesq' href='../HTML/resultados.php?id=" . htmlspecialchars($infogera['geralid']) . "'>" . htmlspecialchars($infogera['referencia']) ."";
    
        // Exibe a frase e adiciona duas quebras de linha
        echo $frase . "<br><br>";
    
        // Incrementa o contador
        $contador++;
    
        // Verifica se o contador atingiu três, se sim, interrompe o loop
        if ($contador >= 3) {
            break;
        }
    }
    
} catch (PDOException $e) {
    echo "Erro:" . $e->getMessage();
} finally {
    if($pdo){
        $pdo = null;
    }
}
?>
