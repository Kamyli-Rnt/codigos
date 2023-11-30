<?php
session_start();
include_once('conexao.php');

$pdo = conectar();
$id = $_GET['id'];
$sql = "SELECT * FROM tb_servicos WHERE id_serv = :id";
$stmc = $pdo->prepare($sql);
$stmc->bindParam(':id', $id);
$stmc->execute();
$re = $stmc->fetch(PDO::FETCH_OBJ);

$img_servico_directory = 'IMG/';
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Alteração de Categorias</title>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <style>
 body {
            background-color: #efc6dead;
            padding: 20px;
            font-family: 'Josefin Sans', sans-serif;
        }

        h2 {
            color: purple;
            text-align: center;
        }

        form {
            background-color: aliceblue;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 40%;
            margin-left: 30%;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            color: #6c757d;
        }

        button {
            background-color: #6f42c1;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #5a249e;
        }
    </style>
    <script src="js/bootstrap.js"></script>
    <script src="js/jquery.js"></script>
</head>

<body>
    <h2>Alteração de Serviços</h2>
    <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <input type="hidden" name="id_serv" value="<?php echo $re->id_serv ?>">
            <label>Serviço Ativo</label>
            <input type="text" name="ser_ativo" class="form-control" value="<?php echo $re->ser_ativo ?>">
        </div>

        <div class="form-group">
            <label>Tipo de Serviço</label>
            <input type="text" name="tipo_serv" class="form-control" value="<?php echo $re->tipo_serv ?>">
        </div>

        <div class="form-group">
            <label>Duração</label>
            <input type="time" name="duracao" class="form-control" value="<?php echo $re->duracao ?>">
        </div>

        <div class="form-group">
            <label>Descrição</label>
            <input type="text" name="descricao" class="form-control" value="<?php echo $re->descricao ?>">
        </div>

        <div class="form-group">
            <label>Valor</label>
            <input type="number" name="valor" class="form-control" value="<?php echo $re->valor ?>">
        </div>

        <div class="form-group">
            <label>Imagem Atual</label><br>
            <img src="<?php echo $re->img_servico; ?>" style="max-width: 200px;" /><br><br>
            <label>Atualizar Imagem</label>
            <input type="file" name="imagem">
        </div>

        <button type="submit" class="btn btn-success" name="btnAlterar">Alterar</button>
    </form>
</body>

</html>


<?php

if (isset($_POST['btnAlterar'])) {
    $ser_ativo = $_POST['ser_ativo'];
    $tipo_serv = $_POST['tipo_serv'];
    $duracao = $_POST['duracao'];
    $descricao = $_POST['descricao'];
    $valor = $_POST['valor'];
    $id = $_POST['id_serv'];

    if (empty($ser_ativo) || empty($tipo_serv) || empty($duracao) || empty($descricao) || empty($valor)) {
        echo "Necessário informar todos os dados";
        exit();
    }

    // Check if a new image is being uploaded
    if (!empty($_FILES['imagem']['name'])) {
        $uploadedFile = $_FILES['imagem']['tmp_name'];
        $nome_imagem = basename($_FILES['imagem']['name']);
        $img_servico = $img_servico_directory . $nome_imagem;

        // Move the uploaded file to the target directory
        if (move_uploaded_file($uploadedFile, $img_servico)) {
            $sqlup = "UPDATE tb_servicos SET ser_ativo = :ser_ativo, tipo_serv = :tipo_serv, duracao = :duracao, descricao = :descricao, valor = :valor, img_servico = :img_servico
                     WHERE id_serv = :id";
            $stmup = $pdo->prepare($sqlup);

            $stmup->bindParam(':ser_ativo', $ser_ativo);
            $stmup->bindParam(':tipo_serv', $tipo_serv);
            $stmup->bindParam(':duracao', $duracao);
            $stmup->bindParam(':descricao', $descricao);
            $stmup->bindParam(':valor', $valor);
            $stmup->bindParam(':img_servico', $img_servico);
            $stmup->bindParam(':id', $id);

            if ($stmup->execute()) {
                echo "Alterado com sucesso!";
                header("Location: categoriaserv.php");
            } else {
                echo "Erro ao alterar!";
            }
        } else {
            echo "Falha ao fazer upload do arquivo";
        }
    } else {
        // No new image uploaded, update other fields
        $sqlup = "UPDATE tb_servicos SET ser_ativo = :ser_ativo, tipo_serv = :tipo_serv, duracao = :duracao, descricao = :descricao, valor = :valor
                 WHERE id_serv = :id";
        $stmup = $pdo->prepare($sqlup);

        $stmup->bindParam(':ser_ativo', $ser_ativo);
        $stmup->bindParam(':tipo_serv', $tipo_serv);
        $stmup->bindParam(':duracao', $duracao);
        $stmup->bindParam(':descricao', $descricao);
        $stmup->bindParam(':valor', $valor);
        $stmup->bindParam(':id', $id);

        if ($stmup->execute()) {
            echo "Alterado com sucesso!";
            header("Location: categoriaserv.php");
        } else {
            echo "Erro ao alterar!";
        }
    }
}
?>
