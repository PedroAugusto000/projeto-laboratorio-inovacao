<?php
require_once '../../projetoads.controller/receita/EditarReceitaController.php';
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Receita</title>
    <link rel="stylesheet" href="../../../public/css/stylesRegistroEditar.css">
</head>
<body>

<header>
    <nav>
        <a href="../../home/index.php">EDIÇÃO</a>
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
    <div class="container">
        <h1>Editar Receita</h1>
        <div class="form-section">
            <form action="../../projetoads.controller/receita/EditarReceitaController.php?id=<?php echo htmlspecialchars($id); ?>" 
                  method="POST" enctype="multipart/form-data">

                <label for="nome">Nome</label>
                <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($receita['nome'] ?? ''); ?>" required>

                <label for="categoria">Categoria</label>
                <select id="categoria" name="categoria" required>
                    <option value="">Selecione uma categoria</option>
                    <?php while ($row = $categorias->fetch_assoc()): ?>
                        <option value="<?php echo $row['id']; ?>" 
                                <?php echo ($row['id'] == $receita['categoria']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($row['nome_categoria']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>

                <label for="opiniao_degustador">Opinião Degustador</label>
                <textarea id="opiniao_degustador" name="opiniao_degustador"><?php echo htmlspecialchars($receita['opiniao_degustador'] ?? ''); ?></textarea>

                <label for="ingredientes">Ingredientes</label>
                <textarea id="ingredientes" name="ingredientes"><?php echo htmlspecialchars($receita['ingredientes'] ?? ''); ?></textarea>

                <label for="modo_preparo">Modo de preparo</label>
                <textarea id="modo_preparo" name="modo_preparo"><?php echo htmlspecialchars($receita['modo_preparo'] ?? ''); ?></textarea>

                <label for="descricao">Descrição</label>
                <textarea id="descricao" name="descricao"><?php echo htmlspecialchars($receita['descricao'] ?? ''); ?></textarea>

                <label for="numero_porcoes">Número de porções</label>
                <input type="text" id="numero_porcoes" name="numero_porcoes" value="<?php echo htmlspecialchars($receita['numero_porcoes'] ?? ''); ?>">

                <label for="nome_cozinheiro">Cozinheiro</label>
                <input type="text" id="nome_cozinheiro" name="nome_cozinheiro" value="<?php echo htmlspecialchars($receita['nome_cozinheiro'] ?? ''); ?>">

                <label for="nome_degustador">Degustador</label>
                <input type="text" id="nome_degustador" name="nome_degustador" value="<?php echo htmlspecialchars($receita['nome_degustador'] ?? ''); ?>">

                <label for="imagem_receita">Anexar imagem da receita</label>
                <input type="file" id="imagem_receita" name="imagem_receita" accept="image/*">
                <?php if (!empty($receita['imagem_receita'])): ?>
                    <p>Imagem atual:</p>
                    <img src="data:image/jpeg;base64,<?php echo base64_encode($receita['imagem_receita']); ?>" 
                         alt="Imagem da receita" width="150px">
                <?php endif; ?>

                <button type="submit" class="register-btn">Atualizar receita</button>
                <br><a href="GerenciarReceitaView.php">Voltar</a>
            </form>
        </div>
    </div>
</main>

</body>
</html>
