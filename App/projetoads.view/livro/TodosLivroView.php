<?php
require_once '../../projetoads.controller/livro/TodosLivrosController.php';
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todos os Livros</title>
    <link rel="stylesheet" href="../../home/styles.css"> <!-- Caminho ajustado -->
</head>
<body>
    <header>
        <div class="logo">Logo</div>
        <div class="menu-icon" onclick="toggleMenu()">&#9776;</div>
        <nav>
            <a href="../receitas/TodasReceitasView.php">Receitas</a>
            <a href="../livro/TodosLivroView.php">Livros</a>
        </nav>
        <div class="user-area">
            <a href="../colaborador/HomeColaboradorView.php">Aba do colaborador</a>
            <a href="../login/LoginView.php">Login</a>
        </div>
    </header>

    <div class="content">
        <h1 class="section-title">Todos os Livros</h1>
        <div class="recommendations">
            <?php if ($livros->num_rows > 0): ?>
                <?php while ($livro = $livros->fetch_assoc()): ?>
                    <div class="item">
                        <div class="livro-item">
                            <h3>
                                <a href="DetalheLivroView.php?id=<?= htmlspecialchars($livro['id']); ?>">
                                    <?= htmlspecialchars($livro['titulo']); ?>
                                </a>
                            </h3>
                            <?php if (!empty($livro['imagem'])): ?>
                                <a href="DetalheLivroView.php?id=<?= htmlspecialchars($livro['id']); ?>">
                                    <img src="data:image/jpeg;base64,<?= base64_encode($livro['imagem']); ?>" 
                                         alt="<?= htmlspecialchars($livro['titulo']); ?>" width="100%" height="150px">
                                </a>
                            <?php else: ?>
                                <div class="no-image">Sem imagem</div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>Nenhum livro encontrado.</p>
            <?php endif; ?>
        </div>
    </div>

    <script src="../../public/scripts/scripts.js"></script> <!-- Caminho ajustado -->
</body>
</html>
