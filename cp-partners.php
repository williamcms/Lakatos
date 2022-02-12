<?php 
include('cfg/core.php');
include('cfg/users_class.php');

$account->sessionLogin();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
	<title><?php echo $website->title; ?>: Parceiros</title>
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
<main class="partners">
    <h2 class="text-center" style="padding-top: 20px;">Gerenciamento de Parceiros</h2>
    <div class="card-box">
        <div class="row">
            <div class="col"><h4>Parceiros</h4></div>
            <div class="col"><form method="POST" id="NEW_PARTNER"><input type="text" name="ADD_PARTNER" hidden><a href="#" class="button2 card_button-add" onclick="$('#NEW_PARTNER').submit();"><span>Novo Parceiro</span></a></form></div>
        </div>
        <div class="row">
            <?php 
                if(isset($_GET['order'])){
                    $option = stripslashes($_GET['order']);

                    $ASC = '<i class="fas fa-sort-up"></i>';
                    $DESC = '<i class="fas fa-sort-down"></i>';

                    $opt0 = '&opt=0';
                    $optArrow1 = $optArrow0 = '';

                    switch($option){
                        case 0:
                            $sqlOpt = 'cliente_active';
                            $opt0 = '&opt='. (!stripslashes($_GET['opt']) ? 1 : 0);
                            $optArrow0 = (!stripslashes($_GET['opt']) ? $ASC : $DESC);
                            $sqlOptOrder = (!stripslashes($_GET['opt']) ? 'ASC' : 'DESC');
                            break;
                        default:
                            $sqlOpt = 'cliente_id';
                            $sqlOptOrder = 'ASC';
                            break;
                    }

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

        if(isset($_GET['order'])){

            echo '<p class="text-muted" style="position: absolute; margin-top:-20px;">Ordenando por: '. $sqlOpt .' '. $sqlOptOrder .'</p>';

            if($stmt = $conn->link->prepare("SELECT * FROM clientes ORDER BY ".$sqlOpt." ". $sqlOptOrder)){
                try{
                    $stmt->execute();
                    $row = $account->get_result($stmt);
                }
                catch(Exception $e){
                    throw new Exception('Erro ao conectar com a base de dados: '. $e);
                }

                if($stmt->num_rows > 0){
                    for($i = 0; $i < $stmt->num_rows; $i++){
                        ($row[$i]['cliente_active'] == 0 ? $NOTACTIVE = 'opacity: 0.7;' : $NOTACTIVE = '');
                        echo '<div class="col card-result-body" style="'.$NOTACTIVE.'"><div class="card-result-title">'.$row[$i]['cliente_name'].'</div>
                        <form method="POST">
                        <input name="cliente_name" type="text" value="'.$row[$i]['cliente_name'].'" hidden>
                        <input name="cliente_image" type="text" value="'.$row[$i]['cliente_image'].'" hidden>
                        <input name="cliente_description" type="text" value="'.$row[$i]['cliente_description'].'" hidden>
                        <input name="cliente_url" type="text" value="'.$row[$i]['cliente_url'].'" hidden>
                        <input name="cliente_active" type="text" value="'.$row[$i]['cliente_active'].'" hidden>
                        <button class="closebtn smallbtn" name="REMOVE_PARTNER" value="'.$row[$i]['cliente_id'].'" style="right: 35px;"><i class="fas fa-user-times"></i></button>
                        <button class="editbtn smallbtn" name="EDIT_PARTNER" value="'.$row[$i]['cliente_id'].'" title="Editar">
                        <i class="far fa-edit"></i></button></form>
                        <hr><div class="card-result-content"><div class="card-result-content-bg" style="background:url(./uploads/logo/'.$row[$i]['cliente_image'].');"></div></div></div>';
                    }

                } else{
                        echo '<div class="box-msg error">'.ERROR_QUERY_NORESULT.'</div>';
                }
            }
        }else{
            if($stmt = $conn->link->prepare("SELECT * FROM clientes ORDER BY cliente_id")){
                try{
                    $stmt->execute();
                    $row = $account->get_result($stmt);
                }
                catch(Exception $e){
                    throw new Exception('Erro ao conectar com a base de dados: '. $e);
                }

                if($stmt->num_rows > 0){
                    for($i = 0; $i < $stmt->num_rows; $i++){
                        ($row[$i]['cliente_active'] == 0 ? $NOTACTIVE = 'opacity: 0.7;' : $NOTACTIVE = '');
                        echo '<div class="col card-result-body" style="order: '.$row[$i]['cliente_id'].';'.$NOTACTIVE.'">
                        <div class="card-result-title">'.$row[$i]['cliente_name'].'</div>
                        <form method="POST">
                        <input name="cliente_name" type="text" value="'.$row[$i]['cliente_name'].'" hidden>
                        <input name="cliente_image" type="text" value="'.$row[$i]['cliente_image'].'" hidden>
                        <input name="cliente_description" type="text" value="'.$row[$i]['cliente_description'].'" hidden>
                        <input name="cliente_url" type="text" value="'.$row[$i]['cliente_url'].'" hidden>
                        <input name="cliente_active" type="text" value="'.$row[$i]['cliente_active'].'" hidden>
                        <button class="closebtn smallbtn" name="REMOVE_PARTNER" value="'.$row[$i]['cliente_id'].'" style="right: 35px;"><i class="fas fa-user-times"></i></button>
                        <button class="editbtn smallbtn" name="EDIT_PARTNER" value="'.$row[$i]['cliente_id'].'" title="Editar">
                        <i class="far fa-edit"></i></button></form>
                        <hr><div class="card-result-content"><div class="card-result-content-bg" style="background:url(./uploads/logo/'.$row[$i]['cliente_image'].');"></div></div></div>';
                    }

                } else{
                        echo '<div class="box-msg error">'.ERROR_QUERY_NORESULT.'</div>';
                }
            }
        }

        if(isset($_POST['EDIT_PARTNER'])){
            $cliente_name = $_POST['cliente_name'];
            $cliente_image = $_POST['cliente_image'];
            $cliente_description = $_POST['cliente_description'];
            $cliente_url = $_POST['cliente_url'];
            $cliente_active = $_POST['cliente_active'];
            $cliente_id = $_POST['EDIT_PARTNER'];
            echo '<div class="overlayform" id="form1"><div class="modalform"><div class="modaldados">
            <span aria-hidden="true" class="closebtn" onclick="formOff(1);">&times;</span>
            <form method="POST" id="form">
                <h2 class="text-center">Preencha as informações abaixo para alterar o parceiro!</h2>
                <div class="form-group"><label>Id do parceiro <span class="text-muted">(não editável)</span></label> <input type="text" name="cliente_id" value="'.$cliente_id.'" readonly></div>
                <div class="form-group"><label>Nome do Parceiro (ex: Alimento.AG)</label> <input type="text" name="cliente_name" value="'.$cliente_name.'" required></div>
                <div class="form-group"><label>Imagem</label> (ex: imagem_do_parceiro.png)<input type="text" name="cliente_image" value="'.$cliente_image.'" required></div>
                <div class="form-group"><label>Descrição Curta</label><textarea name="cliente_description">'.$cliente_description.'</textarea></div>
                <div class="form-group"><label>Site do Parceiro</label> (ex: http://example.com.br)<input type="text" placeholder="http://" name="cliente_url" value="'.$cliente_url.'"></div>
                <div class="form-group"><label>Ativo? Isto afetara a visibilidade deste parceiro no site. <span id="range_input_value">'.$cliente_active.'</span>/1</label><input type="range" min="0" max="1" value="'.$cliente_active.'" name="cliente_active" id="range_input"></div>

                
                <button class="button" style="background-color: var(--green); color: var(--white);" name="CONFIRM_PARTNER_EDIT"><span>Confirmar</span></button>
            </form></div></div></div>';
            echo '<script>formOn(1);</script>';
        }
        if(isset($_POST['CONFIRM_PARTNER_EDIT'])){

            $conn->link = $conn->connect();
            if($stmt = $conn->link->prepare("UPDATE clientes SET cliente_name = ?, cliente_image = ?, cliente_url = ?, cliente_description = ?, cliente_active = ? WHERE cliente_id = ?")){

                echo '<div class="overlayform" id="form2"><div class="modalform"><div class="modaldados text-center"><span aria-hidden="true" class="closebtn" onclick="formOff(2);">&times;</span><h2>Criando anotação...</h2></div></div></div>';
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
                echo '<script>formOff(2);</script>';
            }
        }
        if(isset($_POST['REMOVE_PARTNER'])){
            echo '<div class="overlayform" id="form3"><div class="modalform"><div class="modaldados text-center">
            <span aria-hidden="true" class="closebtn" onclick="formOff(3);">&times;</span>
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
                echo '<div class="overlayform" id="form4"><div class="modalform"><div class="modaldados text-center"><span aria-hidden="true" class="closebtn" onclick="formOff(4);">&times;</span><h2>Excluindo Cliente (id: '.$_POST['CONFIRM_CLIENTE_REM'].')</h2></div></div></div>';
                try{
                    $stmt->bind_param('i', stripslashes($_POST['CONFIRM_CLIENTE_REM']));
                    $stmt->execute();
                }
                catch(Exception $e){
                    throw new Exception('Erro ao conectar com a base de dados: '. $e);
                }
                echo '<script>formOff(4);</script>';
            }
        }

        if(isset($_POST['ADD_PARTNER'])){
            echo '<div class="overlayform" id="form5"><div class="modalform"><div class="modaldados">
            <span aria-hidden="true" class="closebtn" onclick="formOff(5);">&times;</span>
            <form method="POST" id="form">
                <h2 class="text-center">Preencha as informações abaixo para inserir uma nova nota:</h2>
                <div class="form-group"><label>Nome do Parceiro (ex: Alimento.AG)</label> <input type="text" name="cliente_name" required></div>
                <div class="form-group"><label>Imagem</label> (ex: imagem_do_parceiro.png)<input type="text" name="cliente_image" required></div>
                <div class="form-group"><label>Descrição Curta</label><textarea name="cliente_description"></textarea></div>
                <div class="form-group"><label>Site do Parceiro</label> (ex: http://example.com.br)<input type="text" placeholder="http://" name="cliente_url"></div>
                <div class="form-group"><label>Ativo? Isto afetara a visibilidade deste parceiro no site. <span id="range_input_value">0</span>/1</label><input type="range" min="0" max="1" value="0" name="cliente_active" id="range_input"></div>

                
                <button class="button" style="background-color: var(--green); color: var(--white);" name="CONFIRM_PARTNER_ADD"><span>Confirmar</span></button>
            </form></div></div></div>';
            echo '<script>formOn(5);</script>';
        }
        if(isset($_POST['CONFIRM_PARTNER_ADD'])){

            $conn->link = $conn->connect();
            if($stmt = $conn->link->prepare("INSERT INTO clientes (cliente_name, cliente_image, cliente_url, cliente_description, cliente_active) VALUES (?, ?, ?, ?, ?)")){

                echo '<div class="overlayform" id="form6"><div class="modalform"><div class="modaldados text-center"><span aria-hidden="true" class="closebtn" onclick="formOff(6);">&times;</span><h2>Adicionando Parceiro...</h2></div></div></div>';
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
                    
                    $cliente_id = $_POST['cliente_id'];
                    $cliente_id = stripslashes($cliente_id);
                    $cliente_id = mysqli_escape_string($conn->link, $cliente_id);
                    $stmt->execute();
                }
                catch(Exception $e){
                    throw new Exception('Erro ao conectar com a base de dados: '. $e);
                }
                echo '<script>formOff(6);</script>';
            }
        }


    ?>
    </div>
</main>
<?php include('cpanel_footer.php'); ?>
</body>
</html>