<?php 
include('cfg/core.php');
include('cfg/users_class.php');

$account->sessionLogin();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
	<title><?php echo $website->title; ?>: Contas</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="robots" content="noindex, nofollow">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<!-- Styles -->
	<link rel="stylesheet" href="<?php echo url(); ?>/css/cpanel.css?v=2.0"> <!-- mudar --->
	<!-- Scripts -->	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="<?php echo url(); ?>/js/cpanel.js?v=1.8"></script>  <!-- mudar --->
    <!-- Icons -->
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo url(); ?>/apple-touch-icon.png<?php echo $website->iconVersion; ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo url(); ?>/favicon-32x32.png<?php echo $website->iconVersion; ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo url(); ?>/favicon-16x16.png<?php echo $website->iconVersion; ?>">
    <link rel="manifest" href="<?php echo url(); ?>/site.webmanifest<?php echo $website->iconVersion; ?>">
    <link rel="mask-icon" href="<?php echo url(); ?>/safari-pinned-tab.svg<?php echo $website->iconVersion; ?>" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
	<!-- Open Graph-->
    <meta property="og:locale" content="pt_BR">
    <meta property="og:type" content="website">
    <meta property="og:title" content="<?php echo $website->title; ?>">
    <meta property="og:description" content="<?php echo $website->description; ?>">
    <meta property="og:url" content="<?php echo url() ?>">
    <meta property="og:site_name" content="<?php echo $website->title; ?>">
    <meta property="og:image" content="<?php echo $website->image; ?>">
    <!-- Facebook -->
    <?php
        if($fb->page){
            echo '<meta property="fb:page_id" content="'.$fb->page.'" />';
        }
        if($fb->app){
            echo '<meta property="fb:app_id" content="'.$fb->app.'" />';
        }
    ?>
    
    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo $website->title; ?>">
    <meta name="twitter:description" content="<?php echo $website->description; ?>">
    <meta name="twitter:url" content="<?php echo url(); ?>">
    <!-- Other tags -->
    <meta name="description" content="<?php echo $website->description; ?>">
    <meta name="author" content="<?php echo $website->author; ?>">
    <meta name="keywords" content="<?php echo $website->keywords; ?>"/>
    <!-- Location -->
    <?php
    if($location->stAddress){
        echo '<meta name="og:street-address" content="'.$location->stAddress.'"/>';
    }
    if($location->locality){
        echo '<meta name="og:locality" content="'.$location->locality.'"/>';
    }
    if($location->region){
        echo '<meta name="og:region" content="'.$location->region.'"/>';
    }
    if($location->postalCode){
        echo '<meta name="og:postal-code" content="'.$location->postalCode.'"/>';
    }
    if($location->country){
        echo '<meta name="og:country-name" content="'.$location->country.'"/>';
    }
    ?>

    <!-- Info -->
    <?php
    if($email->address){
        echo '<meta name="og:email" content="'.$email->address.'"/>';
    }
    if($location->phoneNumber){
        echo '<meta name="og:phone_number" content="'.$location->phoneNumber.'"/>';
    }
    ?>

    <noscript><p class="text-center popup popup-red">Oh não! Um erro ocorreu, para viualizar melhor está página é necessário ativar o javascript. Saiba mais <a href="https://www.enable-javascript.com/pt/" target="_blank">clicando aqui</a>.</p></noscript>
</head>
<body>
    <?php include('hm_menu_cpanel.php'); ?>
<main class="users">
    <h2 class="text-center" style="padding-top: 20px;">Gerenciamento de Usuários do Painel de Controle</h2>
    <div class="card-box">
        <div class="row">
            <div class="col"><h4>Usuários</h4></div>
            <div class="col"><form method="POST" id="NEW_USER"><input type="text" name="ADD_USER" hidden><a href="#" class="button2 card_button-add" onclick="$('#NEW_USER').submit();"><span>Novo Usuário</span></a></form></div>
        </div>
        <div class="row">
            <?php 
                if(isset($_GET['order'])){
                    $option = stripslashes($_GET['order']);

                    $ASC = '<i class="fas fa-sort-up"></i>';
                    $DESC = '<i class="fas fa-sort-down"></i>';

                    $opt1 = $opt0 = $opt2 = '&opt=0';
                    $optArrow1 = $optArrow0 = $optArrow2 = '';

                    switch($option){
                        case 0:
                            $sqlOpt = 'ORDER BY active';
                            $opt0 = '&opt='. (!stripslashes($_GET['opt']) ? 1 : 0);
                            $optArrow0 = (!stripslashes($_GET['opt']) ? $ASC : $DESC);
                            $sqlOptOrder = (!stripslashes($_GET['opt']) ? 'ASC' : 'DESC');
                            break;
                        case 1:
                            $sqlOpt = 'ORDER BY username';
                            $opt1 = '&opt='. (!stripslashes($_GET['opt']) ? 1 : 0);
                            $optArrow1 = (!stripslashes($_GET['opt']) ? $ASC : $DESC);
                            $sqlOptOrder = (!stripslashes($_GET['opt']) ? 'ASC' : 'DESC');
                            break;
                        case 2:
                            $sqlOpt = 'WHERE email = "" OR name = "" ORDER BY id';
                            $opt2 = '&opt='. (!stripslashes($_GET['opt']) ? 1 : 0);
                            $optArrow2 = (!stripslashes($_GET['opt']) ? $ASC : $DESC);
                            $sqlOptOrder = (!stripslashes($_GET['opt']) ? 'ASC' : 'DESC');
                            break;
                        default:
                            $sqlOpt = 'ORDER BY id';
                            $sqlOptOrder = 'ASC';
                            break;
                    }

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

        if(isset($_GET['order'])){

            echo '<p class="text-muted" style="position: absolute; margin-top:-20px;">Ordenando por: '. $sqlOpt .' '. $sqlOptOrder .'</p>';

            if($stmt = $conn->link->prepare("SELECT * FROM users ".$sqlOpt." ". $sqlOptOrder)){
                try{
                    $stmt->execute();
                    $row = $account->get_result($stmt);
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
                        <div class="card-result-title">'.$row[$i]['username'].'</div>
                        <form method="POST">
                        <input name="user_username" type="text" value="'.$row[$i]['username'].'" hidden>
                        <input name="user_name" type="text" value="'.$row[$i]['name'].'" hidden>
                        <input name="user_active" type="text" value="'.$row[$i]['active'].'" hidden>';
                        if($row[$i]['id'] == 1 || $row[$i]['id'] == 2){}
                        else{
                            echo '<button class="closebtn smallbtn" name="REMOVE_USER" value="'.$row[$i]['id'].'" style="right: 35px;"><i class="fas fa-user-times"></i></button>';
                        }                        
                        echo '<button class="editbtn smallbtn" name="EDIT_USER" value="'.$row[$i]['id'].'" title="Editar">
                        <i class="far fa-edit"></i></button></form>
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
        }else{
            if($stmt = $conn->link->prepare("SELECT * FROM users ORDER BY id")){
                try{
                    $stmt->execute();
                    $row = $account->get_result($stmt);
                }
                catch(Exception $e){
                    throw new Exception('Erro ao conectar com a base de dados: '. $e);
                }

                if($stmt->num_rows > 0){
                    for($i = 0; $i < $stmt->num_rows; $i++){
                        (empty($row[$i]['name']) ? $NAME_REPAIR = '<i class="fas fa-exclamation-triangle"></i>' : $NAME_REPAIR = '');
                        ($row[$i]['active'] == 0 ? $NOTACTIVE = 'opacity: 0.7;' : $NOTACTIVE = '');
                        (empty($row[$i]['email']) ? $EMAIL_REPAIR = '<i class="fas fa-exclamation-triangle"></i>' : $EMAIL_REPAIR = '');

                        echo '<div class="col col-100 card-result-body" style="order: '.$row[$i]['id'].';'.$NOTACTIVE.'">
                        <div class="card-result-title">'.$row[$i]['username'].'</div>
                        <form method="POST">
                        <input name="user_username" type="text" value="'.$row[$i]['username'].'" hidden>
                        <input name="user_name" type="text" value="'.$row[$i]['name'].'" hidden>
                        <input name="user_active" type="text" value="'.$row[$i]['active'].'" hidden>
                        <input name="user_email" type="text" value="'.$row[$i]['email'].'" hidden>';
                        if($row[$i]['id'] == 1 || $row[$i]['id'] == 2){}
                        else{
                            echo '<button class="closebtn smallbtn" name="REMOVE_USER" value="'.$row[$i]['id'].'" style="right: 35px;"><i class="fas fa-user-times"></i></button>';
                        }                        
                        echo '<button class="editbtn smallbtn" name="EDIT_USER" value="'.$row[$i]['id'].'" title="Editar">
                        <i class="far fa-edit"></i></button></form>
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
        }

        if(isset($_POST['EDIT_USER'])){
            $user_username = $_POST['user_username'];
            $user_username = stripslashes($user_username);
            $user_username = mysqli_real_escape_string($conn->link, $user_username);

            $user_name = $_POST['user_name'];
            $user_name = stripslashes($user_name);
            $user_name = mysqli_real_escape_string($conn->link, $user_name);

            $user_email = $_POST['user_email'];
            $user_email = stripslashes($user_email);
            $user_email = mysqli_real_escape_string($conn->link, $user_email);

            $user_active = $_POST['user_active'];
            $user_active = stripslashes($user_active);
            $user_active = mysqli_real_escape_string($conn->link, $user_active);

            $user_id = $_POST['EDIT_USER'];
            echo '<div class="overlayform" id="form1"><div class="modalform"><div class="modaldados">
            <span aria-hidden="true" class="closebtn" onclick="formOff(1);">&times;</span>
            <form method="POST" id="form">
                <h2 class="text-center">Preencha as informações abaixo para alterar o usuário!</h2>
                <div class="form-group"><label>Id do usuário <span class="text-muted">(não editável)</span></label> <input type="text" name="user_id" value="'.$user_id.'" readonly></div>
                <div class="form-group"><label>Usuário</label> <input type="text" name="user_username" value="'.$user_username.'"></div>
                <div class="form-group"><label>Nome</label> <input type="text" name="user_name" value="'.$user_name.'"></div>
                <div class="form-group"><label>Email</label> <input type="text" name="user_email" value="'.$user_email.'"></div>
                <div class="form-group"><label>Ativo? Isto afetara se o usuário pode entrar no painel de controle. <span id="range_input_value">'.$user_active.'</span>/1</label><input type="range" min="0" max="1" value="'.$user_active.'" name="user_active" id="range_input"></div>
                
                <button class="button" style="background-color: var(--green); color: var(--white);" name="CONFIRM_USER_EDIT"><span>Confirmar</span></button>
                <button class="button2" style="background-color: var(--warning); color: var(--white);" name="RESET_PASW_USER" disabled><span>Resetar Senha</span></button>
            </form></div></div></div>';
            echo '<script>formOn(1);</script>';
        }
        if(isset($_POST['CONFIRM_USER_EDIT'])){

            $conn->link = $conn->connect();
            if($stmt = $conn->link->prepare("UPDATE users SET username = ?, name = ?, email = ?, active = ? WHERE id = ?")){

                echo '<div class="overlayform" id="form2"><div class="modalform"><div class="modaldados text-center"><span aria-hidden="true" class="closebtn" onclick="formOff(2);">&times;</span><h2>Criando anotação...</h2></div></div></div>';
                try{
                    $stmt->bind_param('sssii', $user_username, $user_name, $user_email, $user_active, $user_id);
                    $user_id = $_POST['user_id'];
                    $user_id = stripslashes($user_id);
                    $user_id = mysqli_escape_string($conn->link, $user_id);
                    $user_username = $_POST['user_username'];
                    $user_username = stripslashes($user_username);
                    $user_username = mysqli_escape_string($conn->link, $user_username);
                    $user_name = $_POST['user_name'];
                    $user_name = stripslashes($user_name);
                    $user_name = mysqli_escape_string($conn->link, $user_name);
                    $user_email = $_POST['user_email'];
                    $user_email = stripslashes($user_email);
                    $user_email = mysqli_escape_string($conn->link, $user_email);
                    $user_active = $_POST['user_active'];
                    $user_active = stripslashes($user_active);
                    $user_active = mysqli_escape_string($conn->link, $user_active);
                    $stmt->execute();
                }
                catch(Exception $e){
                    throw new Exception('Erro ao conectar com a base de dados: '. $e);
                }
                echo '<script>formOff(2);</script>';
            }
        }
        if(isset($_POST['REMOVE_USER'])){
            $user_username = $_POST['user_username'];
            $user_username = stripslashes($user_username);
            $user_username = mysqli_real_escape_string($conn->link, $user_username);

            $user_id = $_POST['REMOVE_USER'];
            $user_id = stripslashes($user_id);
            $user_id = mysqli_real_escape_string($conn->link, $user_id);

            echo '<div class="overlayform" id="form3"><div class="modalform"><div class="modaldados text-center">
            <span aria-hidden="true" class="closebtn" onclick="formOff(3);">&times;</span>
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
            $user_username = stripslashes($user_username);
            $user_username = mysqli_real_escape_string($conn->link, $user_username);

            $user_id = $_POST['CONFIRM_USER_REM'];
            $user_id = stripslashes($user_id);
            $user_id = mysqli_real_escape_string($conn->link, $user_id);
            $conn->link = $conn->connect();
            echo '<div class="overlayform" id="form4"><div class="modalform"><div class="modaldados text-center"><span aria-hidden="true" class="closebtn" onclick="formOff(4);">&times;</span><h2>Excluindo anotação (id: '.$_POST['CONFIRM_USER_REM'].')</h2></div></div></div>';
            try{
                //(username, name, email, password, permissions, active)
                $rmvUser = $account->rmvUser($user_username, $user_id);
            }
            catch (Exception $e){
                echo $e->getMessage();
                die();
            }
            echo '<script>formOff(4);</script>';
            
        }

        if(isset($_POST['ADD_USER'])){
            echo '<div class="overlayform" id="form5"><div class="modalform"><div class="modaldados">
            <span aria-hidden="true" class="closebtn" onclick="formOff(5);">&times;</span>
            <form method="POST" id="form">
                <h2 class="text-center">Preencha as informações abaixo para inserir uma nova conta de usuário:</h2>
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
                <div class="form-group"><label>Permissão <span id="range_input_value">0</span>/9</label><input type="range" min="0" max="9" value="0" name="user_permission" id="range_input"></div>
                <div class="form-group"><label>Usuário ativo? <span class="text-muted">(Isso afetará se o usuário consegue fazer login no painel de controle)</span> <span id="range_input_value2">0</span>/1</label><input type="range" min="0" max="1" value="0" name="user_active" id="range_input2"></div>

                
                <button class="button" style="background-color: var(--green); color: var(--white);" name="CONFIRM_USER_ADD"><span>Confirmar</span></button>
            </form></div></div></div>';
            echo '<script>formOn(5);</script>';
        }
        if(isset($_POST['CONFIRM_USER_ADD'])){
            $user_username = $_POST['user_username'];
            $user_username = stripslashes($user_username);
            $user_username = mysqli_escape_string($conn->link, $user_username);
            $user_name = $_POST['user_name'];
            $user_name = stripslashes($user_name);
            $user_name = mysqli_escape_string($conn->link, $user_name);
            $user_email = $_POST['user_email'];
            $user_email = stripslashes($user_email);
            $user_email = mysqli_escape_string($conn->link, $user_email);
            $user_password = $_POST['user_password'];
            $user_password = stripslashes($user_password);
            $user_password = mysqli_escape_string($conn->link, $user_password);
            $user_password2 = $_POST['user_password2'];
            $user_password2 = stripslashes($user_password2);
            $user_password2 = mysqli_escape_string($conn->link, $user_password2);
            $user_permission = $_POST['user_permission'];
            $user_permission = stripslashes($user_permission);
            $user_permission = mysqli_escape_string($conn->link, $user_permission);
            $user_active = $_POST['user_active'];
            $user_active = stripslashes($user_active);
            $user_active = mysqli_escape_string($conn->link, $user_active);

            echo '<div class="overlayform" id="form6"><div class="modalform"><div class="modaldados text-center"><span aria-hidden="true" class="closebtn" onclick="formOff(6);">&times;</span><h2>Removendo usuário...</h2></div></div></div>';

            if($user_password == $user_password2){
                try{
                    //(username, name, email, password, permissions, active)
                    $newUser = $account->addUser($user_username, $user_name, $user_email, $user_password, $user_permission);
                }
                catch (Exception $e){
                    echo $e->getMessage();
                    die();
                }
                echo '<script>formOff(6);</script>';
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