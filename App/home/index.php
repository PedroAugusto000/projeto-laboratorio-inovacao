<?php
require_once '../../docs/db/db-conexao.php';
require_once '../projetoads.model/indexModel.php';

$model = new IndexModel("localhost", "root", "", "AcervoReceitas");

// Pega o termo de pesquisa da query string (se houver)
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

// Busca as receitas recomendadas ou filtra pelas receitas que combinam com o termo de pesquisa
if ($searchTerm) {
    $result_receitas = $model->searchReceitas($searchTerm);
    $result_livros = $model->searchLivros($searchTerm);
} else {
    // Caso não haja pesquisa, carrega todas as recomendações
    $result_receitas = $model->getReceitasRecomendadas();
    $result_livros = $model->getLivrosRecomendados();
}

$categorias_receitas = $model->getCategoriasComReceitas();
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
        <div class="logo">
            <a href="index.php">
                <img src="../../public/image/logo.png" alt="Logo Receitas e Livros">
            </a>
        </div>
        <nav>
            <a href="../projetoads.view/receitas/TodasReceitasView.php">Receitas</a>
            <a href="../projetoads.view/livro/TodosLivroView.php">Livros</a>
        </nav>
        
        <!-- Barra de pesquisa, sem botão -->
        <div class="search-bar">
            <form action="index.php" method="GET">
                <input type="text" name="search" placeholder="Pesquisar..." value="<?= htmlspecialchars($searchTerm); ?>" onkeydown="if(event.key === 'Enter') this.form.submit()">
            </form>
        </div>

        <div class="user-area">
            <a href="../projetoads.view/colaborador/HomeColaboradorView.php" class="btn">Aba do colaborador</a>
            <a href="../projetoads.view/login/LoginView.php" class="btn">Login</a>
        </div>
    </header>

    <main class="content">
        <!-- Seção de Receitas -->
        <section>
            <h2 class="section-title">Recomendação de receitas</h2>
            <div class="recommendations">
                <?php while ($row = $result_receitas->fetch_assoc()): ?>
                    <div class="item">
                        <h3>
                            <a href="../projetoads.view/receitas/DetalheReceitaView.php?id=<?= htmlspecialchars($row['id']); ?>">
                                <?= htmlspecialchars($row['nome']); ?>
                            </a>
                        </h3>
                        <?php if (!empty($row['imagem_receita'])): ?>
                            <img src="data:image/jpeg;base64,<?= base64_encode($row['imagem_receita']); ?>" alt="<?= htmlspecialchars($row['nome']); ?>" />
                        <?php else: ?>
                            <div class="no-image">Sem imagem</div>
                        <?php endif; ?>
                    </div>
                <?php endwhile; ?>
            </div>
            <a href="../projetoads.view/receitas/TodasReceitasView.php" class="btn">Ver mais receitas</a>
        </section>

        <!-- Seção de Livros -->
        <section>
            <h2 class="section-title">Recomendação de livros</h2>
            <div class="recommendations">
                <?php while ($livro = $result_livros->fetch_assoc()): ?>
                    <div class="item">
                        <h3>
                            <a href="../projetoads.view/livro/DetalheLivroView.php?id=<?= htmlspecialchars($livro['id']); ?>">
                                <?= htmlspecialchars($livro['titulo']); ?>
                            </a>
                        </h3>
                        <?php if (!empty($livro['imagem'])): ?>
                            <img src="data:image/jpeg;base64,<?= base64_encode($livro['imagem']); ?>" alt="<?= htmlspecialchars($livro['titulo']); ?>" />
                        <?php else: ?>
                            <div class="no-image">Sem imagem</div>
                        <?php endif; ?>
                    </div>
                <?php endwhile; ?>
            </div>
            <a href="../projetoads.view/livro/TodosLivroView.php" class="btn">Ver mais livros</a>
        </section>

        <!-- Seção de Categorias -->
        <section>
        <br> <br>    
        <center>
            <h2 class="section-category">Categorias</h2>
            </center>
            <div class="categories">
                <?php foreach ($categorias_receitas as $categoria => $receitas): ?>
                    <div class="category">
                        <h3><?= htmlspecialchars($categoria); ?></h3>
                        <div class="recommendations">
                            <?php foreach ($receitas as $receita): ?>
                                <div class="item">
                                    <h3>
                                        <a href="../projetoads.view/receitas/DetalheReceitaView.php?id=<?= $receita['id']; ?>">
                                            <?= htmlspecialchars($receita['nome']); ?>
                                        </a>
                                    </h3>
                                    <?php if (!empty($receita['imagem_receita'])): ?>
                                        <img src="data:image/jpeg;base64,<?= base64_encode($receita['imagem_receita']); ?>" alt="<?= htmlspecialchars($receita['nome']); ?>" />
                                    <?php else: ?>
                                        <div class="no-image">Sem imagem</div>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    </main>

    <script src="scripts.js"></script>
</body>
</html>
