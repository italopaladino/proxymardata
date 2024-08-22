<?php

require_once 'config.php';

function testarConexaoPostgreSQL($dsn, $user, $pass) {
    try {
        $pdo = new PDO($dsn, $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        echo "<script>alert('Conexão bem-sucedida!');</script>";
    } catch (PDOException $e) {
        echo "<script>alert('Falha na conexão: " . $e->getMessage() . "');</script>";
    }
}

// Teste da conexão
testarConexaoPostgreSQL($dsn, $user, $pass);



echo "<script>";
echo "setTimeout(function() {";
echo "    history.go(-1);";
echo "}, 20);"; // 3000 milissegundos = 3 segundos
echo "</script>";

exit;

?>

