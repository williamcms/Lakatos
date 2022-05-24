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
	<h2 class="text-center pt-3">Personalizações e informações da conta</h2>
	<div class="card-box">
		
	<?php
		ini_set('error_reporting', E_ALL ^ E_WARNING);

		echo '<div class="row">
			<div class="col"><h4>Modo Noturno</h4></div>
			<div class="col"><form method="POST">
				<input type="text" name="EXTRA_CHANGE" hidden>
				<input type="text" name="extra-name" value="extra-config_nightMode" hidden>
				<label class="switch"><input type="checkbox" name="extra-value" onchange="submit();" 
					'.(isset($_SESSION['extra-config_nightMode']) ? 'checked' : '').'>
				<span class="slider"></span></label>
			</form></div></div>';

		echo '<div class="row">
			<div class="col"><h4>Retrair Menu</h4></div>
			<div class="col"><form method="POST">
				<input type="text" name="EXTRA_CHANGE" hidden>
				<input type="text" name="extra-name" value="extra-config_collapse" hidden>
				<label class="switch"><input type="checkbox" name="extra-value" onchange="submit();" 
					'.(isset($_SESSION['extra-config_collapse']) ? 'checked' : '').'>
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

			echo '<script>setTimeout(function(){ window.location = window.location.href.split("?")[0]; }, 200)</script>';
		}
	?>
	</div>

	<div class="card-box">
	<h4>Seus logins</h4>
	<?php

		$conn->link = $conn->connect();
		$id = $account->myId();

		if($stmt = $conn->link->prepare("SELECT * FROM users_sessions WHERE user_id = ?")){
			try{
				$stmt->bind_param('i', $id);
				$stmt->execute();

				$row = get_result($stmt);
			}catch(Exception $e){
				throw new Exception('Erro ao conectar com a base de dados: '. $e);
			}

			if($stmt->num_rows > 0){
				for($i = 0; $i < $stmt->num_rows; $i++){
					echo '<div class="card-box row">';
					echo '<div class="col pb-2">';
					echo '<div class="row">';
					echo '<p class="col-auto">Navegador: ' .$row[$i]['user_browser']. '</p>';
					echo '<p class="col-auto">Último login: ' .$row[$i]['login_time']. '</p>';
					echo '<p class="col-auto">Sistema: ' .$row[$i]['user_OS']. '</p>';
					echo '</div>';
					echo '<details><summary>Ver mais</summary><p class="text-muted">' .$row[$i]['user_agent']. '</p></details>';
					echo '</div>';
					echo '<div class="row col-auto pb-2">';
					echo (session_id() == $row[$i]['session_id'] ? '<p class="box-msg success">Esta sessão</p>' : '<p class="box-msg error">Remover</p>');
					echo '</div></div>';
				}
			}else{
				echo '<div class="box-msg error center">'.ERROR_QUERY_NORESULT.'</div>';
			}
		}
	?>
	</div>

</main>
<?php include('cpanel_footer.php'); ?>
</body>
</html>