<?php
require '../projetoads.model/db-conexao.php';
session_start();

//Verifica se o formulário foi enviado verificando o método de envio
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //Aqui ele tá só catando os dados enviados pelo formulário
    $nome = $_POST['nome'];
    $nome_fantasia = isset($_POST['nome_fantasia']) ? $_POST['nome_fantasia_input'] : null; //Condição, já que o nome fantasia pode ser nulo
    $funcao = $_POST['funcao'];
    $rg = $_POST['rg'];
    $data_ingresso = $_POST['data_ingresso'];
    $salario = str_replace(['R$', ',', '.'], ['', '.', ''], $_POST['salario']); // Ajusta o formato do salário
    $referencias = $_POST['referencias'];

    //Preparando a query pra inserir os dados na tabela especificada
    $sql = "INSERT INTO Colaboradores (nome, nome_fantasia, funcao, rg, data_ingresso, salario, referencias) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql); //"Vou buscar uma parada, já já te falo..."
    // Liga os parâmetros da query com os valores que foram enviados pelo formulário
    //sssssss sigfnica os tipos de dados que eu vou passar 
    $stmt->bind_param('sssssss', $nome, $nome_fantasia, $funcao, $rg, $data_ingresso, $salario, $referencias); //"Eu quero isso aqui meu fi"

    //Condição p/ ver se deu tudo certo
    if ($stmt->execute()) {
        // Se a execução for bem-sucedida, salva uma mensagem de sucesso na sessão e redireciona para a lista de colaboradores
        $_SESSION['mensagem'] = "Colaborador registrado com sucesso!";
        header('Location: ../projetoads.view/colaborador_funcionarios.php');
        exit; //Encerra pra ter certeza que vai redirecionar

    } else {
        //Caso de bosta:
        $_SESSION['mensagem'] = "Erro ao registrar colaborador: " . $stmt->error;
        header('Location: ../projetoads.view/registro_colaborador.php');
        exit;
    }

//Fechando a conexão com o db
    $stmt->close();
    $conn->close();
} else {
    //Se, por alguma acaso (Que não deve acontecer) o script não for enviado via post ele vai mandar de volta pro registro_colaborador.php
    header('Location: ../projetoads.view/registro_colaborador.php');
    exit;
}
?>
