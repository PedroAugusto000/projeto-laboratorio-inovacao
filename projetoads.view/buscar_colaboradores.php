<?php
$conn = new mysqli("localhost", "root", "", "AcervoReceitas");

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

$query = $_GET['query'];
$sql = "SELECT nome FROM Colaboradores WHERE nome LIKE ?";
$stmt = $conn->prepare($sql);
$search = "%$query%";
$stmt->bind_param("s", $search);
$stmt->execute();
$result = $stmt->get_result();

$colaboradores = [];
while ($row = $result->fetch_assoc()) {
    $colaboradores[] = $row;
}

echo json_encode($colaboradores);

$stmt->close();
$conn->close();
?>
