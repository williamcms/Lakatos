<?php 
	require_once('cfg/core.php');

	if(isset($_GET['pagename'])){
		$pagename = explode('.', $_GET['pagename'])[0];

		$conn->link = $conn->connect();
		if($stmt = $conn->link->prepare("SELECT * FROM machines WHERE mac_pagename = ? LIMIT 1")){
			try{
				$stmt->bind_param('s', $pagename);
				$stmt->execute();
				$row = get_result($stmt);

				if($_SESSION['lang'] != 'pt_BR'){
					$row[0]['mac_title'] = ($_SESSION['lang'] == 'en_US' ? $row[0]['mac_title_en'] : $row[0]['mac_title_es']);
					$row[0]['mac_short_desc'] = ($_SESSION['lang'] == 'en_US' ? $row[0]['mac_short_desc_en'] : $row[0]['mac_short_desc_es']);
					$row[0]['mac_desc'] = ($_SESSION['lang'] == 'en_US' ? $row[0]['mac_desc_en'] : $row[0]['mac_desc_es']);
				}
			}
			catch(Exception $e){
				throw new Exception('Erro ao conectar com a base de dados: '. $e);
			}
		}
	}

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
	<title><?php echo $website->title .': '. (isset($pagename) ? $row[0]['mac_name'] : 'Máquinas') ?></title>
	<?php require_once('header-front.php'); ?>
</head>
<body>
	<?php require_once('menu.php'); ?>

	<main>
		<?php
			if(isset($_GET['pagename']) && $stmt->num_rows){
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
					$features_ids_query .= ($i == 0 ? 'SELECT * FROM features WHERE feat_active = 1 AND (feat_id = ?' : ' OR feat_id = ?');
					array_push($features_ids_array, (isset($feature_ids[$i]['feat_id']) ? $feature_ids[$i]['feat_id'] : 0));
				}
				$features_ids_query .= ')';

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

				$mac_series = $row[0]['mac_series'];
				if($stmt4 = $conn->link->prepare("SELECT * FROM machines WHERE mac_series = ? AND mac_active = 1 AND NOT mac_id = ?")){
					try{
						$stmt4->bind_param('si', $mac_series, $mac_id);
						$stmt4->execute();
						$relatedSeries = get_result($stmt4);
					}
					catch(Exception $e){
						throw new Exception('Erro ao conectar com a base de dados: '. $e);
					}
				}

				foreach($features_result as $key => $value){
					$features[$value['feat_id']]['feat_name'] = 
						$value[(
							$_SESSION['lang'] != 'pt_BR' ? ($_SESSION['lang'] == 'en_US' ? 'feat_name_en' : 'feat_name_es') : 'feat_name'
						)];
					$features[$value['feat_id']]['feat_image'] = $value['feat_image'];
				}
				
				echo '<article class="product">
						<section class="image">
							<picture style="background: url('. $row[0]['mac_image'] .') no-repeat;">
								'. (isNotEmptyNull($row[0]['mac_catalog']) || isNotEmptyNull($row[0]['mac_video']) ? '
									<figcaption>
									'. (isNotEmptyNull($row[0]['mac_catalog']) ? '
									<div class="catalog">
										<a href="'. $row[0]['mac_catalog'] .'">
											<i class="fa-solid fa-book"></i><span>Acesse o <br/>catálogo digital</span>
										</a>
									</div>
									' : '') . (isNotEmptyNull($row[0]['mac_video']) ? '
									<div class="video">
										<a href="'. $row[0]['mac_video'] .'">Ver vídeo</a>
									</div>
									' : '') .'
								</figcaption>' : '') .'
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
										echo constant('WEBSITE_ICON_NUMBER_' . $features[$features_ids_array[$i]]['feat_image']);
										echo '" alt="" /></div><div class="text">';
										echo $features[$features_ids_array[$i]]['feat_name'];
										echo '</div></div>';
									}
								}

							echo '</div>
							</div>

						</section>

						<section class="related">
							<div class="title pt-3 pl-3 pr-4">
								<h2>Mais soluções da linha '. $mac_series .'</h2>
							</div>
							<div class="slick-carousel-arrows" data-slick=\'{"slidesToShow": 3, "responsive": [{"breakpoint": 831, "settings":{"slidesToShow": 1}}]}\'>';

							for($i = 0; $i < $stmt4->num_rows; $i++){
								echo '<div class="item"><figure class="image">';
								echo '<img src="'. $relatedSeries[$i]['mac_image'] .'" alt="" width="" height="" />';
								echo '<a href="./'. $relatedSeries[$i]['mac_pagename'] .'"><figcaption class="title center bold">'. $relatedSeries[$i]['mac_name'] .'&nbsp;&nbsp;&#10148;</figcaption></a></figure>';
								echo '</div>';
							}

						echo '</div>
						</section>

						<section class="extra d-flex center pt-5 pr-4 pb-5 pl-4">';

						for($i = 3; $i < 6 && $stmt2->num_rows != 0; $i++){
								if(isset($features[$features_ids_array[$i]])){
									echo '<div class="d-flex"><div class="image"><img src="';
									echo constant('WEBSITE_ICON_NUMBER_' . $features[$features_ids_array[$i]]['feat_image']);
									echo '" alt="" /></div><div class="text">';
									echo $features[$features_ids_array[$i]]['feat_name'];
									echo '</div></div>';
								}
							}

					echo '</section>
					</article>';
			}else{
				$type = (isset($_GET['type']) ? $_GET['type'] : 'bobinas');

				$conn->link = $conn->connect();
				if($stmt = $conn->link->prepare("SELECT * FROM machines WHERE mac_active = 1 AND mac_type = ?")){
					try{
						$stmt->bind_param('s', $type);
						$stmt->execute();
						$row = get_result($stmt);
					}
					catch(Exception $e){
						throw new Exception('Erro ao conectar com a base de dados: '. $e);
					}
				}
				echo '<article class="products">
					<section class="banner">';

						if($type == 'bobinas'){
							echo '<figure class="bobinas"><figcaption><h1>Máquinas de alimentação por bobinas</h1></figcaption>';
						}else{
							echo '<figure class="chapas"><figcaption><h1>Máquinas de alimentação por chapas</h1></figcaption>';
						}

						echo '</figure>
					</section>

					<section class="type-changer d-flex">
						<a href="'. url() .'/maquinas/bobinas"><span>&#8249;</span> Bobinas</a>
						<a href="'. url() .'/maquinas/chapas">Chapas <span>&#8250;</span></a>
					</section>

					<section class="list">
						<div class="d-flex">';
						for($i = 0; $i < $stmt->num_rows; $i++){
							echo '<figure>
								<a href="'. url() .'/m/'. $row[$i]['mac_pagename'] .'">
								<img src="'. $row[$i]['mac_image'] .'" alt="" width="" height="" />
								<figcaption><h3>'. $row[$i]['mac_name'] .'</h3></figcaption></a>
							</figure>';
						}
					echo '</div>
					</section>
				</article>';

				include_once('contact_section.php');
			}
		?>
	</main>

	<?php require_once('footer.php'); ?>
</body>
</html>