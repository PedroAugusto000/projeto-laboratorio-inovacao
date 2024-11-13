<?php
// Conexão com o banco de dados
$conn = new mysqli("localhost", "root", "", "AcervoReceitas");

// Checa conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Consulta para pegar as 3 receitas mais recentes
$sql_receitas = "SELECT id, nome, imagem_receita FROM receitas ORDER BY id DESC LIMIT 3";
$result_receitas = $conn->query($sql_receitas);

// Consulta para pegar os 3 livros mais recentes
$sql_livros = "SELECT id, titulo, imagem FROM livros ORDER BY id DESC LIMIT 3";
$result_livros = $conn->query($sql_livros);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Inicial - Receitas e Livros</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <div class="logo">Logo</div>
        <div class="menu-icon" onclick="toggleMenu()">&#9776;</div>
        <nav>
            <a href="todas_receitas.php">Receitas</a>
            <a href="todos_livros.php">Livros</a>
        </nav>
        <div class="search-bar">
            <input type="text" placeholder="Pesquisar...">
        </div>
        <div class="user-area">
            <a href="./projetoads.view/colaborador_inicial.php">Aba do colaborador</a>
            <a href="./projetoads.view/login.php">Login</a>
        </div>
    </header>

    <div class="menu" id="side-menu">
        <ul>
            <li><a href="index.php">Página Inicial</a></li>
            <li class="toggle" onclick="toggleSubmenu('submenu-tipos')">Tipos de pratos</li>
            <ul id="submenu-tipos" class="submenu">
                <?php
                    $tipos = ['Tortas', 'Bolos', 'Doces e sobremesas', 'Carnes', 'Massas', 'Saladas', 'Peixes e Frutos do mar'];
                    foreach ($tipos as $tipo) {
                        echo "<li><a href='#'>{$tipo}</a></li>";
                    }
                ?>
            </ul>
            <br> <a href="index.php">Voltar</a>
        </ul>
    </div>

    <div class="content">
        <div class="arrows">
            <button>&larr;</button>
            <h1>Recomendações</h1>
            <button>&rarr;</button>
        </div>

        <!-- Seção de Recomendação de Receitas -->
        <div class="section-title">Recomendação de receitas</div>
        <div class="recommendations">
            <?php while ($row = $result_receitas->fetch_assoc()): ?>
                <div class="item">
                    <div class="receita-item">
                        <h3><a href="./projetoads.view/detalhe_receita.php?id=<?php echo $row['id']; ?>"><?php echo htmlspecialchars($row['nome']); ?></a></h3>
                        <?php if ($row['imagem_receita']): ?>
                            <a href="./projetoads.view/detalhe_receita.php?id=<?php echo $row['id']; ?>">
                                <img src="data:image/jpeg;base64,<?php echo base64_encode($row['imagem_receita']); ?>" alt="<?php echo htmlspecialchars($row['nome']); ?>" width="100%" height="150px">
                            </a>
                        <?php else: ?>
                            <div class="no-image">Sem imagem</div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
        <a href="./projetoads.view/todas_receitas.php" class="see-more">Ver mais receitas</a> <!-- Link para ver todas as receitas -->

        <!-- Seção de Recomendação de Livros -->
        <div class="section-title">Recomendação de livros</div>
        <div class="recommendations">
            <?php while ($livro = $result_livros->fetch_assoc()): ?>
                <div class="item">
                    <div class="livro-item">
                        <h3><a href="./projetoads.view/detalhe_livro.php?id=<?php echo $livro['id']; ?>"><?php echo htmlspecialchars($livro['titulo']); ?></a></h3>
                        <?php if ($livro['imagem']): ?>
                            <a href="./projetoads.view/detalhe_livro.php?id=<?php echo $livro['id']; ?>">
                                <img src="data:image/jpeg;base64,<?php echo base64_encode($livro['imagem']); ?>" alt="<?php echo htmlspecialchars($livro['titulo']); ?>" width="100%" height="150px">
                            </a>
                        <?php else: ?>
                            <div class="no-image">Sem imagem</div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
        <a href="./projetoads.view/todos_livros.php" class="see-more">Ver mais livros</a> <!-- Link para ver todos os livros -->
    </div>

    <script src="scripts.js"></script>
</body>
</html>
