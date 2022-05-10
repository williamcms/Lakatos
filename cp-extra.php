<?php 
include('cfg/core.php');
include('cfg/users_class.php');
$account->sessionLogin();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
	<title><?php echo $website->title; ?>: Home</title>
	<?php require_once('header-cpainel.php'); ?>
</head>
<body>
	<?php include('hm_menu_cpanel.php'); ?>
<main class="extra">
	<h2 class="text-center pt-3">Personalizações do Painel de Controle</h2>
	<div class="card-box">
		
	<?php
		ini_set('error_reporting', E_ALL ^ E_WARNING);

		$conn->link = $conn->connect();

		echo '<div class="row">
			<div class="col"><h4>Modo Noturno</h4></div>
			<div class="col"><form method="POST">
				<input type="text" name="EXTRA_CHANGE" hidden>
				<input type="text" name="extra-name" value="extra-config_nightMode" hidden>
				<label class="switch"><input type="checkbox" name="extra-value" onchange="submit();" 
					'.(isset($_SESSION['extra-config_nightMode']) ? 'checked' : '').'>
				<span class="slider"></span></label>
			</form></div></div>';

		if(isset($_POST['EXTRA_CHANGE'])){
			$extraName = $_POST['extra-name'];
			$extraValue = isset($_POST['extra-value']) ? $_POST['extra-value'] : false;

			echo '<div id="form2">Efetuando Mudanças..</div>';

			if($extraValue){
				$_SESSION[$extraName] = $extraValue;
			}else{
				unset($_SESSION[$extraName]);
			}

			echo '<script>setTimeout(function(){ window.location = window.location}, 200)</script>';
		}
	?>
	</div>

</main>
<?php include('cpanel_footer.php'); ?>
</body>
</html>