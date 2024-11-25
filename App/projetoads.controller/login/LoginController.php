<?php
session_start();
require '../projetoads.model/db-conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'];
    $senha = $_POST['senha'];

    $sql = "SELECT * FROM Login WHERE usuario = ? AND senha = MD5(?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ss', $usuario, $senha); 
    $stmt->execute(); 
    $result = $stmt->get_result(); 

    if ($result->num_rows > 0) {
        $_SESSION['usuario'] = $usuario;
        header('Location: ../index.php');
        exit; 
    } else {
        $_SESSION['erro'] = "Usuário ou senha incorretos!";
        header('Location: ../projetoads.view/login.php');
        exit;
    }
}
?>
