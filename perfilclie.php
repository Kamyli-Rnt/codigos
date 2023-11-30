<?php
include_once('conexao.php');
include_once 'funcaoData.php';
$pdo = conectar();
session_start();


if (!isset($_SESSION['user_id'])) {
    echo "Usuário não está logado.";
    exit;
}

// Carregar as informações do usuário
function carregarInformacoesUsuario($pdo, $id)
{
    $query = "SELECT * FROM tb_clientes WHERE id_clie = :id_clie";
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_clie', $id, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetch(PDO::FETCH_ASSOC);
}

$id_clie = $_SESSION['user_id'];
$usuario = carregarInformacoesUsuario($pdo, $id_clie);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Perfil</title>
    <link rel="stylesheet" href="css/perfilclie.css">
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.css">
<style>
    body {
        font-family: 'Josefin Sans', sans-serif;
        background-color: #efc6dead;
        margin: 0;
        padding: 0;
        min-height: 100vh;
    }

    header {
        background-color: #e290b5;
        color: white;
        padding: 15px;
        text-align: center;
        font-family: 'Josefin Sans', sans-serif;
    }

    nav {
        display: flex;
        justify-content: center;
        align-items: center;
        text-align: center;
        font-family: 'Josefin Sans', sans-serif;
        font-size: 20px;
    }

    .logo img {
    display: block;
    margin: 0 auto;
    width: 170px;
    height: auto;
}


.nav-itens {
    list-style: none;
    display: flex;
    font-family: 'Josefin Sans', sans-serif;
}

.nav-itens li {
    margin-right: 20px;
    font-family: 'Josefin Sans', sans-serif;
}

.nav-itens a {
    text-decoration: none;
    color: white;
    font-family: 'Josefin Sans', sans-serif;
    transition: color 0.4s, transform 0.4s;
}

.nav-itens a:hover {
    color: purple;
    text-decoration: none;
    transform: scale(1.1);
}



    h3 {
        margin: 0;
        font-size: 18px;
        font-family: 'Josefin Sans', sans-serif;
    }

    .background {
        background-color: white;
        padding: 20px;
        margin: 20px;
        border-radius: 20px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .informacoes {
        text-align: center;
        font-size: 25px;
        font-family: 'Josefin Sans', sans-serif;
    }

    .informacoes h2 {
        color: purple;
        font-family: 'Josefin Sans', sans-serif;
    }

    .informacoes p {
        margin: 15px 0;
        font-family: 'Josefin Sans', sans-serif;
    }

    .informacoes a {
        display: inline-block;
        padding: 10px 20px;
        background-color: #4B0082;
        color: white;
        text-decoration: none;
        border-radius: 15px;
        margin-top: 20px;
        font-family: 'Josefin Sans', sans-serif;
        transition: background-color 0.4s, transform 0.4s;
    }

    .informacoes a:hover {
        background-color: #b181d5;
    }

    footer {
        color: white;
        text-align: center;
        font-family: 'Josefin Sans', sans-serif;
    }

    .colfooter {
    width: 100%;
    margin-right: 5%;
    margin-bottom: 0;
    }

    .titleFooter {
        color: white;
        font-size: 20px;
        margin-bottom: 10px;
        font-family: 'Josefin Sans', sans-serif;
    }

    .colfooter ul {
        list-style: none;
        padding: 0;
        margin: 0;
        font-family: 'Josefin Sans', sans-serif;
    }

    .colfooter ul li {
        margin-bottom: 10px;
        font-family: 'Josefin Sans', sans-serif;
        font-size: 20px;
    }

    .colfooter a {
        color: white;
        text-decoration: none;
        font-weight: bold;
        font-family: 'Josefin Sans', sans-serif;
        margin-left: 50px;
    }

    .main_footer_copy {
        margin-top: 20px;
        font-size: 14px;
        font-family: 'Josefin Sans', sans-serif;
    }

    .colfooter .titleFooter {
    font-family: 'Josefin Sans', sans-serif;
    font-size: 25px;
    color: purple;
    padding-bottom: 0.5em;
    margin-bottom: 0.5em;
    border-bottom: 1px #ffffff solid;
    margin-left: 50px;
}

</style>

</head>

<body>

    <header>
        <nav>
            <div class="logo"><a href="index.php"><img class="logo1" src="IMG/logo.jpeg" alt=""></a></div>
            <div class="links">
                <ul class="nav-itens">
                    <li><a href="servicos.php">Serviços</a></li>
                    <li><a href="cadagenda.php">Agendar Horário</a></li>
                    <li><a href="perfilclie.php">Perfil</a></li>
                    <div>
                        <div>
                            <h3>Bem-vindo, <?php echo $_SESSION['nome_clie']; ?>! </h3>
                            <a href="?logout=true"><ion-icon name="exit-outline"></ion-icon></a>
                        </div>
                    </div>
                </ul>
            </div>
        </nav>
    </header>
<br>
<div class="background">
        <div class="informacoes">
            <h2>Perfil do cliente: <?= htmlspecialchars($usuario['nome_clie']) ?></h2><br>
            <p>Nome: <?= htmlspecialchars($usuario['nome_clie']) ?></p>
            <p>Data de nascimento: <?= htmlspecialchars(mybr($usuario['data_nasc_clie'])) ?></p>
            <p>Telefone: <?= htmlspecialchars($usuario['telefone_clie']) ?></p>
            <p>CPF: <?= htmlspecialchars($usuario['cpf_clie']) ?></p>
            <p>Email: <?= htmlspecialchars($usuario['email']) ?></p>
            <a href="altperfilclie.php">Editar Informações</a>
            <a href="historico.php">Seu histórico</a>
        </div>
    </div>
<br>
    <footer class="main_footer container">

        <div class="content">

            <div class="colfooter">

                <h3 class="titleFooter">Menu</h3>

                <ul>
                    <li><a href="index.php" title="Página Inícial">Página Inícial</a></li>
                    <li><a href="sobrenos.php" title="Sobre a Empresa">Sobre nós</a></li>
                    </ul>
            </div>
        </div>
    </footer>

</body>
</html>
