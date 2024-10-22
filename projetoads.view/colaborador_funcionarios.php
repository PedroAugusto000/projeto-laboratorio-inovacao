<?php
session_start();
require '../projetoads.model/db-conexao.php'; 

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

$nomeUsuario = $_SESSION['usuario'];

// Consulta para buscar todos os colaboradores
$sql = "SELECT id, nome, funcao, rg, data_ingresso FROM Colaboradores";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Colaboradores</title>
    <link rel="stylesheet" href="../css/stylesColaborador_funcionarios.css">
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
    <main>
        <h2>Gerenciar Colaboradores</h2>
        <div class="search-bar">
            <input type="text" placeholder="Pesquisar..." />
        </div>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Função</th>
                    <th>Nome</th>
                    <th>RG</th>
                    <th>Data de Ingresso</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['id']); ?></td>
                            <td><?php echo htmlspecialchars($row['funcao']); ?></td>
                            <td><?php echo htmlspecialchars($row['nome']); ?></td>
                            <td><?php echo htmlspecialchars($row['rg']); ?></td>
                            <td><?php echo date('d/m/Y', strtotime($row['data_ingresso'])); ?></td>
                            <td>
                                <a href="editar_colaborador.php?id=<?php echo $row['id']; ?>" title="Editar">&#x270E;</a>
                                <a href="excluir_colaborador.php?id=<?php echo $row['id']; ?>" title="Excluir">&#x1F5D1;</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6">Nenhum colaborador cadastrado.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <a href="registro_colaborador.php">Registrar colaborador</a>
    </main>
</body>
</html>

<?php
$conn->close(); // Fecha a conexão com o banco de dados
?>
