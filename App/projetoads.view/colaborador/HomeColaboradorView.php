<?php
require_once '../../projetoads.controller/colaborador/HomeColaboradorController.php';
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aba do Colaborador</title>
    <link rel="stylesheet" href="../../../public/css/stylesColaborador_inicial.css">
</head>
<body>
    <header>
        <div class="logo">Logo</div>
        <nav>
            <a href="../livro/GerenciarLivroView.php">Livros</a>
            <a href="../receitas/GerenciarReceitaView.php">Receitas</a>
            <a href="../colaborador/GerenciarColaboradorView.php">Funcionários</a>
        </nav>

        <div class="user-area">
            <span class="user-icon">&#x1F464;</span> 
            <span><?php echo htmlspecialchars($nomeUsuario); ?></span> 
            <a href="../../home/index.php" class="logout" title="Sair">&#x27A1;</a>
        </div>
    </header>
    <main>
        <h2>Bem-vindo, <?php echo htmlspecialchars($nomeUsuario); ?>!</h2>
    </main>
</body>
</html>
