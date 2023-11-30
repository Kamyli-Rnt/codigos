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

$sql = "SELECT * FROM tb_agendas";
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

    <h2>
        <center>Listagem de agenda</center>
    </h2>
    
    <table class="table table-striped table-bordered">
        <tr class="table-dark">
            <th>ID</th>
            <th>data</th>
            <th>horario</th>
            <th>id_clie</th>
            <th>fk_id_func</th>
            <th>fk_id_serv</th>
            <th>Ações</th>
        </tr>
        <?php foreach ($resultado as $r) { ?> 
            <tr>
                <td><?php echo $r['id_agenda']; ?></td>
                <td><?php echo date('d/m/Y',strtotime ($r['data'])); ?></td>
                <td><?php echo $r['horario']; ?></td>
                <td><?php echo $r['id_clie']; ?></td>
                <td><?php echo $r['fk_id_func']; ?></td>
                <td><?php echo $r['fk_id_serv']; ?></td>
                <<td>
                    <a href="altagenda.php?id=<?php echo $r['id_agenda'] ?>" class="btn btn-warning">ALTERAR</a>
                    <a href="excluagenda.php?id=<?php echo $r['id_agenda'] ?>" class="btn btn-danger" onclick="confirmarExclusao(<?php echo $r['id_agenda']; ?>)">EXCLUIR</a>
                </td>
           
            <?php } ?>
            
    </table>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script>
        function confirmarExclusao(idAgenda) {
            if (confirm("Certeza que deseja excluir esta agenda?")) {
                window.location.href = "excluagenda.php?id=" + idAgenda;
            }
        }
    </script>
</body>
</html>