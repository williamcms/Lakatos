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

	<main class="aboutus">
		<div class="row">
			<div class="col">
				<h1>Sobre nós</h1>
				<p>Referência no mercado de manufatura de máquinas termoformadoras há mais de 45 anos, a Eletro-Forming passou a se chamar Lakatos. A mudança, ocorrida no início de 2019, aconteceu como parte de uma estratégia de reposicionamento da marca no mercado. O antigo nome deu lugar ao sobrenome Lakatos. </p><br/>
				<p>Sediada no município de Embu das Artes (SP), a Lakatos conta com uma área de produção de 2500 m². O espaço conta com departamento de usinagem, caldeiraria, serralheria, montagem, pintura, metrologia e, também, um estoque de peças para pronto-atendimento.</p><br/>
				<p>A empresa conta com uma equipe altamente habilitada para desenvolvimento de projetos e incorporação das mais modernas tecnologias. Sua linha de produção engloba máquinas de usinagem CNC capazes de manufaturar variadas peças e moldes complexos. </p><br/>
				<p>Os departamentos de Engenharia e Produção da Lakatos são equipados com softwares (CAE, CAD 3D, EPLAN e CAM) de última geração. Um sistema ERP integra as diversas áreas da companhia.</p>
			</div>
			<div class="col-auto">
				<img src="./images/lakatos_empresa.jpg" alt="Foto Aérea" width="800" height="540" />
			</div>
		</div>
		<div class="institutional-photo-1"></div>
		<div class="institutional-photo-2">
			<img src="./images/lakatos-pelo-mundo.png" class="w-100" alt="Lakatos pelo mundo" width="1247" height="686" />
		</div>
		<div class="in-numbers">
			<h2>Lakatos<br/> em números</h2>

			<div class="d-flex">
				<div class="circle d-flex">
					<p>49</p>
					<p>Anos de<br/> atuação</p>
				</div>
				<div class="circle d-flex">
					<p>2000</p>
					<p>Projetos<br/> desenvolvidos</p>
				</div>
				<div class="circle d-flex">
					<p>500</p>
					<p>Moldes<br/> produzidos</p>
				</div>
				<div class="circle d-flex">
					<p>1000</p>
					<p>Clientes<br/> atendidos</p>
				</div>
				<div class="circle d-flex">
					<p>2500</p>
					<p>m² de área<br/> fabril</p>
				</div>
			</div>
		</div>
		<div class="clientes">
			<div class="row">
				<div class="text-wrapper col-auto">
					<div class="text">
						<h2>Nossos <br/>Clientes</h2>
					</div>
				</div>
				<div class="selection col">
					<?php
						(function(){
							global $conn;
							$conn->link = $conn->connect();

							if($stmt = $conn->link->prepare("SELECT * FROM clientes WHERE cliente_active = 1 LIMIT 15")){
								try{
									$stmt->execute();
									$result = get_result($stmt);

									foreach($result as $i => $v){
										echo '<div data-cliente="'. $v['cliente_id'] .'"><img src="'. $v['cliente_image'] .'" alt="'. $v['cliente_name'] .'" width="" height="" /></div>';
									}
								}catch(Exception $e){
									throw new Exception('Erro ao conectar com a base de dados: '. $e);
								}
							}
						})();
					?>
				</div>
			</div>
		</div>
		<div class="gallery">
			<div class="text-wrapper">
				<div class="text">
					<h2>Galeria de fotos</h2>
				</div>
			</div>
			<div class="slick-carousel-arrows" data-slick='{"slidesToShow": 3, "responsive": [{"breakpoint": 831, "settings":{"slidesToShow": 1}}]}'>
				<div class="gallery-item"><img src="./images/lakatos_empresa.jpg" width="" height="" /></div>
				<div class="gallery-item"><img src="./images/lakatos_empresa.jpg" width="" height="" /></div>
				<div class="gallery-item"><img src="./images/lakatos_empresa.jpg" width="" height="" /></div>
				<div class="gallery-item"><img src="./images/lakatos_empresa.jpg" width="" height="" /></div>
			</div>
		</div>
	</main>

	<?php require_once('footer.php'); ?>
</body>
</html>