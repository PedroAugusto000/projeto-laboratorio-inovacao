<?php
// Conexão com o banco de dados
$conn = new mysqli("localhost", "root", "", "AcervoReceitas");

// Checa conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Consulta para pegar todos os livros
$sql_livros = "SELECT id, titulo, imagem FROM livros ORDER BY id DESC";
$result_livros = $conn->query($sql_livros);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todos os Livros</title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
    <header>
        <div class="logo">Logo</div>
        <div class="menu-icon" onclick="toggleMenu()">&#9776;</div>
        <nav>
            <a href="todas_receitas.php">Receitas</a>
            <a href="todos_livros.php">Livros</a>
        </nav>
        <div class="user-area">
            <a href="colaborador_inicial.php">Aba do colaborador</a>
            <a href="login.php">Login</a>
        </div>
    </header>

    <div class="content">
        <h1 class="section-title">Todos os Livros</h1>
        <div class="recommendations">
            <?php while ($livro = $result_livros->fetch_assoc()): ?>
                <div class="item">
                    <div class="livro-item">
                        <h3><a href="detalhe_livro.php?id=<?php echo $livro['id']; ?>"><?php echo htmlspecialchars($livro['titulo']); ?></a></h3>
                        <?php if ($livro['imagem']): ?>
                            <a href="detalhe_livro.php?id=<?php echo $livro['id']; ?>">
                                <img src="data:image/jpeg;base64,<?php echo base64_encode($livro['imagem']); ?>" alt="<?php echo htmlspecialchars($livro['titulo']); ?>" width="100%" height="150px">
                            </a>
                        <?php else: ?>
                            <div class="no-image">Sem imagem</div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <script src="scripts.js"></script>
</body>
</html>
