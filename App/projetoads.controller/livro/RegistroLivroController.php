<?php
require_once '../../projetoads.model/livro/RegistroLivroModel.php';

class LivroController {
    private $model;

    public function __construct() {
        $this->model = new LivroModel("localhost", "root", "", "AcervoReceitas");
    }

    public function registrarLivro($titulo, $isbn, $descricao, $imagemBlob, $receitasSelecionadas) {
        if (empty($titulo) || empty($isbn) || empty($descricao) || empty($imagemBlob)) {
            throw new Exception("Todos os campos são obrigatórios.");
        }

        if (count($receitasSelecionadas) < 2) {
            throw new Exception("Você deve selecionar ao menos duas receitas para criar um livro de receitas.");
        }

        try {
            $livroId = $this->model->cadastrarLivro($titulo, $isbn, $descricao, $imagemBlob);
            if (!empty($receitasSelecionadas)) {
                $this->model->vincularReceitas($livroId, $receitasSelecionadas);
            }
            header("Location: ../../home/index.php");
            exit();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function getReceitas() {
        return $this->model->listarReceitas();
    }
}

try {
    $controller = new LivroController();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $titulo = $_POST['titulo'];
        $isbn = $_POST['isbn'];
        $descricao = $_POST['descricao'];
        $receitasSelecionadas = $_POST['receitas'] ?? [];
        $imagemBlob = null;

        if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == UPLOAD_ERR_OK) {
            $imagemBlob = file_get_contents($_FILES['imagem']['tmp_name']);
        }

        $controller->registrarLivro($titulo, $isbn, $descricao, $imagemBlob, $receitasSelecionadas);
    }

    $receitas = $controller->getReceitas();
} catch (Exception $e) {
    $errorMessage = $e->getMessage();
}
