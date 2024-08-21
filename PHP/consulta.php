<?php
require_once 'config.php';

function obterCad(){
    global $dsn,$user,$pass;
    $users = [];
try{
    $pdo = new PDO ($dsn,$user,$pass, 
    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]); //quando ouver algum erro, gera uma excessao
	
    $sql = "SELECT * FROM users";
    $stm = $pdo->query($sql);
    $stm ->execute();
    $alunos = $stm->fetchAll(PDO::FETCH_OBJ);
	
	
} catch (PDOException $e){
    $users=[];
}finally {
    if($pdo){
        $pdo=null;
    }
}
return $users;
}
?>