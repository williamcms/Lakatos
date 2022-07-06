<?php 
include('cfg/core.php');
include('cfg/users_class.php');

$account->sessionLogin();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
	<title><?php echo $website->title; ?>: Ícones</title>
	<?php require_once('header-cpainel.php'); ?>
</head>
<body>
	<?php include('hm_menu_cpanel.php'); ?>
<main class="icons">
	<h2 class="text-center pt-3">Gerenciamento de Ícones</h2>
	<div class="card-box">
		<div class="row">
			<div class="col"><h4>Ícones</h4></div>
			<div class="col">
				<form method="POST" id="NEW_ICON">
					<input type="text" name="ADD_ICON" hidden><a href="#" class="button2 card_button-add" onclick="$('#NEW_ICON').submit();">
					<span>Novo Ícone</span></a>
				</form></div>
		</div>
		<div class="row">
			<?php 
				
				$option = stripslashes(isset($_GET['order']) ? $_GET['order'] : 'default');

				$ASC = '<i class="fas fa-sort-up"></i>';
				$DESC = '<i class="fas fa-sort-down"></i>';

				$opt0 = '&opt=0';
				$opt = stripslashes(isset($_GET['opt']) ? $_GET['opt'] : null);
				$optArrow1 = $optArrow0 = '';

				switch($option){
					case 0:
						$sqlOpt = 'icon_active';
						$opt0 = '&opt='. (!$opt ? 1 : 0);
						$optArrow0 = (!$opt ? $ASC : $DESC);
						$sqlOptOrder = (!$opt ? 'ASC' : 'DESC');
						break;
					default:
						$sqlOpt = 'icon_id';
						$sqlOptOrder = 'ASC';
						break;
				}

				if(isset($_GET['order'])){
					echo '<div class="col text-center"><div id="sortingOptions">Ordenar por | 
					<span class="option"><a href="?order=0'.$opt0.'">Ativo '.$optArrow0.'</a></span> | 
					<span class="option"><a href="cp-applications">Reset</a></span></div></div>';
				} else{
					echo '<div class="col text-center"><div id="sortingOptions">Ordenar por | 
					<span class="option"><a href="?order=0&opt=0">Ativo</a></span> | 
					<span class="option"><a href="cp-applications">Reset</a></span></div></div>';
				}
			?>
		</div>
	</div>
	<div class="row card-box-results">
	<?php
		$conn->link = $conn->connect();

		echo '<p class="text-muted" style="position: absolute; margin-top:-20px;">Ordenando por: '. $sqlOpt .' '. $sqlOptOrder .'</p>';

		if($stmt = $conn->link->prepare("SELECT * FROM icons ORDER BY ".$sqlOpt." ". $sqlOptOrder)){
			try{
				$stmt->execute();
				$row = get_result($stmt);
			}
			catch(Exception $e){
				throw new Exception('Erro ao conectar com a base de dados: '. $e);
			}

			if($stmt->num_rows > 0){
				for($i = 0; $i < $stmt->num_rows; $i++){
					($row[$i]['icon_active'] == 0 ? $NOTACTIVE = 'opacity: 0.7;' : $NOTACTIVE = '');
					echo '<div class="col card-result-body" style="'.$NOTACTIVE.'">
					<div class="card-result-top">
					<div class="card-result-title">'.$row[$i]['icon_name'].'</div>
					<form method="POST">
					<input name="icon_name" type="text" value="'.$row[$i]['icon_name'].'" hidden>
					<div class="buttonsContainer">
						<button class="closebtn smallbtn" name="REMOVE_ICON" value="'.$row[$i]['icon_id'].'" style="right: 35px;">
							<i class="far fa-trash-alt"></i></button>
						<button class="editbtn smallbtn" name="EDIT_ICON" value="'.$row[$i]['icon_id'].'" title="Editar">
							<i class="far fa-edit"></i></button>
					</div>
					</form></div>
					<hr><div class="card-result-content"><img src="'.$row[$i]['icon_image'].'" class="image" /></div></div>';
				}
			}else{
				echo '<div class="box-msg error">'.ERROR_QUERY_NORESULT.'</div>';
			}
		}

		if(isset($_POST['EDIT_ICON'])){
			
			$icon_id = $_POST['EDIT_ICON'];

			if($stmt = $conn->link->prepare("SELECT * FROM icons WHERE icon_id = ?")){
				try{
					$stmt->bind_param('i', $icon_id);
					$stmt->execute();
					$row = get_result($stmt);
				}
				catch(Exception $e){
					throw new Exception('Erro ao conectar com a base de dados: '. $e);
				}

				echo '<div class="overlayform" id="form1"><div class="modalform"><div class="modaldados">
				<button class="closebtn" onclick="formOff(1);" aria-label="Fechar Janela">&times;</button>
				<form method="POST" id="form">
					<h2 class="text-center">Editar aplicação</h2>
					<div class="form-group"><label>Id do ícone <span class="text-muted">(não editável)</span></label> <input type="text" name="icon_id" value="'.$row[0]['icon_id'].'" readonly></div>
					<div class="form-group"><label>Nome do ícone</label> <input type="text" name="icon_name" value="'.$row[0]['icon_name'].'" required></div>
					<div class="form-group"><label>Ícone</label><input type="text" name="icon_image" value="'.$row[0]['icon_image'].'" required></div>
					<div class="form-group"><label>Ativo? Isto afetara a visibilidade deste item no site. <span id="range_input_value">'.$row[0]['icon_active'].'</span>/1</label><input type="range" min="0" max="1" value="'.$row[0]['icon_active'].'" name="icon_active" id="range_input"></div>

					
					<button class="button btn-green" name="CONFIRM_ICON_EDIT"><span>Confirmar</span></button>
				</form></div></div></div>';
				echo '<script>formOn(1);</script>';
			}
		}
		if(isset($_POST['CONFIRM_ICON_EDIT'])){

			$conn->link = $conn->connect();
			if($stmt = $conn->link->prepare("UPDATE icons SET icon_name = ?, icon_image = ?, icon_active = ? WHERE icon_id = ?")){

				try{
					$stmt->bind_param('ssii', $icon_name, $icon_image, $icon_active, $icon_id);
					$icon_name = $_POST['icon_name'];
					$icon_image = $_POST['icon_image'];
					$icon_active = $_POST['icon_active'];
					$icon_id = $_POST['icon_id'];

					$stmt->execute();
				}
				catch(Exception $e){
					throw new Exception('Erro ao conectar com a base de dados: '. $e);
				}
				echo '<script>reload();</script>';
			}
		}
		if(isset($_POST['REMOVE_ICON'])){
			echo '<div class="overlayform" id="form3"><div class="modalform"><div class="modaldados text-center">
			<button aria-hidden="true" class="closebtn" onclick="formOff(3);" aria-label="Fechar Janela">&times;</button>
			<form method="POST">
				<h2>Tem certeza que quer remover o ícone abaixo?</h2>
				<h3 class="destaque">'.$_POST['icon_name'].' (id: '.$_POST['REMOVE_ICON'].')</h3>
				<p class="text-muted">Isso forá com que itens que utilizem esse ícone possam se comportar de maneira imprevisível.</p>
				<p class="text-muted">Apague conexões/troque existentes, caso ainda não tenha feito!</p><br>
				<button class="button btn-red" name="CONFIRM_ICON_REM" value="'.stripslashes($_POST['REMOVE_ICON']).'"><span>Confirmar</span></button>
			</form></div></div></div>';
			echo '<script>formOn(3);</script>';
		}
		if(isset($_POST['CONFIRM_ICON_REM'])){
			$conn->link = $conn->connect();
			$icon_id = stripslashes($_POST['CONFIRM_ICON_REM']);
			if($stmt = $conn->link->prepare("DELETE FROM ap_included WHERE icon_id = ?")){
				try{
					$stmt->bind_param('i', $icon_id);
					$stmt->execute();
				}
				catch(Exception $e){
					throw new Exception('Erro ao conectar com a base de dados: '. $e);
				}
				echo '<script>reload();</script>';
			}
		}

		if(isset($_POST['ADD_ICON'])){
			echo '<div class="overlayform" id="form5"><div class="modalform"><div class="modaldados">
			<button class="closebtn" onclick="formOff(5);" aria-label="Fechar Janela">&times;</button>
			<form method="POST" id="form">
				<h2 class="text-center">Novo ícone</h2>
				<div class="form-group"><label>Nome do ícone</label> <input type="text" name="icon_name" required></div>
				<div class="form-group"><label>Ícone</label><input type="text" name="icon_image" required></div>
				<div class="form-group"><label>Ativo? Isto afetara a visibilidade deste item no site</label> <span class="range_input_value">1</span>/1<input type="range" min="0" max="1" value="1" name="icon_active" class="range_input"></div>

				
				<button class="button btn-green" name="CONFIRM_ICON_ADD"><span>Confirmar</span></button>
			</form></div></div></div>';
			echo '<script>formOn(5);</script>';
		}
		if(isset($_POST['CONFIRM_ICON_ADD'])){


			$conn->link = $conn->connect();
			if($stmt = $conn->link->prepare("INSERT INTO icons (icon_name, icon_image, icon_active) VALUES (?, ?, ?)")){

				try{
					$stmt->bind_param('ssi', $icon_name, $icon_image, $icon_active);
					$icon_name = $_POST['icon_name'];
					$icon_image = $_POST['icon_image'];
					$icon_active = $_POST['icon_active'];
					
					$stmt->execute();
				}
				catch(Exception $e){
					throw new Exception('Erro ao conectar com a base de dados: '. $e);
				}
				echo '<script>reload();</script>';
			}
		}


	?>
	</div>
</main>
<?php include('cpanel_footer.php'); ?>
</body>
</html>