<?php
include_once('conexao.php');
$pdo = conectar(); 
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
}

// Get the user ID of the logged-in client
$user_id = $_SESSION['user_id'];

// Query to retrieve appointments for the logged-in client
$query = "SELECT a.*, s.tipo_serv, f.nome_func
          FROM tb_agendas a
          INNER JOIN tb_func_servs fs ON a.fk_id_func = fs.fk_id_func AND a.fk_id_serv = fs.fk_id_serv
          INNER JOIN tb_servicos s ON a.fk_id_serv = s.id_serv
          INNER JOIN tb_funcionarios f ON a.fk_id_func = f.id_func
          WHERE a.id_clie = :user_id";

// Prepare the query
$stmt = $pdo->prepare($query);

// Bind the user_id parameter
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);

// Execute the query
$stmt->execute();

// Fetch appointments data
$appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Close the database connection (optional for PDO)
$pdo = null;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans&display=swap" rel="stylesheet">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Appointments</title>

    <style>
        body {
            font-family: 'Josefin Sans', sans-serif;
            background-color: #efc6dead;
            margin: 25px;
            align-items: center;
            min-height: 100vh;
        }

        h1 {
            color: purple;
            text-align: center;
            font-size: 35px;
        }

        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            border-color: black;
        }

        th,
        td {
            padding: 15px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: purple;
            color: white;
        }

        tbody tr:hover {
            background-color: #f5f5f5;
        }

        p {
            text-align: center;
            color: #777;
        }

        .btn-voltar {
            display: block;
            margin: 20px auto;
            padding: 10px 20px;
            background-color: purple;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.4s, transform 0.4s;
            font-size: 18px;
            width: 11%;
            font-family: 'Josefin Sans', sans-serif;

        }

        .btn-voltar:hover {
            background-color: #bf81bf;
            transform: scale(1.1);
            font-family: 'Josefin Sans', sans-serif;
        }
    </style>

</head>

<body>
    <h1>Historico de Agendamento</h1>

    <?php if (empty($appointments)) : ?>
        <p>No appointments found.</p>
    <?php else : ?>
        <table border="1">
            <thead>
                <tr>
                    <th>Data</th>
                    <th>Horario</th>
                    <th>Serviço</th>
                    <th>Funcionario</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($appointments as $appointment) : ?>
                    <tr>
                        <td><?= $appointment['data']; ?></td>
                        <td><?= $appointment['horario']; ?></td>
                        <td><?= $appointment['tipo_serv']; ?></td>
                        <td><?= $appointment['nome_func']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <button class="btn-voltar" onclick="window.location.href='perfilclie.php'">Voltar</button>
    <?php endif; ?>
</body>

</html>

