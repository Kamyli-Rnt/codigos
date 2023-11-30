<?php
session_start();
include_once "conexao.php";

$pdo = conectar();
$sqlc = "SELECT * FROM tb_funcionarios";
$stmtc = $pdo->prepare($sqlc);
$stmtc->execute();
$dados = $stmtc->fetchAll(PDO::FETCH_ASSOC);

function cadastrarHorario()
{
    $pdo = conectar();
    $message = '';

    if (isset($_POST['btnsalvar'])) {
        $dia_semana = $_POST["dia_semana"];
        $entrada_manha = $_POST["entrada_manha"];
        $saida_manha = $_POST["saida_manha"];
        $entrada_tarde = $_POST["entrada_tarde"];
        $saida_tarde = $_POST["saida_tarde"];
        $id_func = $_POST["id_func"];

        // Validar se os horários estão corretos
        if (strtotime($saida_manha) <= strtotime($entrada_manha) || strtotime($entrada_tarde) <= strtotime($saida_manha)) {
            $message = 'Os horários de saída não podem ser menores ou iguais aos horários de entrada.';
        } else {
            try {
                $stmt = $pdo->prepare("INSERT INTO tb_horarios (dia_semana, entrada_manha, saida_manha, entrada_tarde, saida_tarde, id_func) VALUES (:dia_semana, :entrada_manha, :saida_manha, :entrada_tarde, :saida_tarde, :id_func)");
                $stmt->bindParam(':dia_semana', $dia_semana);
                $stmt->bindParam(':entrada_manha', $entrada_manha);
                $stmt->bindParam(':saida_manha', $saida_manha);
                $stmt->bindParam(':entrada_tarde', $entrada_tarde);
                $stmt->bindParam(':saida_tarde', $saida_tarde);
                $stmt->bindParam(':id_func', $id_func);

                if ($stmt->execute()) {
                    $message = 'Cadastro realizado com sucesso!';
                    header("Location: sucesso_adm.php");
                    exit;
                } else {
                    $message = 'Algum dos dados informados está inválido.';
                }
            } catch (Exception $e) {
                $message = 'Erro ao cadastrar: ' . $e->getMessage();
            }
        }
    }

    return $message;
}

$message = cadastrarHorario();
?>

<!DOCTYPE html>
<html>
<head> 
    <meta charset="UTF-8"> 
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toda Bella</title>
    <link rel="stylesheet" href="CSS/admpage.css">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:ital@1&family=Lora&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="IMG/logoguia.png"/>
</head>
<body>
<nav>
            <div class="logo"><a href="admpage.php"><img class="logo1" src="IMG/logo.jpeg" alt=""></a></div>
            <div class="links">
            <ul class="nav-itens"> 
                <li><a href="listagemclie.php">Clientes</a></li>&nbsp; &nbsp; &nbsp;
                <li><a href="incfunc.php">Cadastro funcionários</a></li>&nbsp; &nbsp; &nbsp;
                <li><a href="lisfunc.php">Funcionários</a></li>&nbsp; &nbsp; &nbsp;
                <li><a href="categoriaserv.php">Serviços</a></li>&nbsp; &nbsp; &nbsp;
                <li><a href="incluservicos.php">incluir serviços</a></li>&nbsp; &nbsp; &nbsp;
                <li><a href="cidade.php">Cidade</a></li>&nbsp; &nbsp; &nbsp;
            </ul>
            </div>
            <div class="btn_sair">
                <p>Olá, <?php echo $_SESSION['nome_func']; ?>!</p>
                <a href="logout.php">Sair</a>
            </div>
</nav>

<form method="post">
    <div class="main-cadastro">
        <div class="Cadastro">
            <div class="card-cadastro">
                <h1>Cadastro De Horários</h1><br><br>

                <div class="textfield">
                  <label for="dia_semana">Dia da semana:</label>
               <select name="dia_semana" id="dia_semana">
               <option value="segunda-sexta">terça-Sexta</option>
              <option value="segunda-sabado">terça-Sábado</option>
              </select>
               </div>

                <div class="textfield">
                    <label for="entrada_manha">Entrada manhã:</label>
                    <input type="time" name="entrada_manha" id="entrada_manha">
                </div>

                <div class="textfield">
                    <label for="saida_manha">Saida manhã:</label>
                    <input type="time" name="saida_manha" id="saida_manha">
                </div>

                <div class="textfield">
                    <label for="entrada_tarde">Entrada tarde:</label>
                    <input type="time" name="entrada_tarde" id="entrada_tarde">
                </div>

                <div class="textfield">
                    <label for="saida_tarde">Saida tarde:</label>
                    <input type="time" name="saida_tarde" id="saida_tarde">
                </div>
                <div class="textfield">
                    <label for="funcionario">Funcionário:</label>
                    <select id="id_func" name="id_func">
                        <?php foreach ($dados as $d){
                            echo "<option value='{$d['id_func']}'>{$d['nome_func']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <div id="erro" style="color: red;"><?php echo $message; ?></div>

                <button class="btn-1" name="btnsalvar">Cadastrar</button>
                <button class="btn-2" name="btncancelar">Cancelar</button>
            </div>
        </div>
    </div>
</form>

<script>
    document.getElementById("entrada_manha").addEventListener("change", validarHorarios);
    document.getElementById("saida_manha").addEventListener("change", validarHorarios);
    document.getElementById("entrada_tarde").addEventListener("change", validarHorarios);
    document.getElementById("saida_tarde").addEventListener("change", validarHorarios);

    function validarHorarios() {
        var entradaManha = document.getElementById("entrada_manha").value;
        var saidaManha = document.getElementById("saida_manha").value;
        var entradaTarde = document.getElementById("entrada_tarde").value;
        var saidaTarde = document.getElementById("saida_tarde").value;

       
        var entradaManhaObj = new Date("1970-01-01T" + entradaManha);
        var saidaManhaObj = new Date("1970-01-01T" + saidaManha);
        var entradaTardeObj = new Date("1970-01-01T" + entradaTarde);
        var saidaTardeObj = new Date("1970-01-01T" + saidaTarde);

       
        if (entradaTardeObj <= saidaManhaObj) {
            document.getElementById("erro").innerHTML = "A entrada da tarde não pode ser menor ou igual à saída da manhã.";
        } else {
            document.getElementById("erro").innerHTML = "";
        }
    }
</script>
</body>
</html>