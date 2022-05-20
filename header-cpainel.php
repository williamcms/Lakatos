<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="noindex, nofollow">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<!-- Styles -->
<link rel="stylesheet" href="<?php echo url(); ?>/css/cpanel.css?v=2.0">
<!-- Scripts -->	
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="<?php echo url(); ?>/js/cpanel.js?v=1.8"></script>
<!-- Fontawesome -->
<script src="https://kit.fontawesome.com/631d8d6355.js" crossorigin="anonymous"></script>
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
<!-- Facebook -->
<?php
	if($fb->page){
		echo '<meta property="fb:page_id" content="'.$fb->page.'" />';
	}
	if($fb->app){
		echo '<meta property="fb:app_id" content="'.$fb->app.'" />';
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
?>
<!-- summernote -->
<?php require_once('summernote-head-codes.php'); ?>
<noscript><p class="text-center popup popup-red">
	Oh não! Um erro ocorreu, para viualizar melhor está página é necessário ativar o javascript. 
	Saiba mais <a href="https://www.enable-javascript.com/pt/" target="_blank">clicando aqui</a>.</p>
</noscript>