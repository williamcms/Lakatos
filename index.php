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
    <!-- Scripts -->    
    <script src="<?php echo url(); ?>/js/jquery-3.6.0.min.js"></script>
    <script src="<?php echo url(); ?>/js/common.js"></script>
    <!-- Preload font -->
    <link rel="preload" href="https://use.fontawesome.com/releases/v5.5.0/webfonts/fa-brands-400.woff2" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="https://use.fontawesome.com/releases/v5.5.0/webfonts/fa-regular-400.woff2" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="https://use.fontawesome.com/releases/v5.5.0/webfonts/fa-solid-900.woff2" as="font" type="font/woff2" crossorigin>
    <!-- Icons -->
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
<main>

</main>
<?php require_once('footer.php'); ?>
</body>
</html>