<?php
require '../projetoads.model/db-conexao.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $nome_fantasia = isset($_POST['nome_fantasia']) ? $_POST['nome_fantasia_input'] : null;
    $funcao = $_POST['funcao'];
    $rg = $_POST['rg'];
    $data_ingresso = $_POST['data_ingresso'];
    $salario = str_replace(['R$', ',', '.'], ['', '.', ''], $_POST['salario']); // Ajusta o formato do salário
    $referencias = $_POST['referencias'];

    $sql = "INSERT INTO Colaboradores (nome, nome_fantasia, funcao, rg, data_ingresso, salario, referencias) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sssssss', $nome, $nome_fantasia, $funcao, $rg, $data_ingresso, $salario, $referencias);

    if ($stmt->execute()) {
        $_SESSION['mensagem'] = "Colaborador registrado com sucesso!";
        header('Location: ../projetoads.view/colaborador_funcionarios.php');
        echo "TESTE!";
        exit;

    } else {
        $_SESSION['mensagem'] = "Erro ao registrar colaborador: " . $stmt->error;
        header('Location: ../projetoads.view/registro_colaborador.php');
        exit;
    }

    $stmt->close();
    $conn->close();
} else {
    header('Location: ../projetoads.view/registro_colaborador.php');
    exit;
}
?>
