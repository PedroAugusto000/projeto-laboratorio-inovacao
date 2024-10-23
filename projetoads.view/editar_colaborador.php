<?php
session_start();
require '../projetoads.model/db-conexao.php';

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

$nomeUsuario = $_SESSION['usuario'];
$id = $_GET['id'] ?? '';

$sql = "SELECT * FROM Colaboradores WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();
$colaborador = $result->fetch_assoc();
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
            <a href="#">Livros</a>
            <a href="#">Receitas</a>
            <a href="#">Funcionários</a>
        </nav>
        <div class="user-area">
            <span class="user-icon">&#x1F464;</span>
            <span><?php echo htmlspecialchars($nomeUsuario); ?></span>
            <a href="../index.php" class="logout" title="Sair">&#x27A1;</a>
        </div>
    </header>

    <h2>Editar colaborador</h2>

    <div class="form-todo">
        <form action="../projetoads.controller/EditarColaboradorController.php" method="post" class="form-registro">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($colaborador['id']); ?>">
            <div>
                <label for="nome">Nome</label>
                <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($colaborador['nome']); ?>" required>
            </div>
            <div>
                <label for="nome_fantasia">Possui nome fantasia?</label>
                <input type="text" id="nome_fantasia_input" name="nome_fantasia_input" value="<?php echo htmlspecialchars($colaborador['nome_fantasia']); ?>">
            </div>
            <div>
                <label for="funcao">Função</label>
                <input type="text" id="funcao" name="funcao" value="<?php echo htmlspecialchars($colaborador['funcao']); ?>" required>
            </div>
            <div>
                <label for="rg">RG</label>
                <input type="text" id="rg" name="rg" value="<?php echo htmlspecialchars($colaborador['rg']); ?>" required>
            </div>
            <div>
                <label for="data_ingresso">Data de ingresso</label>
                <input type="date" id="data_ingresso" name="data_ingresso" value="<?php echo htmlspecialchars($colaborador['data_ingresso']); ?>" required>
            </div>
            <div>
                <label for="salario">Salário</label>
                <input type="text" id="salario" name="salario" value="<?php echo htmlspecialchars($colaborador['salario']); ?>" required>
            </div>
            <div>
                <label for="referencias">Referências (Opcional)</label>
                <textarea id="referencias" name="referencias"><?php echo htmlspecialchars($colaborador['referencias']); ?></textarea>
            </div>
            <button type="submit" class="register-btn">Atualizar</button>
        </form>
    </div>
</body>
</html>
