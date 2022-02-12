<?php 
include('cfg/core.php');
include('cfg/users_class.php');

$account->sessionLogin();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
	<title><?php echo $website->title; ?>: Home</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="robots" content="noindex, nofollow">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<!-- Styles -->
	<link rel="stylesheet" href="<?php echo url(); ?>/css/cpanel.css?v=1.8"> <!-- mudar --->
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
<main class="notes">
    <h2 class="text-center" style="padding-top: 20px;">Bem-vindo, <span class="destaque"><?php echo $_SESSION['username']; ?></span>! </h2>
    <div class="card-box">
        <div class="row">
            <div class="col"><h4>Quadro de Avisos</h4></div>
            <div class="col"><form method="POST" id="NEW_NOTE"><input type="text" name="ADD_NOTE" hidden><a href="#" class="button2 card_button-add" onclick="$('#NEW_NOTE').submit();"><span>Novo Aviso</span></a></form></div>
        </div>
        <div class="row">
            <?php 
                if(isset($_GET['order'])){
                    $option = stripslashes($_GET['order']);

                    $ASC = '<i class="fas fa-sort-up"></i>';
                    $DESC = '<i class="fas fa-sort-down"></i>';

                    $opt1 = $opt0 = '&opt=0';
                    $optArrow1 = $optArrow0 = '';

                    switch($option){
                        case 0:
                            $sqlOpt = 'note_timestamp';
                            $opt0 = '&opt='. (!stripslashes($_GET['opt']) ? 1 : 0);
                            $optArrow0 = (!stripslashes($_GET['opt']) ? $ASC : $DESC);
                            $sqlOptOrder = (!stripslashes($_GET['opt']) ? 'ASC' : 'DESC');
                            break;
                        case 1:
                            $sqlOpt = 'note_priority';
                            $opt1 = '&opt='. (!stripslashes($_GET['opt']) ? 1 : 0);
                            $optArrow1 = (!stripslashes($_GET['opt']) ? $ASC : $DESC);
                            $sqlOptOrder = (!stripslashes($_GET['opt']) ? 'ASC' : 'DESC');
                            break;
                        default:
                            $sqlOpt = 'note_id';
                            $sqlOptOrder = 'ASC';
                            break;
                    }

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

        if(isset($_GET['order'])){

            echo '<p class="text-muted" style="position: absolute; margin-top:-20px;">Ordenando por: '. $sqlOpt .' '. $sqlOptOrder .'</p>';

            if($stmt = $conn->link->prepare("SELECT * FROM users_notes ORDER BY ".$sqlOpt." ". $sqlOptOrder)){
                try{
                    $stmt->execute();
                    $row = $account->get_result($stmt);
                }
                catch(Exception $e){
                    throw new Exception('Erro ao conectar com a base de dados: '. $e);
                }

                if($stmt->num_rows > 0){
                    for($i = 0; $i < $stmt->num_rows; $i++){
                            /*$texto = mb_substr($row[$i]['note_content'], 0, 510);
                            if(strlen($row[$i]['note_content'])>510){
                                $texto .= " (...)";
                            }*/
                        echo '<div class="col card-result-body"><div class="card-result-title">'.$row[$i]['note_title'].'</div><form method="POST"><input name="note_name" type="text" value="'.$row[$i]['note_title'].'" hidden><button class="closebtn smallbtn" name="REMOVE_NOTE" value="'.$row[$i]['note_id'].'"><i class="far fa-trash-alt"></i></button></form><hr><div class="card-result-content">'.$row[$i]['note_content'].'</div></div>';
                    }

                } else{
                        echo '<div class="box-msg error">'.ERROR_QUERY_NORESULT.'</div>';
                }
            }
        }else{
            if($stmt = $conn->link->prepare("SELECT * FROM users_notes ORDER BY note_id")){
                try{
                    $stmt->execute();
                    $row = $account->get_result($stmt);
                }
                catch(Exception $e){
                    throw new Exception('Erro ao conectar com a base de dados: '. $e);
                }

                if($stmt->num_rows > 0){
                    for($i = 0; $i < $stmt->num_rows; $i++){
                        /*$texto = mb_substr($row[$i]['note_content'], 0, 510);
                            if(strlen($row[$i]['note_content'])>510){
                                $texto .= " (...)";
                        }*/
                        echo '<div class="col card-result-body" style="order: '.$row[$i]['note_id'].';"><div class="card-result-title">'.$row[$i]['note_title'].'</div><form method="POST"><input name="note_name" type="text" value="'.$row[$i]['note_title'].'" hidden><button class="closebtn smallbtn" name="REMOVE_NOTE" value="'.$row[$i]['note_id'].'"><i class="far fa-trash-alt"></i></button></form><hr><div class="card-result-content"><p>'.$row[$i]['note_content'].'</p></div></div>';
                    }

                } else{
                        echo '<div class="box-msg error">'.ERROR_QUERY_NORESULT.'</div>';
                }
            }
        }

        if(isset($_POST['REMOVE_NOTE'])){
            echo '<div class="overlayform" id="form1"><div class="modalform"><div class="modaldados text-center">
            <span aria-hidden="true" class="closebtn" onclick="formOff(1);">&times;</span>
            <form method="POST">
                <h2>Tem certeza que quer apagar a anotação?</h2>
                <h3 class="destaque">'.$_POST['note_name'].' (id: '.$_POST['REMOVE_NOTE'].')</h3><br>
                <button class="button" style="background-color: var(--danger); color: var(--white);" name="CONFIRM_NOTE_REM" value="'.stripslashes($_POST['REMOVE_NOTE']).'"><span>Confirmar</span></button>
            </form></div></div></div>';
            echo '<script>formOn(1);</script>';
        }
        if(isset($_POST['CONFIRM_NOTE_REM'])){
            $conn->link = $conn->connect();
            $note_id = stripslashes($_POST['CONFIRM_NOTE_REM']);
            if($stmt = $conn->link->prepare("DELETE FROM users_notes WHERE note_id = ?")){
                echo '<div class="overlayform" id="form2"><div class="modalform"><div class="modaldados text-center"><span aria-hidden="true" class="closebtn" onclick="formOff(2);">&times;</span><h2>Excluindo anotação (id: '.$_POST['CONFIRM_NOTE_REM'].')</h2></div></div></div>';
                try{
                    $stmt->bind_param('i', $note_id);
                    $stmt->execute();
                }
                catch(Exception $e){
                    throw new Exception('Erro ao conectar com a base de dados: '. $e);
                }
                echo '<script>formOff(2);</script>';
            }
        }

        if(isset($_POST['ADD_NOTE'])){
            echo '<div class="overlayform" id="form1"><div class="modalform"><div class="modaldados">
            <span aria-hidden="true" class="closebtn" onclick="formOff(1);">&times;</span>
            <form method="POST" id="form">
                <h2 class="text-center">Preencha as informações abaixo para inserir uma nova nota:</h2>
                <div class="form-group"><label>Título</label> <input type="text" name="note_title"></div>
                <div class="form-group"><label>Descrição</label> <textarea name="note_content" maxlength="520"></textarea></div>
                <div class="form-group"><label>Prioridade</label> <span class="range_input_value">0</span>/9<input type="range" min="0" max="9" value="0" name="note_priority" class="range_input"></div>

                
                <button class="button" style="background-color: var(--green); color: var(--white);" name="CONFIRM_NOTE_ADD"><span>Confirmar</span></button>
            </form></div></div></div>';
            echo '<script>formOn(1);</script>';
        }
        if(isset($_POST['CONFIRM_NOTE_ADD'])){

            $conn->link = $conn->connect();
            if($stmt = $conn->link->prepare("INSERT INTO users_notes (note_title, note_content, note_timestamp, note_priority) VALUES (?, ?, NOW(), ?)")){

                echo '<div class="overlayform" id="form2"><div class="modalform"><div class="modaldados text-center"><span aria-hidden="true" class="closebtn" onclick="formOff(2);">&times;</span><h2>Criando anotação...</h2></div></div></div>';
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
                echo '<script>formOff(2);</script>';
            }
        }


    ?>
    </div>
</main>
<?php include('cpanel_footer.php'); ?>
</body>
</html>