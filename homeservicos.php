<?php
session_start();
include_once "conexao.php";

$pdo = conectar();

// Query to fetch data from tb_servicos
$sql = "SELECT * FROM tb_servicos";
$stmt = $pdo->prepare($sql);
$stmt->execute();

// Fetch data into $resultado
$resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="pt-BR"> 
    
<head> 
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toda Bella</title>
    <link rel="stylesheet" href="CSS/homeservicos.css">
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    
</head>
<link rel="icon" type="image/png" href="IMG/logoguia.png"/>
<body>
    <header>
        <nav>
            <div class="logo"><a href="homepage.php"><img class="logo1" src="IMG/logo.jpeg" alt=""></a></div>
            <div class="links">
            <ul class="nav-itens">
                <li><a href="homeservicos.php">Serviços</a></li>&nbsp; &nbsp; &nbsp;
                <li><a href="cadagenda.php">Agendar Horário</a></li>&nbsp; &nbsp; &nbsp;
            </ul>
            </div>
        <div class="button">
            <button class="login"><a href="login.php"><span style="color: #ffffff">Login</span></a></button>
            <button class="cadastro"><a href="inclucliente.php"><span style="color: #ffffff;">Cadastro</span></a></button>
        </div>
        </nav>
    </header>
    



    <?php
    // Loop through each service in the result set
    foreach ($resultado as $servico) {
    ?>
        <section class="cardserunha">
            <div class="card">
                <div class="cardunha">
                    <img src="<?php echo $servico['img_servico']; ?>" alt="<?php echo $servico['tipo_serv']; ?> Image">
                </div>
                <div class="cardunha2">
                    <h1><?php echo $servico['tipo_serv']; ?></h1><br>
                    <ul>
                        <li><h5><?php echo $servico['descricao']; ?></h5></li>
                        <li><h5> - R$ <?php echo number_format($servico['valor'], 2, ',', '.'); ?></h5></li>
                    </ul>
                    <a href="cadagenda.php" class="botao1">agendar horario</a>
                </div>
            </div>
        </section>
    <?php
    }
    ?>
  













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

</body>
</html>