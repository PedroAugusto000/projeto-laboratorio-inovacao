<?php
require_once '../../docs/db/db-conexao.php'; // Usando o arquivo de conexão centralizado

// Query para buscar receitas
$sql_receitas = "SELECT id, nome, imagem_receita FROM receitas ORDER BY id DESC LIMIT 3";
$result_receitas = $conn->query($sql_receitas);
if (!$result_receitas) {
    die("Erro ao buscar receitas: " . $conn->error);
}

// Query para buscar livros
$sql_livros = "SELECT id, titulo, imagem FROM livros ORDER BY id DESC LIMIT 3";
$result_livros = $conn->query($sql_livros);
if (!$result_livros) {
    die("Erro ao buscar livros: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Inicial - Receitas e Livros</title>
    <link rel="stylesheet" href="styles.css"> <!-- Caminho ajustado -->
</head>
<body>
    <header>
        <div class="logo">Logo</div>
        <div class="menu-icon" onclick="toggleMenu()">&#9776;</div>
        <nav>
            <a href="../projetoads.view/receitas/TodasReceitasView.php">Receitas</a>
            <a href="../projetoads.view/livro/TodosLivroView.php">Livros</a>
        </nav>
        <div class="search-bar">
            <input type="text" placeholder="Pesquisar...">
        </div>
        <div class="user-area">
            <a href="../projetoads.view/colaborador/HomeColaboradorView.php">Aba do colaborador</a>
            <a href="../projetoads.view/login/LoginView.php">Login</a>
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
                    echo "<li><a href='#'>" . htmlspecialchars($tipo) . "</a></li>";
                }
                ?>
            </ul>
            <li><a href="index.php">Voltar</a></li>
        </ul>
    </div>

    <main class="content">
        <section>
            <h1>Recomendações</h1>
            
            <div class="section-title">Recomendação de receitas</div>
            <div class="recommendations">
                <?php while ($row = $result_receitas->fetch_assoc()): ?>
                    <div class="item">
                        <h3>
                            <a href="../projetoads.view/receitas/DetalheReceitaView.php?id=<?= htmlspecialchars($row['id']); ?>">
                                <?= htmlspecialchars($row['nome']); ?>
                            </a>
                        </h3>
                        <?php if (!empty($row['imagem_receita'])): ?>
                            <img src="data:image/jpeg;base64,<?= base64_encode($row['imagem_receita']); ?>" 
                                 alt="<?= htmlspecialchars($row['nome']); ?>" />
                        <?php else: ?>
                            <div class="no-image">Sem imagem</div>
                        <?php endif; ?>
                    </div>
                <?php endwhile; ?>
            </div>
            <a href="../projetoads.view/receitas/TodasReceitasView.php" class="see-more">Ver mais receitas</a>
        </section>

        <section>
            <div class="section-title">Recomendação de livros</div>
            <div class="recommendations">
                <?php while ($livro = $result_livros->fetch_assoc()): ?>
                    <div class="item">
                        <h3>
                            <a href="../projetoads.view/livro/DetalheLivroView.php?id=<?= htmlspecialchars($livro['id']); ?>">
                                <?= htmlspecialchars($livro['titulo']); ?>
                            </a>
                        </h3>
                        <?php if (!empty($livro['imagem'])): ?>
                            <img src="data:image/jpeg;base64,<?= base64_encode($livro['imagem']); ?>" 
                                 alt="<?= htmlspecialchars($livro['titulo']); ?>" />
                        <?php else: ?>
                            <div class="no-image">Sem imagem</div>
                        <?php endif; ?>
                    </div>
                <?php endwhile; ?>
            </div>
            <a href="../projetoads.view/livro/TodosLivroView.php" class="see-more">Ver mais livros</a>
        </section>
    </main>

    <script src="../public/scripts/scripts.js"></script> <!-- Caminho ajustado -->
</body>
</html>
