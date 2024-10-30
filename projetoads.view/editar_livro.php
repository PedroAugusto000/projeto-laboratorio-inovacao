<?php
// Conexão com o banco de dados
$conn = new mysqli("localhost", "root", "", "AcervoReceitas");

// Checa conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Verificar se o ID do livro foi passado
if (isset($_GET['id'])) {
    $livroId = $_GET['id'];

    // Selecionar os dados do livro
    $stmt = $conn->prepare("SELECT titulo, isbn, imagem FROM livros WHERE id = ?");
    $stmt->bind_param("i", $livroId);
    $stmt->execute();
    $result = $stmt->get_result();
    $livro = $result->fetch_assoc();
    $stmt->close();

    // Selecionar as receitas associadas ao livro
    $receitasSelecionadas = [];
    $resultReceitas = $conn->query("SELECT receita_id FROM livros_receitas WHERE livro_id = $livroId");
    while ($row = $resultReceitas->fetch_assoc()) {
        $receitasSelecionadas[] = $row['receita_id'];
    }

    // Selecionar todas as receitas para exibir na lista com checkbox
    $result = $conn->query("SELECT id, nome FROM receitas");
}

// Atualizar os dados do livro no banco de dados
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $_POST['titulo'];
    $isbn = !empty($_POST['isbn']) ? $_POST['isbn'] : null;
    $receitasSelecionadas = $_POST['receitas'];
    $imagemBlob = null;

    // Verificar se um novo arquivo de imagem foi enviado
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == UPLOAD_ERR_OK) {
        $imagemBlob = file_get_contents($_FILES['imagem']['tmp_name']);
    }

    // Atualizar o livro na tabela 'livros'
    if ($imagemBlob) {
        $stmt = $conn->prepare("UPDATE livros SET titulo = ?, isbn = ?, imagem = ? WHERE id = ?");
        $stmt->bind_param("ssbi", $titulo, $isbn, $imagemBlob, $livroId);
        $stmt->send_long_data(2, $imagemBlob); // Envia o BLOB da imagem corretamente
    } else {
        $stmt = $conn->prepare("UPDATE livros SET titulo = ?, isbn = ? WHERE id = ?");
        $stmt->bind_param("ssi", $titulo, $isbn, $livroId);
    }
    $stmt->execute();
    $stmt->close();

    // Atualizar a tabela de relacionamento 'livros_receitas'
    $conn->query("DELETE FROM livros_receitas WHERE livro_id = $livroId");
    if (!empty($receitasSelecionadas)) {
        $stmt = $conn->prepare("INSERT INTO livros_receitas (livro_id, receita_id) VALUES (?, ?)");
        foreach ($receitasSelecionadas as $receitaId) {
            $stmt->bind_param("ii", $livroId, $receitaId);
            $stmt->execute();
        }
        $stmt->close();
    }

    // Redirecionar de volta para a página de gerenciamento de livros
    header("Location: gerir_livros.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Livro</title>
    <link rel="stylesheet" href="../css/stylesLivros.css">
</head>
<body>

<header>
    <nav>
        <a href="#">Logo</a>
        <a href="gerir_livros.php">Livros</a>
        <a href="gerenciar_receitas.php">Receitas</a>
        <a href="#">Funcionários</a>
    </nav>
    <div class="user-area">
        <span>Usuário</span>
        <a href="../index.php" class="logout">Sair</a>
    </div>
</header>

<main>
    <h1>Editar Livro</h1>
    
    <!-- Formulário de edição do livro -->
    <form action="editar_livro.php?id=<?php echo $livroId; ?>" method="post" enctype="multipart/form-data">
        <label for="titulo">Título do Livro:</label>
        <input type="text" id="titulo" name="titulo" value="<?php echo htmlspecialchars($livro['titulo']); ?>" required><br><br>

        <label for="isbn">ISBN (opcional):</label>
        <input type="text" id="isbn" name="isbn" value="<?php echo htmlspecialchars($livro['isbn']); ?>"><br><br>

        <label for="imagem">Imagem do Livro:</label>
        <input type="file" id="imagem" name="imagem" accept="image/*"><br><br>
        <?php if ($livro['imagem']): ?>
            <p>Imagem atual:</p>
            <img src="data:image/jpeg;base64,<?php echo base64_encode($livro['imagem']); ?>" alt="Imagem do Livro" width="100px" height="150px">
        <?php endif; ?>
        <br><br>

        <!-- Lista de receitas com checkbox -->
        <table>
            <thead>
                <tr>
                    <th></th>
                    <th>Receita</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td>
                            <input type="checkbox" name="receitas[]" value="<?php echo $row['id']; ?>" <?php echo in_array($row['id'], $receitasSelecionadas) ? 'checked' : ''; ?>>
                        </td>
                        <td><?php echo htmlspecialchars($row["nome"]); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <!-- Botão para salvar as alterações -->
        <button type="submit" class="register-btn">Salvar Alterações</button>
    </form>

</main>

</body>
</html>
