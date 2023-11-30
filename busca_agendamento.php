<?php
include_once 'conexao.php';
$pdo = conectar();
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$id_clie = $_SESSION['user_id'];

// Obtendo informações do agendamento
$sql = "SELECT c.nome_clie, a.data, a.horario, f.nome_func, s.tipo_serv
        FROM tb_agendas a
        JOIN tb_clientes c ON a.id_clie = c.id_clie
        JOIN tb_func_servs fs ON a.fk_id_func = fs.fk_id_func AND a.fk_id_serv = fs.fk_id_serv
        JOIN tb_funcionarios f ON fs.fk_id_func = f.id_func
        JOIN tb_servicos s ON fs.fk_id_serv = s.id_serv
        WHERE a.id_clie = :id_clie";

$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id_clie', $id_clie);
$stmt->execute();
$agendamento = $stmt->fetch(PDO::FETCH_ASSOC);

if ($agendamento) {
    $_SESSION['nome_clie'] = $agendamento['nome_clie'];
    $_SESSION['data'] = $agendamento['data'];
    $_SESSION['horario'] = $agendamento['horario'];
    $_SESSION['nome_func'] = $agendamento['nome_func'];
    $_SESSION['tipo_serv'] = $agendamento['tipo_serv'];
} else {
    // Lida com a situação em que nenhum agendamento é encontrado
    echo "Erro: Nenhum agendamento encontrado para este cliente.";
    exit;
}

if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendamento Cadastrado</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/estilo.css"> <!-- Certifique-se de criar o arquivo de estilo CSS -->
    <style>
        body {
            background-color: #efc6dead;
            font-family: 'Josefin Sans', sans-serif;
        }

        .container {
            max-width: 600px;
            margin: 100px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .success-message {
            background-color: #28a745;
            color: #fff;
            padding: 10px;
            text-align: center;
            border-radius: 20px;
            margin-top: 5px;
        }

        .user-info {
            margin-top: 20px;
            font-size: 22px;
        }

        .user-info p {
            margin: 5px 0;
        }

        .logout-link {
            display: block;
            margin-top: 20px;
            text-align: center;
            color: aliceblue;
            text-decoration: none;
            font-size: 25px;
            transition: background-color 0.4s, transform 0.4s;
            font-family: 'Josefin Sans', sans-serif;
            background-color: purple;
            width: 20%;
            border-radius: 20px;
            padding: 8px;
        }

        .logout-link:hover {
            text-decoration: none;
            color: aliceblue;
            background-color: #a9070fa6;
            transform: scale(1.1);
            font-family: 'Josefin Sans', sans-serif;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="success-message">
            <h2>Agendamento cadastrado com sucesso!</h2>
        </div>

        <div class="user-info">
            <?php
            echo "<p><strong>Nome do Cliente:</strong> " . $_SESSION['nome_clie'] . "</p>";
            echo "<p><strong>Data:</strong> " . date('d/m/Y', strtotime($_SESSION['data'])) . "</p>";
            echo "<p><strong>Horário:</strong> " . $_SESSION['horario'] . "</p>";
            echo "<p><strong>Nome do Profissional:</strong> " . $_SESSION['nome_func'] . "</p>";
            echo "<p><strong>Nome do Serviço:</strong> " . $_SESSION['tipo_serv'] . "</p>";
            ?>
        </div>

        <a class="logout-link" href="?logout=true">Logout</a>
    </div>
</body>

</html>
