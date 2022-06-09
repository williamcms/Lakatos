<?php 
include('cfg/core.php');
include('cfg/users_class.php');

$account->sessionLogin();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
	<title><?php echo $website->title; ?>: Contas</title>
	<?php require_once('header-cpainel.php'); ?>
</head>
<body>
	<?php include('hm_menu_cpanel.php'); ?>
<main class="users">
	<h2 class="text-center pt-3">Gerenciamento de Usuários do Painel</h2>
	<div class="card-box">
		<div class="row">
			<div class="col"><h4>Usuários</h4></div>
			<div class="col"><form method="POST" id="NEW_USER"><input type="text" name="ADD_USER" hidden><a href="#" class="button2 card_button-add" onclick="$('#NEW_USER').submit();"><span>Novo Usuário</span></a></form></div>
		</div>
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
						$sqlOpt = 'ORDER BY active';
						$opt0 = '&opt='. (!$opt ? 1 : 0);
						$optArrow0 = (!$opt ? $ASC : $DESC);
						$sqlOptOrder = (!$opt ? 'ASC' : 'DESC');
						break;
					case 1:
						$sqlOpt = 'ORDER BY username';
						$opt1 = '&opt='. (!$opt ? 1 : 0);
						$optArrow1 = (!$opt ? $ASC : $DESC);
						$sqlOptOrder = (!$opt ? 'ASC' : 'DESC');
						break;
					case 2:
						$sqlOpt = 'WHERE email = "" OR name = "" ORDER BY id';
						$opt2 = '&opt='. (!$opt ? 1 : 0);
						$optArrow2 = (!$opt ? $ASC : $DESC);
						$sqlOptOrder = (!$opt ? 'ASC' : 'DESC');
						break;
					default:
						$sqlOpt = 'ORDER BY id';
						$sqlOptOrder = 'ASC';
						break;
				}
				if(isset($_GET['order'])){
					echo '<div class="col text-center"><div id="sortingOptions">Ordenar por | 
					<span class="option"><a href="?order=1'.$opt1.'">Username '.$optArrow1.'</a></span> | 
					<span class="option"><a href="?order=0'.$opt0.'">Ativo '.$optArrow0.'</a></span> | 
					<span class="option"><a href="?order=2'.$opt2.'">Pendências '.$optArrow2.'</a></span> | 
					<span class="option"><a href="cp-users">Reset</a></span></div></div>';
				} else{
					echo '<div class="col text-center"><div id="sortingOptions">Ordenar por | 
					<span class="option"><a href="?order=1&opt=0">Username</a></span> | 
					<span class="option"><a href="?order=0&opt=0">Ativo</a></span> | 
					<span class="option"><a href="?order=2&opt=0">Pendências</a></span> | 
					<span class="option"><a href="cp-users">Reset</a></span></div></div>';
				}
			?>
		</div>
	</div>
	<div class="row card-box-results">
	<?php
		$conn->link = $conn->connect();

		echo '<p class="text-muted orderby">Ordenando por: '. $sqlOpt .' '. $sqlOptOrder .'</p>';

		if($stmt = $conn->link->prepare("SELECT * FROM users ".$sqlOpt." ". $sqlOptOrder)){
			try{
				$stmt->execute();
				$row = get_result($stmt);
			}
			catch(Exception $e){
				throw new Exception('Erro ao conectar com a base de dados: '. $e);
			}

			if($stmt->num_rows > 0){
				for($i = 0; $i < $stmt->num_rows; $i++){
					(empty($row[$i]['name']) ? $NAME_REPAIR = '<i class="fas fa-exclamation-triangle"></i>' : $NAME_REPAIR = '');
					($row[$i]['active'] == 0 ? $NOTACTIVE = 'opacity: 0.7;' : $NOTACTIVE = '');
					(empty($row[$i]['email']) ? $EMAIL_REPAIR = '<i class="fas fa-exclamation-triangle"></i>' : $EMAIL_REPAIR = '');

					echo '<div class="col col-100 card-result-body" style="'.$NOTACTIVE.'">
					<div class="card-result-top">
					<div class="card-result-title">'.$row[$i]['username'].'</div>
					<form method="POST">
					<input name="user_username" type="text" value="'.$row[$i]['username'].'" hidden>
					<div class="buttonsContainer">';
					if(!($row[$i]['id'] == 1) && !($row[$i]['id'] == 2)){
						echo '<button class="closebtn smallbtn" name="REMOVE_USER" value="'.$row[$i]['id'].'">
								<i class="fas fa-user-times"></i></button>';
					}                        
					echo '<button class="editbtn smallbtn" name="EDIT_USER" value="'.$row[$i]['id'].'" title="Editar">
							<i class="far fa-edit"></i></button>
							</div></form></div>
							<hr><div class="card-result-content">
							<p>Identificação: '.$row[$i]['id'].'</p>
							<p>Nome: '.$row[$i]['name'].$NAME_REPAIR. '</p>
							<p>Email: '.$row[$i]['email'].$EMAIL_REPAIR. '</p>
							<p>Status da Conta: '.($row[$i]['active'] ? 'Ativa' : 'Desativada'). '</p>
							</div></div>';
				}

			} else{
					echo '<div class="box-msg error">'.ERROR_QUERY_NORESULT.'</div>';
			}
		}

		if(isset($_POST['EDIT_USER'])){
			$user_id = $_POST['EDIT_USER'];

			if($stmt = $conn->link->prepare("SELECT * FROM users WHERE id = ?")){
				try{
					$stmt->bind_param('i', $user_id);
					$stmt->execute();
					$row = get_result($stmt);
				}
				catch(Exception $e){
					throw new Exception('Erro ao conectar com a base de dados: '. $e);
				}
				echo '<div class="overlayform" id="form1"><div class="modalform"><div class="modaldados">
				<button class="closebtn" onclick="formOff(1);" aria-label="Fechar Janela">&times;</button>
				<form method="POST" id="form">
					<h2 class="text-center">Alterar usuário</h2>
					<div class="form-group"><label>Id do usuário <span class="text-muted">(não editável)</span></label> <input type="text" name="user_id" value="'.$row[0]['id'].'" readonly></div>
					<div class="form-group"><label>Usuário</label> <input type="text" name="user_username" value="'.$row[0]['username'].'"></div>
					<div class="form-group"><label>Nome</label> <input type="text" name="user_name" value="'.$row[0]['name'].'"></div>
					<div class="form-group"><label>Email</label> <input type="text" name="user_email" value="'.$row[0]['email'].'"></div>
					<div class="form-group"><label>Ativo? Isto afetara se o usuário pode entrar no painel de controle.</label>
					<span class="range_input_value">'.$row[0]['active'].'</span>/1
					<input type="range" min="0" max="1" value="'.$row[0]['active'].'" name="user_active" class="range_input"></div>
					
					<button class="button btn-success" name="CONFIRM_USER_EDIT"><span>Confirmar</span></button>
					<button class="button2 btn-warning" name="CHANGE_PASW_USER"><span>Alterar Senha</span></button>
				</form></div></div></div>';
				echo '<script>formOn(1);</script>';
			}
		}
		if(isset($_POST['CONFIRM_USER_EDIT'])){

			$conn->link = $conn->connect();
			if($stmt = $conn->link->prepare("UPDATE users SET username = ?, name = ?, email = ?, active = ? WHERE id = ?")){

				try{
					$stmt->bind_param('sssii', $user_username, $user_name, $user_email, $user_active, $user_id);
					$user_username = $_POST['user_username'];
					$user_name = $_POST['user_name'];
					$user_email = $_POST['user_email'];
					$user_active = $_POST['user_active'];
					$user_id = $_POST['user_id'];

					$stmt->execute();
				}
				catch(Exception $e){
					throw new Exception('Erro ao conectar com a base de dados: '. $e);
				}
				echo '<script>reload();</script>';
			}
		}
		if(isset($_POST['CHANGE_PASW_USER'])){
			$user_id = $_POST['user_id'];

			echo '<div class="overlayform" id="form2"><div class="modalform"><div class="modaldados">
			<button class="closebtn" onclick="formOff(2);" aria-label="Fechar Janela">&times;</button>
			<form method="POST" id="form">
				<h2 class="text-center">Alterar senha</h2>
				<div class="form-group"><label>Id do usuário <span class="text-muted">(não editável)</span></label> <input type="text" name="user_id" value="'.$user_id.'" readonly></div>
				<div class="form-group"><label>Senha atual</label> <input type="password" name="old_password" required></div>
				<div class="form-group">
					<div class="row">
						<div class="col"><label>Nova Senha</label></div>
						<div class="col confirmPassword"><label>Confirme a Senha</label> <span id="confirmPassword" style="color: var(--danger);"></span></div>

					</div>
					<div class="row">
						<div class="col"><input type="password" name="user_password" id="password" placeholder="A senha deve ter pelo menos 6 digitos" required></div>
						<div class="col confirmPassword2"><label>Confirme a Senha</label> <span id="confirmPassword" style="color: var(--danger);"></span></div>
						<div class="col"><input type="password" name="user_password2" id="password2" placeholder="A senha deve ter pelo menos 6 digitos" required></div>
					</div>
				</div>
				
				<button class="button btn-success" name="CONFIRM_CHANGE_PASW_USER"><span>Confirmar</span></button>
			</form></div></div></div>';
			echo '<script>formOn(2);</script>';
		}
		if(isset($_POST['CONFIRM_CHANGE_PASW_USER'])){
			$user_id = $_POST['user_id'];
			$new_psw = $_POST['user_password'];
			$new_psw2 = $_POST['user_password2'];
			$old_psw = $_POST['old_password'];


			$conn->link = $conn->connect();

			try{
				//check both new and old passwords
				if($new_psw === $new_psw2){	
					$change_psw = $account->changePassword($user_id, $new_psw, $old_psw);
				}
			}
			catch (Exception $e){
				echo $e->getMessage();
				die();
			}
			echo '<script>reload();</script>';
			
		}
		if(isset($_POST['REMOVE_USER'])){
			$user_username = $_POST['user_username'];
			$user_id = $_POST['REMOVE_USER'];

			echo '<div class="overlayform" id="form3"><div class="modalform"><div class="modaldados text-center">
			<button class="closebtn" onclick="formOff(3);" aria-label="Fechar Janela">&times;</button>
			<form method="POST">
				<h2>Tem certeza que quer apagar este usuário?</h2>
				<h3 class="destaque">'.$user_username.' (id: '.$user_id.')</h3><br>
				<input name="user_username" type="text" value="'.$user_username.'" hidden>
				<button class="button" style="background-color: var(--danger); color: var(--white);" name="CONFIRM_USER_REM" value="'.$user_id.'"><span>Confirmar</span></button>
			</form></div></div></div>';
			echo '<script>formOn(3);</script>';
		}

		if(isset($_POST['CONFIRM_USER_REM'])){
			$user_username = $_POST['user_username'];
			$user_id = $_POST['CONFIRM_USER_REM'];

			$conn->link = $conn->connect();

			try{
				//(username, name, email, password, permissions, active)
				$rmvUser = $account->rmvUser($user_username, $user_id);
			}
			catch (Exception $e){
				echo $e->getMessage();
				die();
			}
			echo '<script>reload();</script>';
			
		}

		if(isset($_POST['ADD_USER'])){
			echo '<div class="overlayform" id="form5"><div class="modalform"><div class="modaldados">
			<button class="closebtn" onclick="formOff(5);" aria-label="Fechar Janela">&times;</button>
			<form method="POST" id="form">
				<h2 class="text-center">Criar nova conta de usuário</h2>
				<div class="form-group"><label>Username</label> <input type="text" name="user_username" required></div>
				<div class="form-group"><label>Nome Completo</label> <input type="text" name="user_name" required></div>
				<div class="form-group"><label>Email</label> <input type="text" name="user_email" required></div>
				<div class="form-group">
					<div class="row">
						<div class="col"><label>Senha</label></div>
						<div class="col confirmPassword"><label>Confirme a Senha</label> <span id="confirmPassword" style="color: var(--danger);"></span></div>

					</div>
					<div class="row">
						<div class="col"><input type="password" name="user_password" id="password" placeholder="A senha deve ter pelo menos 6 digitos" required></div>
						<div class="col confirmPassword2"><label>Confirme a Senha</label> <span id="confirmPassword" style="color: var(--danger);"></span></div>
						<div class="col"><input type="password" name="user_password2" id="password2" placeholder="A senha deve ter pelo menos 6 digitos" required></div>
					</div>
				</div>
				<div class="form-group"><label>Usuário ativo? <span class="text-muted">(Isso determina a permissão para fazer login no painel)</span></label>
				<span class="range_input_value">0</span>/1<input type="range" min="0" max="1" value="0" name="user_active" class="range_input"></div>

				
				<button class="button btn-success" name="CONFIRM_USER_ADD"><span>Confirmar</span></button>
			</form></div></div></div>';
			echo '<script>formOn(5);</script>';
		}
		if(isset($_POST['CONFIRM_USER_ADD'])){
			$user_username = $_POST['user_username'];
			$user_name = $_POST['user_name'];
			$user_email = $_POST['user_email'];
			$user_password = $_POST['user_password'];
			$user_password2 = $_POST['user_password2'];
			$user_active = $_POST['user_active'];

			if($user_password == $user_password2){
				try{
					//(username, name, email, password, permissions, active)
					$newUser = $account->addUser($user_username, $user_name, $user_email, $user_password, $user_active);
				}
				catch (Exception $e){
					echo $e->getMessage();
					die();
				}
				echo '<script>reload();</script>';
			} else{
				echo '<script>alert("Senhas não coincidem");</script>';
			}            
		}
	?>
	</div>
</main>
<?php include('cpanel_footer.php'); ?>
</body>
</html>