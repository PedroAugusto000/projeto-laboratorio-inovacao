<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($livro['titulo']); ?> - Detalhes do Livro</title>
    <link rel="stylesheet" href="../css/navbar.css" class="css">
    <style>
        /* Seu CSS mantido aqui */
    </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="book-container">
    <h1><?php echo htmlspecialchars($livro['titulo']); ?></h1>

    <?php if ($livro['imagem']): ?>
        <img src="data:image/jpeg;base64,<?php echo base64_encode($livro['imagem']); ?>" alt="<?php echo htmlspecialchars($livro['titulo']); ?>" class="book-img">
    <?php else: ?>
        <div class="no-image">Sem imagem disponível</div>
    <?php endif; ?>

    <div class="description"><?php echo nl2br(htmlspecialchars($livro['descricao'])); ?></div>
    <div class="isbn"><strong>ISBN:</strong> <?php echo htmlspecialchars($livro['isbn']); ?></div>
    <div class="recipe-count"><strong>Receitas incluídas:</strong> <?php echo count($receitas); ?></div>

    <div class="section-title">Receitas</div>
    <ul class="recipes-list">
        <?php if (count($receitas) > 0): ?>
            <?php foreach ($receitas as $receita): ?>
                <li><a href="detalhe_receita.php?id=<?php echo $receita['id']; ?>"><?php echo htmlspecialchars($receita['nome']); ?></a></li>
            <?php endforeach; ?>
        <?php else: ?>
            <li>Nenhuma receita associada a este livro.</li>
        <?php endif; ?>
    </ul>

    <button class="visualizar-btn" onclick="openModal()">Visualizar Receitas</button>
</div>

<div id="recipeModal" class="modal">
    <div class="modal-content">
        <span class="close-modal" onclick="closeModal()">&times;</span>
        <div id="recipeContent"></div>
        <div class="nav-buttons">
            <button class="nav-button" onclick="prevRecipe()">Anterior</button>
            <button class="nav-button" onclick="nextRecipe()">Próxima</button>
        </div>
    </div>
</div>

<script>
    let recipes = <?php echo json_encode($receitas); ?>;
    let currentRecipeIndex = 0;

    function openModal() {
        document.getElementById("recipeModal").style.display = "flex";
        showRecipe(currentRecipeIndex);
    }

    function closeModal() {
        document.getElementById("recipeModal").style.display = "none";
    }

    function showRecipe(index) {
        const recipe = recipes[index];
        document.getElementById("recipeContent").innerHTML = `
            <h2>${recipe.nome}</h2>
            <h3>Ingredientes</h3>
            <p>${recipe.ingredientes.replace(/\n/g, "<br>")}</p>
            <h3>Modo de Preparo</h3>
            <p>${recipe.modo_preparo.replace(/\n/g, "<br>")}</p>
        `;
    }

    function nextRecipe() {
        if (currentRecipeIndex < recipes.length - 1) {
            currentRecipeIndex++;
            showRecipe(currentRecipeIndex);
        }
    }

    function prevRecipe() {
        if (currentRecipeIndex > 0) {
            currentRecipeIndex--;
            showRecipe(currentRecipeIndex);
        }
    }
</script>

</body>
</html>
