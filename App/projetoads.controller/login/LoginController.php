<?php
session_start();
require '../../../docs/db/db-conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'];
    $senha = $_POST['senha'];

    $sql = "SELECT usuario, nivel_permissao FROM Login WHERE usuario = ? AND senha = MD5(?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ss', $usuario, $senha);
    $stmt->execute();
    $result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $_SESSION['usuario'] = $user['usuario'];
    $_SESSION['nivel_permissao'] = $user['nivel_permissao']; // Adiciona o nível de permissão
    header('Location: ../../home/index.php');
    exit;
} else {
    $_SESSION['erro'] = "Usuário ou senha incorretos!";
    header('Location: ../../projetoads.view/login/LoginView.php');
    exit;
}

}
