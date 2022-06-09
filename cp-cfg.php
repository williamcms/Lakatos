<?php 
include('cfg/core.php');
include('cfg/users_class.php');

$account->sessionLogin();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
	<title><?php echo $website->title; ?>: Configurações do Website</title>
	<?php require_once('header-cpainel.php'); ?>
</head>
<body>
	<?php include('hm_menu_cpanel.php'); ?>
<main class="cfg">
	<h2 class="text-center pt-3">Gerenciamento do Website</h2>
	<div class="card-box">
		<div class="row">
			<?php 
				
				$option = stripslashes(isset($_GET['order']) ? $_GET['order'] : 'default');

				$ASC = '<i class="fas fa-sort-up"></i>';
				$DESC = '<i class="fas fa-sort-down"></i>';

				$opt1 = $opt0 = $opt2 = '&opt=0';
				$opt = stripslashes(isset($_GET['opt']) ? $_GET['opt'] : null);
				$optArrow1 = $optArrow0 = $optArrow2 = '';

				switch($option){
					case 0:
						$sqlOpt = 'ORDER BY config_active';
						$opt0 = '&opt='. (!$opt ? 1 : 0);
						$optArrow0 = (!$opt ? $ASC : $DESC);
						$sqlOptOrder = (!$opt ? 'ASC' : 'DESC');
						break;
					case 1:
						$sqlOpt = 'ORDER BY config_description';
						$opt1 = '&opt='. (!$opt ? 1 : 0);
						$optArrow1 = (!$opt ? $ASC : $DESC);
						$sqlOptOrder = (!$opt ? 'ASC' : 'DESC');
						break;
					case 2:
						$sqlOpt = 'WHERE config_value = "" ORDER BY config_id';
						$opt2 = '&opt='. (!$opt ? 1 : 0);
						$optArrow2 = (!$opt ? $ASC : $DESC);
						$sqlOptOrder = (!$opt ? 'ASC' : 'DESC');
						break;
					default:
						$sqlOpt = 'ORDER BY config_id';
						$sqlOptOrder = 'ASC';
						break;
				}

				if(isset($_GET['order'])){
					echo '<div class="col text-center"><div id="sortingOptions">Ordenar por | 
					<span class="option"><a href="?order=1'.$opt1.'">Nome '.$optArrow1.'</a></span> | 
					<span class="option"><a href="?order=0'.$opt0.'">Ativo '.$optArrow0.'</a></span> | 
					<span class="option"><a href="?order=2'.$opt2.'">Pendências '.$optArrow2.'</a></span> | 
					<span class="option"><a href="cp-cfg">Reset</a></span></div></div>';
				} else{
					echo '<div class="col text-center"><div id="sortingOptions">Ordenar por |
					<span class="option"><a href="?order=1&opt=0">Nome</a></span> | 
					<span class="option"><a href="?order=0&opt=0">Ativo</a></span> | 
					<span class="option"><a href="?order=2&opt=0">Pendências</a></span> | 
					<span class="option"><a href="cp-cfg">Reset</a></span></div></div>';
				}
			?>
		</div>
	</div>
	<div class="row card-box-results">
	<?php
		$conn->link = $conn->connect();

		echo '<p class="text-muted orderby">Ordenando por: '. $sqlOpt .' '. $sqlOptOrder .'</p>';

		if($stmt = $conn->link->prepare("SELECT * FROM website_configs ".$sqlOpt." ". $sqlOptOrder)){
			try{
				$stmt->execute();
				$row = get_result($stmt);
			}
			catch(Exception $e){
				throw new Exception('Erro ao conectar com a base de dados: '. $e);
			}

			if($stmt->num_rows > 0){
				for($i = 0; $i < $stmt->num_rows; $i++){
					($row[$i]['config_active'] == 0 ? $NOTACTIVE = 'opacity: 0.7;' : $NOTACTIVE = '');
					(empty($row[$i]['config_value']) ? $VALUE_REPAIR = '<i class="fas fa-exclamation-triangle"></i>' : $VALUE_REPAIR = '');

					echo '<div class="col col-100 card-result-body" style="'.$NOTACTIVE.'">
					<div class="card-result-top">
					<div class="card-result-title">'.$row[$i]['config_description'].' ('.($row[$i]['config_active'] ? 'Ativo' : 'Desativado'). ')</div>
					<form method="POST">
						<div class="buttonsContainer">
							<button class="editbtn smallbtn" name="EDIT_CONFIG" value="'.$row[$i]['config_id'].'" title="Editar">
							<i class="far fa-edit"></i></button>
						</div>
					</form></div>
					<hr><div class="card-result-content">
					<span class="bold">Valor:</span> <xmp class="italic" style="line-break: anywhere;white-space: normal;display:inline;">'.$row[$i]['config_value'].'</xmp> '.$VALUE_REPAIR.'
					</div></div>';
				}
			}else{
				echo '<div class="box-msg error">'.ERROR_QUERY_NORESULT.'</div>';
			}
		}
		

		if(isset($_POST['EDIT_CONFIG'])){
			$config_id = $_POST['EDIT_CONFIG'];

			if($stmt = $conn->link->prepare("SELECT * FROM website_configs WHERE config_id = ?")){
				try{
					$stmt->bind_param('i', $config_id);
					$stmt->execute();
					$row = get_result($stmt);
				}
				catch(Exception $e){
					throw new Exception('Erro ao conectar com a base de dados: '. $e);
				}

				echo '<div class="overlayform" id="form1"><div class="modalform"><div class="modaldados">
				<button class="closebtn" onclick="formOff(1);" aria-label="Fechar Janela">&times;</button>
				<form method="POST" id="form">
					<h2 class="text-center">Editando &rarr; '.$row[0]['config_description'].'</h2>';

				if(!empty($row[0]['config_help']) OR !$row[0]['config_help'] == 0){
					echo '<div class="cfg-help_text">' .$row[0]['config_help']. '</div>';
				}

				echo '<div class="form-group"><label>Descrição <span class="text-muted">(não editável)</span></label>
						<input type="text" name="config_description" value="'.$row[0]['config_description'].'" readonly></div>
						<div class="form-group"><label>Valor</label>
						<textarea type="text" name="config_value" id="config_value" placeholder="'.$row[0]['config_customplaceholder'].'">'.$row[0]['config_value'].'</textarea></div>
						<div class="form-group"><label>Ativo? Isto podera afetar a estabilidade do website</label>
						<span id="range_input_value">'.$row[0]['config_active'].'</span>/1
						<input type="range" min="0" max="1" value="'.$row[0]['config_active'].'" name="config_active" class="range_input"></div>
					
						<button class="button btn-success" value="'.$row[0]['config_id'].'" name="CONFIRM_CONFIG_EDIT"><span>Confirmar</span></button>
				</form></div><p class="text-muted text-center">Caso o valor deste formulário esteja em branco, essa configuração será desativada automáticamente!</p></div></div>';
				echo '<script>formOn(1);</script>';
			}
		}
		if(isset($_POST['CONFIRM_CONFIG_EDIT'])){

			$conn->link = $conn->connect();
			if($stmt = $conn->link->prepare("UPDATE website_configs SET config_value = ?, config_active = ? WHERE config_id = ?")){

				try{
					$stmt->bind_param('sii', $config_value, $config_active, $config_id);
					
					$config_value = $_POST['config_value'];
					$config_value = str_replace("\r", "", $config_value);
					$config_value = str_replace("\n", "", $config_value);

					$config_active = $_POST['config_active'];
					$config_active = (empty($config_value) ? 0 : $config_active);

					$config_id = $_POST['CONFIRM_CONFIG_EDIT'];

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