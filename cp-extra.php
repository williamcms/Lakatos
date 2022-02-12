<?php 
include('cfg/core.php');
include('cfg/users_class.php');
$account->sessionLogin();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
	<title><?php echo $website->title; ?>: Home</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="robots" content="noindex, nofollow">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<!-- Styles -->
	<link rel="stylesheet" href="<?php echo url(); ?>/css/cpanel.css?v=2.0"> <!-- mudar --->
	<!-- Scripts -->	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="<?php echo url(); ?>/js/cpanel.js?v=1.8"></script>  <!-- mudar --->
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

    <noscript><p class="text-center popup popup-red">Oh não! Um erro ocorreu, para viualizar melhor está página é necessário ativar o javascript. Saiba mais <a href="https://www.enable-javascript.com/pt/" target="_blank">clicando aqui</a>.</p></noscript>
</head>
<body>
    <?php include('hm_menu_cpanel.php'); ?>
<main class="extra">
    <h2 class="text-center" style="padding-top: 20px;">Personalizações do Painel de Controle</h2>
    <div class="card-box">
        
    <?php
        ini_set('error_reporting', E_ALL ^ E_WARNING);

        $conn->link = $conn->connect();

        echo '<div class="row">
            <div class="col"><h4>Modo Noturno</h4></div>
            <div class="col"><form method="POST">
                <input type="text" name="EXTRA_CHANGE" hidden>
                <input type="text" name="extra-name" value="extra-config_nightMode" hidden>
                <label class="switch"><input type="checkbox" name="extra-value" onchange="submit();" '.(isset($_SESSION['extra-config_nightMode']) ? 'checked' : '').'><span class="slider"></span></label>
            </form></div></div>';

        if(isset($_POST['EXTRA_CHANGE'])){
            $extraName = $_POST['extra-name'];
            $extraValue = $_POST['extra-value'];

            echo '<div id="form2">Efetuando Mudanças..</div>';

            $_SESSION[$extraName] = $extraValue;

            echo '<script>formOff(2);</script>';
        }
    ?>
    </div>

    <div class="card-box-results"><div class="box-msg error">Algumas das configurações aqui podem ser desfeitas ao fazer logout do painel.</div></div>
</main>
<?php include('cpanel_footer.php'); ?>
</body>
</html>