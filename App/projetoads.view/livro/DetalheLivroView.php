<?php
require_once '../../projetoads.controller/livro/DetalheLivroController.php';
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($livro['titulo'] ?? 'Detalhes do Livro'); ?> - Detalhes do Livro</title>
    <link rel="stylesheet" href="../../home/styles.css">
    <style>
        a {
            color: #ff9900; /* Cor do link laranja */
            text-decoration: none; /* Remove o sublinhado padrão */
            transition: color 0.3s ease; /* Efeito de transição para a cor */
        }

        a:hover {
            color: #e68a00; /* Cor do link quando passar o mouse (laranja mais escuro) */
        }

        body {
            background-color: #f3f3f3;
            color: #232f3e;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        .book-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1 {
            font-size: 2em;
            text-align: center;
        }
        .book-img {
            width: 100%;
            max-height: 300px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .no-image {
            width: 100%;
            height: 300px;
            background-color: #e0e0e0;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 8px;
            font-style: italic;
            color: #555;
        }
        .section-title {
            margin-top: 20px;
            font-size: 1.5em;
            border-bottom: 2px solid #ff9900;
            padding-bottom: 5px;
        }
        ul.recipes-list {
            list-style-type: none;
            padding: 0;
        }
        ul.recipes-list li {
            margin: 5px 0;
        }
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.8);
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }
        .modal-content {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            max-width: 600px;
            width: 90%;
            text-align: center;
            position: relative;
        }
        .close-modal {
            position: absolute;
            top: 10px;
            right: 20px;
            font-size: 1.5em;
            cursor: pointer;
            color: #333;
        }
        .nav-buttons {
            margin-top: 20px;
            display: flex;
            justify-content: center;
            gap: 10px;
        }
        .nav-button {
            padding: 10px 20px;
            background: #ff9900;
            border: none;
            border-radius: 5px;
            color: #fff;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .nav-button:hover {
            background: #e68a00;
        }

        .nav-button:disabled {
            background: #ccc;
            cursor: not-allowed;
        }
    </style>
</head>
<body>

<?php include '../navbar.php'; ?>

<div class="book-container">
    <h1><?php echo htmlspecialchars($livro['titulo'] ?? 'Livro não encontrado'); ?></h1>

    <?php if (!empty($livro['imagem'])): ?>
        <img src="data:image/jpeg;base64,<?php echo base64_encode($livro['imagem']); ?>" 
             alt="<?php echo htmlspecialchars($livro['titulo']); ?>" class="book-img">
    <?php else: ?>
        <div class="no-image">Sem imagem disponível</div>
    <?php endif; ?>

    <div class="description"><?php echo nl2br(htmlspecialchars($livro['descricao'] ?? 'Descrição indisponível.')); ?></div>
    <div class="isbn"><strong>ISBN:</strong> <?php echo htmlspecialchars($livro['isbn'] ?? 'N/A'); ?></div>
    <div class="recipe-count"><strong>Receitas incluídas:</strong> <?php echo count($receitas ?? []); ?></div>

    <div class="section-title">Receitas</div>
    <ul class="recipes-list">
        <?php if (!empty($receitas)): ?>
            <?php foreach ($receitas as $receita): ?>
                <li><a href="../receitas/DetalheReceitaView.php?id=<?php echo htmlspecialchars($receita['id']); ?>"><?php echo htmlspecialchars($receita['nome']); ?></a></li>
            <?php endforeach; ?>
        <?php else: ?>
            <li>Nenhuma receita associada a este livro.</li>
        <?php endif; ?>
    </ul>

    <?php if (!empty($receitas)): ?>
        <button class="visualizar-btn" onclick="openModal()">Visualizar Receitas</button>
    <?php endif; ?>
</div>

<div id="recipeModal" class="modal">
    <div class="modal-content">
        <span class="close-modal" onclick="closeModal()">&times;</span>
        <div id="recipeContent"></div>
        <div class="nav-buttons">
            <button class="nav-button" id="prevButton" onclick="prevRecipe()">Anterior</button>
            <button class="nav-button" id="nextButton" onclick="nextRecipe()">Próxima</button>
            <button class="nav-button" onclick="closeModal()">Voltar</button>
        </div>
    </div>
</div>

<script>
    let recipes = <?php echo json_encode($receitas, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?>;
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
        document.getElementById("prevButton").disabled = index === 0;
        document.getElementById("nextButton").disabled = index === recipes.length - 1;
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
