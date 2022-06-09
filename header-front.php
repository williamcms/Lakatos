<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="index, follow">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<!-- Styles -->
<link rel="stylesheet" href="<?php echo url(); ?>/css/common.min.css">
<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
<!-- Scripts -->    
<script src="<?php echo url(); ?>/js/jquery-3.6.0.min.js"></script>
<script src="<?php echo url(); ?>/js/common.js" defer></script>
<script src="https://jrxeventos.com.br/js/autogrow.js" defer></script> <!-- Autogrows the textarea field in the whatsapp floating button -->
<!-- Fontawesome -->
<script src="https://kit.fontawesome.com/631d8d6355.js" crossorigin="anonymous"></script>
<!-- Preload font -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&display=swap" rel="stylesheet">
<!-- Slicker -->
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
<script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
<!-- Icons -->
<?php require_once('cfg/icons.php'); ?>
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