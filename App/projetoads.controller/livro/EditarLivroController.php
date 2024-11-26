<?php
require_once '../../projetoads.model/livro/EditarLivroModel.php';

class LivroController {
    private $model;

    public function __construct() {
        $this->model = new LivroModel("localhost", "root", "", "AcervoReceitas");
    }

    public function editarLivro($livroId, $titulo, $isbn, $imagemBlob, $receitasSelecionadas) {
        $this->model->atualizarLivro($livroId, $titulo, $isbn, $imagemBlob);
        $this->model->atualizarReceitasLivro($livroId, $receitasSelecionadas);
        header("Location: ../../projetoads.view/livro/GerenciarLivroView.php");
        exit();
    }

    public function getLivro($livroId) {
        return $this->model->getLivroById($livroId);
    }

    public function getReceitasLivro($livroId) {
        return $this->model->getReceitasByLivroId($livroId);
    }

    public function getReceitas() {
        return $this->model->getReceitas();
    }
}

// Instância do controller
$controller = new LivroController();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $livroId = $_GET['id'];
    $titulo = $_POST['titulo'];
    $isbn = !empty($_POST['isbn']) ? $_POST['isbn'] : null;
    $receitasSelecionadas = $_POST['receitas'] ?? [];
    $imagemBlob = null;

    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == UPLOAD_ERR_OK) {
        $imagemBlob = file_get_contents($_FILES['imagem']['tmp_name']);
    }

    $controller->editarLivro($livroId, $titulo, $isbn, $imagemBlob, $receitasSelecionadas);
}

// Dados para a View
if (isset($_GET['id'])) {
    $livroId = $_GET['id'];
    $livro = $controller->getLivro($livroId);
    $receitasSelecionadas = $controller->getReceitasLivro($livroId);
    $receitas = $controller->getReceitas();
}
