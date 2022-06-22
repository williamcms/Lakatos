<?php 
include('cfg/core.php');
include('cfg/users_class.php');

$account->sessionLogin();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
	<title><?php echo $website->title; ?>: Aplicações</title>
	<?php require_once('header-cpainel.php'); ?>
</head>
<body>
	<?php include('hm_menu_cpanel.php'); ?>
<main class="applications">
	<h2 class="text-center pt-3">Gerenciamento de Aplicações de máquinas</h2>
	<div class="card-box">
		<div class="row">
			<div class="col"><h4>Aplicações</h4></div>
			<div class="col">
				<form method="POST" id="NEW_APPLICATION">
					<input type="text" name="ADD_APPLICATION" hidden><a href="#" class="button2 card_button-add" onclick="$('#NEW_APPLICATION').submit();">
					<span>Nova Aplicação</span></a>
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
						$sqlOpt = 'ap_active';
						$opt0 = '&opt='. (!$opt ? 1 : 0);
						$optArrow0 = (!$opt ? $ASC : $DESC);
						$sqlOptOrder = (!$opt ? 'ASC' : 'DESC');
						break;
					default:
						$sqlOpt = 'ap_id';
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

		if($stmt = $conn->link->prepare("SELECT * FROM applications ORDER BY ".$sqlOpt." ". $sqlOptOrder)){
			try{
				$stmt->execute();
				$row = get_result($stmt);
			}
			catch(Exception $e){
				throw new Exception('Erro ao conectar com a base de dados: '. $e);
			}

			if($stmt->num_rows > 0){
				for($i = 0; $i < $stmt->num_rows; $i++){
					($row[$i]['ap_active'] == 0 ? $NOTACTIVE = 'opacity: 0.7;' : $NOTACTIVE = '');
					echo '<div class="col card-result-body" style="'.$NOTACTIVE.'">
					<div class="card-result-top">
					<div class="card-result-title">'.$row[$i]['ap_name'].'</div>
					<form method="POST">
					<input name="ap_name" type="text" value="'.$row[$i]['ap_name'].'" hidden>
					<div class="buttonsContainer">
						<button class="closebtn smallbtn" name="REMOVE_APPLICATION" value="'.$row[$i]['ap_id'].'" style="right: 35px;">
							<i class="far fa-trash-alt"></i></button>
						<button class="editbtn smallbtn" name="EDIT_APPLICATION" value="'.$row[$i]['ap_id'].'" title="Editar">
							<i class="far fa-edit"></i></button>
					</div>
					</form></div>
					<hr><div class="card-result-content"><img src="'.$row[$i]['ap_image'].'" class="w-100" /></div></div>';
				}
			}else{
				echo '<div class="box-msg error">'.ERROR_QUERY_NORESULT.'</div>';
			}
		}

		if(isset($_POST['EDIT_APPLICATION'])){
			
			$ap_id = $_POST['EDIT_APPLICATION'];

			if($stmt = $conn->link->prepare("SELECT * FROM applications WHERE ap_id = ?")){
				try{
					$stmt->bind_param('i', $ap_id);
					$stmt->execute();
					$row = get_result($stmt);
				}
				catch(Exception $e){
					throw new Exception('Erro ao conectar com a base de dados: '. $e);
				}
				if($stmt2 = $conn->link->prepare("SELECT * FROM icons")){
					try{
						$stmt2->execute();
						$icons = get_result($stmt2);
					}
					catch(Exception $e){
						throw new Exception('Erro ao conectar com a base de dados: '. $e);
					}
				}
				if($stmt3 = $conn->link->prepare("SELECT * FROM machines")){
					try{
						$stmt3->execute();
						$machines = get_result($stmt3);
					}
					catch(Exception $e){
						throw new Exception('Erro ao conectar com a base de dados: '. $e);
					}
				}
				if($stmt4 = $conn->link->prepare("SELECT A.* FROM machines A INNER JOIN machine_applications B ON A.mac_id = B.mac_id where B.ap_id = ?")){
					try{
						$stmt4->bind_param('i', $ap_id);
						$stmt4->execute();
						$mac_ap = get_result($stmt4);
						$mac_ids = array_map(function($value){return $value['mac_id'];}, $mac_ap);
					}
					catch(Exception $e){
						throw new Exception('Erro ao conectar com a base de dados: '. $e);
					}
				}
				echo '<div class="overlayform" id="form1"><div class="modalform"><div class="modaldados">
				<button class="closebtn" onclick="formOff(1);" aria-label="Fechar Janela">&times;</button>
				<form method="POST" id="form">
					<h2 class="text-center">Editar aplicação</h2>
					<div class="form-group"><label>Id da Aplicação <span class="text-muted">(não editável)</span></label> <input type="text" name="ap_id" value="'.$row[0]['ap_id'].'" readonly></div>
					<div class="form-group"><label>Nome da Aplicação</label> <input type="text" name="ap_name" value="'.$row[0]['ap_name'].'" required></div>
					<div class="form-group"><label>Ícone</label>
						<div class="input-group icon-selector-group">
							<div class="input-group-text"><img src="./uploads/icons/applications_icon_0.png" /></div>
							<select name="ap_icon" class="input-group-append icon-selector">
								<option data-image="./uploads/icons/applications_icon_0.png">Nenhum selecionado</option>';
					
					for($i = 0; $i < $stmt2->num_rows; $i++){
						echo '<option value="'.$icons[$i]['icon_id'].'" data-image="'.$icons[$i]['icon_image'].'" '.($row[0]['ap_icon'] == $icons[$i]['icon_id'] ? 'selected': '').'>'.$icons[$i]['icon_name'].'</option>';
					}
					echo '</select></div></div>
					<div class="form-group"><label>Imagem</label><input type="text" name="ap_image" value="'.$row[0]['ap_image'].'" required></div>
					<div class="form-group"><label>Descrição</label><textarea name="ap_desc" class="summernote">'.$row[0]['ap_desc'].'</textarea></div>
					<div class="form-group"><label>Máquinas em que está</label><div class="link-listage d-flex">';

					for($j = 0; $j < $stmt3->num_rows; $j++){
						echo '<div class="item">
								<img src="'.$machines[$j]['mac_image'].'" />
								<input type="checkbox" name="mac_ap_link[]" id="mac'.$machines[$j]['mac_id'].'" class="d-none" value="'.$machines[$j]['mac_id'].'" '.(in_array($machines[$j]['mac_id'], $mac_ids) ? 'checked=""' : '').'"/>
								<label for="mac'.$machines[$j]['mac_id'].'">'.$machines[$j]['mac_name'].'</label></div>';
					}
					
					echo '</div></div>
					<div class="form-group"><label>Ativo? Isto afetara a visibilidade deste aplicação no site. <span id="range_input_value">'.$row[0]['ap_active'].'</span>/1</label><input type="range" min="0" max="1" value="'.$row[0]['ap_active'].'" name="ap_active" id="range_input"></div>

					
					<button class="button" style="background-color: var(--green); color: var(--white);" name="CONFIRM_APPLICATION_EDIT"><span>Confirmar</span></button>
				</form></div></div></div>';
				echo '<script>formOn(1);</script>';
			}
		}
		if(isset($_POST['CONFIRM_APPLICATION_EDIT'])){

			$conn->link = $conn->connect();
			if($stmt = $conn->link->prepare("UPDATE applications SET ap_icon = ?, ap_name = ?, ap_image = ?, ap_desc = ?, ap_active = ? WHERE ap_id = ?")){

				try{
					$stmt->bind_param('ssssii', $ap_icon, $ap_name, $ap_image, $ap_desc, $ap_active, $ap_id);
					$ap_name = $_POST['ap_name'];
					$ap_icon = $_POST['ap_icon'];
					$ap_image = $_POST['ap_image'];
					$ap_desc = $_POST['ap_desc'];
					$ap_desc = str_replace("&quot;", "'", $ap_desc);
					$ap_active = $_POST['ap_active'];
					$ap_id = $_POST['ap_id'];

					$stmt->execute();

					$ap_id = $_POST['ap_id'];
					if(isset($_POST['mac_ap_link'])){
						$mac_ap_ids = $_POST['mac_ap_link'];

						if($stmt2 = $conn->link->prepare("DELETE FROM machine_applications WHERE ap_id = ?")){
							$stmt2->bind_param('i', $ap_id);
							$stmt2->execute();
						}
						foreach($mac_ap_ids as $key => $value){
							if($stmt3 = $conn->link->prepare("INSERT INTO machine_applications(mac_id, ap_id) VALUES(?, ?)")){
								$stmt3->bind_param('ii', $value, $ap_id);
								$stmt3->execute();
							}
						}
					}
				}
				catch(Exception $e){
					throw new Exception('Erro ao conectar com a base de dados: '. $e);
				}
				echo '<script>reload();</script>';
			}
		}
		if(isset($_POST['REMOVE_APPLICATION'])){
			echo '<div class="overlayform" id="form3"><div class="modalform"><div class="modaldados text-center">
			<button aria-hidden="true" class="closebtn" onclick="formOff(3);" aria-label="Fechar Janela">&times;</button>
			<form method="POST">
				<h2>Tem certeza que quer remover a Aplicação abaixo?</h2>
				<h3 class="destaque">'.$_POST['ap_name'].' (id: '.$_POST['REMOVE_APPLICATION'].')</h3><br>
				<button class="button" style="background-color: var(--danger); color: var(--white);" name="CONFIRM_APPLICATION_REM" value="'.stripslashes($_POST['REMOVE_APPLICATION']).'"><span>Confirmar</span></button>
			</form></div></div></div>';
			echo '<script>formOn(3);</script>';
		}
		if(isset($_POST['CONFIRM_APPLICATION_REM'])){
			$conn->link = $conn->connect();
			$ap_id = stripslashes($_POST['CONFIRM_APPLICATION_REM']);
			if($stmt = $conn->link->prepare("DELETE FROM applications WHERE ap_id = ?")){
				try{
					$stmt->bind_param('i', $ap_id);
					$stmt->execute();
				}
				catch(Exception $e){
					throw new Exception('Erro ao conectar com a base de dados: '. $e);
				}
				echo '<script>reload();</script>';
			}
		}

		if(isset($_POST['ADD_APPLICATION'])){
			if($stmt = $conn->link->prepare("SELECT * FROM icons")){
				try{
					$stmt->execute();
					$icons = get_result($stmt);
				}
				catch(Exception $e){
					throw new Exception('Erro ao conectar com a base de dados: '. $e);
				}
			}
			if($stmt2 = $conn->link->prepare("SELECT * FROM machines")){
				try{
					$stmt2->execute();
					$machines = get_result($stmt2);
				}
				catch(Exception $e){
					throw new Exception('Erro ao conectar com a base de dados: '. $e);
				}
			}
			echo '<div class="overlayform" id="form5"><div class="modalform"><div class="modaldados">
			<button class="closebtn" onclick="formOff(5);" aria-label="Fechar Janela">&times;</button>
			<form method="POST" id="form">
				<h2 class="text-center">Nova Aplicação</h2>
				<div class="form-group"><label>Nome da Aplicação</label> <input type="text" name="ap_name" required></div>
				<div class="form-group"><label>Ícone</label>
						<div class="input-group icon-selector-group">
							<div class="input-group-text"><img src="./uploads/icons/applications_icon_0.png" /></div>
							<select name="ap_icon" class="input-group-append icon-selector">
								<option data-image="./uploads/icons/applications_icon_0.png">Nenhum selecionado</option>';
					
					for($i = 0; $i < $stmt2->num_rows; $i++){
						echo '<option value="'.$icons[$i]['icon_id'].'" data-image="'.$icons[$i]['icon_image'].'">'.$icons[$i]['icon_name'].'</option>';
					}
					echo '</select></div></div>
				<div class="form-group"><label>Imagem</label><input type="text" name="ap_image" required></div>
				<div class="form-group"><label>Descrição</label><textarea name="ap_desc" class="summernote"></textarea></div>
				<div class="form-group"><label>Máquinas em que está</label><div class="link-listage d-flex">';

					for($j = 0; $j < $stmt2->num_rows; $j++){
						echo '<div class="item">
								<img src="'.$machines[$j]['mac_image'].'" />
								<input type="checkbox" name="mac_ap_link[]" id="mac'.$machines[$j]['mac_id'].'" class="d-none" value="'.$machines[$j]['mac_id'].'" />
								<label for="mac'.$machines[$j]['mac_id'].'">'.$machines[$j]['mac_name'].'</label></div>';
					}
					
					echo '</div></div>
				<div class="form-group"><label>Ativo? Isto afetara a visibilidade deste aplicação no site</label> <span class="range_input_value">1</span>/1<input type="range" min="0" max="1" value="1" name="ap_active" class="range_input"></div>

				
				<button class="button" style="background-color: var(--green); color: var(--white);" name="CONFIRM_APPLICATION_ADD"><span>Confirmar</span></button>
			</form></div></div></div>';
			echo '<script>formOn(5);</script>';
		}
		if(isset($_POST['CONFIRM_APPLICATION_ADD'])){

			$conn->link = $conn->connect();

			if($stmt = $conn->link->prepare("INSERT INTO applications (ap_name, ap_icon, ap_image, ap_desc, ap_active) VALUES (?, ?, ?, ?, ?)")){
				try{
					$stmt->bind_param('ssssi', $ap_name, $ap_icon, $ap_image, $ap_desc, $ap_active);
					$ap_name = $_POST['ap_name'];
					$ap_icon = $_POST['ap_icon'];
					$ap_image = $_POST['ap_image'];
					$ap_desc = $_POST['ap_desc'];
					$ap_desc = str_replace("&quot;", "'", $ap_desc);
					$ap_active = $_POST['ap_active'];
					
					$stmt->execute();

					$mac_ap_ids = $_POST['mac_ap_link'];
					foreach($mac_ap_ids as $key => $value){
						if($stmt3 = $conn->link->prepare("INSERT INTO machine_applications(mac_id, ap_id) VALUES(?, ?)")){
							$stmt3->bind_param('ii', $value, $ap_id);
							$stmt3->execute();
						}
					}
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