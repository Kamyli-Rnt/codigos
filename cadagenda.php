<?php
include_once "conexao.php";
$pdo = conectar();
session_start();


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$id_clie = $_SESSION['user_id']; 
$sql = "SELECT nome_clie FROM tb_clientes WHERE id_clie = :id_clie";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id_clie', $id_clie);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if ($row) {
    $_SESSION['nome_clie'] = $row['nome_clie'];
}

if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit;
}
$email = isset($_SESSION['email']) ? $_SESSION['email'] : '';


$sql = "SELECT a.*, f.nome_func, s.tipo_serv, c.nome_clie 
        FROM tb_agendas a
        
        INNER JOIN tb_func_servs fs ON a.fk_id_func = fs.fk_id_func
        INNER JOIN tb_funcionarios f ON fs.fk_id_func = f.id_func
        INNER JOIN tb_servicos s ON a.fk_id_serv = s.id_serv
        INNER JOIN tb_clientes c ON a.id_clie = c.id_clie";

$stmt = $pdo->prepare($sql);
$stmt->execute();
$agendas = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sqlFuncionarios = "SELECT * FROM tb_funcionarios";
$stmtFuncionarios = $pdo->prepare($sqlFuncionarios);
$stmtFuncionarios->execute();
$dadosFuncionarios = $stmtFuncionarios->fetchAll(PDO::FETCH_ASSOC);

$sqlServicos = "SELECT * FROM tb_servicos";
$stmtServicos = $pdo->prepare($sqlServicos);
$stmtServicos->execute();
$dadosServicos = $stmtServicos->fetchAll(PDO::FETCH_ASSOC);

$funcionarioLogado = $_SESSION['user_id'];

$funcionarioLogado = $_SESSION['user_id'];

$sqlClientes = "SELECT * FROM tb_clientes WHERE id_clie = :id_clie";
$stmtClientes = $pdo->prepare($sqlClientes);
$stmtClientes->bindParam(':id_clie', $id_clie);
$stmtClientes->execute();
$dadosClientes = $stmtClientes->fetchAll(PDO::FETCH_ASSOC);

function cadastrarAgend($pdo)
{
    $message = '';

    if (isset($_POST['btnsalvar'])) {
        $fk_id_func = $_POST['fk_id_func'];
        $fk_id_serv = $_POST['fk_id_serv'];
        $id_clie = $_POST['id_clie'];
        $data = $_POST['data'];
        $horario = $_POST['horario'];

        $dataAtual = date("Y-m-d");
        if ($data < $dataAtual) {
            $message = 'A data de agendamento não pode ser no passado.';
        } else {
            $stmt_check = $pdo->prepare("SELECT COUNT(*) as count FROM tb_agendas WHERE fk_id_func = :fk_id_func AND data = :data AND horario = :horario");
            $stmt_check->bindParam(':fk_id_func', $fk_id_func);
            $stmt_check->bindParam(':data', $data);
            $stmt_check->bindParam(':horario', $horario);
            $stmt_check->execute();
            $count = $stmt_check->fetch(PDO::FETCH_ASSOC);

            $stmt_check_cliente = $pdo->prepare("SELECT COUNT(*) as count FROM tb_agendas WHERE id_clie = :id_clie AND data = :data AND horario = :horario");
            $stmt_check_cliente->bindParam(':id_clie', $id_clie);
            $stmt_check_cliente->bindParam(':data', $data);
            $stmt_check_cliente->bindParam(':horario', $horario);
            $stmt_check_cliente->execute();
            $count_cliente = $stmt_check_cliente->fetch(PDO::FETCH_ASSOC);

            if ($count['count'] > 0 || $count_cliente['count'] > 0) {
                $message = 'Já existe um agendamento para o mesmo funcionário ou cliente.';
            } else {
                try {
                    $stmt = $pdo->prepare("INSERT INTO tb_agendas (data, horario, id_clie, fk_id_func, fk_id_serv) VALUES (:data, :horario, :id_clie, :fk_id_func, :fk_id_serv)");
                    $stmt->bindParam(':data', $data);
                    $stmt->bindParam(':horario', $horario);
                    $stmt->bindParam(':id_clie', $id_clie);
                    $stmt->bindParam(':fk_id_func', $fk_id_func);
                    $stmt->bindParam(':fk_id_serv', $fk_id_serv);
                    if ($stmt->execute()) {
                        $message = 'Cadastro realizado com sucesso!';
                        header("Location: busca_agendamento.php");
                        exit;
                    } else {
                        $message = 'Algum dos dados informados está inválido.';
                    }
                } catch (Exception $e) {
                    $message = 'Erro ao cadastrar: ' . $e->getMessage();
                }
            }
        }
    }

    return $message;
}

$message = cadastrarAgend($pdo);
?>

<!DOCTYPE html> 
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toda Bella</title>
    <link rel="stylesheet" href="CSS/cadagenda.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="icon" type="image/png" href="IMG/logoguia.png"/>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <style>
        #nome-dia-semana,
        #data-semana,
        #dias-semana button,
        .hora,
        .evento {
            color: black;
        }

        #formulario label,
        #formulario input,
        #formulario select,
        #formulario button {
        color: black;
        }
    </style>
</head>
<body>

        <nav>
            <div class="logo"><a href="index.php"><img class="logo1" src="IMG/logo.jpeg" alt=""></a></div>
            <div class="links">
            <ul class="nav-itens">
                <li><a href="servicos.php">Serviços</a></li>&nbsp; &nbsp; &nbsp;
                <li><a href="cadagenda.php">Agendar Horário</a></li>&nbsp; &nbsp; &nbsp;
                <li><a href="perfilclie.php">perfil</a></li>&nbsp; &nbsp; &nbsp;
            </ul>
            </div>
            
            <h3>Bem-vinda, <?php echo $_SESSION['nome_clie']; ?>! </h3>
                <a href="?logout=true"><ion-icon name="exit-outline"></ion-icon></a> 
        </nav> 

<br><br><br>

<div class="header" id="header">
    <div class="agenda">
       
        <div class="data-semana">
            <p id="nome-dia-semana"></p>
            <p id="data-semana"></p>
        </div>
        <div class="dia-semana" id="dias-semana">
            <button onclick="anteriorDia()"><</button>
            <div></div>
            <button onclick="proximoDia()">></button>
        </div>
        <div class="horario">
            <div class="hora">08:00</div>
            <div class="evento" onclick="mostrarFormulario('08:00')">Clique para agendar</div>
        </div>
        <div class="horario">
            <div class="hora">09:00</div>
            <div class="evento" onclick="mostrarFormulario('09:00')">Clique para agendar</div>
        </div>
        <div class="horario">
            <div class="hora">10:00</div>
            <div class="evento" onclick="mostrarFormulario('10:00')">Clique para agendar</div>
        </div>
        <div class="horario">
            <div class="hora">11:00</div>
            <div class="evento" onclick="mostrarFormulario('11:00')">Clique para agendar</div>
        </div>
        <div class="horario">
            <div class="hora">13:00</div>
            <div class="evento" onclick="mostrarFormulario('13:00')">Clique para agendar</div>
        </div>
        <div class="horario">
            <div class="hora">14:00</div>
            <div class="evento" onclick="mostrarFormulario('14:00')">Clique para agendar</div>
        </div>
        <div class="horario">
            <div class="hora">15:00</div>
            <div class="evento" onclick="mostrarFormulario('15:00')">Clique para agendar</div>
        </div>
        <div class="horario">
            <div class="hora">16:00</div>
            <div class="evento" onclick="mostrarFormulario('16:00')">Clique para agendar</div>
        </div>
        <div class="horario">
            <div class="hora">17:00</div>
            <div class="evento" onclick="mostrarFormulario('17:00')">Clique para agendar</div>
        </div>
        
    </div>
</div>

<br>

    <div id="formulario">
        <form  method="post">
            <div class="main-cadastro">
                <div class="card-cadastro">
                <h1>cadastro de agendamento</h1>
                <div class="textfield">
                        <label for="data">Data de agendamento:</label>
                        <input type="date" name="data" id="data">
                    </div>

                    <div class="textfield">
                        <label for="horario">Horário de agendamento:</label>
                        <input type="time" name="horario" id="horario">
                    </div>

                    <div class="textfield">
                        <label for="clientes">Cliente:</label>
                        <select id="id_clie" name="id_clie">
                            <?php foreach ($dadosClientes as $cliente) {
                                echo "<option value='{$cliente['id_clie']}'>{$cliente['nome_clie']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                   
                    <div class="textfield">
                        <label for="funcionario">Funcionário:</label>
                        <select id="fk_id_func" name="fk_id_func">
                            <?php foreach ($dadosFuncionarios as $funcionario) {
                                echo "<option value='{$funcionario['id_func']}'>{$funcionario['nome_func']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="textfield">
                        <label for="servicos">Serviço:</label>
                        <select id="fk_id_serv" name="fk_id_serv">
                            <?php foreach ($dadosServicos as $servico) {
                                echo "<option value='{$servico['id_serv']}'>{$servico['tipo_serv']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                   
                    
                    <button class="btn-1" name="btnsalvar">Cadastrar</button>
                    <button class="btn-2" name="btncancelar">Cancelar</button>
                </div>
            </div>
            <?php
                if (!empty($message)) {
                    echo "<p class='error-message'>$message</p>";
                }
                ?>
        </form>
    </div>
<br><br><br>
<!--inicio footer-->
    <footer class="main_footer container">
        
        <div class="content">

            <div class="colfooter">
                
                <h3 class="titleFooter"> Menu</h3>
                
                <ul>

                <li><a href="index.php" title="Página Inícial">Página Inícial</a></li>
                <li><a href="sobrenos.php" title="Sobre a Empresa">Sobre nós</a></li>
                <li><a href="#" title="Fale Conosco">Fale Conosco</a></li>
                
                </ul>

            </div>

            <div class="colfooter">
            
            <h3 class="titleFooter"> Contato</h3>
            <p><i class="icon icon-mail"></i> todabella@gmail.com.br</p>
            <p><i class="icon icon-phone"></i> 45 90000-0000</p>
            <p><i class="icon icon-whatsapp"></i> 45 90000-0000</p>

            </div>

            <div class="colfooter">
            
            <h3 class="titleFooter">Redes Sociais</h3>
                                        
            <a href="https://www.facebook.com/login/?next=https%3A%2F%2Fwww.facebook.com%2Fcampaign%2Flanding.php%3F%26campaign_id%3D1661784632%26extra_1%3Ds%257Cc%257C320269324047%257Ce%257Cfacebook%257C%26placement%26creative%3D320269324047%26keyword%3Dfacebook%26partner_id%3Dgooglesem%26extra_2%3Dcampaignid%253D1661784632%2526adgroupid%253D63686352403%2526matchtype%253De%2526network%253Dg%2526source%253Dnotmobile%2526search_or_content%253Ds%2526device%253Dc%2526devicemodel%253D%2526adposition%253D%2526target%253D%2526targetid%253Dkwd-541132862%2526loc_physical_ms%253D9102129%2526loc_interest_ms%253D%2526feeditemid%253D%2526param1%253D%2526param2%253D%26gclid%3DEAIaIQobChMInNGu1fnA_wIVtHxMCh162QcpEAAYASAAEgISYfD_BwE"><ion-icon name="logo-facebook"></ion-icon></a>
            <a href="https://www.instagram.com/"><i class="insta"></i><ion-icon name="logo-instagram"></ion-icon></a>   
            <a href="https://twitter.com/i/flow/login?input_flow_data=%7B%22requested_variant%22%3A%22eyJsYW5nIjoicHQifQ%3D%3D%22%7D"><ion-icon name="logo-twitter"></ion-icon></a>
            <a href="https://www.google.com/maps/@-24.9475177,-53.5094828,15z?entry=ttu"><ion-icon name="location-outline"></ion-icon></a>
            
            </div>

            <div class="clear"></div>
        
        </div>

        <div class="main_footer_copy">
            
            <p class="m-b-footer"> todabella - 2023, todos os direitos reservados.</p> 
            <p class="by"><i class="icon icon-heart-3"></i> Desenvolvido por: <a href="https://www.instagram.com/kmmy_rnt/" title="Seu nome">@kmmy_rnt</a></p>
        
        </div>
        
    </footer>
<!--fim footer-->

<script src="JS/javaagenda.js"></script>
    
</body>
</html>
