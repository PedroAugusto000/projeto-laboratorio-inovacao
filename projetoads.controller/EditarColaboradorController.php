<?php
session_start();
require '../projetoads.model/db-conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $nome_fantasia = $_POST['nome_fantasia_input'] ?? null;
    $funcao = $_POST['funcao'];
    $rg = $_POST['rg'];
    $data_ingresso = $_POST['data_ingresso'];
    $salario = str_replace(['R$', ',', '.'], ['', '.', ''], $_POST['salario']);
    $referencias = $_POST['referencias'];

    $sql = "UPDATE Colaboradores SET nome = ?, nome_fantasia = ?, funcao = ?, rg = ?, data_ingresso = ?, salario = ?, referencias = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sssssssi', $nome, $nome_fantasia, $funcao, $rg, $data_ingresso, $salario, $referencias, $id);

    if ($stmt->execute()) {
        $_SESSION['mensagem'] = "Colaborador atualizado com sucesso!";
    } else {
        $_SESSION['mensagem'] = "Erro ao atualizar colaborador: " . $stmt->error;
    }

    header('Location: ../projetoads.view/colaborador_funcionarios.php');
    exit;
}
?>
