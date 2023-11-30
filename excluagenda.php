<?php
include_once('conexao.php');

$pdo = conectar();

$id = $_GET['id'];

$sqlc = "SELECT * FROM tb_agendas WHERE id_agenda = :id";
$stmc = $pdo->prepare($sqlc);
$stmc->bindParam(':id', $id);

$stmc->execute();

if ($stmc->rowCount() > 0) {
    $sqlex = "DELETE FROM tb_agendas WHERE id_agenda = $id";
    $stmex = $pdo->query($sqlex);
    echo "agenda excluído com sucesso!";
} else {
    echo "agenda não encontrado!";
}

header('Location: lisagenda.php');