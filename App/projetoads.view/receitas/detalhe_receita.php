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
        .description, .ingredients, .instructions, .portions, .review {
            margin-bottom: 20px;
        }
        .section-title {
            font-size: 1.4em;
            color: #232f3e;
            margin: 20px 0 10px;
            border-bottom: 2px solid #ff9900;
            padding-bottom: 5px;
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
