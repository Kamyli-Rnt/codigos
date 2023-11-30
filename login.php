<?php
include_once 'conexao.php';
$pdo = conectar();
session_start();

// Initialize the error variable
$error = "";

if (isset($_POST['btnEntrar'])) {
    $email = $_POST['email'];
    $senha = md5($_POST['senha']);
    $sql = "SELECT tipo, id, email, senha, nome_func FROM (
        SELECT 'C' as tipo, id_clie as id, email, senha, NULL as nome_func FROM tb_clientes
        UNION 
        SELECT 'A' as tipo, id_func as id, email, senha, nome_func FROM tb_funcionarios WHERE tipo_cadastro = 'A'
        UNION
        SELECT 'F' as tipo, id_func as id, email, senha, nome_func FROM tb_funcionarios WHERE tipo_cadastro = 'F'
    ) AS combined 
    WHERE email = :email AND senha = :senha";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':senha', $senha);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $_SESSION['loggedin'] = true;
        $_SESSION['user_id'] = $row['id'];

        if ($row['tipo'] == 'A') {
            if ($row['email'] == 'kamylirenata@gmail.com') {
                $_SESSION['nome_func'] = $row['nome_func'];
                header('Location: admpage.php');
            } else {
                header('Location: index.php');
            }
        } elseif ($row['tipo'] == 'F') {
            $_SESSION['nome_func'] = $row['nome_func'];
            header('Location: funcpage.php');
        } else {
            header('Location: index.php');
        }
        exit();
    } else {
        $error = "E-mail ou senha inválida!";
    }
}
?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv of="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="CSS/login.css">
</head>
<link rel="icon" type="image/png" href="IMG/logoguia.png"/>
<body>
<div class="page">
<a href="homepage.php">
    <img class="logo1" src="IMG/logo.jpeg" alt="" width="300">
</a>
        <div class="links"></div>
        <form method="POST" class="formLogin">
            <h1>Login</h1>
            <!-- Display error message if any -->
            <?php if (!empty($error)) : ?>
                <div class="error-message"><?php echo $error; ?></div>
            <?php endif; ?>
            <p>Digite os seus dados de acesso no campo abaixo.</p>
            <label for="email">E-mail</label>
            <input type="email" placeholder="Digite seu e-mail" autofocus="true" name="email" />
            <label for="password">Senha</label>
            <input type="password" placeholder="Digite sua senha" name="senha">
            <a href="loginadm.php">esqueceu a senha</a>
            <br>
            <button type="submit" class="btn" name="btnEntrar">Acessar</button>
        </form>
    </div>
</body>
</html>
