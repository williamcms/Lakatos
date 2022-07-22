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
					<source src="./uploads/video/video.mp4" type="video/mp4">
				</video>                
			</div>
			<div class="info">
				<h1 class="pb-2">Inovamos a sua <br/>Produtividade</h1>
				<button id="playVideo" aria-label="Reproduzir vídeo" title="Reproduzir vídeo"><span>Reproduzir vídeo</span></button>
			</div>
		</div>
		<div class="section home-mid-categories" id="aplicacoes">
			<div class="row">
				<div class="text-wrapper col-auto">
					<div class="text">
						<h2>Qual a sua <br/><span>necessidade?</span></h2>
						<p>A Lakatos Termoformadoras possui <br/>know-how para desenvolver moldes <br/>
						e máquinas capazes de produzir <br/>aplicações para diversas áreas!</p>
					</div>
				</div>
				<div class="selection col">
					<?php
						(function(){
							global $conn;
							$conn->link = $conn->connect();

							if($stmt = $conn->link->prepare("SELECT * FROM applications WHERE ap_active = 1 AND ap_icon > 0")){
								try{
									$stmt->execute();
									$result = get_result($stmt);

									foreach($result as $i => $v){
										echo '<div data-apId="'. $v['ap_id'] .'">
										<a href="#'. $v['ap_name'] .'">
											<img src="'. constant('WEBSITE_ICON_NUMBER_' . $v['ap_icon']) .'" alt="'. $v['ap_name'] .'" width="" height=" />"
										<span>'. $v['ap_name'] .'</span>
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
		</div>
		<div class="section home-mid-machines" id="maquinas">
			<div class="text-wrapper m-view">
				<div class="text">
					<h2>Últimas máquinas</h2>
					<p>Temos a solução ideal</p>
				</div>
			</div>
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
									if($_SESSION['lang'] != 'pt_BR'){
										$v['mac_short_desc'] = ($_SESSION['lang'] == 'en_US' ? $v['mac_short_desc_en'] : $v['mac_short_desc_es']);
									}

									echo '<div data-apId="'. $v['mac_id'] .'">
									<a href="'. url() .'/m/'. $v['mac_pagename'] .'" target="_self" title="Máquina '. $v['mac_name'] .'"><img src="'. $v['mac_banner'] .'" mouseout="'. $v['mac_banner'] .'" mousein="'. $v['mac_banner_hover'] .'" aria-label="'. $v['mac_name'] .'" title="'. $v['mac_name'] .'" width="800" height="533" /></a>
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
		<div class="section home-mid-chart" id="sustentabilidade">
			<div class="text-wrapper">
				<div class="text">
					<h2>Sustentabilidade</h2>
					<p>Economia circular e onde a Lakatos se encontra no ciclo</p>
				</div>
			</div>
			<div class="row">
				<div class="col">
					<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation.</p>
				</div>
				<div class="col">
					<?php

						if($stmt = $conn->link->prepare("SELECT * FROM chart LIMIT 1")){
							try{
								$stmt->execute();
								$row = get_result($stmt);
							}
							catch(Exception $e){
								throw new Exception('Erro ao conectar com a base de dados: '. $e);
							}

							class _data{
								public $_arr = array();

								public function get(){
									return $this->_arr;
								}

								public function __construct(){
									$data = func_get_args();

									foreach($data as $key => $value){
										$data[$key] = explode(',', $value);
									}

									foreach($data as $key => $value){
										foreach($value as $key1 => $value1){
											if($key == 0){
												$this->_arr['label'][$key1] = trim($value1);
											}
											if($key == 1){
												$this->_arr['data'][$key1] = trim($value1);
											}
											if($key == 2){
												$this->_arr['fColor'][$key1] = trim($value1);
											}
											if($key == 3){
												$this->_arr['bColor'][$key1] = trim($value1);
											}
										}
									}
								}
							}

							$data = new _data($row[0]['labels'], $row[0]['dataset_data'], $row[0]['dataset_colors'], $row[0]['dataset_borders_color'] );
							$gData = $data->get();

							if($stmt->num_rows > 0){
								if($row[0]['selected'] == 0){
									echo "<canvas id='chart'></canvas><script>
										$(document).ready(function(){
											let ctx = $('#chart');
											var myPieChart = new Chart(ctx, {
												// line, bar, radar, doughnut, pie, polarArea
												type: '". $row[0]["type"] ."',
												data: {
													labels: [";
													foreach($gData['label'] as $key => $value){
														echo "'". $value ."',";
														
													}
													echo "],
													datasets: [{
														label: '". $row[0]['label'] ."',
														data: [";
														foreach($gData['data'] as $key => $value){
															echo $value .",";
															
														}
														echo "],
														backgroundColor: [";
														foreach($gData['fColor'] as $key => $value){
															echo "'". $value ."20',";
															
														}
														echo "],
														borderColor: [";
														foreach($gData['bColor'] as $key => $value){
															echo "'". $value ."',";
															
														}
														echo "],
														borderWidth: ". $row[0]['dataset_borders_width'] .",
														borderRadius: ". $row[0]['dataset_borders_radius'] ."
													}]
												},
												options: {
													plugins: {
														title: {
															display: '". $row[0]['options_title_display'] ."',
															text: '". $row[0]['options_title_text'] ."',
															padding: {
																top: ". $row[0]['options_title_padding_top'] .",
																bottom: ". $row[0]['options_title_padding_bottom'] ."
															}
														},
														subtitle: {
															display: '". $row[0]['options_subtitle_display'] ."',
															text: '". $row[0]['options_subtitle_text'] ."',
															padding: {
																top: ". $row[0]['options_subtitle_padding_top'] .",
																bottom: ". $row[0]['options_subtitle_padding_bottom'] ."
															}
														}
													}
												}
											});
										});
									</script>";
								}else{
									echo '<img src="'. $row[0]['alt'] .'" alt="" />';
								}
							}
						}

					?>
				</div>
					
			</div>
		</div>
		<div class="section home-mid-blog" id="blog">
			<div class="text-wrapper">
				<div class="text">
					<h2>Últimas notícias</h2>
				</div>
				<div class="seemore bolder"><a href="#" role="button" class="button2" aria-label="Ver mais notícias" title="Ver mais notícias"><span>Ver mais</span></a></div>
			</div>
			<div class="row">
				<div class="col"><img src="./uploads/blog/blog-last.png" /></div>
				<div class="col">
					<div class="item"><img src="./uploads/blog/blog-1.png" /></div>
					<div class="item"><img src="./uploads/blog/blog-2.png" /></div>
				</div>
			</div>
		</div>
		<?php include_once('contact_section.php'); ?>
		<div class="section contactnetwork" id="redecontato">
			<div class="text-wrapper" id="redesContato">
				<div class="text">
					<h2>Redes de contato</h2>
					<p>Está procurando por um representante específico?</p>
					<p>Selecione a região abaixo e veja as opções de contato</p>
				</div>
			</div>
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
							<span><strong>Telefone</strong>: 51 967 783     781</span></p>
					</div>
				</div>
			</form>
		</div>
	</main>

	<?php require_once('footer.php'); ?>
</body>
</html>