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
        $result = $this->conn->query($sql);

        if (!$result) {
            die("Erro na consulta: " . $this->conn->error);
        }

        return $result;
    }

    public function deletarReceita($id) {
        $stmt = $this->conn->prepare("DELETE FROM receitas WHERE id = ?");
        if (!$stmt) {
            die("Erro ao preparar a consulta: " . $this->conn->error);
        }

        $stmt->bind_param("i", $id);
        $executado = $stmt->execute();

        if (!$executado) {
            error_log("Erro ao deletar receita: " . $stmt->error);
        }

        $stmt->close();
        return $executado;
    }
}
