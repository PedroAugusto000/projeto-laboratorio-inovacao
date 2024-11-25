<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todas as Receitas</title>
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
        <h1 class="section-title">Todas as Receitas</h1>
        <div class="recommendations">
            <?php while ($row = $receitas->fetch_assoc()): ?>
                <div class="item">
                    <div class="receita-item">
                        <h3><a href="detalhe_receita.php?id=<?php echo $row['id']; ?>"><?php echo htmlspecialchars($row['nome']); ?></a></h3>
                        <?php if ($row['imagem_receita']): ?>
                            <a href="detalhe_receita.php?id=<?php echo $row['id']; ?>">
                                <img src="data:image/jpeg;base64,<?php echo base64_encode($row['imagem_receita']); ?>" alt="<?php echo htmlspecialchars($row['nome']); ?>" width="100%" height="150px">
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
