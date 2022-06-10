<?php 
include('cfg/core.php');
include('cfg/users_class.php');

$account->sessionLogin();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
	<title><?php echo $website->title; ?>: Máquinas</title>
	<?php require_once('header-cpainel.php'); ?>
</head>
<body>
	<?php include('hm_menu_cpanel.php'); ?>
<main class="machines">
	<h2 class="text-center pt-3">Gerenciamento de Máquinas</h2>
	<div class="card-box">
		<div class="row">
			<div class="col"><h4>Máquinas</h4></div>
			<div class="col">
				<form method="POST" id="NEW_MACHINE">
					<input type="text" name="ADD_MACHINE" hidden><a href="#" class="button2 card_button-add" onclick="$('#NEW_MACHINE').submit();">
					<span>Nova Máquina</span></a>
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
						$sqlOpt = 'mac_active';
						$opt0 = '&opt='. (!$opt ? 1 : 0);
						$optArrow0 = (!$opt ? $ASC : $DESC);
						$sqlOptOrder = (!$opt ? 'ASC' : 'DESC');
						break;
					default:
						$sqlOpt = 'mac_id';
						$sqlOptOrder = 'ASC';
						break;
				}

				if(isset($_GET['order'])){
					echo '<div class="col text-center"><div id="sortingOptions">Ordenar por | 
					<span class="option"><a href="?order=0'.$opt0.'">Ativo '.$optArrow0.'</a></span> | 
					<span class="option"><a href="cp-machines">Reset</a></span></div></div>';
				} else{
					echo '<div class="col text-center"><div id="sortingOptions">Ordenar por | 
					<span class="option"><a href="?order=0&opt=0">Ativo</a></span> | 
					<span class="option"><a href="cp-machines">Reset</a></span></div></div>';
				}
			?>
		</div>
	</div>
	<div class="row card-box-results">
	<?php
		$conn->link = $conn->connect();

		echo '<p class="text-muted" style="position: absolute; margin-top:-20px;">Ordenando por: '. $sqlOpt .' '. $sqlOptOrder .'</p>';

		if($stmt = $conn->link->prepare("SELECT * FROM machines ORDER BY ".$sqlOpt." ". $sqlOptOrder)){
			try{
				$stmt->execute();
				$row = get_result($stmt);
			}
			catch(Exception $e){
				throw new Exception('Erro ao conectar com a base de dados: '. $e);
			}

			if($stmt->num_rows > 0){
				for($i = 0; $i < $stmt->num_rows; $i++){
					($row[$i]['mac_active'] == 0 ? $NOTACTIVE = 'opacity: 0.7;' : $NOTACTIVE = '');
					echo '<div class="col card-result-body" style="'.$NOTACTIVE.'">
					<div class="card-result-top">
					<div class="card-result-title">'.$row[$i]['mac_name'].'</div>
					<form method="POST">
					<input name="mac_name" type="text" value="'.$row[$i]['mac_name'].'" hidden>
					<div class="buttonsContainer">
						<button class="closebtn smallbtn" name="REMOVE_MACHINE" value="'.$row[$i]['mac_id'].'" style="right: 35px;">
							<i class="far fa-trash-alt"></i></button>
						<button class="editbtn smallbtn" name="EDIT_MACHINE" value="'.$row[$i]['mac_id'].'" title="Editar">
							<i class="far fa-edit"></i></button>
					</div>
					</form></div>
					<hr><div class="card-result-content"><img src="'.$row[$i]['mac_image'].'" class="w-100" /></div></div>';
				}

			} else{
					echo '<div class="box-msg error">'.ERROR_QUERY_NORESULT.'</div>';
			}
		}

		if(isset($_POST['EDIT_MACHINE'])){

			$mac_id = $_POST['EDIT_MACHINE'];

			if($stmt = $conn->link->prepare("SELECT * FROM machines WHERE mac_id = ?")){
				try{
					$stmt->bind_param('i', $mac_id);
					$stmt->execute();
					$row = get_result($stmt);
				}
				catch(Exception $e){
					throw new Exception('Erro ao conectar com a base de dados: '. $e);
				}

				echo '<div class="overlayform" id="form1"><div class="modalform"><div class="modaldados">
				<button class="closebtn" onclick="formOff(1);" aria-label="Fechar Janela">&times;</button>
				<form method="POST" id="form">
					<h2 class="text-center">Editar Máquina</h2>
					<div class="form-group"><label>Id da máquina <span class="text-muted">(não editável)</span></label>
						<input type="text" name="mac_id" value="'.$row[0]['mac_id'].'" readonly></div>
					<div class="form-group"><label>Nome da máquina</label> <input type="text" name="mac_name" value="'.$row[0]['mac_name'].'" required></div>
					<div class="form-group"><label>Imagem</label><input type="text" name="mac_image" value="'.$row[0]['mac_image'].'" required></div>
					<div class="form-group"><label>Imagem de Sobreposição</label><input type="text" name="mac_image_hover" value="'.$row[0]['mac_image_hover'].'"></div>
					<div class="form-group"><label>Descrição Curta</label><textarea name="mac_short_desc" class="summernote" maxlength="390">'.$row[0]['mac_short_desc'].'</textarea></div>
					<div class="form-group"><label>Descrição Completa</label><textarea name="mac_desc" class="summernote" maxlength="9990">'.$row[0]['mac_desc'].'</textarea></div>
					<div class="form-group"><label>Aplicações</label><input type="text" name="mac_applications" value="'.$row[0]['mac_applications'].'"></div>
					<div class="form-group"><label>Ativo? Isto afetara a visibilidade desta máquina no site. <span id="range_input_value">'.$row[0]['mac_active'].'</span>/1</label><input type="range" min="0" max="1" value="'.$row[0]['mac_active'].'" name="mac_active" id="range_input"></div>

					
					<button class="button" style="background-color: var(--green); color: var(--white);" name="CONFIRM_MACHINE_EDIT"><span>Confirmar</span></button>
				</form></div></div></div>';
				echo '<script>formOn(1);</script>';
			}
		}
		if(isset($_POST['CONFIRM_MACHINE_EDIT'])){

			$conn->link = $conn->connect();
			if($stmt = $conn->link->prepare("UPDATE machines SET mac_name = ?, mac_image = ?, mac_image_hover = ?, mac_desc = ?, mac_short_desc = ?, mac_applications = ?, mac_active = ? WHERE mac_id = ?")){

				try{
					$stmt->bind_param('ssssssii', $mac_name, $mac_image, $mac_image_hover, $mac_desc, $mac_short_desc, $mac_applications, $mac_active, $mac_id);
					$mac_name = $_POST['mac_name'];
					$mac_image = $_POST['mac_image'];
					$mac_image_hover = $_POST['mac_image_hover'];
					$mac_short_desc = $_POST['mac_short_desc'];
					$mac_short_desc = str_replace("&quot;", "'", $mac_short_desc);
					$mac_desc = $_POST['mac_desc'];
					$mac_desc = str_replace("&quot;", "'", $mac_desc);
					$mac_applications = $_POST['mac_applications'];
					$mac_active = $_POST['mac_active'];
					$mac_id = $_POST['mac_id'];

					$stmt->execute();
				}
				catch(Exception $e){
					throw new Exception('Erro ao conectar com a base de dados: '. $e);
				}
				echo '<script>reload();</script>';
			}
		}
		if(isset($_POST['REMOVE_MACHINE'])){
			echo '<div class="overlayform" id="form3"><div class="modalform"><div class="modaldados text-center">
			<button aria-hidden="true" class="closebtn" onclick="formOff(3);" aria-label="Fechar Janela">&times;</button>
			<form method="POST">
				<h2>Tem certeza que quer remover a máquina abaixo?</h2>
				<h3 class="destaque">'.$_POST['mac_name'].' (id: '.$_POST['REMOVE_MACHINE'].')</h3><br>
				<button class="button" style="background-color: var(--danger); color: var(--white);" name="CONFIRM_MACHINE_REM" value="'.stripslashes($_POST['REMOVE_MACHINE']).'"><span>Confirmar</span></button>
			</form></div></div></div>';
			echo '<script>formOn(3);</script>';
		}
		if(isset($_POST['CONFIRM_MACHINE_REM'])){
			$conn->link = $conn->connect();
			if($stmt = $conn->link->prepare("DELETE FROM machines WHERE mac_id = ?")){
				try{
					$stmt->bind_param('i', stripslashes($_POST['CONFIRM_MACHINE_REM']));
					$stmt->execute();
				}
				catch(Exception $e){
					throw new Exception('Erro ao conectar com a base de dados: '. $e);
				}
				echo '<script>reload();</script>';
			}
		}

		if(isset($_POST['ADD_MACHINE'])){
			echo '<div class="overlayform" id="form5"><div class="modalform"><div class="modaldados">
			<button class="closebtn" onclick="formOff(5);" aria-label="Fechar Janela">&times;</button>
			<form method="POST" id="form">
				<h2 class="text-center">Nova máquina</h2>
				<div class="form-group"><label>Nome da máquina</label> <input type="text" name="mac_name" required></div>
				<div class="form-group"><label>Imagem</label><input type="text" name="mac_image" required></div>
				<div class="form-group"><label>Imagem de Sobreposição</label><input type="text" name="mac_image_hover"></div>
				<div class="form-group"><label>Descrição Curta</label><textarea name="mac_short_desc" class="summernote" maxlength="390"></textarea></div>
				<div class="form-group"><label>Descrição Completa</label><textarea name="mac_desc" class="summernote" maxlength="9990"></textarea></div>
				<div class="form-group"><label>Aplicações</label><input type="text" name="mac_applications"></div>
				<div class="form-group"><label>Ativo? Isto afetara a visibilidade deste parceiro no site</label> <span class="range_input_value">0</span>/1<input type="range" min="0" max="1" value="0" name="mac_active" class="range_input"></div>

				
				<button class="button" style="background-color: var(--green); color: var(--white);" name="CONFIRM_MACHINE_ADD"><span>Confirmar</span></button>
			</form></div></div></div>';
			echo '<script>formOn(5);</script>';
		}
		if(isset($_POST['CONFIRM_MACHINE_ADD'])){


			$conn->link = $conn->connect();
			if($stmt = $conn->link->prepare("INSERT INTO machines (mac_name, mac_image, mac_image_hover, mac_desc, mac_short_desc, mac_applications, mac_active) VALUES (?, ?, ?, ?, ?, ?, ?)")){

				try{
					$stmt->bind_param('ssssssi', $mac_name, $mac_image, $mac_image_hover, $mac_desc, $mac_short_desc, $mac_applications, $mac_active);
					$mac_name = $_POST['mac_name'];
					$mac_image = $_POST['mac_image'];
					$mac_image_hover = $_POST['mac_image_hover'];
					$mac_short_desc = $_POST['mac_short_desc'];
					$mac_short_desc = str_replace("&quot;", "'", $mac_short_desc);
					$mac_desc = $_POST['mac_desc'];
					$mac_desc = str_replace("&quot;", "'", $mac_desc);
					$mac_applications = $_POST['mac_applications'];
					$mac_active = $_POST['mac_active'];

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