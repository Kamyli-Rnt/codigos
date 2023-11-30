<?php
include_once('conexao.php');
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

$sql = "SELECT * FROM tb_clientes";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Listagem de cliente</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/funcpage1.css">
    <script src="js/bootstrap.js"></script>
    <script src="js/jquery.js"></script>
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
            <div class="navbar">
    <div class="logo">
    <h3 style="font-size: 20px; color: aliceblue;">Bem-vinda, <?php echo $_SESSION['nome_func']; ?>! </h3></div>
    <div class="nav-itens">
        <a href="?logout=true"><ion-icon name="exit-outline"></ion-icon></a>
    </div>
</div>

        </nav>
    </header>

    <h2>
        <center>Listagem de cliente</center>
    </h2>
    <table class="table table-striped table-bordered">
        <tr class="table-dark">
            <th>ID</th>
            <th>Ativo</th>
            <th>Nome</th>
            <th>Data nascimento</th>
            <th>Tipo cadastro</th>
            <th>Telefone</th>
            <th>E-mail</th>
            <th>Senha</th>
            <th>CPF</th>
            <th>Ações</th>
        </tr>
        <?php foreach ($resultado as $r) { ?> 
            <tr>
                <td><?php echo $r['id_clie']; ?></td>
                <td><?php echo $r['clie_ativo']; ?></td>
                <td><?php echo $r['nome_clie']; ?></td>
                <td><?php echo date('d/m/Y',strtotime ($r['data_nasc_clie']));?></td>
                <td><?php echo $r['tipo_cadastro']; ?></td>
                <td><?php echo $r['telefone_clie']; ?></td>
                <td><?php echo $r['email']; ?></td>
                <td><?php echo $r['senha']; ?></td>
                <td><?php echo $r['cpf_clie']; ?></td>
                <td>
                    <a href="altcliente.php?id=<?php echo $r['id_clie'] ?>" class="btn btn-warning">ALTERAR</a>
                    <a href="javascript:void(0);" class="btn btn-danger" onclick="confirmarExclusao(<?php echo $r['id_clie']; ?>)">EXCLUIR</a>
                </td>
            </tr>
        <?php } ?>
    </table>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

    <script>
        function confirmarExclusao(idCliente) {
            if (confirm("Certeza que deseja excluir este cliente?")) {
                window.location.href = "exclucliente.php?id=" + idCliente;
            }
        }
    </script>
</body>
</html>