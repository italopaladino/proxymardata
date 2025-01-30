<?php

require_once 'config.php';

try {
    // Conexão com o banco de dados PostgreSQL
    $db = new PDO($dsn, $user, $pass);

    // Defina o modo de erro para exceções
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Obter dados do formulário
        $login = $_POST['nome'];
        $senha = trim($_POST['senha']); 

        // Consulta SQL usando instruções preparadas
        $query = "SELECT * FROM users WHERE nome = :login";
        $stmt = $db->prepare($query);

        if ($stmt) {
            $stmt->bindParam(':login', $login, PDO::PARAM_STR);
            $stmt->execute();

            // Obter o resultado da consulta
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            var_dump($user); ##exibir erro 


            // Verificar se o usuário existe e a senha está correta
            if ($user && password_verify($senha, $user ['senha_hash'])) {
            header ('Location: ../HTML/minhaconta.html');
            exit();

// se nao tiver registrado ele mostra

            } else {

        echo '<script>';
        echo 'alert("Verifique suas credenciais, ou contate o administrador");';
        echo 'window.location.href = "../HTML/inicio.html";'; // Redireciona após exibir o alerta
        echo '</script>';
    exit();

            }
        } else {
            echo 'Erro ao preparar a consulta';
        }
    }

}

catch (PDOException $e) {
    echo 'Erro de conexão: ' . $e->getMessage();
}

var_dump ($senha);
var_dump(password_verify($senha, $user ['senha_hash']));

// Fechar a conexão com o banco de dados
$db = null;

?>