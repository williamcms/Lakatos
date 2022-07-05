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
				<form method="POST" id="MANAGE_FEATURES">
					<input type="text" name="OPEN_FEATURES_DIALOG" hidden />
					<a href="#" class="button2 card_button-add" onclick="$('#MANAGE_FEATURES').submit();" />
						<span>Gerênciar Features</span>
					</a>
				</form>
			</div>
			<div class="col-auto">
				<form method="POST" id="NEW_MACHINE">
					<input type="text" name="ADD_MACHINE" hidden />
					<a href="#" class="button2 card_button-add" onclick="$('#NEW_MACHINE').submit();" />
						<span>Nova Máquina</span>
					</a>
				</form>
			</div>
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
					<div class="buttonsContainer">
						<button class="closebtn smallbtn" name="REMOVE_MACHINE" value="'.$row[$i]['mac_id'].'">
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
				if($stmt2 = $conn->link->prepare("SELECT * FROM applications")){
					try{
						$stmt2->execute();
						$applications = get_result($stmt2);
					}
					catch(Exception $e){
						throw new Exception('Erro ao conectar com a base de dados: '. $e);
					}
				}
				if($stmt3 = $conn->link->prepare("SELECT * FROM machine_applications WHERE mac_id = ?")){
					try{
						$stmt3->bind_param('i', $mac_id);
						$stmt3->execute();
						$mac_ap = get_result($stmt3);
						$ap_ids = array_map(function($value){return $value['ap_id'];}, $mac_ap);
					}
					catch(Exception $e){
						throw new Exception('Erro ao conectar com a base de dados: '. $e);
					}
				}

				echo '<div class="overlayform" id="form1"><div class="modalform"><div class="modaldados">
				<button class="closebtn" onclick="formOff(1);" aria-label="Fechar Janela">&times;</button>
				<form method="POST" id="form">
					<h2 class="text-center">Editar Máquina</h2>
					<div class="form-group"><label>Id da máquina <span class="text-muted">(não editável)</span></label>
						<input type="text" name="mac_id" value="'.$row[0]['mac_id'].'" readonly />
					</div>
					<div class="form-group"><label>Nome da máquina</label>
						<input type="text" class="nosymbolinput" data-copy="mac_pagename" name="mac_name" value="'.$row[0]['mac_name'].'" required/>
					</div>
					<div class="form-group"><label>Nome no Link</label> <span class="text-muted">(gerado com base no nome acima)</span>
						<input type="text" name="mac_pagename" value="'.$row[0]['mac_pagename'].'" readonly />
					</div>
					<div class="form-group"><label>Imagem</label>
						<input type="text" name="mac_image" value="'.$row[0]['mac_image'].'" required/>
					</div>
					<div class="form-group"><label>Imagem de Sobreposição</label>
						<input type="text" name="mac_image_hover" value="'.$row[0]['mac_image_hover'].'" />
					</div>

					<div class="form-group"><label>Descrição Curta</label>
						<textarea name="mac_short_desc" class="summernote" maxlength="390">'.$row[0]['mac_short_desc'].'</textarea>
					</div>
					<div class="form-group"><label>Descrição Completa</label>
						<textarea name="mac_desc" class="summernote" maxlength="9990">'.$row[0]['mac_desc'].'</textarea>
					</div>

					<div class="form-group"><label>Feature 1</label>
						<input type="text" name="mac_feature1" value="'.$row[0]['mac_feature1'].'" />
					</div>
					<div class="form-group"><label>Feature 2</label>
						<input type="text" name="mac_feature2" value="'.$row[0]['mac_feature2'].'" />
					</div>
					<div class="form-group"><label>Feature 3</label>
						<input type="text" name="mac_feature3" value="'.$row[0]['mac_feature3'].'" />
					</div>
					<div class="form-group"><label>Feature Extendida 1</label>
						<input type="text" name="mac_feature_extended1" value="'.$row[0]['mac_feature_extended1'].'" />
					</div>
					<div class="form-group"><label>Feature Extendida 2</label>
						<input type="text" name="mac_feature_extended2" value="'.$row[0]['mac_feature_extended2'].'" />
					</div>
					<div class="form-group"><label>Feature Extendida 3</label>
						<input type="text" name="mac_feature_extended3" value="'.$row[0]['mac_feature_extended3'].'" />
					</div>
					<div class="form-group"><label>Linha de máquinas</label>
						<input type="text" name="mac_series" value="'.$row[0]['mac_series'].'" />
					</div>
					<div class="form-group"><label>Aplicações</label><div class="link-listage">';

					for($j = 0; $j < $stmt2->num_rows; $j++){
						echo '<div class="item">
								<img src="'.$applications[$j]['ap_image'].'" />
								<input type="checkbox" name="mac_ap_link[]" id="ap'.$applications[$j]['ap_id'].'" class="d-none" value="'.$applications[$j]['ap_id'].'" '.(in_array($applications[$j]['ap_id'], $ap_ids) ? 'checked=""' : '').'" />
								<label for="ap'.$applications[$j]['ap_id'].'">'.$applications[$j]['ap_name'].'</label></div>';
					}
					
					echo '</div></div>
					<div class="form-group"><label>Ativo? Isto afetara a visibilidade deste item no site. <span id="range_input_value">'.$row[0]['mac_active'].'</span>/1</label><input type="range" min="0" max="1" value="'.$row[0]['mac_active'].'" name="mac_active" id="range_input" /></div>

					
					<button class="button" style="background-color: var(--green); color: var(--white);" name="CONFIRM_MACHINE_EDIT"><span>Confirmar</span></button>
				</form></div></div></div>';
				echo '<script>formOn(1);</script>';
			}
		}
		if(isset($_POST['CONFIRM_MACHINE_EDIT'])){

			$conn->link = $conn->connect();
			if($stmt = $conn->link->prepare("UPDATE machines SET mac_name = ?, mac_pagename = ?, mac_image = ?, mac_image_hover = ?, mac_desc = ?, mac_short_desc = ?, mac_active = ? WHERE mac_id = ?")){

				try{
					$stmt->bind_param('ssssssii', $mac_name, $mac_pagename, $mac_image, $mac_image_hover, $mac_desc, $mac_short_desc, $mac_active, $mac_id);
					$mac_name = $_POST['mac_name'];
					$mac_pagename = $_POST['mac_pagename'];
					$mac_image = $_POST['mac_image'];
					$mac_image_hover = $_POST['mac_image_hover'];
					$mac_short_desc = $_POST['mac_short_desc'];
					$mac_short_desc = str_replace("&quot;", "'", $mac_short_desc);
					$mac_desc = $_POST['mac_desc'];
					$mac_desc = str_replace("&quot;", "'", $mac_desc);
					$mac_active = $_POST['mac_active'];
					$mac_id = $_POST['mac_id'];

					$stmt->execute();

					if(isset($_POST['mac_ap_link'])){
						$mac_ap_ids = $_POST['mac_ap_link'];

						if($stmt2 = $conn->link->prepare("DELETE FROM machine_applications WHERE mac_id = ?")){
							$stmt2->bind_param('i', $mac_id);
							$stmt2->execute();
						}
						foreach($mac_ap_ids as $key => $value){
							if($stmt3 = $conn->link->prepare("INSERT INTO machine_applications(mac_id, ap_id) VALUES(?, ?)")){
								$stmt3->bind_param('ii', $mac_id, $value);
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
			$mac_id = stripslashes($_POST['CONFIRM_MACHINE_REM']);
			if($stmt = $conn->link->prepare("DELETE FROM machines WHERE mac_id = ?")){
				try{
					$stmt->bind_param('i', $mac_id);
					$stmt->execute();

					if($stmt2 = $conn->link->prepare("DELETE FROM machine_applications WHERE mac_id = ?")){
						$stmt2->bind_param('i', $mac_id);
						$stmt2->execute();
					}
				}
				catch(Exception $e){
					throw new Exception('Erro ao conectar com a base de dados: '. $e);
				}
				echo '<script>reload();</script>';
			}
		}
		
		if(isset($_POST['ADD_MACHINE'])){
			if($stmt = $conn->link->prepare("SELECT * FROM applications")){
				try{
					$stmt->execute();
					$applications = get_result($stmt);
				}
				catch(Exception $e){
					throw new Exception('Erro ao conectar com a base de dados: '. $e);
				}
			}

			echo '<div class="overlayform" id="form5"><div class="modalform"><div class="modaldados">
			<button class="closebtn" onclick="formOff(5);" aria-label="Fechar Janela">&times;</button>
			<form method="POST" id="form">
				<h2 class="text-center">Nova máquina</h2>
				<div class="form-group"><label>Nome da máquina</label>
					<input type="text" class="nosymbolinput" data-copy="mac_pagename" name="mac_name" required/>
				</div>
				<div class="form-group"><label>Nome no Link</label> <span class="text-muted">(gerado com base no nome acima)</span>
					<input type="text" name="mac_pagename" readonly />
				</div>
				<div class="form-group"><label>Imagem</label>
					<input type="text" name="mac_image" required/>
				</div>
				<div class="form-group"><label>Imagem de Sobreposição</label>
					<input type="text" name="mac_image_hover" />
				</div>

				<div class="form-group"><label>Descrição Curta</label>
					<textarea name="mac_short_desc" class="summernote" maxlength="390"></textarea>
				</div>
				<div class="form-group"><label>Descrição Completa</label>
					<textarea name="mac_desc" class="summernote" maxlength="9990"></textarea>
				</div>

				<div class="form-group"><label>Feature 1</label>
					<input type="text" name="mac_feature1" />
				</div>
				<div class="form-group"><label>Feature 2</label>
					<input type="text" name="mac_feature2" />
				</div>
				<div class="form-group"><label>Feature 3</label>
					<input type="text" name="mac_feature3" />
				</div>
				<div class="form-group"><label>Feature Extendida 1</label>
					<input type="text" name="mac_feature_extended1" />
				</div>
				<div class="form-group"><label>Feature Extendida 2</label>
					<input type="text" name="mac_feature_extended2" />
				</div>
				<div class="form-group"><label>Feature Extendida 3</label>
					<input type="text" name="mac_feature_extended3" />
				</div>
				<div class="form-group"><label>Linha de máquinas</label>
					<input type="text" name="mac_series" />
				</div>

				<div class="form-group"><label>Aplicações</label><div class="link-listage">';

					for($j = 0; $j < $stmt->num_rows; $j++){
						echo '<div class="item">
								<img src="'.$applications[$j]['ap_image'].'" />
								<input type="checkbox" name="mac_ap_link[]" id="ap'.$applications[$j]['ap_id'].'" class="d-none" value="'.$applications[$j]['ap_id'].'" />
								<label for="ap'.$applications[$j]['ap_id'].'">'.$applications[$j]['ap_name'].'</label></div>';
					}
					
					echo '</div></div>
				<div class="form-group"><label>Ativo? Isto afetara a visibilidade deste item no site</label> <span class="range_input_value">1</span>/1
					<input type="range" min="0" max="1" value="1" name="mac_active" class="range_input" />
				</div>

				
				<button class="button" style="background-color: var(--green); color: var(--white);" name="CONFIRM_MACHINE_ADD"><span>Confirmar</span></button>
			</form></div></div></div>';
			echo '<script>formOn(5);</script>';
		}
		if(isset($_POST['CONFIRM_MACHINE_ADD'])){


			$conn->link = $conn->connect();
			if($stmt = $conn->link->prepare("INSERT INTO machines (mac_name, mac_pagename, mac_image, mac_image_hover, mac_desc, mac_short_desc, mac_active) VALUES (?, ?, ?, ?, ?, ?, ?)")){

				try{
					$stmt->bind_param('ssssssi', $mac_name, $mac_pagename, $mac_image, $mac_image_hover, $mac_desc, $mac_short_desc, $mac_active);
					$mac_name = $_POST['mac_name'];
					$mac_pagename = $_POST['mac_pagename'];
					$mac_image = $_POST['mac_image'];
					$mac_image_hover = $_POST['mac_image_hover'];
					$mac_short_desc = $_POST['mac_short_desc'];
					$mac_short_desc = str_replace("&quot;", "'", $mac_short_desc);
					$mac_desc = $_POST['mac_desc'];
					$mac_desc = str_replace("&quot;", "'", $mac_desc);
					$mac_active = $_POST['mac_active'];

					$stmt->execute();

					$mac_ap_ids = $_POST['mac_ap_link'];
					$mac_id = $stmt->insert_id;
					foreach($mac_ap_ids as $key => $value){
						if($stmt3 = $conn->link->prepare("INSERT INTO machine_applications(mac_id, ap_id) VALUES(?, ?)")){
							$stmt3->bind_param('ii', $mac_id, $value);
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

		if(isset($_POST['OPEN_FEATURES_DIALOG'])){
			if($stmt = $conn->link->prepare("SELECT * FROM mac_features")){
				try{
					$stmt->execute();
					$row = get_result($stmt);
				}
				catch(Exception $e){
					throw new Exception('Erro ao conectar com a base de dados: '. $e);
				}
			}

			echo '<div class="overlayform" id="form6"><div class="modalform"><div class="modaldados">
					<button class="closebtn" onclick="formOff(6);" aria-label="Fechar Janela">&times;</button>
					<form method="POST" id="form">
						<button href="#" class="button2 btn-primary center" name="NEW_FEATURE" />
							<span>Nova Feature</span>
						</button>
						<div class="table-list text-center">
							<div class="col row w-100">
								<div class="col bold">Imagem</div>
								<div class="col bold">Título</div>
								<div class="col bold buttonsContainer">Ações</div>
							</div>';
			if($stmt->num_rows > 0){
				for($i = 0; $i < $stmt->num_rows; $i++){
					echo '<div class="col row w-100">
							<div class="col">
								<img src="'. constant('WEBSITE_ICON_NUMBER_'.$row[$i]['feat_image']) .'" />
							</div>
							<div class="col">
								'.$row[$i]['feat_name'].'
							</div>
							<div class="col buttonsContainer">
								<button class="editbtn smallbtn" name="EDIT_FEATURE" value="'.$row[$i]['feat_id'].'" title="Editar">
									<i class="far fa-edit"></i></button>
								<button class="closebtn smallbtn" name="REMOVE_FEATURE" value="'.$row[$i]['feat_id'].'">
									<i class="far fa-trash-alt"></i></button>
							</div>
						</div>';
				}
			}else{
				echo '<div class="box-msg error center pt-5">'.ERROR_QUERY_NORESULT.'</div>';
			}

			echo '</div></form></div></div></div> <script>formOn(6);</script>';
		}


	?>
	</div>
</main>
<?php include('cpanel_footer.php'); ?>
</body>
</html>