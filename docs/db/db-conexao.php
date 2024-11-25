<?php
$host = '127.0.0.1'; //Ip do servidor
$db = 'AcervoReceitas'; //Nome do banco
$user = 'root'; //Nome de usuário
$senha = ''; //Senha -> Sem senha por enquanto 

$conn = new mysqli($host, $user, $senha, $db); //Criando conexão com o db usando o mysqli

//Ele vai ver se a conexão com o db vai ser feita
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error); //Se a conexão "morrer", der erro, vai mostrar essa mensagem
} else {
    echo "Conexão bem-sucedida!"; //Se não der erro, então deve ser sucesso né?
}

//
?>
