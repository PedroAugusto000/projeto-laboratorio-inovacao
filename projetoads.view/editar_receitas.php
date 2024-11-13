<?php
// Conexão com o banco de dados
$conn = new mysqli("localhost", "root", "", "AcervoReceitas");

// Checa conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Pega todas as categorias disponíveis
$sqlCategorias = "SELECT id, nome_categoria FROM categorias";
$resultCategorias = $conn->query($sqlCategorias);

// Verifica se o ID da receita foi passado
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Consulta a receita pelo ID
    $sql = "SELECT * FROM receitas WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verifica se encontrou a receita
    if ($result->num_rows > 0) {
        $receita = $result->fetch_assoc();
    } else {
        echo "Receita não encontrada.";
        exit;
    }
} else {
    echo "ID da receita não fornecido.";
    exit;
}

// Atualiza a receita se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST["nome"];
    $categoria = $_POST["categoria"];
    $opiniao_degustador = $_POST["opiniao_degustador"];
    $ingredientes = $_POST["ingredientes"];
    $modo_preparo = $_POST["modo_preparo"];
    $descricao = $_POST["descricao"];
    $numero_porcoes = $_POST["numero_porcoes"];
    $nome_cozinheiro = $_POST["nome_cozinheiro"];
    $nome_degustador = $_POST["nome_degustador"];

    // Verifica se uma nova imagem foi enviada
    if (isset($_FILES["imagem_receita"]) && $_FILES["imagem_receita"]["error"] == 0) {
        $imagem_receita = file_get_contents($_FILES["imagem_receita"]["tmp_name"]);
        $sql = "UPDATE receitas SET nome=?, categoria=?, opiniao_degustador=?, ingredientes=?, modo_preparo=?, descricao=?, numero_porcoes=?, nome_cozinheiro=?, nome_degustador=?, imagem_receita=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssssssi", $nome, $categoria, $opiniao_degustador, $ingredientes, $modo_preparo, $descricao, $numero_porcoes, $nome_cozinheiro, $nome_degustador, $imagem_receita, $id);
        $stmt->send_long_data(9, $imagem_receita);
    } else {
        // Atualiza sem alterar a imagem
        $sql = "UPDATE receitas SET nome=?, categoria=?, opiniao_degustador=?, ingredientes=?, modo_preparo=?, descricao=?, numero_porcoes=?, nome_cozinheiro=?, nome_degustador=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssssssi", $nome, $categoria, $opiniao_degustador, $ingredientes, $modo_preparo, $descricao, $numero_porcoes, $nome_cozinheiro, $nome_degustador, $id);
    }

    if ($stmt->execute()) {
        echo "Receita atualizada com sucesso!";
    } else {
        echo "Erro ao atualizar a receita: " . $conn->error;
    }

    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Receita</title>
    <link rel="stylesheet" href="../css/stylesRegistroReceitas.css">
    <script>
        function autocomplete(input, url) {
            input.addEventListener("input", function() {
                fetch(url + '?query=' + input.value)
                    .then(response => response.json())
                    .then(data => {
                        const list = document.getElementById(input.id + "-list");
                        list.innerHTML = "";
                        data.forEach(item => {
                            const option = document.createElement("div");
                            option.textContent = item.nome;
                            option.addEventListener("click", () => {
                                input.value = item.nome;
                                list.innerHTML = "";
                            });
                            list.appendChild(option);
                        });
                    });
            });
        }

        document.addEventListener("DOMContentLoaded", function() {
            autocomplete(document.getElementById("nome_cozinheiro"), "buscar_colaboradores.php");
            autocomplete(document.getElementById("nome_degustador"), "buscar_colaboradores.php");
        });
    </script>
</head>
<body>

<header>
    <nav>
        <a href="#">Logo</a>
        <a href="#">Livros</a>
        <a href="gerenciar_receitas.php">Receitas</a>
        <a href="#">Funcionários</a>
    </nav>
    <div class="user-area">
        <span>Usuário</span>
        <a href="#" class="logout">Sair</a>
    </div>
</header>

<main>
    <div class="container">
        <h1>Editar Receita</h1>
        <div class="form-section">
            <form action="editar_receitas.php?id=<?php echo $id; ?>" method="POST" enctype="multipart/form-data">
                <label for="nome">Nome</label>
                <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($receita['nome']); ?>" required>

                <!-- Campo de Categoria como lista suspensa -->
                <label for="categoria">Categoria</label>
                <select id="categoria" name="categoria" required>
                    <option value="">Selecione uma categoria</option>
                    <?php while ($rowCategoria = $resultCategorias->fetch_assoc()): ?>
                        <option value="<?php echo $rowCategoria['id']; ?>" <?php echo ($rowCategoria['id'] == $receita['categoria']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($rowCategoria['nome_categoria']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>

                <label for="opiniao_degustador">Opinião Degustador</label>
                <textarea id="opiniao_degustador" name="opiniao_degustador"><?php echo htmlspecialchars($receita['opiniao_degustador']); ?></textarea>

                <label for="ingredientes">Ingredientes</label>
                <textarea id="ingredientes" name="ingredientes"><?php echo htmlspecialchars($receita['ingredientes']); ?></textarea>

                <label for="modo_preparo">Modo de preparo</label>
                <textarea id="modo_preparo" name="modo_preparo"><?php echo htmlspecialchars($receita['modo_preparo']); ?></textarea>

                <label for="descricao">Descrição</label>
                <textarea id="descricao" name="descricao"><?php echo htmlspecialchars($receita['descricao']); ?></textarea>

                <label for="numero_porcoes">Número de porções</label>
                <input type="text" id="numero_porcoes" name="numero_porcoes" value="<?php echo htmlspecialchars($receita['numero_porcoes']); ?>">

                <label for="nome_cozinheiro">Cozinheiro</label>
                <input type="text" id="nome_cozinheiro" name="nome_cozinheiro" value="<?php echo htmlspecialchars($receita['nome_cozinheiro']); ?>">
                <div id="nome_cozinheiro-list" class="autocomplete-list"></div>

                <label for="nome_degustador">Degustador</label>
                <input type="text" id="nome_degustador" name="nome_degustador" value="<?php echo htmlspecialchars($receita['nome_degustador']); ?>">
                <div id="nome_degustador-list" class="autocomplete-list"></div>

                <!-- Campo para upload da imagem -->
                <label for="imagem_receita">Anexar imagem da receita</label>
                <input type="file" id="imagem_receita" name="imagem_receita" accept="image/*">
                <?php if ($receita['imagem_receita']): ?>
                    <p>Imagem atual:</p>
                    <img src="data:image/jpeg;base64,<?php echo base64_encode($receita['imagem_receita']); ?>" alt="Imagem da receita" width="150px">
                <?php endif; ?>

                <button type="submit" class="register-btn">Atualizar receita</button>
                <br><a href="gerenciar_receitas.php">Voltar</a>
            </form>
        </div>
    </div>
</main>

</body>
</html>
