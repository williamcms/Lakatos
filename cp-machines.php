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

				$opt0 = $opt1 = $opt2 = '&opt=0';
				$opt = stripslashes(isset($_GET['opt']) ? $_GET['opt'] : null);
				$optArrow2 = $optArrow1 = $optArrow0 = '';

				switch($option){
					case 0:
						$sqlOpt = 'mac_active';
						$opt0 = '&opt='. (!$opt ? 1 : 0);
						$optArrow0 = (!$opt ? $ASC : $DESC);
						$sqlOptOrder = (!$opt ? 'ASC' : 'DESC');
						break;
					case 1:
						$sqlOpt = 'mac_name';
						$opt1 = '&opt='. (!$opt ? 1 : 0);
						$optArrow1 = (!$opt ? $ASC : $DESC);
						$sqlOptOrder = (!$opt ? 'ASC' : 'DESC');
						break;
					case 2:
						$sqlOpt = 'mac_series';
						$opt2 = '&opt='. (!$opt ? 1 : 0);
						$optArrow2 = (!$opt ? $ASC : $DESC);
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
					<span class="option"><a href="?order=1'.$opt1.'">Nome '.$optArrow1.'</a></span> | 
					<span class="option"><a href="?order=2'.$opt2.'">Série '.$optArrow2.'</a></span> | 
					<span class="option"><a href="cp-machines">Reset</a></span></div></div>';
				} else{
					echo '<div class="col text-center"><div id="sortingOptions">Ordenar por | 
					<span class="option"><a href="?order=0&opt=0">Ativo</a></span> | 
					<span class="option"><a href="?order=1&opt=1">Nome</a></span> | 
					<span class="option"><a href="?order=2&opt=2">Série</a></span> | 
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
					<input type="text" name="mac_name" value="'.$row[$i]['mac_name'].'" hidden/>
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
				if($stmt4 = $conn->link->prepare("SELECT * FROM features")){
					try{
						$stmt4->execute();
						$features = get_result($stmt4);
					}
					catch(Exception $e){
						throw new Exception('Erro ao conectar com a base de dados: '. $e);
					}
				}
				if($stmt5 = $conn->link->prepare("SELECT * FROM machine_features WHERE mac_id = ? ORDER BY mf_id ASC")){
					try{
						$stmt5->bind_param('i', $mac_id);
						$stmt5->execute();
						$selectedFeatures = get_result($stmt5);
					}
					catch(Exception $e){
						throw new Exception('Erro ao conectar com a base de dados: '. $e);
					}
				}

				echo '<div class="overlayform" id="form1"><div class="modalform"><div class="modaldados">
				<button class="closebtn" onclick="formOff(1);" aria-label="Fechar Janela">&times;</button>
				<form method="POST">
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
					</div>';

					$maxFeatures = 6;
					for($j = 0; $j < $maxFeatures; $j++){
						echo '<div class="form-group"><label>Feature '.($j + 1).'</label>
								<div class="input-group icon-selector-group">
									<div class="input-group-text"><img src="./uploads/icons/applications_icon_0.png" /></div>
									<select name="mac_feature[]" class="input-group-append icon-selector">
										<option data-image="./uploads/icons/applications_icon_0.png">Nenhum selecionado</option>';
							
							for($i = 0; $i < $stmt4->num_rows; $i++){
								echo '<option value="'.$features[$i]['feat_id'].'" data-image="'.constant('WEBSITE_ICON_NUMBER_'.$features[$i]['feat_image']).'" '.($features[$i]['feat_id'] == $selectedFeatures[$j]['feat_id'] ? 'selected': '').'>
									'.$features[$i]['feat_name'].'</option>';
							}
						echo '</select></div></div>';
					}

										
					echo '<div class="form-group"><label>Linha de máquinas</label>
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

					
					<button class="button btn-green" name="CONFIRM_MACHINE_EDIT"><span>Confirmar</span></button>
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

					if(isset($_POST['mac_feature'])){
						$mac_feat_ids = $_POST['mac_feature'];

						if($stmt4 = $conn->link->prepare("DELETE FROM machine_features WHERE mac_id = ?")){
							$stmt4->bind_param('i', $mac_id);
							$stmt4->execute();
						}
						foreach($mac_feat_ids as $key => $value){
							if($stmt5 = $conn->link->prepare("INSERT INTO machine_features(mac_id, feat_id) VALUES(?, ?)")){
								$stmt5->bind_param('ii', $mac_id, $value);
								$stmt5->execute();
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
			<button class="closebtn" onclick="formOff(3);" aria-label="Fechar Janela">&times;</button>
			<form method="POST">
				<h2>Tem certeza que quer remover a máquina abaixo?</h2>
				<h3 class="destaque">'.$_POST['mac_name'].' (id: '.$_POST['REMOVE_MACHINE'].')</h3><br>
				<button class="button btn-red" name="CONFIRM_MACHINE_REM" value="'.stripslashes($_POST['REMOVE_MACHINE']).'"><span>Confirmar</span></button>
			</form></div></div></div>';
			echo '<script>formOn(3);</script>';
		}
		if(isset($_POST['CONFIRM_MACHINE_REM'])){
			$conn->link = $conn->connect();
			$mac_id = stripslashes($_POST['CONFIRM_MACHINE_REM']);
			if($stmt2 = $conn->link->prepare("DELETE FROM machine_applications WHERE mac_id = ?")){
				try{
					$stmt2->bind_param('i', $mac_id);
					$stmt2->execute();
				}
				catch(Exception $e){
					throw new Exception('Erro ao conectar com a base de dados: '. $e);
				}
			}
			if($stmt3 = $conn->link->prepare("DELETE FROM machine_features WHERE mac_id = ?")){
				try{
					$stmt3->bind_param('i', $mac_id);
					$stmt3->execute();
				}
				catch(Exception $e){
					throw new Exception('Erro ao conectar com a base de dados: '. $e);
				}
			}
			if($stmt = $conn->link->prepare("DELETE FROM machines WHERE mac_id = ?")){
				try{
					$stmt->bind_param('i', $mac_id);
					$stmt->execute();
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

				if($stmt2 = $conn->link->prepare("SELECT * FROM features")){
					try{
						$stmt2->execute();
						$features = get_result($stmt2);
					}
					catch(Exception $e){
						throw new Exception('Erro ao conectar com a base de dados: '. $e);
					}
				}

				echo '<div class="overlayform" id="form5"><div class="modalform"><div class="modaldados">
				<button class="closebtn" onclick="formOff(5);" aria-label="Fechar Janela">&times;</button>
				<form method="POST">
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
					</div>';

					$maxFeatures = 6;
					for($j = 0; $j < $maxFeatures; $j++){
						echo '<div class="form-group"><label>Feature '.($j + 1).'</label>
								<div class="input-group icon-selector-group">
									<div class="input-group-text"><img src="./uploads/icons/applications_icon_0.png" /></div>
									<select name="mac_feature[]" class="input-group-append icon-selector">
										<option data-image="./uploads/icons/applications_icon_0.png">Nenhum selecionado</option>';
							
							for($i = 0; $i < $stmt2->num_rows; $i++){
								echo '<option value="'.$features[$i]['feat_id'].'" data-image="'.constant('WEBSITE_ICON_NUMBER_'.$features[$i]['feat_image']).'">
									'.$features[$i]['feat_name'].'</option>';
							}
						echo '</select></div></div>';
					}

					echo '<div class="form-group"><label>Linha de máquinas</label>
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

					
					<button class="button btn-green" name="CONFIRM_MACHINE_ADD"><span>Confirmar</span></button>
				</form></div></div></div>';
				echo '<script>formOn(5);</script>';
			}
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

					if(isset($_POST['mac_ap_link'])){
						$mac_ap_ids = $_POST['mac_ap_link'];
						$mac_id = $stmt->insert_id;
						foreach($mac_ap_ids as $key => $value){
							if($stmt3 = $conn->link->prepare("INSERT INTO machine_applications(mac_id, ap_id) VALUES(?, ?)")){
								$stmt3->bind_param('ii', $mac_id, $value);
								$stmt3->execute();
							}
						}
					}
					if(isset($_POST['mac_feature'])){
						$mac_feat_ids = $_POST['mac_feature'];

						foreach($mac_feat_ids as $key => $value){
							if($stmt4 = $conn->link->prepare("INSERT INTO machine_features(mac_id, feat_id) VALUES(?, ?)")){
								$stmt4->bind_param('ii', $mac_id, $value);
								$stmt4->execute();
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

		if(isset($_POST['OPEN_FEATURES_DIALOG'])){
			if($stmt = $conn->link->prepare("SELECT * FROM features")){
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
					<form method="POST">
						<button href="#" class="button2 btn-primary center" name="NEW_FEATURE" />
							<span>Nova Feature</span>
						</button>
					</form>
					<div class="table-list text-center">
						<div class="col row w-100">
							<div class="col bold">Imagem</div>
							<div class="col bold">Título</div>
							<div class="col bold buttonsContainer">Ações</div>
						</div>';
			if($stmt->num_rows > 0){
				for($i = 0; $i < $stmt->num_rows; $i++){
					echo '<form method="POST">
							<input type="text" name="feat_name" value="'.$row[$i]['feat_name'].'" hidden/>
							<div class="col row w-100">
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
						</div>
					</form>';
				}
			}else{
				echo '<div class="box-msg error center pt-5">'.ERROR_QUERY_NORESULT.'</div>';
			}

			echo '</div></div></div></div> <script>formOn(6);</script>';
		}

		if(isset($_POST['EDIT_FEATURE'])){
			$feat_id = $_POST['EDIT_FEATURE'];
			if($stmt = $conn->link->prepare("SELECT * FROM features WHERE feat_id = ?")){
				try{
					$stmt->bind_param('i', $feat_id);
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

				echo '<div class="overlayform" id="form7"><div class="modalform"><div class="modaldados">
				<button class="closebtn" onclick="formOff(7);" aria-label="Fechar Janela">&times;</button>
				<form method="POST">
					<h2 class="text-center">Editar Feature</h2>
					<div class="form-group"><label>Nome da Feature</label> <input type="text" name="feat_name" value="'. $row[0]['feat_name'] .'" required/></div>
					<div class="form-group"><label>Ícone</label>
						<div class="input-group icon-selector-group">
							<div class="input-group-text"><img src="./uploads/icons/applications_icon_0.png" /></div>
							<select name="feat_image" class="input-group-append icon-selector">
								<option data-image="./uploads/icons/applications_icon_0.png">Nenhum selecionado</option>';
					
					for($i = 0; $i < $stmt2->num_rows; $i++){
						echo '<option value="'.$icons[$i]['icon_id'].'" data-image="'.$icons[$i]['icon_image'].'" '.($row[0]['feat_image'] == $icons[$i]['icon_id'] ? 'selected': '').'>'.$icons[$i]['icon_name'].'</option>';
					}
					echo '</select></div></div>
					<div class="form-group"><label>Ativo? Isto afetara a visibilidade deste item no site</label> <span class="range_input_value">'. $row[0]['feat_active'] .'</span>/1<input type="range" min="0" max="1" value="'. $row[0]['feat_active'] .'" name="feat_active" class="range_input" /></div>

					
					<button class="button btn-green" name="CONFIRM_EDIT_FEATURE" value="'.$row[0]['feat_id'].'"><span>Confirmar</span></button>
				</form></div></div></div>';
				echo '<script>formOn(7);</script>';
			}
		}

		if(isset($_POST['CONFIRM_EDIT_FEATURE'])){
			$feat_id = $_POST['CONFIRM_EDIT_FEATURE'];
			$feat_name = $_POST['feat_name'];
			$feat_image = $_POST['feat_image'];
			$feat_active = $_POST['feat_active'];

			if($stmt = $conn->link->prepare("UPDATE features SET feat_name = ?, feat_image = ?, feat_active = ? WHERE feat_id = ?")){
				try{
					$stmt->bind_param('ssii', $feat_name, $feat_image, $feat_active, $feat_id);
					$stmt->execute();
				}
				catch(Exception $e){
					throw new Exception('Erro ao conectar com a base de dados: '. $e);
				}
				echo '<script>reload();</script>';
			}
		}

		if(isset($_POST['NEW_FEATURE'])){
			$feat_id = $_POST['NEW_FEATURE'];

			if($stmt2 = $conn->link->prepare("SELECT * FROM icons")){
				try{
					$stmt2->execute();
					$icons = get_result($stmt2);
				}
				catch(Exception $e){
					throw new Exception('Erro ao conectar com a base de dados: '. $e);
				}
			}

			echo '<div class="overlayform" id="form8"><div class="modalform"><div class="modaldados">
			<button class="closebtn" onclick="formOff(8);" aria-label="Fechar Janela">&times;</button>
			<form method="POST">
				<h2 class="text-center">Editar Feature</h2>
				<div class="form-group"><label>Nome da Feature</label> <input type="text" name="feat_name" required/></div>
				<div class="form-group"><label>Ícone</label>
					<div class="input-group icon-selector-group">
						<div class="input-group-text"><img src="./uploads/icons/applications_icon_0.png" /></div>
						<select name="feat_image" class="input-group-append icon-selector">
							<option data-image="./uploads/icons/applications_icon_0.png">Nenhum selecionado</option>';
				
				for($i = 0; $i < $stmt2->num_rows; $i++){
					echo '<option value="'.$icons[$i]['icon_id'].'" data-image="'.$icons[$i]['icon_image'].'">'.$icons[$i]['icon_name'].'</option>';
				}
				echo '</select></div></div>
				<div class="form-group"><label>Ativo? Isto afetara a visibilidade deste item no site</label> <span class="range_input_value">1</span>/1<input type="range" min="0" max="1" value="1" name="feat_active" class="range_input" /></div>

				
				<button class="button btn-green" name="CONFIRM_NEW_FEATURE"><span>Confirmar</span></button>
			</form></div></div></div>';
			echo '<script>formOn(8);</script>';
			
		}

		if(isset($_POST['CONFIRM_NEW_FEATURE'])){
			$feat_id = $_POST['CONFIRM_NEW_FEATURE'];
			$feat_name = $_POST['feat_name'];
			$feat_image = $_POST['feat_image'];
			$feat_active = $_POST['feat_active'];

			if($stmt = $conn->link->prepare("INSERT INTO features(feat_name, feat_image, feat_active) VALUES(?, ?, ?)")){
				try{
					$stmt->bind_param('ssi', $feat_name, $feat_image, $feat_active);
					$stmt->execute();
				}
				catch(Exception $e){
					throw new Exception('Erro ao conectar com a base de dados: '. $e);
				}
				echo '<script>reload();</script>';
			}
		}

		if(isset($_POST['REMOVE_FEATURE'])){
			echo '<div class="overlayform" id="form9"><div class="modalform"><div class="modaldados text-center">
			<button class="closebtn" onclick="formOff(9);" aria-label="Fechar Janela">&times;</button>
			<form method="POST">
				<h2>Tem certeza que quer remover a feature abaixo?</h2>
				<h3 class="destaque">'.$_POST['feat_name'].' (id: '.$_POST['REMOVE_FEATURE'].')</h3><br>
				<button class="button btn-red" name="CONFIRM_REMOVE_FEATURE" value="'.$_POST['REMOVE_FEATURE'].'"><span>Confirmar</span></button>
			</form></div></div></div>';
			echo '<script>formOn(9);</script>';
			
		}

		if(isset($_POST['CONFIRM_REMOVE_FEATURE'])){
			$feat_id = $_POST['CONFIRM_REMOVE_FEATURE'];

			if($stmt2 = $conn->link->prepare("DELETE FROM machine_features WHERE feat_id = ?")){
				try{
					$stmt2->bind_param('i', $feat_id);
					$stmt2->execute();
				}
				catch(Exception $e){
					throw new Exception('Erro ao conectar com a base de dados: '. $e);
				}
			}
			if($stmt = $conn->link->prepare("DELETE FROM features WHERE feat_id = ?")){
				try{
					$stmt->bind_param('i', $feat_id);
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