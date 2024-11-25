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
        $sql = "SELECT receitas.id, receitas.nome, categorias.nome_categoria AS categoria 
                FROM receitas 
                LEFT JOIN categorias ON receitas.categoria = categorias.id";
        return $this->conn->query($sql);
    }

    public function deletarReceita($id) {
        $stmt = $this->conn->prepare("DELETE FROM receitas WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
