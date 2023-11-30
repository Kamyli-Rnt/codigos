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

$sql = "SELECT * FROM tb_funcionarios";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Listagem de funcionarios</title>
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
                <h3 style=" font-size: 17px; color: purple;">Bem-vinda, <?php echo $_SESSION['nome_func']; ?>!</h3>
                <a href="?logout=true"><ion-icon name="exit-outline"></ion-icon></a> 
            </div>
        </nav>
    </header>

    <h2>
        <center>Listagem de funcionarios</center>
    </h2>
    <table class="table table-striped table-bordered">
        <tr class="table-dark">
            <th>ID</th>
            <th>Nome</th>
            <th>Ativo</th>
            <th>Tipo cadastro</th>
            <th>Data nascimento</th>
            <th>CPF</th>
            <th>Telefone</th>
            <th>E-mail</th>
            <th>Senha</th>
            <th>Ações</th>
        </tr>
        <?php foreach ($resultado as $r) { ?> 
            <tr>
                <td><?php echo $r['id_func']; ?></td>
                <td><?php echo $r['nome_func']; ?></td>
                <td><?php echo $r['func_ativo']; ?></td>
                <td><?php echo $r['tipo_cadastro']; ?></td>
                <td><?php echo date('d/m/Y',strtotime ($r['data_nasc_func'])); ?></td>
                <td><?php echo $r['cpf_func']; ?></td>
                <td><?php echo $r['telefone_func']; ?></td>
                <td><?php echo $r['email']; ?></td>
                <td><?php echo $r['senha']; ?></td>
                <td>
                    <a href="altfunc.php?id=<?php echo $r['id_func'] ?>" class="btn btn-warning">ALTERAÇÃO</a>
                    <a href="javascript:void(0);" class="btn btn-danger" onclick="confirmarExclusao(<?php echo $r['id_func']; ?>)">EXCLUSÃO</a>
                </td>
            </tr>
        <?php } ?>
    </table>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

    <script>
        function confirmarExclusao(idFuncionario) {
            if (confirm("Certeza que deseja excluir este funcionário?")) {
                window.location.href = "exclufunc.php?id=" + idFuncionario;
            }
        }
    </script>
</body>
</html>
