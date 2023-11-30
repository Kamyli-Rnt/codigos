<?php
include_once('conexao.php');
$pdo = conectar(); 
session_start();

if (!isset($_SESSION['user_id'])) {
    echo "Usuário não está logado.";
    exit;
}

if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit;
}

// Variable to store success or error message
$alteracaoMessage = '';

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

// Handle form submissions for updating email, name, and telephone
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['atualizarInfo'])) {
    $novo_email = $_POST['novo_email'];
    $novo_nome = $_POST['novo_nome'];
    $novo_telefone = $_POST['novo_telefone'];

    // Validate the new email (you can add more validation if needed)
    if (!empty($novo_email)) {
        $sql = "UPDATE tb_clientes SET email = :novo_email WHERE id_clie = :id_clie";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':novo_email', $novo_email);
        $stmt->bindParam(':id_clie', $id_clie, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $alteracaoMessage = 'Alteração feita com sucesso.';
        } else {
            $alteracaoMessage = 'Erro na alteração.';
        }
    } else {
        $alteracaoMessage = 'O novo email não pode estar vazio.';
    }

    // Validate the new name (you can add more validation if needed)
    if (!empty($novo_nome)) {
        $sql = "UPDATE tb_clientes SET nome_clie = :novo_nome WHERE id_clie = :id_clie";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':novo_nome', $novo_nome);
        $stmt->bindParam(':id_clie', $id_clie, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $alteracaoMessage = 'Alteração feita com sucesso.';
        } else {
            $alteracaoMessage = 'Erro na alteração.';
        }
    } else {
        $alteracaoMessage = 'O novo nome não pode estar vazio.';
    }

    // Validate the new telephone (you can add more validation if needed)
    if (!empty($novo_telefone)) {
        $sql = "UPDATE tb_clientes SET telefone_clie = :novo_telefone WHERE id_clie = :id_clie";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':novo_telefone', $novo_telefone);
        $stmt->bindParam(':id_clie', $id_clie, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $alteracaoMessage = 'Alteração feita com sucesso.';
        } else {
            $alteracaoMessage = 'Erro na alteração.';
        }
    } else {
        $alteracaoMessage = 'O novo telefone não pode estar vazio.';
    }
}

// Handle form submissions for updating password
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['atualizarSenha'])) {
    // ... (Similar logic for updating password)
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Atualizar Perfil</title>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/altperfilclie.css">
    <style>
        body {
            background-color: #efc6dead;
            margin: 0;
            padding: 0;
        }

        .nav-itens a {
        color: white;
        }

        a{
            color: black;
        }

        header {
            background-color: #e290b5;
            padding: 10px;
            color: white;
            text-align: center;
        }

        .logo {
            margin-right: 20px;
        }

        .nav-itens {
            list-style-type: none;
            padding: 0;
            margin: 0;
            display: flex;
            align-items: center;
        }

        .nav-itens li {
            margin-right: 20px;
        }

        .informacoes {
            background-color: white;
            padding: 20px;
            margin: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #e290b5;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #e290b5;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="date"],
        input[type="time"],
        input[type="number"] {
        width: 100%;
        padding: 10px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
        color: black;
}


        input[type="submit"] {
            background-color: purple;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #e290b5;
        }

        .success-message {
            color: #4caf50;
        }

        .error-message {
            color: #f44336;
        }

        .background {
            background-color: #efc6dead;
            padding: 20px;
            margin: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        
        ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        ul li {
            margin-bottom: 8px;
        }

        .clear {
            clear: both;
        }

        .by {
            margin-top: 5px;
        }

        .by a {
            color: #ffffff;
        }

        .by a:hover {
            text-decoration: underline;
        }
    </style>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</head>
<body>
    <header>
        <nav>
            <div class="logo">
                <a href="index.php">
                    <img class="logo1" src="IMG/logo.jpeg" alt="">
                </a>
            </div>
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

    <br><br><br>
    <div class="background">
        <!-- Seção de informações do perfil do usuário -->
        <div class="informacoes">
            <h2>Perfil do cliente: <?= htmlspecialchars($usuario['nome_clie']) ?></h2><br>
            <p>Nome: <?= htmlspecialchars($usuario['nome_clie']) ?></p>
            <p>Data de nascimento: <?= htmlspecialchars($usuario['data_nasc_clie']) ?></p>
            <p>Telefone: <?= htmlspecialchars($usuario['telefone_clie']) ?></p>
            <p>CPF: <?= htmlspecialchars($usuario['cpf_clie']) ?></p>
            <p>Email: <?= htmlspecialchars($usuario['email']) ?></p>
        </div>
    </div>

    <div class="background">
        <!-- Seção de alterar informações do usuário -->
        <div class="informacoes">
            <h2>Alterar Informações do usuário:</h2><br>
            <!-- Display success or error message -->
            <?php if (!empty($alteracaoMessage)) { ?>
                <p class="<?php echo (strpos($alteracaoMessage, 'sucesso') !== false) ? 'success-message' : 'error-message'; ?>">
                    <?php echo $alteracaoMessage; ?>
                </p>
            <?php } ?>

            <!-- Formulário para atualizar email, name e telefone -->
            <form method="post" action="">
                <div>
                    <label for="novo_email">Novo email do usuário:</label>
                    <input type="email" name="novo_email" value="<?= htmlspecialchars($usuario['email']) ?>" required>
                </div>

                <div>
                    <label for="novo_nome">Novo nome do usuário:</label>
                    <input type="text" name="novo_nome" value="<?= htmlspecialchars($usuario['nome_clie']) ?>" required>
                </div>

                <div>
                    <label for="novo_telefone">Novo telefone do usuário:</label>
                    <input type="text" name="novo_telefone" value="<?= htmlspecialchars($usuario['telefone_clie']) ?>" required>
                </div>

                <div>
                    <input type="submit" name="atualizarInfo" value="Atualizar Informações">
                </div>
            </form>

            <br>

            <form method="post" action="">
                <div>
                    <label for="nova_senha">Nova senha do usuário:</label>
                    <input type="password" name="nova_senha" required>
                </div>

                <div>
                    <label for="confirme">Confirme sua nova senha:</label>
                    <input type="password" name="confirme" required>
                </div>

                <div>
                    <input type="submit" name="atualizarSenha" value="Atualizar Senha">
                </div>
            </form>
        </div>
    </div>
    <br><br>
    <!--inicio footer-->
    <footer class="main_footer container">
        <div class="content">
            <div class="colfooter">
                <h3 class="titleFooter"> Menu</h3>
                <ul>
                    <li><a href="index.php" title="Página Inicial">Página Inicial</a></li>
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
                <a href="https://www.instagram.com/"><ion-icon name="logo-instagram"></ion-icon></a>
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

</body>
</html>
