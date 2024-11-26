<?php
class ColaboradorModel {
    private $conn;

    public function __construct($host, $user, $password, $database) {
        $this->conn = new mysqli($host, $user, $password, $database);
        if ($this->conn->connect_error) {
            die("Falha na conexão: " . $this->conn->connect_error);
        }
    }

    public function listarColaboradores() {
        $sql = "SELECT id, nome, funcao, rg, data_ingresso FROM Colaboradores";
        $result = $this->conn->query($sql);

        if (!$result) {
            die("Erro na consulta: " . $this->conn->error);
        }

        return $result;
    }

    public function getConn() {
        return $this->conn;
    }
}
?>
