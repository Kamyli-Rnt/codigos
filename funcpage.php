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

?>


<!DOCTYPEhtml>
<html lang="pt-BR">
<head>
<meta charset="UTF-8"> 
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toda Bella</title>
    <link rel="stylesheet" href="CSS/funcpage1.css">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:ital@1&family=Lora&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="IMG/logoguia.png"/>
</head>

<body>
    <header>
        <nav>
            <div class="logo"><a href="funcpage.php"><img class="logo1" src="IMG/logo.jpeg" alt=""></a></div>
            <div class="links">
                <ul class="nav-itens">
                <li><a href="listagemclie1.php">Clientes</a></li>     
                <li><a href="lisagenda.php">agenda</a></li>     
                </ul>
            </div>

            <div>
            <h3 style="font-size: 20px; color: aliceblue;">Bem-vinda, <?php echo $_SESSION['nome_func']; ?>! </h3></div>
                <a href="?logout=true"><ion-icon name="exit-outline"></ion-icon></a>
            </div>
        </nav>
        
    </header>
    <br><br><br>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>