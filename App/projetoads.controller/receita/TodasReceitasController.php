<?php
require_once 'ReceitaModel.php';

class ReceitaController {
    private $model;

    public function __construct() {
        $this->model = new ReceitaModel("localhost", "root", "", "AcervoReceitas");
    }

    public function listarReceitas() {
        return $this->model->getTodasReceitas();
    }
}

// Instância do controller
$controller = new ReceitaController();
$receitas = $controller->listarReceitas();
