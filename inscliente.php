<?php
session_start();
include_once 'conexao.php';

$pdo = conectar();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link rel="stylesheet" href="CSS/cadastro.css">
    <script src="JS/cadastro.js"></script>

</head>
<link rel="icon" type="image/png" href="IMG/logoguia.png"/>
<body>

    <div class="page"> 
        <div class="logo"><a href="index.php"><img class="logo1" src="IMG/logo.jpeg" alt=""></a></div>
        <div class="links"></div>
        <form method="POST" class="formCadastro">
            <h1>Cadastro</h1>
            <p>Digite os seus dados no campo abaixo.</p> <br>
            <div class="p1">
                <div>
                <label for="nome">Nome</label><br>
                <input type="text" name="nome_clie" placeholder="Digite seu nome">
                </div>
                <div>
                <label for="campo3">Data de Nascimento</label><br>
                <input oninput="mascara(this, 'data')" id="campo3" type="date" name="data_nasc_clie" class="form-control" placeholder="dd/mm/aaaa" autocomplete="off" name="customer['birthdate']">
                </div>
            </div>
            <div class="p1">
                <div>
                <label for="campo4">CPF</label><br>
                <input oninput="mascara(this, 'cpf')" id="campo4" type="text" name="cpf_clie" class="form-control" placeholder="xxx.xxx.xxx-xx" autocomplete="off" name="customer['cpf']">
                </div>
                <div>
                <label for="campo7">Telefone</label><br>
                <input oninput="mascara(this, 'tel')" id="campo7" type="number" name="telefone_clie" class="form-control" placeholder="(xx) xxxxx-xxxx" autocomplete="off" name="customer['tel']">
                </div>
           </div>
           <div class="p1">
                <div>
                    <label for="email">E-mail</label><br>
                    <input type="text" name="email" placeholder="Digite seu e-mail" autofocus="true" />
                </div>
                <div>
                    <label for="password">Senha</label><br>
                    <input type="password" name="senha" placeholder="crie uma senha" />
                </div>
            </div>
            <div>
                <input type="submit" value="cadastro" name="btn" class="btn" />
            </div>
        </form>
        
    </div>
    
</body>
</html>


<?php
    if(isset($_POST['btn'])){

        $nome_clie = $_POST['nome_clie'];
        $data_nasc_clie = $_POST['data_nasc_clie'];
        $telefone_clie = $_POST['telefone_clie'];
        $email = $_POST['email'];
        $senha = md5($_POST['senha']);
        $cpf_clie = $_POST['cpf_clie'];
        $cidade = 1;


        if(empty ($nome_clie) && ($data_nasc_clie) && ($telefone_clie) && ($email) && ($senha) && ($cpf_clie)){
            echo "Necessário informar campos obrigatórios";
            exit();
        };

        $sql = "INSERT INTO tb_clientes(nome_clie, data_nasc_clie, telefone_clie, email, senha, cpf_clie, id_cid) VALUES ( :nome_clie, :data_nasc_clie, :telefone_clie, :email, :senha, :cpf_clie, :id_cid)";
        
        $stmt = $pdo->prepare($sql);

        
        $stmt->bindParam(':nome_clie', $nome_clie);
        $stmt->bindParam(':data_nasc_clie', $data_nasc_clie);
        $stmt->bindParam(':telefone_clie', $telefone_clie);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':senha', $senha);
        $stmt->bindParam(':cpf_clie',  $cpf_clie);
        $stmt->bindParam(':id_cid',  $cidade);
       
        if($stmt->execute()){
            echo "Cliente cadastrado com sucesso!";
            //header("Location: pagina.php");
        }else{
            echo "Erro ao cadastrar cliente. Tente novamente.";
        };

    };
    
?>