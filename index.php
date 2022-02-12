<?php require_once('cfg/core.php'); ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <title><?php echo $website->title; ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="index, follow">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Styles -->
    <link rel="stylesheet" href="<?php echo url(); ?>/css/common.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <!-- Scripts -->    
    <script src="<?php echo url(); ?>/js/jquery-3.6.0.min.js"></script>
    <script src="<?php echo url(); ?>/js/common.js"></script>
    <script src="https://jrxeventos.com.br/js/autogrow.js"></script> <!-- Autogrows the textarea field in the whatsapp floating button -->
    <!-- Preload font -->
    <link rel="preload" href="https://use.fontawesome.com/releases/v5.5.0/webfonts/fa-brands-400.woff2" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="https://use.fontawesome.com/releases/v5.5.0/webfonts/fa-regular-400.woff2" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="https://use.fontawesome.com/releases/v5.5.0/webfonts/fa-solid-900.woff2" as="font" type="font/woff2" crossorigin>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&display=swap" rel="stylesheet">
    <!-- Slicker -->
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
    <script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <!-- Icons -->
    <link rel="icon" href="https://www.lakatos.com/favicon.png" type="image/x-icon" />
    <link rel="shortcut icon" href="https://www.lakatos.com/favicon.png" type="image/x-icon" />
    
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo url(); ?>/apple-touch-icon.png<?php echo $website->iconVersion; ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo url(); ?>/favicon-32x32.png<?php echo $website->iconVersion; ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo url(); ?>/favicon-16x16.png<?php echo $website->iconVersion; ?>">
    <link rel="manifest" href="<?php echo url(); ?>/site.webmanifest<?php echo $website->iconVersion; ?>">
    <link rel="mask-icon" href="<?php echo url(); ?>/safari-pinned-tab.svg<?php echo $website->iconVersion; ?>" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
    <!-- Open Graph-->
    <meta property="og:locale" content="pt_BR">
    <meta property="og:type" content="website">
    <meta property="og:title" content="<?php echo $website->title; ?>">
    <meta property="og:description" content="<?php echo $website->description; ?>">
    <meta property="og:url" content="<?php echo url() ?>">
    <meta property="og:site_name" content="<?php echo $website->title; ?>">
    <meta property="og:image" content="<?php echo $website->image; ?>">
    <meta property="og:image:width" content="1654">
    <meta property="og:image:height" content="612">
    <!-- Facebook -->
    <?php
        if($fb->page){
            print '<meta property="fb:page_id" content="'.$fb->page.'" />';
        }
        if($fb->app){
            print '<meta property="fb:app_id" content="'.$fb->app.'" />';
        }
    ?>

    <!-- Management -->
    <?php
        if($mkt->gSearchConsole){
            print $mkt->gSearchConsole;
        }
        if($mkt->bWebmaster){
            print $mkt->bWebmaster;
        }
    ?>
    
    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo $website->title; ?>">
    <meta name="twitter:description" content="<?php echo $website->description; ?>">
    <meta name="twitter:url" content="<?php echo url(); ?>">
    <!-- Other tags -->
    <meta name="description" content="<?php echo $website->description; ?>">
    <meta name="author" content="<?php echo $website->author; ?>">
    <meta name="keywords" content="<?php echo $website->keywords; ?>"/>
    <!-- Location -->
    <?php
    if($location->stAddress){
        echo '<meta name="og:street-address" content="'.$location->stAddress.'"/>';
    }
    if($location->locality){
        echo '<meta name="og:locality" content="'.$location->locality.'"/>';
    }
    if($location->region){
        echo '<meta name="og:region" content="'.$location->region.'"/>';
    }
    if($location->postalCode){
        echo '<meta name="og:postal-code" content="'.$location->postalCode.'"/>';
    }
    if($location->country){
        echo '<meta name="og:country-name" content="'.$location->country.'"/>';
    }
    ?>

    <!-- Info -->
    <?php
    if($email->address){
        echo '<meta name="og:email" content="'.$email->address.'"/>';
    }
    if($location->phoneNumber){
        echo '<meta name="og:phone_number" content="'.$location->phoneNumber.'"/>';
    }
    if($mkt->fPixel){
        echo $mkt->fPixel;
    }
    ?>

    <noscript><p class="center popup popup-red">Oh não! Um erro ocorreu, para visualizar melhor está página é necessário ativar o javascript. Saiba mais <a href="https://www.enable-javascript.com/pt/" target="_blank">clicando aqui</a>.</p></noscript>
</head>
<body>
    <?php require_once('menu.php'); ?>

    <main>
        <div class="home-top_video" id="home">
            <div class="video">
                <video muted autoplay loop id="homeVideo">
                    <source src="_prototype/video/video.mp4" type="video/mp4">
                </video>                
            </div>
            <div class="info">
                <h2>Inovando a sua Produtividade</h2>
                <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam</p>
                <button id="playVideo">Pausar vídeo</button>
            </div>
        </div>
        <div class="section-separator"></div>
        <div class="home-mid-aboutus" id="aboutus" name="aboutus">
            <div class="row">
                <div class="col">
                    <div class="text">
                        <h2>Sobre nós</h2>
                        <div class="text-separator"></div><div class="text-separator"></div>
                        <p>Referência no mercado de manufatura de máquinas termoformadoras há mais de 45 anos, a Eletro-Forming passou a se chamar Lakatos. A mudança, ocorrida no início de 2019, aconteceu como parte de uma estratégia de reposicionamento da marca no mercado. O antigo nome deu lugar ao sobrenome Lakatos. </p>
                        <div class="text-separator"></div>
                        <p>Sediada no município de Embu das Artes (SP), a Lakatos conta com uma área de produção de 2500 m². O espaço conta com departamento de usinagem, caldeiraria, serralheria, montagem, pintura, metrologia e, também, um estoque de peças para pronto-atendimento.</p>
                        <div class="text-separator"></div>
                        <p>A empresa conta com uma equipe altamente habilitada para desenvolvimento de projetos e incorporação das mais modernas tecnologias. Sua linha de produção engloba máquinas de usinagem CNC capazes de manufaturar variadas peças e moldes complexos. </p>
                        <div class="text-separator"></div>
                        <p>Os departamentos de Engenharia e Produção da Lakatos são equipados com softwares (CAE, CAD 3D, EPLAN e CAM) de última geração. Um sistema ERP integra as diversas áreas da companhia.</p>
                    </div>
                </div>
                <div class="col">
                    <img src="_prototype/images/lakatos_empresa.jpg" alt="Foto Aérea" width="800" height="540" />
                </div>
            </div>
        </div>
        <div class="section-separator"></div>
        <div class="home-mid-categories">
            <div class="categories_text-wrapper">
                <div class="categories_text">
                    <h2>Qual a sua necessidade?</h2>
                    <p>A Lakatos Termoformadoras possui know how para desenvolver</p>
                    <p>moldes e máquinas capazes de produzir aplicações para diversas áreas!</p>
                </div>
            </div>
            <div class="section-separator"></div>
            <div class="categories_selection">
                <div>
                    <a href="#alimenticio"><i class="fas fa-birthday-cake"></i>
                    <p>Alimentício</p></a>
                </div>
                <div>
                    <i class="fas fa-utensils"></i>
                    <p>Descartáveis</p>
                </div>
                <div>
                    <i class="fas fa-cubes"></i>
                    <p>Embalagens blister</p>
                </div>
                <div>
                    <i class="fas fa-home"></i>
                    <p>Casa e construção</p>
                </div>

                <div>
                    <i class="fas fa-square-full"></i>
                    <p>Refrigeradores</p>
                </div>
                <div>
                    <i class="fas fa-car"></i>
                    <p>Autopeças</p>
                </div>
                <div>
                    <i class="fas fa-seedling"></i>
                    <p>Agro-mudas</p>
                </div>
                <div>
                    <i class="fas fa-plane"></i>
                    <p>Aeronáutico</p>
                </div>
            </div>
        </div>
        <div class="section-separator"></div>
        <div class="applications-detailed" id="alimenticio">
            <div class="slick-carousel-both">
                <img src="http://www.lakatos.com/painel/dashboard/uploads/galeria/imagens/imagem_aplicacao__eletro_forming__1__1515415744__0801182018104904.jpg" alt="aplicação hortifruit" title="Embalagem">
                <img src="http://www.lakatos.com/painel/dashboard/uploads/galeria/imagens/imagem_aplicacao__eletro_forming__0__1515415743__0801182018104903.jpg" alt="aplicação hortifruit" title="Embalagem">
                <img src="http://www.lakatos.com/painel/dashboard/uploads/galeria/imagens/imagem_aplicacao__eletro_forming__2__1516118663__1601182018140423.jpg" alt="aplicação hortifruit" title="Embalagem">
                <img src="http://www.lakatos.com/painel/dashboard/uploads/galeria/imagens/imagem_aplicacao__eletro_forming__3__1516118663__1601182018140423.jpg" alt="aplicação hortifruit" title="Embalagem">
            </div>
            <div>
                <p>As máquinas da Lakatos indicadas para a fabricação de embalagens para hortiffrut são a TC e a TCM (para quando as embalagens possuem furos).</p>
                <div class="text-separator"></div>
                <p>A linha TC é automática: molda e corta na mesma estação, empilha, conta e retira as peças em uma esteira transportadora. Já a linha TCM molda, perfura, corta, empilha e também retira as peças contadas em uma esteira.</p>
                <div class="text-separator"></div>
                <p>As embalagens para produtos em hortifruti são feitas em PET, normalmente, com espessura entre 0,2 e 0,6 mm, sendo que as mais comuns do mercado são as de uva (clamshell 186 x 230 mm), morango (clamshell 180x 120 mm aberto) e tomate grape (clamshell 90 x 90 mm fechado).</p>
            </div>
        </div>
    </main>
    <div class="section-separator"></div>

<?php require_once('footer.php'); ?>
</body>
</html>