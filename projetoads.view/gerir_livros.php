<?php
// Conexão com o banco de dados
$conn = new mysqli("localhost", "root", "", "AcervoReceitas");

// Verifica a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Verifica se há um pedido de exclusão
if (isset($_GET["delete"])) {
    $id = $_GET["delete"];
    $conn->query("DELETE FROM livros WHERE id = $id");
    header("Location: gerir_livros.php");
}

// Seleciona todos os livros
$result = $conn->query("
    SELECT id, isbn, titulo 
    FROM livros
");

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Livros</title>
    <link rel="stylesheet" href="../css/stylesLivros.css">
</head>
<body>

<header>
    <nav>
        <a href="#">Logo</a>
        <a href="gerir_livros.php">Livros</a>
        <a href="gerenciar_receitas.php">Receitas</a>
        <a href="#">Funcionários</a>
    </nav>
    <div class="user-area">
        <span>Usuário</span>
        <a href="../index.php" class="logout">Sair</a>
    </div>
</header>

<main>
    <h1>Gerenciar Livros</h1>
    <div class="search-bar">
        <input type="text" placeholder="Buscar livro...">
    </div>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>ISBN</th>
                <th>Título</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row["id"]; ?></td>
                    <td><?php echo htmlspecialchars($row["isbn"]); ?></td>
                    <td><?php echo htmlspecialchars($row["titulo"]); ?></td>
                    <td>
                        <a href="editar_livro.php?id=<?php echo $row['id']; ?>">✏️</a>
                        <a href="gerir_livros.php?delete=<?php echo $row['id']; ?>" onclick="return confirm('Tem certeza que quer deletar esse livro?')">🗑️</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <a href="registro_livro.php" class="register-btn">Registrar livro</a>
</main>

</body>
</html>
