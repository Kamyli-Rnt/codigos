<?php
include_once('conexao.php');

$pdo = conectar();

$id = $_GET['id'];

$sqlc = "SELECT * FROM tb_funcionarios WHERE id_func = :id";
$stmc = $pdo->prepare($sqlc);
$stmc->bindParam(':id', $id);

$stmc->execute();

if ($stmc->rowCount() > 0) {
    $sqlex = "DELETE FROM tb_funcionarios WHERE id_func = $id";
    $stmex = $pdo->query($sqlex);
    echo "Serviço excluído com sucesso!";
} else {
    echo "serviço não encontrado!";
}

header('Location: lisfunc.php');