<?php
//Sessão...
session_start();
require '../projetoads.model/db-conexao.php';

// Verifica se o usuário está logado. Se não estiver, redireciona para a página de login.
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

// Senão... Armazena o nome do usuário logado numa variável
$nomeUsuario = $_SESSION['usuario'];

// Pega o ID do colaborador da URL, se estiver presente; caso contrário, define como uma string vazia
$id = $_GET['id'] ?? '';

$sql = "SELECT * FROM Colaboradores WHERE id = ?"; //// Prepara a consulta SQL para selecionar as informações do colaborador pelo ID
$stmt = $conn->prepare($sql); //Preparando a consulta
$stmt->bind_param('i', $id); //Parâmetro da consulta i = inteiro
$stmt->execute(); //Executa...
$result = $stmt->get_result(); //Cata o resultado
$colaborador = $result->fetch_assoc(); //// Busca a linha correspondente ao colaborador
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Colaborador</title>
    <link rel="stylesheet" href="../css/stylesRegistro_colaborador.css">
</head>
<body>
    <header>
        <div class="logo">Logo</div>
        <nav>
            <a href="gerir_livros.php">Livros</a>
            <a href="gerenciar_receitas.php">Receitas</a>
            <a href="colaborador_funcionarios.php">Funcionários</a>
        </nav>
        <div class="user-area">
            <span class="user-icon">&#x1F464;</span>
            <span><?php echo ($nomeUsuario); ?></span>
            <a href="../index.php" class="logout" title="Sair">&#x27A1;</a>
        </div>
    </header>

    <h2>Editar colaborador</h2>

    <div class="form-todo">
        <form action="../projetoads.controller/EditarColaboradorController.php" method="post" class="form-registro">
            <!-- Campo oculto para enviar o ID do colaborador (necessário para identificar qual colaborador será atualizado) -->
            <input type="hidden" name="id" value="<?php echo ($colaborador['id']); ?>">
            <div>
                <label for="nome">Nome</label>
                <input type="text" id="nome" name="nome" value=" <?php echo($colaborador['nome']); ?>" required>
            </div>
            <div>
                <label for="nome_fantasia">Possui nome fantasia?</label>
                <input type="text" id="nome_fantasia_input" name="nome_fantasia_input" value="<?php echo htmlspecialchars($colaborador['nome_fantasia']); ?>">
            </div>
            <div>
                <label for="funcao">Função</label>
                <input type="text" id="funcao" name="funcao" value="<?php echo ($colaborador['funcao']); ?>" required>
            </div>
            <div>
                <label for="rg">RG</label>
                <input type="text" id="rg" name="rg" value="<?php echo ($colaborador['rg']); ?>" required>
            </div>
            <div>
                <label for="data_ingresso">Data de ingresso</label>
                <input type="date" id="data_ingresso" name="data_ingresso" value="<?php echo ($colaborador['data_ingresso']); ?>" required>
            </div>
            <div>
                <label for="salario">Salário</label>
                <input type="text" id="salario" name="salario" value="<?php echo ($colaborador['salario']); ?>" required>
            </div>
            <div>
                <label for="referencias">Referências (Opcional)</label>
                <textarea id="referencias" name="referencias"><?php echo ($colaborador['referencias']); ?></textarea>
            </div>
            <button type="submit" class="register-btn">Atualizar</button>
            <a href="colaborador_funcionarios.php">Voltar</a>
        </form>
    </div>
</body>
</html>
