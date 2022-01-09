<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
?>

<div class="formContact" >
		<form action="#" method="POST" id="formContato">
		<div class="form-group">
			<div class="row">
				<div class="col">Nome: <input type="text" name="Fname" required></div>
				<div class="col">Email: <input type="email" name="email" required></div>
			</div>
		</div>
		<div class="form-group">
			Precisa acrescentar alguma informação? Digite abaixo <span class="text-muted">(opcional)</span>
			<textarea class="fontb" name="message" placeholder="Escreva aqui..."></textarea>
		</div>
	<button class="button" name="SubmitButton" style="background-color: #FFF;"><span>Enviar</span></button>
</form>

<?php
if(isset($_POST['SubmitButton'])){
	$name = ($_POST['Fname']);
	$from = ($_POST['email']);
	$messageform = ($_POST['message']);

	$messagePlainText = $name. 'entrou em contato:';
	$messagePlainText2 = 'Nome: '.$name.' | Email: '.$from.' | Mensagem: '.$messageform;

	//Email para o website
	$formText = "Hello ".$email->name.",\nThis is a text email, the text/plain version, because your device does not support the original HTML version..\\n\n ".$messagePlainText." \n ".$messagePlainText2;

	$formHTML = '
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
	 <head>
	  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	  <title>'.$website->title.': Formulário de Contato</title>
	  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	</head>
	<body style="margin: 0;padding: 0;">
		<table border="0" cellpadding="0" cellspacing="0" width="100%">
			<tr>
				<td>
					<table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="border: 1px solid #cccccc;">
						<tr>
							<td align="center" style="padding: 0 0 0 0">
								<img src="http://williamcms.com.br/images/WILLIAMCMS_email.png" width="600" height="200" alt="Cover Image" style="object-fit:cover;"/>
							</td>
						</tr>
						<tr>
							<td bgcolor="#FFFFFF" style="padding: 40px 30px 40px 30px;">
								<table border="0" cellpadding="0" cellspacing="0" width="100%">
									<tr>
										<td>
											<b>Nome:</b> '.$name.'
										</td>
										<td>
											<b>Email:</b> '.$from.'
										</td>
									</tr>
									<tr>
										<td>
											&nbsp;
										</td>
									</tr>
									<tr>
										<td>
											<b>Mensagem:</b> '.$messageform.'
										</td>
									</tr>
									<tr>
										<td>
											&nbsp;
										</td>
									</tr>
									<tr>
										<td>
											&nbsp;
										</td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td bgcolor="#202125" style="padding: 15px 15px 15px 15px;">
								<table border="0" cellpadding="0" cellspacing="0" width="100%">
									<tr>
										<td width="75%" style="color:#FFFFFF;text-align:center;">
											williamcms.com.br &reg; 2019.
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>	
	</body>
	</html>';

	$mail = new PHPMailer(true);                                // Passing `true` enables exceptions

	try {
	    //Server settings
	    $mail->CharSet = 'UTF-8';
	    $mail->SMTPDebug = 0;                                   // Enable verbose debug output (2)
	    $mail->isSMTP();                                        // Set mailer to use SMTP
	    $mail->Host = $email->host;                             // Specify main and backup SMTP servers
	    $mail->SMTPAuth = false;                                // Enable SMTP authentication (false on GoDaddy)
	    $mail->SMTPAutoTLS = false;								// (false on GoDaddy)
	    $mail->Username = $email->username;                     // SMTP username
	    $mail->Password = $email->password;                     // SMTP password
	    // $mail->SMTPSecure = $email->encryption;              // Enable TLS encryption, `ssl` also accepted (disabled on GoDaddy)
	    $mail->Port = $email->port;                             // TCP port to connect to

	    //Recipients
	    $mail->setFrom($email->replyTo);			//Use ALWAYS the email that is sending
	    $mail->addAddress($email->address);                     // Name is optional
	    $mail->addReplyTo($from);

	    //Content
		$mail->isHTML(true);                                    // Set email format to HTML
		$mail->Subject = 'Formulário do portfólio: '.$name;
		$mail->Body    = $formHTML;
		$mail->AltBody = $formText;

	    if($mail->send()){
	   		echo '<p>Caso não encontre o email, verifique sua caixa de Spam!</p>';
	    	echo '<script type="text/javascript">window.location.href="?sucess"</script>';
		}
	} catch (Exception $e) {
	    echo '<p>Pode haver um problema com o servidor de email, tente novamente em um momento..</p><br />';
	    echo '<span class="text-muted">Message could not be sent. Mailer Error: '. $mail->ErrorInfo .'</span>';
	}

}
?>