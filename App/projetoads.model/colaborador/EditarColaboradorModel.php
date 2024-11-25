<?php
class ColaboradorModel {
    private $conn;

    public function __construct($host, $user, $password, $database) {
        $this->conn = new mysqli($host, $user, $password, $database);
        if ($this->conn->connect_error) {
            die("Falha na conexão: " . $this->conn->connect_error);
        }
    }

    public function getColaboradorById($id) {
        $sql = "SELECT * FROM Colaboradores WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function atualizarColaborador($dados) {
        $sql = "UPDATE Colaboradores SET nome = ?, nome_fantasia = ?, funcao = ?, rg = ?, data_ingresso = ?, salario = ?, referencias = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param(
            'sssssssi',
            $dados['nome'],
            $dados['nome_fantasia'],
            $dados['funcao'],
            $dados['rg'],
            $dados['data_ingresso'],
            $dados['salario'],
            $dados['referencias'],
            $dados['id']
        );
        return $stmt->execute();
    }
}
