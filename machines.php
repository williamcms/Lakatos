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
		<?php
			if(isset($_GET['pagename'])){
				$pagename = explode('.', $_GET['pagename'])[0];

				$conn->link = $conn->connect();
				if($stmt = $conn->link->prepare("SELECT * FROM machines WHERE mac_pagename = ? LIMIT 1")){
					try{
						$stmt->bind_param('s', $pagename);
						$stmt->execute();
						$row = get_result($stmt);
					}
					catch(Exception $e){
						throw new Exception('Erro ao conectar com a base de dados: '. $e);
					}
					if($stmt->num_rows >= 1){
						echo '<article class="product">
								<section class="image">
									<picture>
										<img src="'. url() . $row[0]['mac_image'] .'" alt="" width="" height="" />
										<figcaption>
											<div class="catalog">Acesse o catálogo digital</div>
											<div class="video">Reproduzir vídeo</div>
										</figcaption>
									</picture>
								</section>

								<section class="info">
									<div class="title">
										'. $row[0]['mac_name'] .'
									</div>

									<div class="row">
										<div class="col">
											'. $row[0]['mac_desc'] .'
										</div>

										<div class="col">
										</div>
									</div>

								</section>

								<section class="related">
								</section>

								<section class="extra">
								</section>
							</article>';
					}else{
						echo 'Busca não retornou resultados';
					}
				}
			}else{
				echo 'Máquina não pesquisada';
			}
		?>
	</main>

	<?php require_once('footer.php'); ?>
</body>
</html>