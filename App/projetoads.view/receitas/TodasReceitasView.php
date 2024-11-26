<?php
require_once '../../projetoads.controller/receita/TodasReceitasController.php';
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todas as Receitas</title>
    <link rel="stylesheet" href="../../home/styles.css"> 
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
        <h1 class="section-title">Todas as Receitas</h1>
        <div class="recommendations">
            <?php if ($receitas->num_rows > 0): ?>
                <?php while ($row = $receitas->fetch_assoc()): ?>
                    <div class="item">
                        <div class="receita-item">
                            <h3>
                                <a href="DetalheReceitaView.php?id=<?= htmlspecialchars($row['id']); ?>">
                                    <?= htmlspecialchars($row['nome']); ?>
                                </a>
                            </h3>
                            <?php if (!empty($row['imagem_receita'])): ?>
                                <a href="DetalheReceitaView.php?id=<?= htmlspecialchars($row['id']); ?>">
                                    <img src="data:image/jpeg;base64,<?= base64_encode($row['imagem_receita']); ?>" 
                                         alt="<?= htmlspecialchars($row['nome']); ?>" width="100%" height="150px">
                                </a>
                            <?php else: ?>
                                <div class="no-image">Sem imagem</div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>Nenhuma receita encontrada.</p>
            <?php endif; ?>
        </div>
    </div>

    <script src="../../public/scripts/scripts.js"></script> <!-- Caminho ajustado -->
</body>
</html>
