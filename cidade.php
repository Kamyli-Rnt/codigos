<?php
include_once 'conexao.php';
$pdo = conectar();
session_start();

$message = '';

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


if (isset($_POST['btnSalvar'])) {
    $nome = $_POST['nome'];
    $estado = 'PR';

    if ($nome !== 'Cascavel') {
        $message = 'Você só pode cadastrar a cidade "Cascavel"!';
    } else {
        try {
            $pdo = conectar();

            $stmt = $pdo->prepare("SELECT COUNT(*) FROM tb_cidades WHERE nome = :nome AND estado = :estado");
            $stmt->bindValue(':nome', 'Cascavel');
            $stmt->bindValue(':estado', $estado);
            $stmt->execute();

            if ($stmt->fetchColumn() > 0) {
                $message = 'Cidade "Cascavel" já cadastrada no sistema!';
            } else {
                $stmt = $pdo->prepare("INSERT INTO tb_cidades (nome, estado) VALUES (:nome, :estado)");
                $stmt->bindValue(':nome', 'Cascavel');
                $stmt->bindValue(':estado', $estado);
                $stmt->execute();

                $message = 'Cidade cadastrada com sucesso!';
            }
        } catch (PDOException $e) {
            $message = 'Erro no banco de dados: ' . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/admpage.css">
    <title>Cadastro de Cidades | Toda Bella</title>

    <style>
    body {
        font-family: 'Libre Baskerville', 'Lora', serif, Arial, sans-serif;
        color: antiquewhite;
        margin: 0;
        padding: 0;
        background-color: #be92beb6;
    }

    header {
        display: flex;
        align-items: center;
        padding: 10px;
        background-color: #e290b5;
        background-color: #e290b5;
    }

    .logo {
        display: flex;
        align-items: center;
    }

    .logo img {
        height: 70px;
    }

    .nav-itens {
        list-style: none;
        display: flex;
=    }

    .nav-itens li {
        background-color: #e290b5;
        font-size: 20px;
    }

    .form-container {
        background-color: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        width: 300px;
        margin: 20px auto;
    }

    label {
        display: block;
        margin-bottom: 8px;
        color: #ff69b4;
    }

    input,
    select {
        width: 100%;
        padding: 8px;
        margin-bottom: 16px;
        box-sizing: border-box;
    }

    button {
        background-color: pink;
        color: #fff;
        padding: 10px 15px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    button:hover {
        background-color: purple;
    }
</style>


</head>
<body>

    <header>
        <div class="logo">
            <a href="admpage.php"><img class="logo1" src="IMG/logo.jpeg" alt=""></a>
        </div>
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
            <a href="?logout=true"><ion-icon name="exit-outline"></ion-icon></a> 
        </div>
    </header>

    <div class="form-container">
        <form method="post" action="">
            <label for="cidade1">Nome Cidade</label>
            <input id="cidade1" type="text" name="nome" placeholder="Informe a sua cidade..." required>

            <br><br>

            <select name="estado" required>
                <option value="">Selecione o Estado</option>
                <option>PR</option>
            </select>

            <br><br>

            <button type="submit" class="buttoncad" name="btnSalvar">CADASTRE-SE</button>
        </form>
        <?php echo $message; ?>    
    </div>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>
