<?php
require_once 'config.php'; // Inclui o arquivo de configuração com as credenciais do banco de dados

// Recebe o parâmetro 'q' da requisição GET
$q = isset($_GET["q"]) ? $_GET["q"] : '';

try {
    // Conecta ao banco de dados usando as variáveis definidas no arquivo de configuração
    $pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

    // Prepara a consulta SQL parametrizada para buscar autores que correspondam ao nome digitado
    $stmt = $pdo->prepare("SELECT autor FROM autores WHERE autor ILIKE :autor");
    $stmt->execute(['autor' => '%' . $q . '%']);

    // Array para armazenar as sugestões de autores
    $suggestions = array();

    // Itera sobre os resultados da consulta e adiciona os nomes ao array de sugestões
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $suggestions[] = $row["autor"];
    }

    // Retorna as sugestões como JSON
    header('Content-Type: application/json'); // Define o tipo de conteúdo como JSON
    echo json_encode($suggestions);
} catch (PDOException $e) {
    // Em caso de erro, retorna uma mensagem de erro
    http_response_code(500); // Define o código de resposta HTTP para indicar erro interno do servidor
    echo json_encode(array("message" => "Erro ao conectar com o banco de dados: " . $e->getMessage()));
    exit; // Encerra o script após enviar a resposta JSON
}
?>
