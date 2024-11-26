<?php
session_start();
require_once '../../projetoads.controller/livro/GerenciarLivroController.php';
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Livros</title>
    <link rel="stylesheet" href="../../../public/css/stylesLivros.css">
</head>
<body>

<header>
    <div class="logo-container">
        <a href="#">Logo</a>
    </div>
    <nav>
        <a href="../livro/GerenciarLivroView.php">Livros</a>
        <a href="../receitas/GerenciarReceitaView.php">Receitas</a>
        <a href="../colaborador/GerenciarColaboradorView.php">Funcionários</a>
    </nav>
    <div class="user-area">
        <span>Usuário</span>
        <a href="../../home/index.php" class="logout">Sair</a>
    </div>
</header>

<main>
    <h1>Gerenciar Livros</h1>
    <div class="search-bar">
        <form method="get" action="GerenciarLivroView.php">
            <input type="text" name="search" placeholder="Buscar livro..." value="<?php echo htmlspecialchars($searchTerm ?? ''); ?>">
        </form>
    </div>
    <a href="RegistroLivroView.php" class="register-btn" style="display: block; margin-top: 10px;">Registrar livro</a>
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
            <?php if ($livros && $livros->num_rows > 0): ?>
                <?php while ($row = $livros->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row["id"]); ?></td>
                        <td><?php echo htmlspecialchars($row["isbn"]); ?></td>
                        <td><?php echo htmlspecialchars($row["titulo"]); ?></td>
                        <td>
                            <a href="EditarLivroView.php?id=<?php echo $row['id']; ?>">✏️</a>
                            <a href="GerenciarLivroView.php?delete=<?php echo $row['id']; ?>" onclick="return confirm('Tem certeza que quer deletar esse livro?')">🗑️</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">Nenhum livro encontrado.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</main>

</body>
</html>
