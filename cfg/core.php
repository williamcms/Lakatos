<?php 
header('Content-type: text/html; charset=utf-8');
//Login Messages
define('ERROR_LOGIN_BLANK', 'Os campos do formulário não podem ficar em branco.');
define('ERROR_LOGIN_DENIED', 'Você não tem permissão para fazer login.<br>Se acha que isto é um erro, contate o administrador do site.');
define('ERROR_LOGIN_USERNAME', 'Erro! Usuário incorreto.');
define('ERROR_LOGIN_PASSWORD', 'Erro! Senha incorreta.');
define('ERROR_ACCESS_DENIED', 'Você não possui permissão para acessar esta área,<br>permissão elevada necessária.');
define('LOGIN_SUCCESS', 'Sucesso! Você será redirecionado em alguns instantes.');
define('LOGIN_SUCCESS_SESSION', 'Parece que você já esta logado, vamos te redirecionar em alguns instantes.');
//Registration Messages
define('INVALID_USERNAME', 'Erro! Seu nome de usuário não é válido.');
define('INVALID_PASSWORD', 'Erro! Sua senha não é válida.');
define('USERNAME_EXISTS', 'Erro! O nome de usuário que você escolheu já existe.');
//Database Messages
define('ERROR_QUERY_NORESULT', 'Parece que não há nada por aqui!');
define('ERROR_QUERY_NORESULT_PARAMS', 'Parece que não há nada por aqui, tente mudar os termos da busca!');
define('ERROR_DATABASE_ACCESS_DENIED', 'Erro! Você não possui permissões para realizar este tipo de operação.');
//Files Messages
define('ERROR_FILE_EXISTS', 'Erro! O arquivo que vocês está tentando enviar já existe.');
define('ERROR_FILE_NOT_SENT', 'Erro! Seu arquivo não foi enviado, tente novamente em instantes!');
define('ERROR_FILE_NOT_SENT_ERROR_KNOWN', 'Erro! Ocorreu um erro ao enviar seu arquivo.');

if(ini_set('session.name', 'SEUCOOKIE') === false || !session_name('SEUCOOKIE'))
{
	die('Unable to set sesssion scope');
}

session_start();

/* Verify if the var is not Empty or Null */
function isNotEmptyNull($var){
	if(trim($var) == '') {
		return FALSE;
	}
	if(is_null($var)) {
		return FALSE;
	}
	if(empty($var)) {
		return FALSE;
	}

	return TRUE;
}
/* Get the current url in use */
function url(){
	$server_name = $_SERVER['SERVER_NAME'];
	//$port = ':'.$_SERVER['SERVER_PORT'];
	$port = ''; //Change if necessary

	$n = $_SERVER['SCRIPT_NAME'];
	$arr = explode('/', $n);
	if(count($arr)>2){
		array_splice($arr,0,1);
		array_splice($arr,count($arr)-1);

		$n = '/'.implode('/', $arr);
	}else{
		$n = '';
	}

	if (!empty($_SERVER['HTTPS']) && (strtolower($_SERVER['HTTPS']) == 'on' || $_SERVER['HTTPS'] == '1')) {
		$scheme = 'https';
	} else {
		$scheme = 'http';
	}
	return $scheme.'://'.$server_name.$port.$n;
}
/* Get current page filename */
function getFileName($extension = false){
	$arr = $_SERVER['SCRIPT_NAME'];
	$arr = explode('/', $arr);
	$arr_max = count($arr);
	array_splice($arr, 0, $arr_max-1);
	
	if($extension){
		$noExtension = explode('.', $arr[0]);
		return $noExtension[0];
	}
	return $arr[0];
}
/* Database Configs */
class _conn{
	private $host = 'localhost';
	private $username = 'root';
	private $password = '';
	private $database = 'lakatos';
	public $link;

	public function getter($var){
		return $this->$var;
	}
	public function connect(){
		//error_reporting(E_ERROR | E_PARSE);
		$conn = mysqli_connect($this->host, $this->username, $this->password, $this->database);
		mysqli_set_charset($conn, 'utf8'); //Remove Bug de acentos :3
		// Check connection
		if(mysqli_connect_errno()){
			echo '<div>';
			echo 'Falha de conexão com a Base de Dados (MySQL): ' . mysqli_connect_error();
			echo '</div>';
		}
		return $conn;
	}
	public function close($link){
		mysqli_close($link);
	}
}

$conn = new _conn;

/* Custom get_result function when not is not possible to activate nd_mysqli*/
function get_result($statement){
	$RESULT = array();
	$statement->store_result();
	for ($i=0; $i<$statement->num_rows; $i++) {
		$Metadata = $statement->result_metadata();
		$PARAMS = array();
		while ($field = $Metadata->fetch_field()){
			$PARAMS[] = &$RESULT[$i][$field->name];
		}
		call_user_func_array( array( $statement, 'bind_result' ), $PARAMS );
		$statement->fetch();
	}
	return $RESULT;
}
/* Get Website Configs in Database */
(function() {
	global $conn;
	$conn->link = $conn->connect();

	if($stmt = $conn->link->prepare("SELECT config_name, config_value, config_active FROM website_configs")){
		try{
			$stmt->execute();
			$result = get_result($stmt);

			foreach($result as $i => $v){
				if(!isNotEmptyNull($v['config_value']) OR $v['config_active'] == 0){
					define(strtoupper($v['config_name']), '');
				} else{
					define(strtoupper($v['config_name']), $v['config_value']);
				}
			}
		}
		catch(Exception $e){
			throw new Exception('Erro ao conectar com a base de dados: '. $e);
		}
	}
	$stmt->close();
	$conn->close($conn->link);
})();

/* Get Website Icons in Database */
(function() {
	global $conn;
	$conn->link = $conn->connect();

	if($stmt = $conn->link->prepare("SELECT * FROM icons")){
		try{
			$stmt->execute();
			$result = get_result($stmt);

			// Definição quando nenhum ícone é selecionado
			define(strtoupper('WEBSITE_ICON_NUMBER_0'), '');

			foreach($result as $i => $v){
				if(!isNotEmptyNull($v['icon_image']) OR $v['icon_active'] == 0){
					define(strtoupper('WEBSITE_ICON_NUMBER_' . $v['icon_id']), '');
				}else{
					define(strtoupper('WEBSITE_ICON_NUMBER_' . $v['icon_id']), $v['icon_image']);
				}
			}
		}
		catch(Exception $e){
			throw new Exception('Erro ao conectar com a base de dados: '. $e);
		}
	}
	$stmt->close();
	$conn->close($conn->link);
})();

/* Get Language */
(function(){
	global $conn;
	$conn->link = $conn->connect();

	//Set default language
	$default_lang = 'pt_BR';

	//Try to get language by url's var
	$lang_get = (isset($_GET['lang']) ? $_GET['lang'] : 0);
	//Try to get language by session's var
	$lang_session = (isset($_SESSION['lang']) ? $_SESSION['lang'] : 0);
	//Verify if language is available  by session, if not try language by web's var, if not try default
	$lang = ($lang_get ? $lang_get : ($lang_session ? $lang_session : 'pt_BR'));

	//verify if the selected language is valid and apply it
	if($lang){
		switch($lang ? $lang : $default_lang){
			case 'en_US':
				$_SESSION['lang'] = 'en_US';
				break;
			case 'es_ES':
				$_SESSION['lang'] = 'es_ES';
				break;
			default:
				$_SESSION['lang'] = $default_lang;
				break;
		}
	}

	if($stmt = $conn->link->prepare("SELECT * FROM website_lang WHERE lang_locale = ?")){
		try{
			$stmt->bind_param('s', $lang);
			$stmt->execute();
			$result = get_result($stmt);

			foreach($result as $i => $v){
				
				//Formating bold text ex: *PALAVRA*
				$v['lang_value'] = preg_replace("/\*(.*?)\*/", '<strong>$1</strong>', $v['lang_value']);
				//Formating italic text ex: _PALAVRA_
				$v['lang_value'] = preg_replace("/\_(.*?)\_/", '<i>$1</i>', $v['lang_value']);

				define(strtoupper($v['lang_name']), $v['lang_value']);
				
			}
		}
		catch(Exception $e){
			throw new Exception('Erro ao conectar com a base de dados: '. $e);
		}
	}
	$stmt->close();
	$conn->close($conn->link);
})();

class _website{
	public $title = WEBSITE_TITLE; 				//og:title
	public $iconVersion = ''; 					//If you need to update an old version of your icon in browsers that may have cached it ex: ?v=E6myLpg8vn
	public $image = WEBSITE_IMAGE; 				//og:image
	public $description = WEBSITE_DESCRIPTION; 	//og:description
	public $keywords = WEBSITE_KEYWORDS; 		//Site's keywords
	public $author = WEBSITE_AUTHOR; 			//Site's author
}
class _email{
	public $name = EMAIL_NAME; 					//Your name or your Site Name
	public $replyTo = EMAIL_REPLYTO; 			//Email address to reply to your emails
	public $address = EMAIL_ADDRESS; 			//Email address that will receive the emails
	public $host = 'localhost'; 				//Your SMTP servers (smtpout.secureserver.net) (use localhost on GoDaddy)
	public $username = '';
	public $password = '';
	public $port = '25'; 						//default = 465 (use 25 on GoDaddy)
	public $encryption = 'ssl';
}
class _social{
	public $facebook = SOCIAL_FACEBOOK;
	public $twitter = SOCIAL_TWITTER;
	public $linkedin = SOCIAL_LINKEDIN;
	public $instagram = SOCIAL_INSTAGRAM;
	public $youtube = SOCIAL_YOUTUBE;
}
class _mkt{
	public $gAnalytics = MKT_GANALYTICS;
	public $gAds = MKT_GADS;
	public $fPixel = MKT_FPIXEL;
	public $gSearchConsole = MKT_GSEARCHCONSOLE;
	public $bWebmaster = MKT_BWEBMASTER;
}
class _fb{
	public $page = FB_PAGE;
	public $app = FB_APP;
}
class _locationDetails{
	public $stAddress = LOCATION_STADDRESS;		//1601 S California Ave
	public $locality = LOCATION_LOCALITY;		//Palo Alto
	public $region = LOCATION_REGION;			//CA
	public $postalCode = LOCATION_POSTALCODE;	//94304
	public $country = LOCATION_COUNTRY;			//USA
	public $phoneNumber = LOCATION_PHONENUMBER;	//+1-650-123-4567
	public $whastapp = LOCATION_WHATSAPP;	//+1-650-123-4567
	public $cleanWhatsapp = LOCATION_WHATSAPP;
}
class _widget{
	public $whatsapp = WIDGET_WHATSAPP;
}
class _api{
	public $tinify = API_TINIFY_ACCESS_TOKEN;
}

$website = new _website;
$social = new _social;
$email = new _email;
$mkt = new _mkt;
$fb = new _fb;
$location = new _locationDetails;
$widget = new _widget;
$api = new _api;

//Removes special characters from phone number
$location->cleanWhatsapp = str_replace(' ', '', $location->cleanWhatsapp);
$location->cleanWhatsapp = str_replace('-', '', $location->cleanWhatsapp);
$location->cleanWhatsapp = preg_replace('/[^A-Za-z0-9\-]/', '', $location->cleanWhatsapp);

//Social media icons SVG
if(!$social->instagram == ''){
	$social_instagram = '<a href="'.$social->instagram.'" target="_blank" aria-label="Página do Instagram">
		<img src="'.url().'/images/instagram-brands.svg" alt="Instagram" aria-hidden="true"/></a>';
}else{
	$social_instagram = '';
}
if(!$social->facebook == ''){
	$social_facebook = '<a href="'.$social->facebook.'" target="_blank" aria-label="Página do Facebook">
		<img src="'.url().'/images/facebook-square-brands.svg" alt="Facebook" aria-hidden="true"/></a>';
}else{
	$social_facebook = '';
}
if(!$social->twitter == ''){
	$social_twitter = '<a href="'.$social->twitter.'" target="_blank" aria-label="Página do Twitter">
		<img src="'.url().'/images/twitter-brands.svg" alt="Twitter" aria-hidden="true"/></a>';
}else{
	$social_twitter = '';
}
if(!$social->linkedin == ''){
	$social_linkedin = '<a href="'.$social->linkedin.'" target="_blank" aria-label="Página do Linkedin">
		<img src="'.url().'/images/linkedin-brands.svg" alt="Linkedin" aria-hidden="true"/></a>';
}else{
	$social_linkedin = '';
}

//Social media icons CSS
if(!$social->instagram == ''){
	$social_link_instagram = '<a href="'.$social->instagram.'" target="_blank" class="fab fa-instagram" aria-label="Página do Instagram"></a>';
}else{
	$social_link_instagram = '';
}
if(!$social->facebook == ''){
	$social_link_facebook = '<a href="'.$social->facebook.'" target="_blank" class="fab fa-facebook-f" aria-label="Página do Facebook"></a>';
}else{
	$social_link_facebook = '';
}
if(!$social->twitter == ''){
	$social_link_twitter = '<a href="'.$social->twitter.'" target="_blank" class="fab fa-twitter" aria-label="Página do Twitter"></a>';
}else{
	$social_link_twitter = '';
}
if(!$social->linkedin == ''){
	$social_link_linkedin = '<a href="'.$social->linkedin.'" target="_blank" class="fab fa-linkedin-in" aria-label="Página do Linkedin"></a>';
}else{
	$social_link_linkedin = '';
}
if(!$social->youtube == ''){
	$social_link_youtube = '<a href="'.$social->youtube.'" target="_blank" class="fab fa-youtube" aria-label="Página do Youtube"></a>';
}else{
	$social_link_youtube = '';
}

/*
<?php require_once("cfg/core.php"); ?>

$conn->link = $conn->connect();

$conn->close($conn->link);

$conn->getter(var);

<?php
	echo $social_link_instagram;
	echo $social_link_facebook;
	echo $social_link_twitter;
	echo $social_link_linkedin;
?>

*/