<?php
class ReceitaModel {
    private $conn;

    public function __construct($host, $user, $password, $database) {
        $this->conn = new mysqli($host, $user, $password, $database);
        if ($this->conn->connect_error) {
            die("Falha na conexão: " . $this->conn->connect_error);
        }
    }

    public function getTodasReceitas() {
        $sql = "SELECT id, nome, imagem_receita FROM receitas ORDER BY id DESC";
        return $this->conn->query($sql);
    }
}
