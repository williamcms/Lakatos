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

					$mac_id = $row[0]['mac_id'];
					if($stmt2 = $conn->link->prepare("SELECT * FROM machine_features WHERE mac_id = ? ORDER BY mf_id ASC")){
						try{
							$stmt2->bind_param('i', $mac_id);
							$stmt2->execute();
							$feature_ids = get_result($stmt2);
						}
						catch(Exception $e){
							throw new Exception('Erro ao conectar com a base de dados: '. $e);
						}
					}
					$maxFeatures = 6;
					$features_ids_query = '';
					$features_ids_array = Array();
					for($i = 0; $i < $maxFeatures; $i++) {
						$features_ids_query .= ($i == 0 ? 'SELECT * FROM features WHERE feat_id = ?' : ' OR feat_id = ?');
						array_push($features_ids_array, (isset($feature_ids[$i]['feat_id']) ? $feature_ids[$i]['feat_id'] : 0));
					}
					if($stmt3 = $conn->link->prepare($features_ids_query)){
						try{
							$stmt3->bind_param('ssssss', $features_ids_array[0], $features_ids_array[1], $features_ids_array[2], $features_ids_array[3], $features_ids_array[4], $features_ids_array[5]);
							$stmt3->execute();
							$features_result = get_result($stmt3);
						}
						catch(Exception $e){
							throw new Exception('Erro ao conectar com a base de dados: '. $e);
						}
					}
					foreach($features_result as $key => $value){
						$features[$value['feat_id']]['feat_name'] = $value['feat_name'];
						$features[$value['feat_id']]['feat_image'] = $value['feat_image'];
					}
					if($stmt->num_rows >= 1){
						echo '<article class="product">
								<section class="image">
									<picture>
										<img src="'. url() . $row[0]['mac_image'] .'" alt="" width="" height="" />
										<figcaption>
											<div class="catalog"><a href=""><i class="fa-solid fa-book"></i><span>Acesse o <br/>catálogo digital</span></a></div>
											<div class="video"><a href="">Reproduzir vídeo</a></div>
										</figcaption>
									</picture>
								</section>

								<section class="info">
									<div class="title pt-3 pl-3 pr-4">
										<h1>'. $row[0]['mac_name'] .'</h1>
									</div>

									<div class="description row">
										<div class="col">
											'. $row[0]['mac_desc'] .'
										</div>

										<div class="col">';

										for($i = 0; $i < 3 && $stmt2->num_rows != 0; $i++){
											if(isset($features[$features_ids_array[$i]])){
												echo '<div class="d-flex"><div class="image"><img src="';
												echo url() . constant('WEBSITE_ICON_NUMBER_' . $features[$features_ids_array[$i]]['feat_image']);
												echo '" alt="" /></div><div class="text">';
												echo $features[$features_ids_array[$i]]['feat_name'];
												echo '</div></div>';
											}
										}

									echo '</div>
									</div>

								</section>

								<section class="related">
								</section>

								<section class="extra d-flex center pt-5 pr-4 pb-5 pl-4">';

								for($i = 3; $i < 6 && $stmt2->num_rows != 0; $i++){
										if(isset($features[$features_ids_array[$i]])){
											echo '<div class="d-flex"><div class="image"><img src="';
											echo url() . constant('WEBSITE_ICON_NUMBER_' . $features[$features_ids_array[$i]]['feat_image']);
											echo '" alt="" /></div><div class="text">';
											echo $features[$features_ids_array[$i]]['feat_name'];
											echo '</div></div>';
										}
									}

							echo '</section>
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