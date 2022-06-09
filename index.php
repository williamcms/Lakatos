<?php require_once('cfg/core.php'); ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
	<title><?php echo $website->title; ?></title>
	<!-- Chart API -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.8.0/chart.min.js" defer></script>
	<?php require_once('header-front.php'); ?>
</head>
<body>
	<?php require_once('menu.php'); ?>

	<main>
		<div class="home-top_video paused" id="home">
			<div class="video">
				<video muted loop id="homeVideo">
					<source src="_prototype/video/video.mp4" type="video/mp4">
				</video>                
			</div>
			<div class="info">
				<h1 class="pb-2">Inovamos a sua <br/>Produtividade</h1>
				<button id="playVideo" aria-label="Reproduzir vídeo" title="Reproduzir vídeo"><span>Reproduzir vídeo</span></button>
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
					<h2>Qual a sua <span class="highlight">necessidade</span>?</h2>
					<p>A Lakatos Termoformadoras possui know-how para desenvolver</p>
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
		<div class="section home-mid-machines" id="maquinas">
			<div class="text-wrapper d-none">
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

						if($stmt = $conn->link->prepare("SELECT * FROM machines WHERE mac_active = 1 ORDER BY mac_id DESC LIMIT 5")){
							try{
								$stmt->execute();
								$result = get_result($stmt);

								foreach($result as $i => $v){
									echo '<div data-apId="'. $v['mac_id'] .'" data-applications="'. $v['mac_applications'] .'">
									<img src="'. $v['mac_image'] .'" mouseout="'. $v['mac_image'] .'" mousein="'. $v['mac_image_hover'] .'" aria-label="'. $v['mac_name'] .'" title="'. $v['mac_name'] .'" width="800" height="533" />
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
		<div class="section home-mid-chart" id="sustentabilidade">
			<div class="text-wrapper">
				<div class="text">
					<h2>Sustentabilidade</h2>
					<p>Economia circular e onde a Lakatos se encontra no ciclo</p>
				</div>
			</div>
			<div class="section-separator-1"></div>
			<div class="row">
				<div class="col">
					<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation.</p>
				</div>
				<div class="col">
					<canvas id="chart"></canvas>
				</div>
					
			</div>
		</div>
		<div class="section-separator"></div>
		<div class="section home-mid-blog" id="blog">
			<div class="text-wrapper">
				<div class="text">
					<h2>Últimas notícias</h2>
				</div>
				<div class="seemore bolder"><a href="#" role="button" class="button2" aria-label="Ver mais notícias" title="Ver mais notícias"><span>Ver mais</span></a></div>
			</div>
			<div class="section-separator-1"></div>
			<div class="row">
				<div class="col"><img src="./uploads/blog/blog-last.png" /></div>
				<div class="col">
					<div class="item"><img src="./uploads/blog/blog-1.png" /></div>
					<div class="item"><img src="./uploads/blog/blog-2.png" /></div>
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
			<div class="text-wrapper" id="redesContato">
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

	<script>
		$(document).ready(function(){
			let ctx = $('#chart');
			var myPieChart = new Chart(ctx, {
				// line, bar, radar, doughnut, pie, polarArea
				type: 'doughnut',
				data: {
					labels: ['Vermelho', 'Azul', 'Amarelo', 'Verde', 'Roxo', 'Laranja'],
					datasets: [{
						label: '# of Votes',
						data: [12, 19, 3, 5, 2, 3],
						backgroundColor: [
							'rgba(255, 99, 132, 0.2)',
							'rgba(54, 162, 235, 0.2)',
							'rgba(255, 206, 86, 0.2)',
							'rgba(75, 192, 192, 0.2)',
							'rgba(153, 102, 255, 0.2)',
							'rgba(255, 159, 64, 0.2)'
						],
						borderColor: [
							'rgba(255, 99, 132, 1)',
							'rgba(54, 162, 235, 1)',
							'rgba(255, 206, 86, 1)',
							'rgba(75, 192, 192, 1)',
							'rgba(153, 102, 255, 1)',
							'rgba(255, 159, 64, 1)'
						],
						borderWidth: 1
					}]
				},
				options: {}
			});
		})
	</script>

	<?php require_once('footer.php'); ?>
</body>
</html>