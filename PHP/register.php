<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {


/*    $host = "localhost";
    $port = 5432;
    $user = "postgres";
    $pass = "postgre";
    $name = "postgres";

$dsn ="pgsql:host=$host;port=$port;dbname=$name";
*/

require_once 'config.php';

try {
        $db = new PDO($dsn, $user, $pass);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


        $newUsername = $_POST['newUsername'];
        $newPassword = password_hash($_POST['newPassword'], PASSWORD_BCRYPT);

        $query = "INSERT INTO users (nome, senha_hash) VALUES (:nome, :senha_hash)";
        $stmt = $db->prepare($query);

        if ($stmt) {
            $stmt->bindParam(':nome', $newUsername, PDO::PARAM_STR);
            $stmt->bindParam(':senha_hash', $newPassword, PDO::PARAM_STR);

            $stmt->execute();

            echo 'Registration successful';
        } else {
            echo 'Erro ao preparar a consulta de registro';
        }
    } catch (PDOException $e) {
        echo 'Erro de conexão: ' . $e->getMessage();
    }

    $db = null;
} else {
    header('Location: login.php');
    exit();
}
?>
