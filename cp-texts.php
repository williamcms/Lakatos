<?php 
include('cfg/core.php');
include('cfg/users_class.php');

$account->sessionLogin();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
	<title><?php echo $website->title; ?>: Textos e traduções</title>
	<?php require_once('header-cpainel.php'); ?>
</head>
<body>
	<?php include('hm_menu_cpanel.php'); ?>
<main class="languages">
	<h2 class="text-center pt-3">Gerenciamento de Textos e traduções</h2>
	<div class="card-box">
		<div class="row">
			<?php 
				if(isset($_GET['success'])){
					if($_GET['success'] === 'all'){
						echo '<div class="col box-msg popup popup-green-darker">Todas as alterações nas traduções foram salvas!</div>';
					}else{
						echo '<div class="col box-msg popup popup-green-darker">As alterações foram salvas. 
						<a href="#'.$_GET['success'].'" onclick="$(\'#'.$_GET['success'].'\').addClass(\'focus\');">Ver item</a></div>';
					}
				}
			?>
		</div>
		<div class="row">
			<div class="col">
				<button class="button2 w-100 card_button-add" onclick="getLangs();"><span>Alterar Todos</span></button>
				<div class="progress" id="allLangsProgress">
					<div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-increment="10" aria-valuemax="100">0%</div>
				</div>
			</div>
		</div>
	</div>
	<form method="POST" id="formAllLangs">
		<textarea name="CONFIRM_ALL_LANG_EDIT" id="CONFIRM_ALL_LANG_EDIT" readonly hidden></textarea>
	</form>
	<div class="row card-box-results">
	<?php
		$conn->link = $conn->connect();

		if($stmt = $conn->link->prepare("SELECT * FROM website_lang ORDER BY lang_name ASC")){
			try{
				$stmt->execute();
				$row = get_result($stmt);
			}
			catch(Exception $e){
				throw new Exception('Erro ao conectar com a base de dados: '. $e);
			}
			class _data{
				public $_arr = array();

				public function get(){
					return $this->_arr;
				}

				public function __construct(){
					$data = func_get_args();

					foreach($data[0] as $key => $value){
						$this->_arr[$key/3][$value['lang_locale']]['lang_name'] = $value['lang_name'];
						$this->_arr[$key/3][$value['lang_locale']]['lang_value'] = $value['lang_value'];
						$this->_arr[$key/3][$value['lang_locale']]['lang_desc'] = $value['lang_desc'];
						$this->_arr[$key/3][$value['lang_locale']]['lang_category'] = $value['lang_category'];
					}
				}
			}
			$data = new _data($row);
			$gData = $data->get();

			if($stmt->num_rows > 0){
				for($i = 0; $i < $stmt->num_rows / 3; $i++){

					echo '<div class="col col-100 card-result-body" id="'.$gData[$i]['pt_BR']['lang_name'].'">
					<form method="POST">
					<div class="card-result-top">
						<div class="card-result-title">'.$gData[$i]['pt_BR']['lang_desc'].'</div>
						<div class="buttonsContainer">
							<button class="editbtn smallbtn" name="CONFIRM_LANG_EDIT" value="'.$gData[$i]['pt_BR']['lang_name'].'" title="Editar">
								<i class="fa-solid fa-paper-plane"></i>
							</button>
						</div>
					</div>
					<hr>
					<div class="card-result-content">
						<div class="form-group lang">
							<div class="lang-selector">
								<div data-lang="PT_BR" class="selected">PT</div>
								<div data-lang="EN_US">EN</div>
								<div data-lang="ES_ES">ES</div>
							</div>
							<div data-thislang="PT_BR" class="">
								<input type="text" name="'.$gData[$i]['pt_BR']['lang_name'].'[]" value="'.$gData[$i]['pt_BR']['lang_value'].'" />
							</div>
							<div data-thislang="EN_US" class="d-none">
								<input type="text" name="'.$gData[$i]['pt_BR']['lang_name'].'[]" value="'.$gData[$i]['en_US']['lang_value'].'" />
							</div>
							<div data-thislang="ES_ES" class="d-none">
								<input type="text" name="'.$gData[$i]['pt_BR']['lang_name'].'[]" value="'.$gData[$i]['es_ES']['lang_value'].'" />
							</div>
						</div>	
					</div>
					</form>
					</div>';
				}
			}else{
				echo '<div class="box-msg error">'.ERROR_QUERY_NORESULT.'</div>';
			}
			$stmt->close();
			$conn->close($conn->link);
		}

		if(isset($_POST['CONFIRM_LANG_EDIT'])){
			$lang_name = $_POST['CONFIRM_LANG_EDIT'];
			$lang_values = $_POST[$lang_name];

			foreach($lang_values as $key => $value){
				$conn->link = $conn->connect();
				if($stmt = $conn->link->prepare("UPDATE website_lang SET lang_value = ? WHERE lang_name = ? AND lang_locale = ?")){
					echo '<div class="overlayform" id="form2"><div class="modalform"><div class="modaldados text-center">
					<h2>Editando configuração...</h2></div></div></div>';
					try{
						if($key == 0){
							$lang_locale = 'pt_BR';
						}elseif($key == 1){
							$lang_locale = 'en_US';
						}else{
							$lang_locale = 'es_ES';
						}
						$stmt->bind_param('sss', $value, $lang_name, $lang_locale);
						$stmt->execute();
					}
					catch(Exception $e){
						throw new Exception('Erro ao conectar com a base de dados: '. $e);
					}
					echo '<script>window.location = window.location.pathname + "?success='. $lang_name . '"</script>';
					$stmt->close();
					$conn->close($conn->link);
				}
			}
		}
		if(isset($_POST['CONFIRM_ALL_LANG_EDIT'])){
			$allLang = $_POST['CONFIRM_ALL_LANG_EDIT'];
			$allLang = json_decode($allLang, true);

			$conn->link = $conn->connect();
			for($i = 0; $i < count($allLang); $i++){
				$lang_id = $allLang[$i][0];
				$lang_value = $allLang[$i][1];
				$lang_translation = $allLang[$i][2];
				
				if($stmt = $conn->link->prepare("UPDATE website_lang SET lang_value = ?, lang_translation = ? WHERE lang_id = ?")){

					echo '<div class="overlayform" id="form3"><div class="modalform"><div class="modaldados text-center">
					<h2>Editando configuração...</h2></div></div></div>';
					try{
						$stmt->bind_param('ssi', $lang_value, $lang_translation, $lang_id);
						$stmt->execute();
					}
					catch(Exception $e){
						throw new Exception('Erro ao conectar com a base de dados: '. $e);
					}
				}
				$stmt->close();
			}
			echo '<script>window.location = window.location.pathname + "?success=all"</script>';
			$conn->close($conn->link);
		}
	?>
	</div>
</main>
<?php include('cpanel_footer.php'); ?>
</body>
</html>