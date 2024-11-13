<?php
// Conexão com o banco de dados
$conn = new mysqli("localhost", "root", "", "AcervoReceitas");

// Checa conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Verifica se o ID da receita foi passado na URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID de receita inválido ou não fornecido.");
}

$id_receita = intval($_GET['id']);

// Pega as informações da receita do banco
$sql = "SELECT nome, categoria, opiniao_degustador, ingredientes, modo_preparo, descricao, numero_porcoes, nome_cozinheiro, nome_degustador, imagem_receita 
        FROM receitas WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_receita);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Receita não encontrada.");
}

$receita = $result->fetch_assoc();
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($receita['nome']); ?> - Detalhe da Receita</title>
    <link rel="stylesheet" href="../css/navbar.css" class="css">
    <style>
        body {
            background-color: #f3f3f3;
            color: #232f3e;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        .recipe-container {
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
        .recipe-img {
            width: 100%;
            max-height: 300px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .description {
            font-size: 1.1em;
            line-height: 1.6;
            color: #333;
            margin-bottom: 20px;
            text-align: justify;
        }
        .author {
            font-style: italic;
            color: #555;
            text-align: right;
            margin-bottom: 30px;
        }
        .section-title {
            font-size: 1.4em;
            color: #232f3e;
            margin: 20px 0 10px;
            border-bottom: 2px solid #ff9900;
            padding-bottom: 5px;
        }
        .ingredients, .instructions, .portions {
            background-color: #f7f7f7;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            color: #555;
        }
        .review {
            font-style: italic;
            color: #555;
            margin-top: 30px;
            line-height: 1.6;
        }
        .reviewer {
            color: #333;
            font-weight: bold;
            margin-top: 10px;
            text-align: right;
        }
    </style>
</head>
<body>

<!-- Inclui a barra de navegação -->
<?php include 'navbar.php'; ?>

<div class="recipe-container">
    <h1><?php echo htmlspecialchars($receita['nome']); ?></h1>

    <?php if ($receita['imagem_receita']): ?>
        <img src="data:image/jpeg;base64,<?php echo base64_encode($receita['imagem_receita']); ?>" alt="<?php echo htmlspecialchars($receita['nome']); ?>" class="recipe-img">
    <?php else: ?>
        <div class="no-image">Sem imagem disponível</div>
    <?php endif; ?>

    <div class="description">
        <?php echo nl2br(htmlspecialchars($receita['descricao'])); ?>
    </div>
    <div class="author">Por <?php echo htmlspecialchars($receita['nome_cozinheiro']); ?></div>

    <div class="section-title">Ingredientes</div>
    <div class="ingredients">
        <?php echo nl2br(htmlspecialchars($receita['ingredientes'])); ?>
    </div>

    <div class="section-title">Modo de Preparo</div>
    <div class="instructions">
        <?php echo nl2br(htmlspecialchars($receita['modo_preparo'])); ?>
    </div>

    <div class="section-title">Número de Porções</div>
    <div class="portions">
        Serve <?php echo htmlspecialchars($receita['numero_porcoes']); ?> porções
    </div>

    <div class="section-title">Opinião do Degustador</div>
    <div class="review">
        <?php echo nl2br(htmlspecialchars($receita['opiniao_degustador'])); ?>
    </div>
    <div class="reviewer">Por <?php echo htmlspecialchars($receita['nome_degustador']); ?></div>
</div>

</body>
</html>
