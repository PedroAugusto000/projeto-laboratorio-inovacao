<?php
class ReceitaModel {
    private $conn;

    public function __construct($host, $user, $password, $database) {
        $this->conn = new mysqli($host, $user, $password, $database);
        if ($this->conn->connect_error) {
            die("Falha na conexão: " . $this->conn->connect_error);
        }
    }

    public function getReceitaById($id) {
        $sql = "SELECT nome, categoria, opiniao_degustador, ingredientes, modo_preparo, descricao, numero_porcoes, nome_cozinheiro, nome_degustador, imagem_receita 
                FROM receitas WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            error_log("Erro ao preparar consulta: " . $this->conn->error);
            return null;
        }

        $stmt->bind_param("i", $id);
        if (!$stmt->execute()) {
            error_log("Erro ao executar consulta: " . $stmt->error);
            return null;
        }

        $result = $stmt->get_result();
        $receita = $result->fetch_assoc();
        $stmt->close();
        return $receita;
    }
}
