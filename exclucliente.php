<?php
include_once('conexao.php');

$pdo = conectar();

$id = $_GET['id'];

$sqlc = "SELECT * FROM tb_clientes WHERE id_clie = :id";
$stmc = $pdo->prepare($sqlc);
$stmc->bindParam(':id', $id);

$stmc->execute();

if ($stmc->rowCount() > 0) {
    $sqlex = "DELETE FROM tb_clientes WHERE id_clie = $id";
    $stmex = $pdo->query($sqlex);
    echo "Serviço excluído com sucesso!";
} else {
    echo "serviço não encontrado!";
}

header('Location: listagemclie.php');