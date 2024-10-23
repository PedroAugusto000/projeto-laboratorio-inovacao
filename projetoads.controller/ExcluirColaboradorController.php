<?php
session_start();
require '../projetoads.model/db-conexao.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM Colaboradores WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);

    if ($stmt->execute()) {
        $_SESSION['mensagem'] = "Colaborador excluído com sucesso!";
    } else {
        $_SESSION['mensagem'] = "Erro ao excluir colaborador: " . $stmt->error;
    }

    header('Location: ../projetoads.view/colaborador_funcionarios.php');
    exit;
} else {
    header('Location: ../projetoads.view/colaborador_funcionarios.php');
    exit;
}
?>
