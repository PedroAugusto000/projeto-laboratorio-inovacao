<?php

class LivroModel {
    private $conn;

    public function __construct($host, $user, $password, $database) {
        $this->conn = new mysqli($host, $user, $password, $database);
        if ($this->conn->connect_error) {
            die("Falha na conexão: " . $this->conn->connect_error);
        }
    }

    public function buscarLivros($termoBusca = '') {
        $query = "SELECT id, isbn, titulo FROM livros";
        if (!empty($termoBusca)) {
            $query .= " WHERE titulo LIKE '%" . $this->conn->real_escape_string($termoBusca) . "%' OR isbn LIKE '%" . $this->conn->real_escape_string($termoBusca) . "%'";
        }
        return $this->conn->query($query);
    }

    public function deletarLivro($id) {
        $this->conn->query("DELETE FROM livros WHERE id = " . (int)$id);
    }
}
