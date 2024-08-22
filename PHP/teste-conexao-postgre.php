<?php

require_once 'config.php';

function testarConexaoPostgreSQL($host, $port, $dbname, $user, $pass) {
    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname;user=$user;password=$pass";
    
    try {
        $pdo = new PDO($dsn);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        echo "<script>alert('Conexão bem-sucedida!');</script>";
    } catch (PDOException $e) {
        echo "<script>alert('Falha na conexão: " . $e->getMessage() . "');</script>";
    }
}

// Teste da conexão
testarConexaoPostgreSQL($host, $port, $dbname, $user, $pass);

echo "<script>";
echo "setTimeout(function() {";
echo "    history.go(-1);";
echo "}, 20);"; // 3000 milissegundos = 3 segundos
echo "</script>";

exit;

?>

