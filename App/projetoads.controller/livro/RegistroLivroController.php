<?php
require_once '../../projetoads.model/livro/RegistroLivroModel.php';

class LivroController {
    private $model;

    public function __construct() {
        $this->model = new LivroModel("localhost", "root", "", "AcervoReceitas");
    }

    public function registrarLivro($titulo, $isbn, $descricao, $imagemBlob, $receitasSelecionadas) {
        $livroId = $this->model->cadastrarLivro($titulo, $isbn, $descricao, $imagemBlob);
        if (!empty($receitasSelecionadas)) {
            $this->model->vincularReceitas($livroId, $receitasSelecionadas);
        }
        header("Location: ../../home/index.php");
        exit();
    }

    public function getReceitas() {
        return $this->model->listarReceitas();
    }
}

// Instância do controller
$controller = new LivroController();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $_POST['titulo'];
    $isbn = !empty($_POST['isbn']) ? $_POST['isbn'] : null;
    $descricao = $_POST['descricao'] ?? '';
    $receitasSelecionadas = $_POST['receitas'] ?? [];
    $imagemBlob = null;

    if ($isbn && !preg_match("/^\d{13}$/", $isbn)) {
        die("ISBN inválido. Deve ter 13 dígitos.");
    }

    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == UPLOAD_ERR_OK) {
        $imagemBlob = file_get_contents($_FILES['imagem']['tmp_name']);
    }

    $controller->registrarLivro($titulo, $isbn, $descricao, $imagemBlob, $receitasSelecionadas);
}

// Receitas para exibir na View
$receitas = $controller->getReceitas();
