<?php
session_start();
require '../projetoads.model/db-conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'];
    $senha = $_POST['senha'];

    // Prepara a consulta SQL para verificar se existe um usuário com a combinação de usuário e senha informados
    // A senha é verificada usando MD5
    $sql = "SELECT * FROM Login WHERE usuario = ? AND senha = MD5(?)";

    $stmt = $conn->prepare($sql);//Prepara a consulta
    $stmt->bind_param('ss', $usuario, $senha); //Ligando os parâmetros
    $stmt->execute(); //Executa
    $result = $stmt->get_result(); //Cata os resultado

    // Verifica se foi encontrado algum registro com o usuário e a senha informados
    if ($result->num_rows > 0) {
        //Se encontrar ele vai salavar o usuário na sessão e já enviar pra página inicial
        $_SESSION['usuario'] = $usuario;
        header('Location: ../index.php');
        exit; //Certeza que vai ser redirecionado (Encerra o script)
    } else {
        //Se der bosta. E fica na mesma página pro caba inserir o login dnv
        $_SESSION['erro'] = "Usuário ou senha incorretos!";
        header('Location: ../projetoads.view/login.php');
        exit;
    }
}
?>
