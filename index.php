<?php require_once('cfg/core.php'); ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
	<title><?php echo $website->title; ?></title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="robots" content="index, follow">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<!-- Styles -->
	<link rel="stylesheet" href="<?php echo url(); ?>/css/common.css">
	<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
	<!-- Scripts -->    
	<script src="<?php echo url(); ?>/js/jquery-3.6.0.min.js"></script>
	<script src="<?php echo url(); ?>/js/common.js"></script>
	<script src="https://jrxeventos.com.br/js/autogrow.js"></script> <!-- Autogrows the textarea field in the whatsapp floating button -->
	<!-- Preload font -->
	<link rel="preload" href="https://use.fontawesome.com/releases/v5.5.0/webfonts/fa-brands-400.woff2" as="font" type="font/woff2" crossorigin>
	<link rel="preload" href="https://use.fontawesome.com/releases/v5.5.0/webfonts/fa-regular-400.woff2" as="font" type="font/woff2" crossorigin>
	<link rel="preload" href="https://use.fontawesome.com/releases/v5.5.0/webfonts/fa-solid-900.woff2" as="font" type="font/woff2" crossorigin>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&display=swap" rel="stylesheet">
	<!-- Slicker -->
	<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
	<script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
	<!-- Icons -->
	<link rel="apple-touch-icon" sizes="60x60" href="<?php echo url(); ?>/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="<?php echo url(); ?>/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="<?php echo url(); ?>/favicon-16x16.png">
	<link rel="manifest" href="<?php echo url(); ?>/site.webmanifest">
	<link rel="mask-icon" href="<?php echo url(); ?>/safari-pinned-tab.svg" color="#456fd8">
	<meta name="msapplication-TileColor" content="#dcdcdc">
	<meta name="theme-color" content="#ffffff">
	<!-- Open Graph-->
	<meta property="og:locale" content="pt_BR">
	<meta property="og:type" content="website">
	<meta property="og:title" content="<?php echo $website->title; ?>">
	<meta property="og:description" content="<?php echo $website->description; ?>">
	<meta property="og:url" content="<?php echo url() ?>">
	<meta property="og:site_name" content="<?php echo $website->title; ?>">
	<meta property="og:image" content="<?php echo $website->image; ?>">
	<meta property="og:image:width" content="1654">
	<meta property="og:image:height" content="612">
	<!-- Facebook -->
	<?php
		if($fb->page){
			print '<meta property="fb:page_id" content="'.$fb->page.'" />';
		}
		if($fb->app){
			print '<meta property="fb:app_id" content="'.$fb->app.'" />';
		}
	?>

	<!-- Management -->
	<?php
		if($mkt->gSearchConsole){
			print $mkt->gSearchConsole;
		}
		if($mkt->bWebmaster){
			print $mkt->bWebmaster;
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
	if($mkt->fPixel){
		echo $mkt->fPixel;
	}
	?>

	<noscript><p class="center popup popup-red">Oh não! Um erro ocorreu, para visualizar melhor está página é necessário ativar o javascript. Saiba mais <a href="https://www.enable-javascript.com/pt/" target="_blank">clicando aqui</a>.</p></noscript>
</head>
<body>
	<?php require_once('menu.php'); ?>

	<main>
		<div class="home-top_video" id="home">
			<div class="video">
				<video muted autoplay loop id="homeVideo">
					<source src="_prototype/video/video.mp4" type="video/mp4">
				</video>                
			</div>
			<div class="info">
				<h2>Inovando a sua Produtividade</h2>
				<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam</p>
				<button id="playVideo">Pausar vídeo</button>
			</div>
		</div>
		<div class="section-separator"></div>
		<div class="home-mid-aboutus" id="aboutus" name="aboutus">
			<div class="row">
				<div class="col">
					<div class="text">
						<h2>Sobre nós</h2>
						<div class="text-separator"></div><div class="text-separator"></div>
						<p>Referência no mercado de manufatura de máquinas termoformadoras há mais de 45 anos, a Eletro-Forming passou a se chamar Lakatos. A mudança, ocorrida no início de 2019, aconteceu como parte de uma estratégia de reposicionamento da marca no mercado. O antigo nome deu lugar ao sobrenome Lakatos. </p>
						<div class="text-separator"></div>
						<p>Sediada no município de Embu das Artes (SP), a Lakatos conta com uma área de produção de 2500 m². O espaço conta com departamento de usinagem, caldeiraria, serralheria, montagem, pintura, metrologia e, também, um estoque de peças para pronto-atendimento.</p>
						<div class="text-separator"></div>
						<p>A empresa conta com uma equipe altamente habilitada para desenvolvimento de projetos e incorporação das mais modernas tecnologias. Sua linha de produção engloba máquinas de usinagem CNC capazes de manufaturar variadas peças e moldes complexos. </p>
						<div class="text-separator"></div>
						<p>Os departamentos de Engenharia e Produção da Lakatos são equipados com softwares (CAE, CAD 3D, EPLAN e CAM) de última geração. Um sistema ERP integra as diversas áreas da companhia.</p>
					</div>
				</div>
				<div class="col">
					<img src="_prototype/images/lakatos_empresa.jpg" alt="Foto Aérea" width="800" height="540" />
				</div>
			</div>
		</div>
		<div class="section-separator"></div>
		<div class="section home-mid-categories" id="aplicacoes">
			<div class="text-wrapper">
				<div class="text">
					<h2>Qual a sua necessidade?</h2>
					<p>A Lakatos Termoformadoras possui know how para desenvolver</p>
					<p>moldes e máquinas capazes de produzir aplicações para diversas áreas!</p>
				</div>
				<div class="seemore bolder"><a href="#" role="button" class="button2" aria-label="Ver mais máquinas" title="Ver mais máquinas"><span>Ver mais</span></a></div>
			</div>
			<div class="section-separator"></div>
			<div class="selection">
				<?php
					(function(){
						global $conn;
						$conn->link = $conn->connect();

						if($stmt = $conn->link->prepare("SELECT ap_id, ap_icon, ap_name, ap_included FROM mac_applications WHERE ap_active = 1")){
							try{
								$stmt->execute();
								$result = get_result($stmt);

								foreach($result as $i => $v){
									echo '<div data-apId="'. $v['ap_id'] .'" data-machines="'. $v['ap_included'] .'">
									<a href="#'. $v['ap_name'] .'">'. $v['ap_icon'] .'
									<p>'. $v['ap_name'] .'</p>
									</a></div>';
								}
							}catch(Exception $e){
								throw new Exception('Erro ao conectar com a base de dados: '. $e);
							}
						}
					})();
				?>
			</div>
		</div>
		<div class="section-separator"></div>
		<div class="applications-detailed" id="Alimentício">
			<!-- Contéudo -->
		</div>
		<div class="section-separator"></div>
		<div class="section home-mid-machines" id="maquinas">
			<div class="text-wrapper">
				<div class="text">
					<h2>Últimas máquinas</h2>
				</div>
				<div class="seemore bolder"><a href="#" role="button" class="button2" aria-label="Ver mais máquinas" title="Ver mais máquinas"><span>Ver mais</span></a></div>
			</div>
			<div class="section-separator-1"></div>
			<div class="slick-carousel-arrows">
				<?php
					(function(){
						global $conn;
						$conn->link = $conn->connect();

						if($stmt = $conn->link->prepare("SELECT mac_id, mac_name, mac_image, mac_short_desc, mac_desc, mac_applications FROM machines WHERE mac_active = 1 ORDER BY mac_id DESC LIMIT 5")){
							try{
								$stmt->execute();
								$result = get_result($stmt);

								foreach($result as $i => $v){
									echo '<div data-apId="'. $v['mac_id'] .'" data-applications="'. $v['mac_applications'] .'">
									<img src="'. $v['mac_image'] .'" aria-label="'. $v['mac_name'] .'" title="'. $v['mac_name'] .'" width="800" height="533" />
									<div class="name w-75 center bold"><a href="#">'. $v['mac_name'] .'</a></div>
									<div class="desc w-75">'. $v['mac_short_desc'] .'</div></div>';
								}
							}catch(Exception $e){
								throw new Exception('Erro ao conectar com a base de dados: '. $e);
							}
						}
					})();
				?>
			</div>
		</div>
		<div class="section-separator"></div>
		<div class="section home-mid-moldes">
			<div class="text-wrapper">
				<div class="text">
					<h2>Moldes</h2>
					<p>Além da produção das termoformadoras,</p>
					<p>a Lakatos se dedica à fabricação dos moldes!</p>
				</div>
			</div>
			<div class="section-separator-1"></div>
			<div class="row">
				<div class="col">
					<p>Para isso, possui estrutura completa, que compreende máquinas de usinagem CNC, bem como um departamento de metrologia, onde opera uma máquina tridimensional com precisão milesimal. Além disso, apresenta uma equipe de engenharia altamente capacitada a desenhar as mais complexas superfícies por meio do software CAD 3D.</p>
					<p>Todo esse suporte permite que o trabalho seja executado perfeitamente e no material mais adequado. Podemos iniciar o processo com modelos em Epóxi para fundição, como maquinar laminados e fundidos até atingir a precisão em aço especial temperado com 60 HRC. A saber, os moldes produzidos pela Lakatos são variados, ou seja, para todas as suas linhas de máquinas termoformadoras, a exemplo de modelos para embalagens com multicavidades para alta produtividade, bem como em tamanhos maiores para autopeças ou a produção de peças de  refrigeradores.</p>
					<p>Em nossas soluções incluímos canais de refrigeração, manifold, partes postiças com cilindros pneumáticos, travas especiais, extratores, câmara de vácuo, vedações, facas de corte, entre outras técnicas para alcançar a excelência em seu molde.</p>
					<p>Em suma, a função da Lakatos é oferecer a solução completa, que inclui a máquina termoformadora juntamente com o molde, assumindo toda a responsabilidade da operação (turn key), com condições de uso imediato.</p>
				</div>
				<div class="col">
					<img class="img-responsive" src="https://www.lakatos.com/painel/dashboard/uploads/paginas/imagem_pagina___09-jpg___eletro_forming__1493231978__2604172017153938.jpg" title="Moldes Lakatos" />
				</div>
					
			</div>
		</div>
		<div class="section-separator"></div>
		<div class="section contactus" id="contato">
			<div class="text-wrapper">
				<div class="text">
					<h2>Contato</h2>
					<p>Está precisando de ajuda?</p>
					<p>Preencha o formulário abaixo 
						<?php  if($location->phoneNumber){
							echo 'ou entre em contato por whatsapp <a href="https://wa.me/'. $location->cleanWhatsapp .'" target="_blank">'. $location->whastapp .'</a>.';
						} ?>
					</p>
				</div>
			</div>
			<div class="section-separator-2"></div>
			<form method="POST">
				<div class="form-group row">
					<div class="input-group col">
						<div class="input-group-prepend"><span class="input-group-text">Nome</span></div>
						<input type="text" name="nome">
					</div>
					<div class="input-group col">
						<div class="input-group-prepend"><span class="input-group-text">Telefone</span></div>
						<input type="tel" name="telefone">
					</div>
				</div>
				<div class="form-group row">
					<div class="input-group col">
						<div class="input-group-prepend"><span class="input-group-text">Email</span></div>
						<input type="email" name="email">
					</div>
					<div class="input-group col">
						<div class="input-group-prepend"><span class="input-group-text">Assunto</span></div>
						<input type="text" name="assunto">
					</div>
				</div>
				<div class="form-group">
					<div class="input-group">
						<div class="input-group-prepend"><span class="input-group-text">Mensagem</span></div>
						<textarea name="mensagem"></textarea>
					</div>
				</div>
				<button class="button2 btn-green"><span>Enviar</span></button>
			</form>
			<div class="section-separator"></div>
			<div class="text-wrapper">
				<div class="text">
					<h2>Redes de contato</h2>
					<p>Está procurando por um representante específico?</p>
					<p>Selecione a região abaixo e veja as opções de contato</p>
				</div>
			</div>
			<div class="section-separator-2"></div>
			<form>
				<div class="form-group center_m fornecedores">
					<div class="input-group">
						<div class="input-group-prepend"><span class="input-group-text">Fornecedor</span></div>
						<select id="fornecedoresContato">
							<option selected>Selecione</option>
							<option value="BRA-SUL">Brasil - Sul</option>
							<option value="BRA-NOR">Brasil - Nordeste</option>
							<option value="ARG">Argentina</option>
							<option value="PERU">Peru</option>
						</select>
					</div>
				</div>
				<div class="section-separator-2"></div>

				<div class="contact-options">

					<div class="BRA-SUL" style="display:none">
						<h3>Contatos para Brasil - Sul</h3>
						<p><strong>Nome</strong>: Abilio Heiss</p>
						<p><span><strong>Email</strong>: <a href="mailto:abilioheiss@terra.com.br">abilioheiss@terra.com.br</a></span> 
							<span><strong>Telefone</strong>: 41 9107-2250</span></p>
					</div>
					<div class="BRA-NOR" style="display:none">
						<h3>Contatos para Brasil - Nordeste</h3>
						<p><strong>Nome</strong>: Sandro Alvares</p>
						<p><span><strong>Email</strong>: <a href="mailto:sandro.alvares@naftabr.com">sandro.alvares@naftabr.com</a></span> 
							<span><strong>Telefone</strong>: 81 9292-1975</span></p>
					</div>
					<div class="ARG" style="display:none">
						<h3>Contatos para Argentina</h3>
						<p><strong>Nome</strong>: Manuel Muntadas</p>
						<p><span><strong>Email</strong>: <a href="mailto:manuel@jmmuntadas.net">manuel@jmmuntadas.net</a></span> 
							<span><strong>Telefone</strong>: +54 9 11 5920-1981</span></p>
					</div>
					<div class="PERU" style="display:none">
						<h3>Contatos para Peru</h3>
						<p><strong>Nome</strong>: Giorgio Hungut</p>
						<p><span><strong>Email</strong>: <a href="mailto:giorgio@ghtrading.com.pe">giorgio@ghtrading.com.pe</a></span> 
							<span><strong>Telefone</strong>: 51 967 783 	781</span></p>
					</div>
				</div>
			</form>
		</div>
	</main>
	<div class="section-separator"></div>

<?php require_once('footer.php'); ?>
</body>
</html>