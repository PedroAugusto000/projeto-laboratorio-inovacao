<?php
class LivroModel {
    private $conn;

    public function __construct($host, $user, $password, $database) {
        $this->conn = new mysqli($host, $user, $password, $database);
        if ($this->conn->connect_error) {
            die("Falha na conexão: " . $this->conn->connect_error);
        }
    }

    public function getTodosLivros() {
        $sql = "SELECT id, titulo, imagem FROM livros ORDER BY id DESC";
        return $this->conn->query($sql);
    }
}
