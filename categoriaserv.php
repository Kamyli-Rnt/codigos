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

$sql = "SELECT * FROM tb_servicos";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Listagem de Serviços</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/admpage.css">
    <script src="js/bootstrap.js"></script>
    <script src="js/jquery.js"></script>
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
                    <li><a href="cadfuncserv.php">funcserv</a></li>&nbsp; &nbsp; &nbsp;
                    <li><a href="cidade.php">Cidade</a></li>&nbsp; &nbsp; &nbsp;
                </ul>
            </div>
            <div>
                <h3 style=" font-size: 20px; color: purple;">Bem-vinda, <?php echo $_SESSION['nome_func']; ?>!</h3>
                <a href="?logout=true"><ion-icon name="exit-outline"></ion-icon></a> 
            </div>
        </nav>
    </header>

    <h2>
        <center>Listagem de Serviços</center>
    </h2>
    <?php if ($resultado) { ?>
        <table class="table table-striped table-bordered">
            <tr class="table-dark">
                <th>Imagem</th>
                <th>ID</th>
                <th>Ativo</th>
                <th>Nome serviços</th>
                <th>Valor</th>
                <th>Duração</th>
                <th>Descrição</th>
                <th>Ações</th>
            </tr>
            <?php foreach ($resultado as $r) { ?> 
                <tr>
                    <td><img src="<?php echo $r['img_servico']; ?>" alt="Imagem do serviço" width="70" height="70"></td>
                    <td><?php echo $r['id_serv']; ?></td>
                    <td><?php echo $r['ser_ativo']; ?></td>
                    <td><?php echo $r['tipo_serv']; ?></td>
                    <td><?php echo $r['valor']; ?></td>
                    <td><?php echo $r['duracao']; ?></td>
                    <td><?php echo $r['descricao']; ?></td>
                    <td>
                        <a href="altservicos.php?id=<?php echo $r['id_serv'] ?>" class="btn btn-warning">ALTERAÇÃO</a>
                        <a href="javascript:void(0);" class="btn btn-danger" onclick="confirmarExclusao(<?php echo $r['id_serv']; ?>)">EXCLUSÃO</a>
                    </td>
                </tr>
            <?php } ?>
        </table>
    <?php } else {
        echo "Nenhum resultado encontrado.";
    }
    ?>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

    <script>
        function confirmarExclusao(idServico) {
            if (confirm("Certeza que deseja excluir este serviço?")) {
                window.location.href = "exserv.php?id=" + idServico;
            }
        }
    </script>
</body>
</html>
