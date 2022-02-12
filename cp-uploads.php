<?php 
require_once('cfg/core.php');
require_once('cfg/users_class.php');
require_once('optimizer/vendor/autoload.php');

//Optimizer API Key (tinify.com)
\Tinify\setKey(API_TINIFY_ACCESS_TOKEN); 

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

    <noscript><p class="text-center popup popup-red">Oh não! Um erro ocorreu, para visualizar melhor está página é necessário ativar o javascript. Saiba mais <a href="https://www.enable-javascript.com/pt/" target="_blank">clicando aqui</a>.</p></noscript>
</head>
<body>
    <?php require_once('hm_menu_cpanel.php'); ?>
<main class="files">
    <h2 class="text-center" style="padding-top: 20px;">Gerenciamento de Mídias</h2>
    <div class="card-box text-center">
        <form action="#" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col">
                    <input type="file" name="FileToUpload" id="FileToUpload">
                </div>
                <div class="col-auto center_m">
                    <button type="submit" class="button2" name="submit"><span>Enviar Arquivo</span></button>
                </div>
            </div>
            <div class="opt_optimize"><input type="checkbox" name="opt_optimize" value="1" id="opt_optimize">&nbsp;<label for="opt_optimize">Otimizar imagem</label>
                <i class="fa info">
                    <span><p>Habilitar esta função pode aumentar alguns segundos o tempo que demora para enviar a imagem!</p>
                    <p class="text-muted">Obs.: Esta função é limitada ao envio de 500 imagens por mês de forma gratuita e funciona apenas com imagens nos formatos gif, jpg, jpeg, png e webp.</p></span>
                </i></div>
        </form>
        </div>
    </div>

    <?php

    if(isset($_GET['success'])){
        echo '<p class="box-msg popup popup-green">O arquivo '. $_GET['success'] .' foi enviado '. (!($_GET['optimizer']) == 0 ? ($_GET['optimizer'] == 2 ? 'mas não foi otimizado por que não é um formato suportado.' : 'e otimizado!') : '') .'</p>';
    }

    function convertToReadableSize($size){
        $base = log($size) / log(1024);
        $suffix = array("", "KB", "MB", "GB", "TB");
        $f_base = floor($base);
        return round(pow(1024, $base - floor($base)), 1) . $suffix[$f_base];
    }
    //Where save files
    $target_dir = 'uploads/';

    if(isset($_POST['SubmitRemover'])){
        $conn->link = $conn->connect();
        if($stmt = $conn->link->prepare("DELETE FROM files WHERE id = ?")){
            $stmt->bind_param('i', $file_id);
            $file_id = $_POST['SubmitRemover'];
            $arquivo = $_POST['arquivo'];

            if(!file_exists($target_dir . $arquivo)){
                $stmt->execute();
            } elseif (unlink($target_dir . $arquivo)){
                $stmt->execute();
            }

            if($stmt->error){
                printf("Erro: %s.\n", $stmt->error);
            }else{
                echo '<div class="card-box-results"><div class="box-msg popup popup-red">';
                echo 'O arquivo '. $_POST['arquivo'] .' foi removido</div></div>';
            }
            $stmt->close();
            $conn->close($conn->link);
        }
    }

    if(isset($_POST['submit'])){
        // Get choice of optmization
        $opt_optimize = (isset($_POST['opt_optimize']) ? $_POST['opt_optimize'] : 0);
        // Get the original file name from $_FILES
        $file_name = $_FILES['FileToUpload']['name'];
        // Remove any characters you don't want
        // The below code will remove anything that is not a-z, 0-9 or a dot.
        $file_name = preg_replace("/[^a-zA-Z0-9.]/", "", $file_name);
        $target_file = $target_dir . $file_name;
        $uploadOk = 1;
        $optimizer = 0;

        $conn->link = $conn->connect();
        if($stmt = $conn->link->prepare("SELECT name FROM files WHERE name = ?")){
            $stmt->bind_param('s', $file_name);
            $stmt->execute();
            $stmt->store_result();
            echo '<div class="box-msg">';
            if($stmt->num_rows){
                echo '<p class="popup popup-red">' .ERROR_FILE_EXISTS. '</p>';
                $uploadOk = 0;
            }
            if(!$uploadOk){
                if(!$stmt->num_rows){
                    echo '<p class="popup popup-red">' .ERROR_FILE_NOT_SENT. '</p>';
                }
            }else{
                if(move_uploaded_file($_FILES["FileToUpload"]["tmp_name"], $target_file)){
                    //Optimize Image
                    $allowed_mime_types_toOptimize = array('image/gif', 'image/jpg', 'image/jpeg', 'image/png', 'image/webp');
                    if(in_array($_FILES['FileToUpload']['type'], $allowed_mime_types_toOptimize) AND $opt_optimize){
                        $source = \Tinify\fromFile(getcwd() . '/' . $target_dir . $file_name);
                        $source->toFile(getcwd(). '/' . $target_dir . $file_name);
                        $optimizer = 1;
                    }elseif($opt_optimize){
                        $optimizer = 2;
                    }

                    if($stmt = $conn->link->prepare("INSERT INTO files (name, size, user, sent) VALUES (?, ?, ?, STR_TO_DATE(?, '%d-%m-%Y %H:%i:%s'))")){
                        $stmt->bind_param('sdss', $file_name, $file_size, $file_sentby, $file_sentwhen);
                        $file_size = filesize($target_file);
                        $file_sentby = $_SESSION['username'];
                        $file_datetime = new DateTime(null, new DateTimeZone('America/Sao_Paulo'));
                        $file_sentwhen = $file_datetime->format('d-m-Y H:i:s');

                        $stmt->execute();

                        if($stmt->error){
                            printf("Erro: %s.\n", $stmt->error);
                        }else{
                            echo '<script>window.location = window.location.pathname + "?success='. $file_name . '&optimizer='. $optimizer .'"</script>';
                            //header('Location:'.$_SERVER['PHP_SELF'].'?success='. $file_name . '&optimizer='. $optimizer);
                        }
                    }
                } else{
                    echo '<p class="popup popup-red">' .ERROR_FILE_NOT_SENT_ERROR_KNOWN. '<br>';
                    $uploaderror = $_FILES["FileToUpload"]["error"];
                    echo 'Erro #'. $uploaderror .': ';
                    switch($uploaderror){
                        case '1':
                            echo 'O seu arquivo excede o limite de upload. Entre em contato com o administrador do site caso precise aumentar o limite. (UPLOAD_ERR_INI_SIZE)</p>';
                            break;
                        case '2':
                            echo 'O seu arquivo excede o limite de upload desta página. Entre em contato com o administrador do site caso precise aumentar o limite. (MAX_FILE_SIZE)</p>';
                            break;
                        case '3':
                            echo 'O arquivo foi enviado parcialmente. Entre em contato com o administrador do site para reportar o problema. (UPLOAD_ERR_PARTIAL)</p>';
                            break;
                        case '4':
                            echo 'O arquivo não foi enviado. Verifique se você selecionou um arquivo. (UPLOAD_ERR_NO_FILE)';
                            break;
                        case '6':
                            echo 'Pasta temporária não encontrada. Entre em contato com o administrador do site para reportar o problema. (UPLOAD_ERR_NO_TMP_DIR)</p>';
                            break;
                        case '7':
                            echo 'Falha ao gravar o arquivo no disco. Verifique se você possui permissões para gravar arquivos em sua máquina. Entre em contato com o administrador do site caso o problema persista. (UPLOAD_ERR_CANT_WRITE)</p>';
                            break;      
                        case '8':
                            echo 'Uma extensão do PHP parou o upload do arquivo. O PHP não fornece uma maneira de determinar qual extensão causou a parada do upload do arquivo. Entre em contato como administrador do site para reportar o problema. (UPLOAD_ERR_EXTENSION)</p>';
                            break;
                        default:
                            echo 'Algo estranho ocorreu. Entre em contato com o administrador e reporte o ocorrido, bem como o número do erro.</p>';
                            break;
                    }
                }
            }
            echo '</div>';
            $stmt->close();
            $conn->close($conn->link);
        }
    }
    if($browser->isMobile()){
        echo '<div class="card-box-results"><div class="card-result-body text-left" style="padding: 20px;">';
    }else{
        echo '<div class="card-box-results"><div class="card-result-body text-left"><div class="row">
        <div class="col bold">Nome</div>
        <div class="col-auto bold">Tamanho</div>
        <div class="col-auto bold">Usuário</div>
        <div class="col bold text-center">Enviado</div>
        <div class="col-auto bold">Excluir</div></div>';
    }
    $conn->link = $conn->connect();
    if($stmt = $conn->link->prepare("SELECT id, name, size, user, sent FROM files")){
        $stmt->execute();
        $stmt->bind_result($file_id, $file_name, $file_size, $file_sentby, $file_sentwhen);
        $stmt->store_result();

        if(!$stmt->num_rows){
            echo '<p class="p-3 center italic">'. ERROR_QUERY_NORESULT .'</p>';
        }

        if($browser->isMobile()){
            while($stmt->fetch()){
                echo '<form method="POST" class="pb-4"><div class="row">';  
                echo '<div class="col-100"><strong>Nome:</strong> <a href="./'.$target_dir . $file_name .'" target="_blank">images/'. $file_name .'</a></div>';
                echo '<div class="col-100"><strong>Tamanho:</strong> '.convertToReadableSize($file_size).'</div>';
                echo '<div class="col-100"><strong>Enviado por:</strong> '.$file_sentby.'</div>';
                echo '<div class="col-100"><strong>Data em:</strong> '.date('d/m/Y H:i:s', strtotime($file_sentwhen)).'</div>';
                echo '<div class="col-100"><button name="SubmitRemover" value="'.$file_id.'" class="button2 confirmRMV w-100" title="Remover">Remover</button>
                <input type="text" name="arquivo" value="'.$file_name.'" readonly hidden></div>';
                echo '</div></form>';
            }
        }else{
            while($stmt->fetch()){
                echo '<form method="POST"><div class="row">';  
                echo '<div class="col"><a href="./'.$target_dir . $file_name .'" target="_blank">'.$target_dir . $file_name .'</a></div>';
                echo '<div class="col-auto">'.convertToReadableSize($file_size).'</div>';
                echo '<div class="col-auto">'.$file_sentby.'</div>';
                echo '<div class="col text-center">'.date('d/m/Y H:i:s', strtotime($file_sentwhen)).'</div>';
                echo '<div class="col-auto"><button name="SubmitRemover" value="'.$file_id.'" class="closebtn times" title="Remover">&times;</button>
                <input type="text" name="arquivo" value="'.$file_name.'" readonly hidden></div></div></form>';
            }
        }
        $stmt->close();
        $conn->close($conn->link);
    }
    echo '</div></div>';
    ?>
</main>
<?php require_once('cpanel_footer.php'); ?>
</body>
</html>