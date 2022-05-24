<?php 
include('cfg/core.php');
include('cfg/users_class.php');

$account->sessionLogin();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
	<title><?php echo $website->title; ?>: Clientes</title>
	<?php require_once('header-cpainel.php'); ?>
</head>
<body>
	<?php include('hm_menu_cpanel.php'); ?>
<main class="partners">
	<h2 class="text-center pt-3">Gerenciamento de Clientes</h2>
	<div class="card-box">
		<div class="row">
			<div class="col"><h4>Clientes</h4></div>
			<div class="col">
				<form method="POST" id="NEW_PARTNER">
					<input type="text" name="ADD_PARTNER" hidden><a href="#" class="button2 card_button-add" onclick="$('#NEW_PARTNER').submit();">
					<span>Novo Cliente</span></a>
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
						$sqlOpt = 'cliente_active';
						$opt0 = '&opt='. (!$opt ? 1 : 0);
						$optArrow0 = (!$opt ? $ASC : $DESC);
						$sqlOptOrder = (!$opt ? 'ASC' : 'DESC');
						break;
					default:
						$sqlOpt = 'cliente_id';
						$sqlOptOrder = 'ASC';
						break;
				}

				if(isset($_GET['order'])){
					echo '<div class="col text-center"><div id="sortingOptions">Ordenar por | 
					<span class="option"><a href="?order=0'.$opt0.'">Ativo '.$optArrow0.'</a></span> | 
					<span class="option"><a href="cp-partners">Reset</a></span></div></div>';
				} else{
					echo '<div class="col text-center"><div id="sortingOptions">Ordenar por | 
					<span class="option"><a href="?order=0&opt=0">Ativo</a></span> | 
					<span class="option"><a href="cp-partners">Reset</a></span></div></div>';
				}
			?>
		</div>
	</div>
	<div class="row card-box-results">
	<?php
		$conn->link = $conn->connect();

		echo '<p class="text-muted" style="position: absolute; margin-top:-20px;">Ordenando por: '. $sqlOpt .' '. $sqlOptOrder .'</p>';

		if($stmt = $conn->link->prepare("SELECT * FROM clientes ORDER BY ".$sqlOpt." ". $sqlOptOrder)){
			try{
				$stmt->execute();
				$row = get_result($stmt);
			}
			catch(Exception $e){
				throw new Exception('Erro ao conectar com a base de dados: '. $e);
			}

			if($stmt->num_rows > 0){
				for($i = 0; $i < $stmt->num_rows; $i++){
					($row[$i]['cliente_active'] == 0 ? $NOTACTIVE = 'opacity: 0.7;' : $NOTACTIVE = '');
					echo '<div class="col card-result-body" style="'.$NOTACTIVE.'">
					<div class="card-result-top">
					<div class="card-result-title">'.$row[$i]['cliente_name'].'</div>
					<form method="POST">
					<input name="cliente_name" type="text" value="'.$row[$i]['cliente_name'].'" hidden>
					<div class="buttonsContainer">
						<button class="closebtn smallbtn" name="REMOVE_PARTNER" value="'.$row[$i]['cliente_id'].'" style="right: 35px;">
							<i class="far fa-trash-alt"></i></button>
						<button class="editbtn smallbtn" name="EDIT_PARTNER" value="'.$row[$i]['cliente_id'].'" title="Editar">
							<i class="far fa-edit"></i></button>
					</div>
					</form></div>
					<hr><div class="card-result-content"><img src="'.$row[$i]['cliente_image'].'" class="w-100"/></div></div>';
				}

			} else{
					echo '<div class="box-msg error">'.ERROR_QUERY_NORESULT.'</div>';
			}
		}

		if(isset($_POST['EDIT_PARTNER'])){
			$cliente_id = $_POST['EDIT_PARTNER'];

			if($stmt = $conn->link->prepare("SELECT * FROM clientes WHERE cliente_id = ?")){
				try{
					$stmt->bind_param('i', $cliente_id);
					$stmt->execute();
					$row = get_result($stmt);
				}
				catch(Exception $e){
					throw new Exception('Erro ao conectar com a base de dados: '. $e);
				}

				echo '<div class="overlayform" id="form1"><div class="modalform"><div class="modaldados">
				<button class="closebtn" onclick="formOff(1);" aria-label="Fechar Janela">&times;</button>
				<form method="POST" id="form">
					<h2 class="text-center">Editar parceiro</h2>
					<div class="form-group"><label>Id do parceiro <span class="text-muted">(não editável)</span></label> <input type="text" name="cliente_id" value="'.$row[0]['cliente_id'].'" readonly></div>
					<div class="form-group"><label>Nome do Parceiro</label> <input type="text" name="cliente_name" value="'.$row[0]['cliente_name'].'" required></div>
					<div class="form-group"><label>Imagem</label> (ex: imagem_do_parceiro.png)<input type="text" name="cliente_image" value="'.$row[0]['cliente_image'].'" required></div>
					<div class="form-group"><label>Descrição Curta</label><textarea name="cliente_description" maxlength="500">'.$row[0]['cliente_description'].'</textarea></div>
					<div class="form-group"><label>Site do Parceiro</label> (ex: http://example.com.br)<input type="text" placeholder="http://" name="cliente_url" value="'.$row[0]['cliente_url'].'"></div>
					<div class="form-group"><label>Ativo? Isto afetara a visibilidade deste parceiro no site.</label> <span class="range_input_value">'.$row[0]['cliente_active'].'</span>/1<input type="range" min="0" max="1" value="'.$row[0]['cliente_active'].'" name="cliente_active" class="range_input"></div>

					
					<button class="button" style="background-color: var(--green); color: var(--white);" name="CONFIRM_PARTNER_EDIT"><span>Confirmar</span></button>
				</form></div></div></div>';
				echo '<script>formOn(1);</script>';
			}
		}
		if(isset($_POST['CONFIRM_PARTNER_EDIT'])){

			$conn->link = $conn->connect();
			if($stmt = $conn->link->prepare("UPDATE clientes SET cliente_name = ?, cliente_image = ?, cliente_url = ?, cliente_description = ?, cliente_active = ? WHERE cliente_id = ?")){

				try{
					$stmt->bind_param('ssssii', $cliente_name, $cliente_image, $cliente_url, $cliente_description, $cliente_active, $cliente_id);
					$cliente_name = $_POST['cliente_name'];
					$cliente_name = stripslashes($cliente_name);
					$cliente_name = mysqli_escape_string($conn->link, $cliente_name);

					$cliente_image = $_POST['cliente_image'];
					$cliente_image = stripslashes($cliente_image);
					$cliente_image = mysqli_escape_string($conn->link, $cliente_image);

					$cliente_description = $_POST['cliente_description'];
					$cliente_description = stripslashes($cliente_description);
					$cliente_description = mysqli_escape_string($conn->link, $cliente_description);

					$cliente_url = $_POST['cliente_url'];
					$cliente_url = stripslashes($cliente_url);
					$cliente_url = mysqli_escape_string($conn->link, $cliente_url);

					$cliente_active = $_POST['cliente_active'];
					$cliente_active = stripslashes($cliente_active);
					$cliente_active = mysqli_escape_string($conn->link, $cliente_active);
					
					$cliente_id = $_POST['cliente_id'];
					$cliente_id = stripslashes($cliente_id);
					$cliente_id = mysqli_escape_string($conn->link, $cliente_id);
					$stmt->execute();
				}
				catch(Exception $e){
					throw new Exception('Erro ao conectar com a base de dados: '. $e);
				}
				echo '<script>reload();</script>';
			}
		}
		if(isset($_POST['REMOVE_PARTNER'])){
			echo '<div class="overlayform" id="form3"><div class="modalform"><div class="modaldados text-center">
			<button aria-hidden="true" class="closebtn" onclick="formOff(3);" aria-label="Fechar Janela">&times;</button>
			<form method="POST">
				<h2>Tem certeza que quer remover o parceiro abaixo?</h2>
				<h3 class="destaque">'.$_POST['cliente_name'].' (id: '.$_POST['REMOVE_PARTNER'].')</h3><br>
				<button class="button" style="background-color: var(--danger); color: var(--white);" name="CONFIRM_CLIENTE_REM" value="'.stripslashes($_POST['REMOVE_PARTNER']).'"><span>Confirmar</span></button>
			</form></div></div></div>';
			echo '<script>formOn(3);</script>';
		}
		if(isset($_POST['CONFIRM_CLIENTE_REM'])){
			$conn->link = $conn->connect();
			if($stmt = $conn->link->prepare("DELETE FROM clientes WHERE cliente_id = ?")){
				try{
					$stmt->bind_param('i', stripslashes($_POST['CONFIRM_CLIENTE_REM']));
					$stmt->execute();
				}
				catch(Exception $e){
					throw new Exception('Erro ao conectar com a base de dados: '. $e);
				}
				echo '<script>reload();</script>';
			}
		}

		if(isset($_POST['ADD_PARTNER'])){
			echo '<div class="overlayform" id="form5"><div class="modalform"><div class="modaldados">
			<button class="closebtn" onclick="formOff(5);" aria-label="Fechar Janela">&times;</button>
			<form method="POST" id="form">
				<h2 class="text-center">Novo parceiro</h2>
				<div class="form-group"><label>Nome do Parceiro</label> <input type="text" name="cliente_name" required></div>
				<div class="form-group"><label>Imagem</label> (ex: imagem_do_parceiro.png)<input type="text" name="cliente_image" required></div>
				<div class="form-group"><label>Descrição Curta</label><textarea name="cliente_description" maxlength="500"></textarea></div>
				<div class="form-group"><label>Site do Parceiro</label> (ex: http://example.com.br)<input type="text" placeholder="http://" name="cliente_url"></div>
				<div class="form-group"><label>Ativo? Isto afetara a visibilidade deste parceiro no site</label> <span class="range_input_value">1</span>/1<input type="range" min="0" max="1" value="1" name="cliente_active" class="range_input"></div>

				
				<button class="button" style="background-color: var(--green); color: var(--white);" name="CONFIRM_PARTNER_ADD"><span>Confirmar</span></button>
			</form></div></div></div>';
			echo '<script>formOn(5);</script>';
		}
		if(isset($_POST['CONFIRM_PARTNER_ADD'])){


			$conn->link = $conn->connect();
			if($stmt = $conn->link->prepare("INSERT INTO clientes (cliente_name, cliente_image, cliente_url, cliente_description, cliente_active) VALUES (?, ?, ?, ?, ?)")){

				try{
					$stmt->bind_param('ssssi', $cliente_name, $cliente_image, $cliente_url, $cliente_description, $cliente_active);
					$cliente_name = $_POST['cliente_name'];
					$cliente_name = stripslashes($cliente_name);
					$cliente_name = mysqli_escape_string($conn->link, $cliente_name);

					$cliente_image = $_POST['cliente_image'];
					$cliente_image = stripslashes($cliente_image);
					$cliente_image = mysqli_escape_string($conn->link, $cliente_image);

					$cliente_description = $_POST['cliente_description'];
					$cliente_description = stripslashes($cliente_description);
					$cliente_description = mysqli_escape_string($conn->link, $cliente_description);

					$cliente_url = $_POST['cliente_url'];
					$cliente_url = stripslashes($cliente_url);
					$cliente_url = mysqli_escape_string($conn->link, $cliente_url);

					$cliente_active = $_POST['cliente_active'];
					$cliente_active = stripslashes($cliente_active);
					$cliente_active = mysqli_escape_string($conn->link, $cliente_active);
					
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