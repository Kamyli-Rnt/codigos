<?php
session_start();
include_once 'conexao.php';

$pdo = conectar();



?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toda Bella</title>
    <link rel="stylesheet" href="CSS/homepage.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:ital@1&family=Lora&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="IMG/logoguia.png"/> 
    <script src="JS/js.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</head>

<body> 
<!--inicio nav-->
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
<!--fim nav-->
<!--inicio dos slides-->

<main>      
    <section class="container">
        <div class="slide fade">
            <div class="numeroslide"></div>
            <img class="imgslide" src="IMG/1.png">  
        </div>

        <div class="slide fade">
            <div class="numeroslide"></div>
            <img class="imgslide" src="IMG/2.png">   
        </div>

        <div class="slide fade">
            <div class="numeroslide"></div>
            <img class="imgslide" src="IMG/3.png">
        </div>

        <div class="slide fade">
            <div class="numeroslide"></div>
            <img class="imgslide" src="IMG/4.png">
        </div>

            <a class="botaoA" onclick="mudarSlide(-1)">&lsaquo;</a>
            <a class="botaoP" onclick="mudarSlide(1)">&rsaquo;</a>
    </section>
            <section style="text-align: center;">
                <span class="indicador" onclick="slideAtual(1)"></span>
                <span class="indicador" onclick="slideAtual(2)"></span>
                <span class="indicador" onclick="slideAtual(3)"></span>
                <span class="indicador" onclick="slideAtual(4)"></span>
            </section>               

    <script type="text/javascript" src="JS/js.js"></script>

</main>
<!--fim dos slides-->



<!--sla-->
<br><br><br>
<div class="exemplo2">
    <div class="horario">
        
        <h1><p><span style="color: rgb(0, 0, 0);">Horários de atendimento</p></h1><br></span>
        <div class="hrs">
            <div class="hrs1">
                <h3>Ter. á sex.</h3>
                <h3>08hrs ás 12hrs</h3>
                <h3>13hrs ás 18hrs</h3>
            </div>
            <div class="hrs2">
                <h3>Sab.</h3>
                <h3>08hrs ás 12hrs</h3>
                <h3>13hrs ás 16hrs</h3>
            </div>
        </div>
    </div>
    
        <div class="imgloc">
            <img class="loc" src="IMG/loc.jpg">
        </div>

    <div class="localizacao">
        <h1><p><span style="color: black;">Onde estamos</p></h1></span>
        <div class="loca1">
       <h3>Rua Tranquilo Noro <br> N°720</h3>
        </div>
        
    
    
    </div>
</div>



<br>
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
</body>
</html>