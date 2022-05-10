<?php 
include('cfg/core.php');
include('cfg/users_class.php');

$account->sessionLogin();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
	<title><?php echo $website->title; ?></title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="robots" content="noindex, nofollow">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<!-- Styles -->
	<link rel="stylesheet" href="<?php echo url(); ?>/css/common.min.css">
	<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
	<!-- Scripts -->	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="<?php echo url(); ?>/js/common.js"></script>
	<!-- Preload font -->
	<link rel="preload" href="https://use.fontawesome.com/releases/v5.5.0/webfonts/fa-brands-400.woff2" as="font" type="font/woff2" crossorigin>
	<link rel="preload" href="https://use.fontawesome.com/releases/v5.5.0/webfonts/fa-regular-400.woff2" as="font" type="font/woff2" crossorigin>
	<link rel="preload" href="https://use.fontawesome.com/releases/v5.5.0/webfonts/fa-solid-900.woff2" as="font" type="font/woff2" crossorigin>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&display=swap" rel="stylesheet">
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
	<meta name="og:email" content="<?php echo $email->replyTo; ?>"/>
	<?php
	if($location->phoneNumber){
		echo '<meta name="og:phone_number" content="'.$location->phoneNumber.'"/>';
	}
	?>

	<noscript><p class="text-center popup popup-red">Oh não! Um erro ocorreu, para viualizar melhor está página é necessário ativar o javascript. Saiba mais <a href="https://www.enable-javascript.com/pt/" target="_blank">clicando aqui</a>.</p></noscript>
</head>
<body>
	<?php require_once('menu.php'); ?>
	<main>
		<div class="d-block p-3 w-25 loginPanel">
			<form action="#" method="POST" target="_self">
				<div class="form-group">Nome <input type="text" name="username" value="<?php echo isset($_POST['username']) ? $_POST['username'] : null; ?>"></div>
				<div class="form-group">Senha <input type="password" name="password"></div>
				<button class="button2 btn-green" name="SubmitLoginButton"><span>LOGIN</span></button>
			</form>
			<div class="center psw"><a href="#" class="text-muted">Esqueceu sua senha?</a></div>
			<?php
				if($account->isAuthenticated()){
					echo '<div class="box-msg success center">'.LOGIN_SUCCESS_SESSION.'</div>';
					echo '<script>setTimeout(function(){ window.location.replace("./cp-home");}, 2000)</script>';
				}

				if(isset($_POST['SubmitLoginButton'])){
					$conn->link = $conn->connect();

					$username = stripslashes($_POST['username']);
					$username = mysqli_real_escape_string($conn->link, $username);

					$password = stripslashes($_POST['password']);
					$password = mysqli_real_escape_string($conn->link, $password);

					try{
						if($newLogin = $account->login($username, $password)){
							echo '<div class="box-msg success">'.LOGIN_SUCCESS.'</div>';
							if(!isset($_GET['return'])){
								echo '<script>setTimeout(function(){ window.location.replace("./cp-home");}, 2000)</script>';
							}else{
								echo '<script>setTimeout(function(){ window.location.replace("./'.$_GET['return'].'");}, 2000)</script>';
							}
						}
					}
					catch (Exception $e){
						echo '<div class="box-msg error center">'. $e->getMessage() .'</div>';
					}
				}
			?>
		</div>
	</main>
<?php include('footer.php'); ?>
</body>
</html>