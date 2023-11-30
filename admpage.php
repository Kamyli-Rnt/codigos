<?php
include_once 'conexao.php';
$pdo = conectar();
session_start();

if (!isset($_SESSION['nome_func'])) {
    header("Location: login.php");
    exit;
} 

$id_funcionario = $_SESSION['user_id']; 
$sql = "SELECT nome_func FROM tb_funcionarios WHERE id_func = :id_funcionario";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id_funcionario', $id_funcionario);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if ($row) {
    $_SESSION['nome_func'] = $row['nome_func'];
}

if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR"> 
<head> 
    <meta charset="UTF-8"> 
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toda Bella</title>
    <link rel="stylesheet" href="CSS/admpage.css">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:ital@1&family=Lora&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="IMG/logoguia.png"/>
</head>
<body>
    <header>
        <nav>
            <div class="logo"><a href="admpage.php"><img class="logo1" src="IMG/logo.jpeg" alt=""></a></div>
            <div class="links">
                <ul class="nav-itens"> 
                    <li><a href="listagemclie.php">Clientes</a></li>&nbsp; &nbsp; &nbsp;
                    <li><a href="incfunc.php">Cadastro funcionários</a></li>&nbsp; &nbsp; &nbsp;
                    <li><a href="lisfunc.php">Funcionários</a></li>&nbsp; &nbsp; &nbsp;
                    <li><a href="categoriaserv.php">Serviços</a></li>&nbsp; &nbsp; &nbsp;
                    <li><a href="incluservicos.php">Incluir serviços</a></li>&nbsp; &nbsp; &nbsp;
                    <li><a href="cadfuncserv.php">Funcserv</a></li>&nbsp; &nbsp; &nbsp;
                    <li><a href="cidade.php">Cidade</a></li>&nbsp; &nbsp; &nbsp;
                </ul>
            </div>

            <div>
            <h3 style=" font-size: 17px; color: purple;">Bem-vinda, <?php echo $_SESSION['nome_func']; ?>!</h3>
                <a href="?logout=true"><ion-icon name="exit-outline"></ion-icon></a> 
            </div>
        </nav>
        
    </header>
    <br><br><br> 
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>
