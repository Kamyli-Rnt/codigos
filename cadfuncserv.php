<?php
include_once 'conexao.php';
$pdo = conectar();
session_start();

if (!isset($_SESSION['nome_func'])) {
    header("Location: login.php");
    exit;
}

if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit;
}

$sqlFuncionarios = "SELECT * FROM tb_funcionarios";
$stmtFuncionarios = $pdo->prepare($sqlFuncionarios);
$stmtFuncionarios->execute();
$dadosFuncionarios = $stmtFuncionarios->fetchAll(PDO::FETCH_ASSOC);

$sqlServicos = "SELECT * FROM tb_servicos";
$stmtServicos = $pdo->prepare($sqlServicos);
$stmtServicos->execute();
$dadosServicos = $stmtServicos->fetchAll(PDO::FETCH_ASSOC);

function cadastrarServFunc($pdo)
{
    $message = '';

    if (isset($_POST['btnsalvar'])) {
        $fk_id_func = $_POST['fk_id_func'];
        $fk_id_serv = $_POST['fk_id_serv'];

        try {
            $stmt = $pdo->prepare("INSERT INTO tb_func_servs (fk_id_func, fk_id_serv) VALUES (:fk_id_func, :fk_id_serv)");
            $stmt->bindParam(':fk_id_func', $fk_id_func);
            $stmt->bindParam(':fk_id_serv', $fk_id_serv);
            
            if ($stmt->execute()) {
                $message = 'Cadastro realizado com sucesso!';
                header("Location: busca_func_servs.php");
                exit;
            } else {
                $message = 'Algum dos dados informados está inválido.';
            }
        } catch (Exception $e) {
            $message = 'Erro ao cadastrar: ' . $e->getMessage();
        }
    }

    return $message;
}

$message = cadastrarServFunc($pdo);
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/funcservicos.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Josefin+Sans&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Josefin Sans', sans-serif;
            background-color: #be92beb6;
        }

        nav {
            background-color: #e290b5;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            font-size: 15px;
            font-family: 'Josefin Sans', sans-serif;
        }

        nav .logo img {
            max-height: 79px;
        }

        nav .links ul {
            list-style: none;
            display: flex;
            font-family: 'Josefin Sans', sans-serif;
        }

        nav .links ul li {
            margin-right: 15px;
            font-family: 'Josefin Sans', sans-serif;
        }

        nav .links a {
            text-decoration: none;
            color: #fff;
            font-weight: bold;
            font-size: 18px;
            transition: background-color 0.4s, transform 0.4s;
            font-family: 'Josefin Sans', sans-serif;
        }

        .nav-links a:hover{
            background-color: purple;
            transform: scale(1.1);
        }

        nav h3 {
            margin: 0;
            color: #fff;
        }

        nav a[ion-icon] {
            font-size: 24px;
            color: #fff;
            text-decoration: none;
        }

.container {
    max-width: 600px;
    margin: 50px auto;
    background-color: snow;
    padding: 25px;
    border-radius: 35px;
    box-shadow: 0 0 10px rgb(175 124 181);
    font-family: 'Josefin Sans', sans-serif;
}
        form {
            display: flex;
            flex-direction: column;
            font-family: 'Josefin Sans', sans-serif;
        }

        .textfield,
        .buttons {
            margin-bottom: 20px;
            font-family: 'Josefin Sans', sans-serif;
        }

        label {
            font-weight: bold;
            margin-bottom: 5px;
            font-family: 'Josefin Sans', sans-serif;
        }

        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-family: 'Josefin Sans', sans-serif;
        }

        .btn-1,
        .btn-2 {
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            transition: background-color 0.3s ease;
            font-family: 'Josefin Sans', sans-serif;

        }

        .btn-1 {
            background-color: #ff66b2;
            color: #fff;
            transition: background-color 0.4s, transform 0.4s;
            font-family: 'Josefin Sans', sans-serif;
        }

        .btn-2 {
            background-color: #ff66b2;
            color: white;
            margin-left: 10px;
            transition: background-color 0.4s, transform 0.4s;
            font-family: 'Josefin Sans', sans-serif;
        }

        .btn-1:hover,
        .btn-2:hover {
            background-color: pink;
            transform: scale(1.1);
            font-family: 'Josefin Sans', sans-serif;
        }
    </style>
    <title>Toda Bella</title>
    <link rel="icon" type="image/png" href="IMG/logoguia.png" />
</head>

<body>
    <nav>
        <div class="logo"><a href="admpage.php"><img class="logo1" src="IMG/logo.jpeg" alt=""></a></div>
        <div class="links">
            <ul class="nav-itens">
                <li><a href="listagemclie.php">Clientes</a></li>&nbsp; &nbsp; &nbsp;
                <li><a href="incfunc.php">Cadastro funcionários</a></li>&nbsp; &nbsp; &nbsp;
                <li><a href="lisfunc.php">Funcionários</a></li>&nbsp; &nbsp; &nbsp;
                <li><a href="categoriaserv.php">Serviços</a></li>&nbsp; &nbsp; &nbsp;
                <li><a href="incluservicos.php">Incluir serviços</a></li>&nbsp; &nbsp; &nbsp;
                <li><a href="cadfuncserv.php">funcserv</a></li>&nbsp; &nbsp; &nbsp;
                <li><a href="cidade.php">Cidade</a></li>&nbsp; &nbsp; &nbsp;
            </ul>
        </div>
        <div>
        <h3 style=" font-size: 17px; color: purple;">Bem-vinda, <?php echo $_SESSION['nome_func']; ?>!</h3>
            <a href="?logout=true" style="text-decoration: none; color: #fff;"><ion-icon name="exit-outline"></ion-icon></a>
        </div>
    </nav>
    <div class="container">
        <form method="POST">
            <div class="textfield">
                <label for="funcionario">Funcionário:</label>
                <select id="fk_id_func" name="fk_id_func">
                    <?php foreach ($dadosFuncionarios as $funcionario) {
                        echo "<option value='{$funcionario['id_func']}'>{$funcionario['nome_func']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="textfield">
                <label for="servicos">Serviço:</label>
                <select id="fk_id_serv" name="fk_id_serv">
                    <?php foreach ($dadosServicos as $servico) {
                        echo "<option value='{$servico['id_serv']}'>{$servico['tipo_serv']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="buttons">
                <button class="btn-1" name="btnsalvar">Cadastrar</button>
                <button class="btn-2" name="btncancelar">Cancelar</button>
            </div>
        </form>
    </div>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>

</html>
