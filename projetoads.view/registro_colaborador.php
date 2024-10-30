<?php
//Verificando a sessão...
session_start();
if (!isset($_SESSION['usuario'])) {
    // Se a sessão 'usuario' não estiver definida, redireciona para a página de login
    header('Location: login.php');
    exit; // Encerra o script para garantir que o usuário seja redirecionado
}

//Else...
// Armazena o nome do usuário logado em uma variável
$nomeUsuario = $_SESSION['usuario'];
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Colaborador</title>
    <link rel="stylesheet" href="../css/stylesRegistro_colaborador.css">
</head>
<body>
    <header>
        <div class="logo">Logo</div>
        <nav>
            <a href="#">Livros</a>
            <a href="#">Receitas</a>
            <a href="#">Funcionários</a>
        </nav>
        <div class="user-area">
            <span class="user-icon">&#x1F464;</span>
            <span><?php echo ($nomeUsuario); ?></span>
            <a href="../index.php" class="logout" title="Sair">&#x27A1;</a>
        </div>
    </header>

    <h2>Registro colaborador</h2>

    <div class="form-todo">
        <form action="../projetoads.controller/RegistroColaboradorController.php" method="post" class="form-registro">
            <div>
                <label for="nome">Nome</label>
                <input type="text" id="nome" name="nome" placeholder="Informe o nome..." required>
            </div>
            <div>
                <label for="nome_fantasia">Possui nome fantasia?</label>
                <input type="text" id="nome_fantasia_input" name="nome_fantasia_input" placeholder="Informe o nome fantasia..." disabled>
                <input type="checkbox" id="nome_fantasia" name="nome_fantasia">
            </div>
            <div>
                <label for="funcao">Função</label>
                <input type="text" id="funcao" name="funcao" placeholder="Cozinheiro, degustador..." required>
            </div>
            <div>
                <label for="rg">RG</label>
                <input type="text" id="rg" name="rg" placeholder="1.234.567" required>
            </div>
            <div>
                <label for="data_ingresso">Data de ingresso</label>
                <input type="date" id="data_ingresso" name="data_ingresso" required>
            </div>
            <div>
                <label for="salario">Salário</label>
                <input type="text" id="salario" name="salario" placeholder="R$1500,00" required>
            </div>
            <div>
                <label for="referencias">Referências (Opcional)</label>
                <textarea id="referencias" name="referencias" placeholder="Trabalhou no restaurante Oro no RJ..."></textarea>
            </div>
            <button type="submit" class="register-btn">Registrar</button>

            <a href="../projetoads.view/colaborador_funcionarios.php">Voltar</a>
        </form>
    </div>

    <script src="../scripts/scriptsRegistro_colaborador.js"></script>
</body>
</html>
