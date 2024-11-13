<?php
// Conexão com o banco de dados
$conn = new mysqli("localhost", "root", "", "AcervoReceitas");

// Checa conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Verifica se o ID do livro foi passado na URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID do livro inválido ou não fornecido.");
}

$id_livro = intval($_GET['id']);

// Pega as informações do livro do banco
$sql = "SELECT titulo, isbn, descricao, imagem FROM livros WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_livro);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Livro não encontrado.");
}

$livro = $result->fetch_assoc();
$stmt->close();

// Pega as receitas associadas ao livro
$sql_receitas = "SELECT r.id, r.nome, r.ingredientes, r.modo_preparo FROM receitas r
                 JOIN livros_receitas lr ON r.id = lr.receita_id
                 WHERE lr.livro_id = ?";
$stmt_receitas = $conn->prepare($sql_receitas);
$stmt_receitas->bind_param("i", $id_livro);
$stmt_receitas->execute();
$receitas_result = $stmt_receitas->get_result();

$receitas = [];
while ($row = $receitas_result->fetch_assoc()) {
    $receitas[] = $row;
}
$stmt_receitas->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($livro['titulo']); ?> - Detalhes do Livro</title>
    <link rel="stylesheet" href="../css/navbar.css" class="css">
    <style>
        /* Estilos principais */
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
            color: #232f3e;
            margin-bottom: 10px;
            text-align: center;
        }
        .book-img {
            width: 100%;
            max-height: 300px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .description, .isbn, .recipe-count, .section-title, .recipes-list, .visualizar-btn {
            margin-bottom: 20px;
        }
        .isbn, .recipe-count {
            color: #555;
        }
        .recipes-list {
            list-style-type: none;
            padding: 0;
        }
        .recipes-list li {
            margin-bottom: 8px;
        }
        .recipes-list li a {
            color: #ff9900;
            text-decoration: none;
            font-weight: bold;
        }
        .recipes-list li a:hover {
            color: #232f3e;
        }
        /* Botão Visualizar */
        .visualizar-btn {
            background-color: #232f3e;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
        }
        .visualizar-btn:hover {
            background-color: #ff9900;
        }
        /* Estilos do Modal */
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
        }
        .modal-content {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            width: 80%;
            max-width: 700px;
            text-align: center;
        }
        .close-modal {
            color: #aaa;
            font-size: 24px;
            cursor: pointer;
            float: right;
        }
        .nav-buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }
        .nav-button {
            padding: 10px 15px;
            background-color: #232f3e;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .nav-button:hover {
            background-color: #ff9900;
        }
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

    <!-- Botão Visualizar -->
    <button class="visualizar-btn" onclick="openModal()">Visualizar Receitas</button>
</div>

<!-- Modal para visualização das receitas -->
<div id="recipeModal" class="modal">
    <div class="modal-content">
        <span class="close-modal" onclick="closeModal()">&times;</span>
        <div id="recipeContent">
            <!-- Conteúdo da receita atual será carregado aqui -->
        </div>
        <div class="nav-buttons">
            <button class="nav-button" onclick="prevRecipe()">Anterior</button>
            <button class="nav-button" onclick="nextRecipe()">Próxima</button>
        </div>
    </div>
</div>

<script>
    // Variáveis para controle da navegação
    let recipes = <?php echo json_encode($receitas); ?>;
    let currentRecipeIndex = 0;

    // Função para abrir o modal e exibir a primeira receita
    function openModal() {
        document.getElementById("recipeModal").style.display = "flex";
        showRecipe(currentRecipeIndex);
    }

    // Função para fechar o modal
    function closeModal() {
        document.getElementById("recipeModal").style.display = "none";
    }

    // Função para exibir uma receita específica
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

    // Funções de navegação
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
