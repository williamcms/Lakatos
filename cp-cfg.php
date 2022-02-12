<?php 
include('cfg/core.php');
include('cfg/users_class.php');

$account->sessionLogin();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
	<title><?php echo $website->title; ?>: Configurações do Website</title>
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
<main class="cfg">
    <h2 class="text-center" style="padding-top: 20px;">Gerenciamento do Website</h2>
    <div class="card-box">
        <div class="row">
            <!--
            <div class="col"><h4>Configurações</h4></div>
            
            <div class="col"><form method="POST" id="NEW_CONFIG"><input type="text" name="ADD_CONFIG" hidden><a href="#" class="button2 card_button-add" onclick="$('#NEW_CONFIG').submit();"><span>Nova Configuração</span></a></form></div>
            -->
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
                            $sqlOpt = 'ORDER BY config_active';
                            $opt0 = '&opt='. (!stripslashes($_GET['opt']) ? 1 : 0);
                            $optArrow0 = (!stripslashes($_GET['opt']) ? $ASC : $DESC);
                            $sqlOptOrder = (!stripslashes($_GET['opt']) ? 'ASC' : 'DESC');
                            break;
                        case 1:
                            $sqlOpt = 'ORDER BY config_description';
                            $opt1 = '&opt='. (!stripslashes($_GET['opt']) ? 1 : 0);
                            $optArrow1 = (!stripslashes($_GET['opt']) ? $ASC : $DESC);
                            $sqlOptOrder = (!stripslashes($_GET['opt']) ? 'ASC' : 'DESC');
                            break;
                        case 2:
                            $sqlOpt = 'WHERE config_value = "" ORDER BY config_id';
                            $opt2 = '&opt='. (!stripslashes($_GET['opt']) ? 1 : 0);
                            $optArrow2 = (!stripslashes($_GET['opt']) ? $ASC : $DESC);
                            $sqlOptOrder = (!stripslashes($_GET['opt']) ? 'ASC' : 'DESC');
                            break;
                        default:
                            $sqlOpt = 'ORDER BY config_id';
                            $sqlOptOrder = 'ASC';
                            break;
                    }

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

        if(isset($_GET['order'])){

            echo '<p class="text-muted" style="position: absolute; margin-top:-20px;">Ordenando por: '. $sqlOpt .' '. $sqlOptOrder .'</p>';

            if($stmt = $conn->link->prepare("SELECT * FROM website_configs ".$sqlOpt." ". $sqlOptOrder)){
                try{
                    $stmt->execute();
                    $row = $account->get_result($stmt);
                }
                catch(Exception $e){
                    throw new Exception('Erro ao conectar com a base de dados: '. $e);
                }

                if($stmt->num_rows > 0){
                    for($i = 0; $i < $stmt->num_rows; $i++){
                        ($row[$i]['config_active'] == 0 ? $NOTACTIVE = 'opacity: 0.7;' : $NOTACTIVE = '');
                        (empty($row[$i]['config_value']) ? $VALUE_REPAIR = '<i class="fas fa-exclamation-triangle"></i>' : $VALUE_REPAIR = '');

                        echo '<div class="col col-100 card-result-body" style="'.$NOTACTIVE.'">
                        <div class="card-result-title">'.$row[$i]['config_description'].' ('.($row[$i]['config_active'] ? 'Ativo' : 'Desativado'). ')</div>
                        <form method="POST">
                        <input name="config_name" type="text" value="'.$row[$i]['config_name'].'" hidden>
                        <textarea name="config_value" style="display:none;">'.$row[$i]['config_value'].'</textarea>
                        <input name="config_description" type="text" value="'.$row[$i]['config_description'].'" hidden>
                        <input name="config_active" type="text" value="'.$row[$i]['config_active'].'" hidden>
                        <button class="editbtn smallbtn" name="EDIT_CONFIG" value="'.$row[$i]['config_id'].'" title="Editar">
                        <i class="far fa-edit"></i></button></form>
                        <hr><div class="card-result-content">
                        <span class="bold">Valor:</span> <xmp class="italic" style="line-break: anywhere;white-space: normal;display:inline;">'.$row[$i]['config_value'].'</xmp> '.$VALUE_REPAIR.'
                        </div></div>';
                    }

                } else{
                        echo '<div class="box-msg error">'.ERROR_QUERY_NORESULT.'</div>';
                }
            }
        }else{
            if($stmt = $conn->link->prepare("SELECT * FROM website_configs ORDER BY config_id")){
                try{
                    $stmt->execute();
                    $row = $account->get_result($stmt);
                }
                catch(Exception $e){
                    throw new Exception('Erro ao conectar com a base de dados: '. $e);
                }

                if($stmt->num_rows > 0){
                    for($i = 0; $i < $stmt->num_rows; $i++){
                        ($row[$i]['config_active'] == 0 ? $NOTACTIVE = 'opacity: 0.7;' : $NOTACTIVE = '');
                        (empty($row[$i]['config_value']) ? $VALUE_REPAIR = '<i class="fas fa-exclamation-triangle"></i>' : $VALUE_REPAIR = '');

                        echo '<div class="col col-100 card-result-body" style="'.$NOTACTIVE.'">
                        <div class="card-result-title">'.$row[$i]['config_description'].' ('.($row[$i]['config_active'] ? 'Ativo' : 'Desativado'). ')</div>
                        <form method="POST">
                        <input name="config_name" type="text" value="'.$row[$i]['config_name'].'" hidden>
                        <textarea name="config_value" style="display:none;">'.$row[$i]['config_value'].'</textarea>
                        <input name="config_description" type="text" value="'.$row[$i]['config_description'].'" hidden>
                        <input name="config_active" type="text" value="'.$row[$i]['config_active'].'" hidden>
                        <textarea name="config_help" style="display:none;">'.$row[$i]['config_help'].'</textarea>
                        <textarea name="config_customplaceholder" style="display:none;">'.$row[$i]['config_customplaceholder'].'</textarea>
                        <button class="editbtn smallbtn" name="EDIT_CONFIG" value="'.$row[$i]['config_id'].'" title="Editar">
                        <i class="far fa-edit"></i></button></form>
                        <hr><div class="card-result-content">
                        <span class="bold">Valor:</span> <xmp class="italic" style="line-break: anywhere;white-space: normal;display:inline;">'.$row[$i]['config_value'].'</xmp> '.$VALUE_REPAIR.'
                        </div></div>';
                    }

                } else{
                        echo '<div class="box-msg error">'.ERROR_QUERY_NORESULT.'</div>';
                }
            }
        }

        if(isset($_POST['EDIT_CONFIG'])){
            $config_name = $_POST['config_name'];
            $config_value = $_POST['config_value'];
            $config_description = $_POST['config_description'];
            $config_help = $_POST['config_help'];
            $config_customplaceholder = $_POST['config_customplaceholder'];
            $config_active = $_POST['config_active'];
            $config_id = $_POST['EDIT_CONFIG'];
            echo '<div class="overlayform" id="form1"><div class="modalform"><div class="modaldados">
            <span aria-hidden="true" class="closebtn" onclick="formOff(1);">&times;</span>
            <form method="POST" id="form">
                <h2 class="text-center">Editando &rarr; '.$config_description.'</h2>';

            if(!empty($config_help) OR !$config_help == 0){
                echo '<div class="cfg-help_text">' .$config_help. '</div>';
            }

            echo '<div class="form-group"><label>Descrição <span class="text-muted">(não editável)</span></label> <input type="text" name="config_description" value="'.$config_description.'" readonly></div>
                <div class="form-group"><label>Valor</label> <textarea type="text" name="config_value" id="config_value" placeholder="'.$config_customplaceholder.'">'.$config_value.'</textarea></div>
                <div class="form-group"><label>Ativo? Isto podera afetar a estabilidade do website. <span id="range_input_value">'.$config_active.'</span>/1</label><input type="range" min="0" max="1" value="'.$config_active.'" name="config_active" id="range_input"></div>
                
                <button class="button" style="background-color: var(--green); color: var(--light);" value="'.$config_id.'" name="CONFIRM_CONFIG_EDIT"><span>Confirmar</span></button>
            </form></div><p class="text-muted text-center">Caso o valor deste formulário esteja em branco, essa configuração será desativada automáticamente!</p></div></div>';
            echo '<!-- Autosize Script -->
                <script>
                    var textarea = document.getElementById("config_value");

                    textarea.addEventListener("click", autosize);
                                 
                    function autosize(){
                      var el = this;
                      setTimeout(function(){
                        el.style.cssText = "height:auto";
                        el.style.cssText = "height:" + (el.scrollHeight + 10) + "px";
                      }, 0);
                    }
                    formOn(1);</script>';
        }
        if(isset($_POST['CONFIRM_CONFIG_EDIT'])){

            $conn->link = $conn->connect();
            if($stmt = $conn->link->prepare("UPDATE website_configs SET config_value = ?, config_active = ? WHERE config_id = ?")){

                echo '<div class="overlayform" id="form2"><div class="modalform"><div class="modaldados text-center"><span aria-hidden="true" class="closebtn" onclick="formOff(2);">&times;</span><h2>Criando anotação...</h2></div></div></div>';
                try{
                    $stmt->bind_param('sii', $config_value, $config_active, $config_id);
                    $config_value = $_POST['config_value'];
                    $config_value = str_replace("\r", "", $config_value);
                    $config_value = str_replace("\n", "", $config_value);
                    $config_value = stripslashes($config_value);
                    //$config_value = mysqli_escape_string($conn->link, $config_value);
                    $config_active = $_POST['config_active'];
                    $config_active = stripslashes($config_active);
                    $config_active = mysqli_escape_string($conn->link, $config_active);
                    $config_active = (empty($config_value) ? 0 : $config_active);
                    $config_id = $_POST['CONFIRM_CONFIG_EDIT'];
                    $config_id = stripslashes($config_id);
                    $config_id = mysqli_escape_string($conn->link, $config_id);
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