<?php
$host = '127.0.0.1'; 
$db = 'AcervoReceitas'; 
$user = 'root'; 
$senha = ''; 

$conn = new mysqli($host, $user, $senha, $db); 

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error); 
} else {
    echo "Conexão bem-sucedida!"; 
}

//
?>
