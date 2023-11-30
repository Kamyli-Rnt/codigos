<?php
session_start();
include_once('conexao.php');

$pdo = conectar();

$id = $_GET['id'];

$sql = "SELECT * FROM tb_clientes WHERE id_clie = :id";

$stmc = $pdo->prepare($sql);
$stmc->bindParam(':id', $id);
$stmc->execute();

$re = $stmc->fetch(PDO::FETCH_OBJ);

/*
COMO USAR:
FETCH_ASSOC = $re['idcategoria']
FETCH_OBJ = $re->idcategoria
*/
?><!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Alteração de Cliente</title>
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
    <h2>Alteração de cliente</h2>
    <form method="POST">
        <div class="form-group">
            <label>Nome</label>
            <input type="text" name="nome_clie" class="form-control" value="<?php echo $re->nome_clie ?>">
        </div>

        <div class="form-group">
            <label>Data de nascimento</label>
            <input type="date" name="data_nasc_clie" class="form-control" value="<?php echo $re->data_nasc_clie ?>">
        </div>

        <div class="form-group">
            <label>Cadastro</label>
            <input type="text" name="tipo_cadastro" class="form-control" value="<?php echo $re->tipo_cadastro ?>">
        </div>

        <div class="form-group">
            <label>Telefone</label>
            <input type="text" name="telefone_clie" class="form-control" value="<?php echo $re->telefone_clie ?>">
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="text" name="email" class="form-control" value="<?php echo $re->email ?>">
        </div>

        <div class="form-group">
            <label>Senha</label>
            <input type="text" name="senha" class="form-control" value="<?php echo $re->senha ?>">
        </div>

        <div class="form-group">
            <label>CPF</label>
            <input type="text" name="cpf_clie" class="form-control" value="<?php echo $re->cpf_clie ?>">
        </div>

        <button type="submit" class="btn btn-success" name="btnAlterar">Alterar</button>
    </form>
</body>

</html>

<?php
// teste se botão foi pressionado
if (isset($_POST['btnAlterar'])) {

    //pego o valor do input (alterado ou não)
    $nome_clie = $_POST['nome_clie'];
    $data_nasc_clie = $_POST['data_nasc_clie'];
    $tipo_cadastro = $_POST['tipo_cadastro'];
    $telefone_clie = $_POST['telefone_clie'];
    $email = $_POST['email'];
    $senha = md5($_POST['senha']);
    $cpf_clie = $_POST['cpf_clie'];


    //verifico se tem conteudo
    if (empty($nome_clie) && empty($data_nasc_clie) && empty($tipo_cadastro) && empty($telefone_clie) && empty($email) && empty($senha) && empty($cpf_clie)) {
        echo "Necessário informar os dados";
        exit(); 
    }

    //crio o sql de alteraçãob
    $sqlup = "UPDATE tb_clientes SET nome_clie = :nome_clie, data_nasc_clie = :data_nasc_clie, tipo_cadastro = :tipo_cadastro, telefone_clie = :telefone_clie, email = :email, senha = :senha, cpf_clie = :cpf_clie
             WHERE id_clie = :id";

    //preparo do sql
    $stmup = $pdo->prepare($sqlup);

    $stmup->bindParam(':nome_clie', $nome_clie);
    $stmup->bindParam(':data_nasc_clie', $data_nasc_clie);
    $stmup->bindParam(':tipo_cadastro', $tipo_cadastro);
    $stmup->bindParam(':telefone_clie', $telefone_clie);
    $stmup->bindParam(':email', $email);
    $stmup->bindParam(':senha', $senha);
    $stmup->bindParam(':cpf_clie', $cpf_clie);
    $stmup->bindParam(':id', $id);

    if($stmup->execute()){
        echo "Alterado com sucesso!";
        header("Location: listagemclie.php");
    } else {
        echo "Erro ao alterar!";
    }
}
