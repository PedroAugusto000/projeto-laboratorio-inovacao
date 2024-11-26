<?php
class ColaboradorModel {
    private $conn;

    public function __construct($host, $user, $password, $database) {
        $this->conn = new mysqli($host, $user, $password, $database);
        if ($this->conn->connect_error) {
            die("Falha na conexão: " . $this->conn->connect_error);
        }
    }

    public function excluirColaborador($id) {
        $sql = "DELETE FROM Colaboradores WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        
        if (!$stmt) {
            die("Erro ao preparar consulta: " . $this->conn->error);
        }

        $stmt->bind_param('i', $id);
        $executado = $stmt->execute();

        if (!$executado) {
            error_log("Erro ao excluir colaborador: " . $stmt->error);
        }

        $stmt->close();
        return $executado;
    }
}
