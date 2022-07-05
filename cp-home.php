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
<main class="notes">
	<h2 class="text-center pt-3">Bem-vindo, <?php echo $_SESSION['username']; ?>! </h2>
	<div class="card-box">
		<div class="row">
			<div class="col"><h4>Quadro de Avisos</h4></div>
			<div class="col">
				<form method="POST" id="NEW_NOTE">
					<input type="text" name="ADD_NOTE" hidden/><a href="#" class="button2 card_button-add" onclick="$('#NEW_NOTE').submit();">
					<span>Novo Aviso</span></a>
				</form></div>
		</div>
		<div class="row">
			<?php 
				
				$option = stripslashes(isset($_GET['order']) ? $_GET['order'] : 'default');

				$ASC = '<i class="fas fa-sort-up"></i>';
				$DESC = '<i class="fas fa-sort-down"></i>';

				$opt1 = $opt0 = '&opt=0';
				$opt = stripslashes(isset($_GET['opt']) ? $_GET['opt'] : null);
				$optArrow1 = $optArrow0 = '';

				switch($option){
					case 0:
						$sqlOpt = 'note_timestamp';
						$opt0 = '&opt='. (!$opt ? 1 : 0);
						$optArrow0 = (!$opt ? $ASC : $DESC);
						$sqlOptOrder = (!$opt ? 'ASC' : 'DESC');
						break;
					case 1:
						$sqlOpt = 'note_priority';
						$opt1 = '&opt='. (!$opt ? 1 : 0);
						$optArrow1 = (!$opt ? $ASC : $DESC);
						$sqlOptOrder = (!$opt ? 'ASC' : 'DESC');
						break;
					default:
						$sqlOpt = 'note_id';
						$sqlOptOrder = 'ASC';
						break;
				}

				if(isset($_GET['order'])){
					echo '<div class="col text-center"><div id="sortingOptions">Ordenar por | 
					<span class="option"><a href="?order=0'.$opt0.'">Data de inclusão '.$optArrow0.'</a></span> | 
					<span class="option"><a href="?order=1'.$opt1.'">Prioridade '.$optArrow1.'</a></span> | 
					<span class="option"><a href="cp-home">Reset</a></span></div></div>';
				} else{
					echo '<div class="col text-center"><div id="sortingOptions">Ordenar por | 
					<span class="option"><a href="?order=0&opt=0">Data de inclusão</a></span> | 
					<span class="option"><a href="?order=1&opt=0">Prioridade</a></span> | 
					<span class="option"><a href="cp-home">Reset</a></span></div></div>';
				}
			?>
		</div>
	</div>
	<div class="row card-box-results">
	<?php
		$conn->link = $conn->connect();

		echo '<p class="text-muted orderby">Ordenando por: '. $sqlOpt .' '. $sqlOptOrder .'</p>';

		if($stmt = $conn->link->prepare("SELECT * FROM users_notes ORDER BY ".$sqlOpt." ". $sqlOptOrder)){
			try{
				$stmt->execute();
				$row = get_result($stmt);
			}
			catch(Exception $e){
				throw new Exception('Erro ao conectar com a base de dados: '. $e);
			}

			if($stmt->num_rows > 0){
				for($i = 0; $i < $stmt->num_rows; $i++){
					echo '<div class="col card-result-body">
					<div class="card-result-top">
					<div class="card-result-title">'.$row[$i]['note_title'].'</div>
						<form method="POST">
							<input name="note_name" type="text" value="'.$row[$i]['note_title'].'" hidden/>
							<div class="buttonsContainer">
								<button class="closebtn smallbtn" name="REMOVE_NOTE" value="'.$row[$i]['note_id'].'">
								<i class="far fa-trash-alt"></i></button>
							</div>
						</form></div>
						<hr><div class="card-result-content">'.$row[$i]['note_content'].'</div></div>';
				}

			} else{
					echo '<div class="box-msg error">'.ERROR_QUERY_NORESULT.'</div>';
			}
		}

		if(isset($_POST['REMOVE_NOTE'])){
			echo '<div class="overlayform" id="form1"><div class="modalform"><div class="modaldados text-center">
			<button class="closebtn" onclick="formOff(1);" aria-label="Fechar Janela">&times;</button>
			<form method="POST">
				<h2>Tem certeza que quer apagar a anotação?</h2>
				<h3 class="destaque">'.$_POST['note_name'].' (id: '.$_POST['REMOVE_NOTE'].')</h3><br>
				<button class="button btn-danger" name="CONFIRM_NOTE_REM" value="'.stripslashes($_POST['REMOVE_NOTE']).'"><span>Confirmar</span></button>
			</form></div></div></div>';
			echo '<script>formOn(1);</script>';
		}
		if(isset($_POST['CONFIRM_NOTE_REM'])){
			$conn->link = $conn->connect();
			$note_id = stripslashes($_POST['CONFIRM_NOTE_REM']);
			if($stmt = $conn->link->prepare("DELETE FROM users_notes WHERE note_id = ?")){
				try{
					$stmt->bind_param('i', $note_id);
					$stmt->execute();
				}
				catch(Exception $e){
					throw new Exception('Erro ao conectar com a base de dados: '. $e);
				}
			}
			echo '<script>reload();</script>';
		}

		if(isset($_POST['ADD_NOTE'])){
			echo '<div class="overlayform" id="form2"><div class="modalform"><div class="modaldados">
					<button class="closebtn" onclick="formOff(2);" aria-label="Fechar Janela">&times;</button>
					<form method="POST" id="form">
						<h2 class="text-center">Preencha as informações abaixo para inserir uma nova nota</h2>
						<div class="form-group"><label>Título</label> <input type="text" name="note_title" /></div>
						<div class="form-group"><label>Descrição</label> <textarea name="note_content" maxlength="520"></textarea></div>
						<div class="form-group"><label>Prioridade</label> <span class="range_input_value">0</span>/9
							<input type="range" min="0" max="9" value="0" name="note_priority" class="range_input" /></div>

						
						<button class="button btn-green" name="CONFIRM_NOTE_ADD"><span>Confirmar</span></button>
					</form></div></div></div>';
			echo '<script>formOn(2);</script>';
		}
		if(isset($_POST['CONFIRM_NOTE_ADD'])){

			$conn->link = $conn->connect();
			if($stmt = $conn->link->prepare("INSERT INTO users_notes (note_title, note_content, note_timestamp, note_priority) VALUES (?, ?, NOW(), ?)")){
				try{
					$stmt->bind_param('ssi', $note_title, $note_content, $note_priority);
					$note_title = $_POST['note_title'];
					$note_content = $_POST['note_content'];
					$note_priority = $_POST['note_priority'];
					$stmt->execute();
				}
				catch(Exception $e){
					throw new Exception('Erro ao conectar com a base de dados: '. $e);
				}
			}
			echo '<script>reload();</script>';
		}


	?>
	</div>
</main>
<?php include('cpanel_footer.php'); ?>
</body>
</html>